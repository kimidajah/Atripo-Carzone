<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::where('status', 'tersedia');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model_type', 'LIKE', "%{$search}%")
                  ->orWhere('plate_number', 'LIKE', "%{$search}%");
            });
        }

        // Brand Filter
        if ($request->filled('brand') && $request->brand !== 'all') {
            $query->where('brand', $request->brand);
        }

        // Transmission Filter
        if ($request->filled('transmission') && $request->transmission !== 'all') {
            $query->where('transmission', $request->transmission);
        }

        $cars = $query->latest()->get();

        // Get list of available brands
        $brands = Car::where('status', 'tersedia')
            ->select('brand')
            ->distinct()
            ->pluck('brand');

        $totalAvailable = Car::where('status', 'tersedia')->count();

        return view('welcome', compact('cars', 'brands', 'totalAvailable'));
    }
}
