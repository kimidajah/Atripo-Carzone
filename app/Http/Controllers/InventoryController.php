<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        // Summary Statistics
        $totalCars = Car::count();
        $availableCount = Car::where('status', 'tersedia')->count();
        $reservedCount = Car::where('status', 'dipesan')->count();
        $soldCount = Car::where('status', 'terjual')->count();

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model_type', 'LIKE', "%{$search}%")
                  ->orWhere('plate_number', 'LIKE', "%{$search}%");
            });
        }

        // Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $cars = $query->latest()->paginate(12)->withQueryString();

        return view('inventory.index', compact(
            'cars', 'totalCars', 'availableCount', 'reservedCount', 'soldCount'
        ));
    }
}
