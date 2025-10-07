<?php

namespace App\Http\Controllers;

use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainSearchController extends Controller
{
    /**
     * Display the train search page and handle search.
     */
    public function index(Request $request)
    {
        // Get unique routes and stations for search filters
        $routes = Train::where('status', 'active')
            ->distinct()
            ->pluck('route')
            ->filter()
            ->sort()
            ->values();

        $stations = Train::where('status', 'active')
            ->select('source_station', 'destination_station')
            ->get()
            ->flatMap(function ($train) {
                return [$train->source_station, $train->destination_station];
            })
            ->unique()
            ->filter()
            ->sort()
            ->values();

        // Check if this is a search request
        $hasSearch = $request->hasAny(['train_number', 'route', 'source_station', 'destination_station', 'departure_time', 'train_type', 'journey_date']);

        if (!$hasSearch) {
            // Just show the search form
            return view('trains.search', compact('routes', 'stations'));
        }

        // Validate search inputs
        $request->validate([
            'train_number' => 'nullable|string|max:50',
            'route' => 'nullable|string|max:255',
            'source_station' => 'nullable|string|max:255',
            'destination_station' => 'nullable|string|max:255',
            'departure_time' => 'nullable|date_format:H:i',
            'train_type' => 'nullable|string|in:express,local,intercity,mail,passenger',
            'journey_date' => 'nullable|date|after_or_equal:today',
        ]);

        $query = Train::where('status', 'active');

        // Filter by train number
        if ($request->filled('train_number')) {
            $query->where('train_number', 'LIKE', '%' . $request->train_number . '%');
        }

        // Filter by route
        if ($request->filled('route')) {
            $query->where('route', 'LIKE', '%' . $request->route . '%');
        }

        // Filter by source station
        if ($request->filled('source_station')) {
            $query->where('source_station', 'LIKE', '%' . $request->source_station . '%');
        }

        // Filter by destination station
        if ($request->filled('destination_station')) {
            $query->where('destination_station', 'LIKE', '%' . $request->destination_station . '%');
        }

        // Filter by train type
        if ($request->filled('train_type')) {
            $query->where('type', $request->train_type);
        }

        // Filter by departure time (with 2-hour range)
        if ($request->filled('departure_time')) {
            $time = $request->departure_time;
            $query->whereTime('departure_time', '>=', $time)
                  ->whereTime('departure_time', '<=', date('H:i', strtotime($time . ' +2 hours')));
        }

        // Order by departure time
        $trains = $query->orderBy('departure_time', 'asc')
                       ->paginate(10)
                       ->appends($request->except('page'));

        return view('trains.search', compact('trains', 'routes', 'stations', 'hasSearch'));
    }

    /**
     * Show train details for booking.
     */
    public function show(Train $train)
    {
        if ($train->status !== 'active') {
            return redirect()->route('trains.search')->with('error', 'This train is not available for booking.');
        }

        return view('trains.details', compact('train'));
    }
}
