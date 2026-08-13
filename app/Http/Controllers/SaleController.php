<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['car', 'customer', 'user']);

        // Filter by Payment Type (Cash vs Credit)
        if ($request->filled('payment_type') && $request->payment_type !== 'all') {
            $query->where('payment_type', $request->payment_type);
        }

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('sale_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('sale_date', '<=', $request->end_date);
        }

        // Search by Invoice, Car, or Customer Name/NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('car', function ($carQuery) use ($search) {
                      $carQuery->where('brand', 'LIKE', "%{$search}%")
                               ->orWhere('model_type', 'LIKE', "%{$search}%")
                               ->orWhere('plate_number', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('customer', function ($custQuery) use ($search) {
                      $custQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('nik', 'LIKE', "%{$search}%");
                  });
            });
        }

        $sales = $query->latest('sale_date')->paginate(10)->withQueryString();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // Only fetch cars that are available for sale (not sold)
        $availableCars = Car::whereIn('status', ['tersedia', 'dipesan'])->orderBy('brand')->get();
        $customers = Customer::orderBy('name')->get();

        return view('sales.create', compact('availableCars', 'customers'));
    }

    public function store(StoreSaleRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($request, $validated, &$sale) {
                // Lock car row for update to prevent race conditions
                $car = Car::where('id', $validated['car_id'])->lockForUpdate()->firstOrFail();

                // Strict check: if car status is already 'terjual', abort transaction
                if ($car->status === 'terjual') {
                    throw new \Exception('Mobil tidak dapat dijual karena status kendaraan sudah TERJUAL.');
                }

                // Retrieve customer
                $customer = Customer::where('id', $validated['customer_id'])->firstOrFail();

                // Update customer documents if supplied in transaction form
                $customerData = [];
                if (!empty($validated['nik'])) $customerData['nik'] = $validated['nik'];
                if (!empty($validated['kk_number'])) $customerData['kk_number'] = $validated['kk_number'];
                if (!empty($validated['npwp_number'])) $customerData['npwp_number'] = $validated['npwp_number'];

                $documentFields = ['ktp_file', 'kk_file', 'salary_slip_file', 'npwp_file'];
                foreach ($documentFields as $field) {
                    if ($request->hasFile($field)) {
                        if ($customer->$field && Storage::disk('public')->exists($customer->$field)) {
                            Storage::disk('public')->delete($customer->$field);
                        }
                        $customerData[$field] = $request->file($field)->store('customers/documents', 'public');
                    }
                }

                if (!empty($customerData)) {
                    $customer->update($customerData);
                }

                // Calculate Credit Specific Fields
                $paymentType = $validated['payment_type'];
                $dpAmount = null;
                $tenorMonths = null;
                $interestRate = null;
                $totalInterest = null;
                $monthlyInstallment = null;

                if ($paymentType === 'credit') {
                    $salePrice = (float)$validated['sale_price'];
                    $dpAmount = (float)$validated['dp_amount'];
                    $principal = max(0, $salePrice - $dpAmount);
                    $tenorMonths = (int)$validated['tenor_months'];
                    $interestRate = (float)$validated['interest_rate_per_year'];

                    $totalInterest = $principal * ($interestRate / 100) * ($tenorMonths / 12);
                    $monthlyInstallment = ($principal + $totalInterest) / $tenorMonths;
                }

                // Generate unique invoice number
                $invoiceNumber = Sale::generateInvoiceNumber();

                // Create Sale Record
                $sale = Sale::create([
                    'invoice_number' => $invoiceNumber,
                    'car_id' => $car->id,
                    'customer_id' => $customer->id,
                    'user_id' => Auth::id(),
                    'sale_date' => $validated['sale_date'],
                    'sale_price' => $validated['sale_price'],
                    'payment_type' => $paymentType,
                    'payment_method' => $validated['payment_method'],
                    'dp_amount' => $dpAmount,
                    'tenor_months' => $tenorMonths,
                    'interest_rate_per_year' => $interestRate,
                    'total_interest' => $totalInterest,
                    'monthly_installment' => $monthlyInstallment,
                    'notes' => $validated['notes'] ?? null,
                ]);

                // Automatically update car status to 'terjual'
                $car->update(['status' => 'terjual']);
            });

            return redirect()->route('sales.index')
                ->with('success', 'Transaksi penjualan ' . strtoupper($sale->payment_type) . ' berhasil disimpan dan status mobil telah diperbarui menjadi TERJUAL.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage() ?: 'Terjadi kesalahan. Transaksi gagal disimpan.');
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['car', 'customer', 'user']);
        return view('sales.show', compact('sale'));
    }
}
