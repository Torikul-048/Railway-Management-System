<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteManagementController extends Controller
{
    /**
     * Display a listing of train routes.
     */
    public function index()
    {
        // Get unique routes from trains
        $routes = Train::select('route', 'source_station', 'destination_station', DB::raw('COUNT(*) as train_count'))
            ->groupBy('route', 'source_station', 'destination_station')
            ->orderBy('train_count', 'desc')
            ->get();

        // Get all stations (unique source and destination)
        $stations = Train::select('source_station as station')
            ->union(Train::select('destination_station as station'))
            ->distinct()
            ->orderBy('station')
            ->pluck('station');

        return view('admin.routes.index', compact('routes', 'stations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
