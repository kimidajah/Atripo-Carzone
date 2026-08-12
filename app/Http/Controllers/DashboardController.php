<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Key Performance Metrics
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'tersedia')->count();
        $reservedCars = Car::where('status', 'dipesan')->count();
        $soldCars = Car::where('status', 'terjual')->count();

        $totalSalesRevenue = Sale::sum('sale_price');
        $totalSalesCount = Sale::count();

        // Recent Additions & Transactions
        $recentCars = Car::latest()->take(5)->get();
        $recentSales = Sale::with(['car', 'customer', 'user'])->latest()->take(5)->get();

        // Monthly Sales Chart Data (Last 6 Months)
        $driver = DB::getDriverName();
        $dateExpression = $driver === 'sqlite' 
            ? "strftime('%Y-%m', sale_date) as month_year"
            : "DATE_FORMAT(sale_date, '%Y-%m') as month_year";

        $monthlySalesData = Sale::select(
                DB::raw($dateExpression),
                DB::raw("COUNT(*) as total_transactions"),
                DB::raw("SUM(sale_price) as total_revenue")
            )
            ->groupBy('month_year')
            ->orderBy('month_year', 'asc')
            ->take(6)
            ->get();

        $chartLabels = [];
        $chartRevenue = [];
        $chartTransactions = [];

        foreach ($monthlySalesData as $data) {
            $date = \DateTime::createFromFormat('Y-m', $data->month_year);
            $chartLabels[] = $date ? $date->format('M Y') : $data->month_year;
            $chartRevenue[] = (float) $data->total_revenue;
            $chartTransactions[] = (int) $data->total_transactions;
        }

        if ($user->isAdmin()) {
            return view('dashboard.admin', compact(
                'totalCars', 'availableCars', 'reservedCars', 'soldCars',
                'totalSalesRevenue', 'totalSalesCount',
                'recentCars', 'recentSales',
                'chartLabels', 'chartRevenue', 'chartTransactions'
            ));
        }

        return view('dashboard.owner', compact(
            'totalCars', 'availableCars', 'reservedCars', 'soldCars',
            'totalSalesRevenue', 'totalSalesCount',
            'recentCars', 'recentSales',
            'chartLabels', 'chartRevenue', 'chartTransactions'
        ));
    }
}
