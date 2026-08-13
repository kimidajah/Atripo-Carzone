<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $query = Sale::with(['car', 'customer', 'user'])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->orderBy('sale_date', 'desc');

        $sales = $query->get();

        $totalTransactions = $sales->count();
        $totalRevenue = $sales->sum('sale_price');

        // Check if printable view requested
        if ($request->has('print') || $request->has('pdf')) {
            return view('reports.sales_pdf', compact('sales', 'startDate', 'endDate', 'totalTransactions', 'totalRevenue'));
        }

        return view('reports.sales', compact('sales', 'startDate', 'endDate', 'totalTransactions', 'totalRevenue'));
    }

    public function management(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Mobil Masuk: Units added into system during the selected date range
        $carsIncoming = Car::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->get();

        // Mobil Keluar: Units sold during the selected date range
        $salesOutgoing = Sale::with(['car', 'customer', 'user'])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->latest('sale_date')
            ->get();

        $totalIncoming = $carsIncoming->count();
        $totalOutgoing = $salesOutgoing->count();
        $currentAvailable = Car::where('status', 'tersedia')->count();

        if ($request->has('print') || $request->has('pdf')) {
            return view('reports.management_pdf', compact(
                'carsIncoming', 'salesOutgoing', 'startDate', 'endDate',
                'totalIncoming', 'totalOutgoing', 'currentAvailable'
            ));
        }

        return view('reports.management', compact(
            'carsIncoming', 'salesOutgoing', 'startDate', 'endDate',
            'totalIncoming', 'totalOutgoing', 'currentAvailable'
        ));
    }

    public function inventory(Request $request)
    {
        $status = $request->input('status', 'all');
        $brand = $request->input('brand', 'all');

        $query = Car::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($brand !== 'all') {
            $query->where('brand', $brand);
        }

        $cars = $query->orderBy('brand')->orderBy('model_type')->get();

        $totalCars = Car::count();
        $availableCount = Car::where('status', 'tersedia')->count();
        $reservedCount = Car::where('status', 'dipesan')->count();
        $soldCount = Car::where('status', 'terjual')->count();

        $brands = Car::select('brand')->distinct()->pluck('brand');

        if ($request->has('print') || $request->has('pdf')) {
            return view('reports.inventory_pdf', compact(
                'cars', 'status', 'brand', 'totalCars', 'availableCount', 'reservedCount', 'soldCount'
            ));
        }

        return view('reports.inventory', compact(
            'cars', 'status', 'brand', 'brands', 'totalCars', 'availableCount', 'reservedCount', 'soldCount'
        ));
    }
}
