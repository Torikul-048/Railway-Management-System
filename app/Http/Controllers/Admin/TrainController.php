<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrainController extends Controller
{
    /**
     * Display a listing of trains.
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
        $validatedData = $request->validate([
            'train_number' => ['required', 'string', 'max:20', 'unique:trains,train_number'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:express,local,mail,passenger,intercity'],
            'route' => ['required', 'string', 'max:500'],
            'source_station' => ['required', 'string', 'max:255'],
            'destination_station' => ['required', 'string', 'max:255', 'different:source_station'],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_time' => ['required', 'date_format:H:i', 'after:departure_time'],
            'total_seats' => ['required', 'integer', 'min:1', 'max:1000'],
            'fare_per_seat' => ['required', 'numeric', 'min:1'],
            'facilities' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:active,inactive,maintenance'],
        ]);

        // Set available seats equal to total seats initially
        $validatedData['available_seats'] = $validatedData['total_seats'];

        try {
            $train = Train::create($validatedData);

            return redirect()
                ->route('admin.trains.show', $train)
                ->with('success', 'Train schedule created successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create train schedule. Please try again.');
        }
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
        $validatedData = $request->validate([
            'train_number' => ['required', 'string', 'max:20', Rule::unique('trains')->ignore($train->id)],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:express,local,mail,passenger,intercity'],
            'route' => ['required', 'string', 'max:500'],
            'source_station' => ['required', 'string', 'max:255'],
            'destination_station' => ['required', 'string', 'max:255', 'different:source_station'],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_time' => ['required', 'date_format:H:i', 'after:departure_time'],
            'total_seats' => ['required', 'integer', 'min:1', 'max:1000'],
            'fare_per_seat' => ['required', 'numeric', 'min:1'],
            'facilities' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:active,inactive,maintenance'],
        ]);

        try {
            $train->update($validatedData);

            return redirect()
                ->route('admin.trains.show', $train)
                ->with('success', 'Train schedule updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update train schedule. Please try again.');
        }
    }

    /**
     * Remove the specified train from storage.
     */
    public function destroy(Train $train)
    {
        try {
            // Check if train has any bookings
            if ($train->bookings()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete train with existing bookings. Set status to inactive instead.');
            }

            $train->delete();

            return redirect()
                ->route('admin.trains.index')
                ->with('success', 'Train schedule deleted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete train schedule. Please try again.');
        }
    }
}