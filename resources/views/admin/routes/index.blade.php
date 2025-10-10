@extends('layouts.admin')

@section('title', 'Route Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Route Management</h1>
            <p class="text-muted">View and manage train routes</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Routes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $routes->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-route fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Stations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stations->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Active Trains</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $routes->sum('train_count') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-train fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Routes Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Train Routes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Route Name</th>
                            <th>Source Station</th>
                            <th>Destination Station</th>
                            <th>Number of Trains</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($routes as $route)
                            <tr>
                                <td><strong>{{ $route->route }}</strong></td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-success"></i>
                                    {{ $route->source_station }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                    {{ $route->destination_station }}
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $route->train_count }} trains</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No routes found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stations List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Stations</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($stations as $station)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-building fa-2x text-primary mb-2"></i>
                            <h6 class="mb-0">{{ $station }}</h6>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
