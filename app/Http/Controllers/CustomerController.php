<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%")
                  ->orWhere('kk_number', 'LIKE', "%{$search}%")
                  ->orWhere('npwp_number', 'LIKE', "%{$search}%");
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        $documentFields = ['ktp_file', 'kk_file', 'salary_slip_file', 'npwp_file'];
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('customers/documents', 'public');
            }
        }

        $customer = Customer::create($data);

        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan ' . $customer->name . ' berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        $customer->load('sales.car');
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();

        $documentFields = ['ktp_file', 'kk_file', 'salary_slip_file', 'npwp_file'];
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                if ($customer->$field && Storage::disk('public')->exists($customer->$field)) {
                    Storage::disk('public')->delete($customer->$field);
                }
                $data[$field] = $request->file($field)->store('customers/documents', 'public');
            }
        }

        $customer->update($data);

        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan ' . $customer->name . ' berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->sales()->exists()) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat transaksi penjualan.');
        }

        $documentFields = ['ktp_file', 'kk_file', 'salary_slip_file', 'npwp_file'];
        foreach ($documentFields as $field) {
            if ($customer->$field && Storage::disk('public')->exists($customer->$field)) {
                Storage::disk('public')->delete($customer->$field);
            }
        }

        $name = $customer->name;
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan ' . $name . ' berhasil dihapus.');
    }
}
