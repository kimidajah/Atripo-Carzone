<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        // Search by Brand or Model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'LIKE', "%{$search}%")
                  ->orWhere('model_type', 'LIKE', "%{$search}%")
                  ->orWhere('plate_number', 'LIKE', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Brand
        if ($request->filled('brand') && $request->brand !== 'all') {
            $query->where('brand', $request->brand);
        }

        $cars = $query->latest()->paginate(10)->withQueryString();
        $brands = Car::select('brand')->distinct()->pluck('brand');

        return view('cars.index', compact('cars', 'brands'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(StoreCarRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($data);

        return redirect()->route('cars.index')
            ->with('success', 'Data mobil ' . $data['brand'] . ' ' . $data['model_type'] . ' (' . $data['plate_number'] . ') berhasil ditambahkan.');
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($car->image && Storage::disk('public')->exists($car->image)) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('cars.index')
            ->with('success', 'Data mobil ' . $car->brand . ' ' . $car->model_type . ' berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        // Check if car has existing sales
        if ($car->sales()->exists()) {
            return back()->with('error', 'Mobil tidak dapat dihapus karena sudah memiliki riwayat transaksi penjualan.');
        }

        if ($car->image && Storage::disk('public')->exists($car->image)) {
            Storage::disk('public')->delete($car->image);
        }

        $brandModel = $car->brand . ' ' . $car->model_type;
        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Data mobil ' . $brandModel . ' berhasil dihapus.');
    }
}
