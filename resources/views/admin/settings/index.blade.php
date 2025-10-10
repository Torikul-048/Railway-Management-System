@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">System Settings</h1>
        <p class="text-muted">Configure system preferences and settings</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- General Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">General Settings</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">System Name</label>
                            <input type="text" class="form-control" value="Railway Management System" readonly>
                            <small class="text-muted">System name is read-only</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <input type="text" class="form-control" value="BDT (৳)" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time Zone</label>
                            <select class="form-select" disabled>
                                <option>Asia/Dhaka</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Booking Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Booking Settings</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Max Seats per Booking</label>
                            <input type="number" class="form-control" value="10" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Booking Advance Days</label>
                            <input type="number" class="form-control" value="30" readonly>
                            <small class="text-muted">Days in advance customers can book</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Seat Reservation Time (minutes)</label>
                            <input type="number" class="form-control" value="10" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cancellation Policy -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Refund Policy</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Current Refund Policy:</strong>
                        <ul class="mt-2">
                            <li>Within 6 hours of booking: <span class="badge bg-success">90% refund</span></li>
                            <li>Within 12 hours of booking: <span class="badge bg-success">75% refund</span></li>
                            <li>Within 24 hours of booking: <span class="badge bg-warning">50% refund</span></li>
                            <li>Within 48 hours of booking: <span class="badge bg-warning">20% refund</span></li>
                            <li>Less than 6 hours before departure: <span class="badge bg-danger">10% refund</span></li>
                            <li>After departure: <span class="badge bg-danger">No refund</span></li>
                        </ul>
                    </div>
                    <p class="text-muted small">Refund policy is currently fixed. Contact developer to modify.</p>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Laravel Version:</strong></td>
                            <td>{{ app()->version() }}</td>
                        </tr>
                        <tr>
                            <td><strong>PHP Version:</strong></td>
                            <td>{{ PHP_VERSION }}</td>
                        </tr>
                        <tr>
                            <td><strong>Environment:</strong></td>
                            <td><span class="badge bg-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">{{ app()->environment() }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Debug Mode:</strong></td>
                            <td><span class="badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Maintenance Mode -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Maintenance & Cache</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-warning w-100" onclick="alert('This feature requires terminal access')">
                                <i class="fas fa-wrench"></i> Enable Maintenance
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-info w-100" onclick="alert('This feature requires terminal access')">
                                <i class="fas fa-trash"></i> Clear Cache
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-success w-100" onclick="alert('This feature requires terminal access')">
                                <i class="fas fa-sync"></i> Optimize System
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-danger w-100" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-database"></i> Clear Sessions
                            </button>
                        </div>
                    </div>
                    <p class="text-muted small mt-2">
                        <i class="fas fa-info-circle"></i> These actions should be performed via terminal: 
                        <code>php artisan down</code>, 
                        <code>php artisan cache:clear</code>, 
                        <code>php artisan optimize</code>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
