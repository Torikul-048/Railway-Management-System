<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;

class TrainController extends Controller
{
    /**
     * Display a listing of the trains.
     */
    public function index()
    {
        $trains = Train::latest()->paginate(10);
        return view('admin.trains.index', compact('trains'));
    }

    /**
     * Show the form for creating a new train.
     */
    public function create()
    {
        return view('admin.trains.create');
    }

    /**
     * Store a newly created train in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'train_number' => 'required|string|unique:trains,train_number',
            'type' => 'required|in:express,local,mail,passenger,intercity',
            'route' => 'required|string|max:255',
            'source_station' => 'required|string|max:255',
            'destination_station' => 'required|string|max:255',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'total_seats' => 'required|integer|min:1',
            'fare_per_seat' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,maintenance',
            'facilities' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Set available_seats to total_seats initially
        $validated['available_seats'] = $validated['total_seats'];

        Train::create($validated);

        return redirect()->route('admin.trains.index')
            ->with('success', 'Train schedule created successfully!');
    }

    /**
     * Display the specified train.
     */
    public function show(Train $train)
    {
        return view('admin.trains.show', compact('train'));
    }

    /**
     * Show the form for editing the specified train.
     */
    public function edit(Train $train)
    {
        return view('admin.trains.edit', compact('train'));
    }

    /**
     * Update the specified train in storage.
     */
    public function update(Request $request, Train $train)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'train_number' => 'required|string|unique:trains,train_number,' . $train->id,
            'type' => 'required|in:express,local,mail,passenger,intercity',
            'route' => 'required|string|max:255',
            'source_station' => 'required|string|max:255',
            'destination_station' => 'required|string|max:255',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'total_seats' => 'required|integer|min:1',
            'fare_per_seat' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,maintenance',
            'facilities' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $train->update($validated);

        return redirect()->route('admin.trains.index')
            ->with('success', 'Train schedule updated successfully!');
    }

    /**
     * Remove the specified train from storage.
     */
    public function destroy(Train $train)
    {
        $train->delete();

        return redirect()->route('admin.trains.index')
            ->with('success', 'Train schedule deleted successfully!');
    }
}
