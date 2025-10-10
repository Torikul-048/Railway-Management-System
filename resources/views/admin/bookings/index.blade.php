@extends('layouts.admin')

@section('title', 'Booking Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">Booking Management</h2>
            <p class="text-muted">Manage and monitor all train bookings</p>
        </div>
        <div>
            <a href="{{ route('admin.bookings.export', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Bookings</h6>
                            <h3 class="mb-0">{{ number_format($stats['total_bookings']) }}</h3>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-ticket-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Confirmed</h6>
                            <h3 class="mb-0 text-success">{{ number_format($stats['confirmed_bookings']) }}</h3>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending</h6>
                            <h3 class="mb-0 text-warning">{{ number_format($stats['pending_bookings']) }}</h3>
                        </div>
                        <div class="text-warning">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Revenue</h6>
                            <h3 class="mb-0 text-info">৳{{ number_format($stats['total_revenue'], 2) }}</h3>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-search"></i> Search & Filter Bookings</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.bookings.index') }}">
                <div class="row g-3">
                    <!-- PNR Search -->
                    <div class="col-md-3">
                        <label for="pnr" class="form-label">PNR / Booking Reference</label>
                        <input type="text" class="form-control" id="pnr" name="pnr" 
                               value="{{ request('pnr') }}" placeholder="Enter PNR">
                    </div>

                    <!-- User Search -->
                    <div class="col-md-3">
                        <label for="user" class="form-label">User Name / Email</label>
                        <input type="text" class="form-control" id="user" name="user" 
                               value="{{ request('user') }}" placeholder="Enter name or email">
                    </div>

                    <!-- Phone Search -->
                    <div class="col-md-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ request('phone') }}" placeholder="Enter phone">
                    </div>

                    <!-- Booking Status -->
                    <div class="col-md-3">
                        <label for="status" class="form-label">Booking Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Payment Status -->
                    <div class="col-md-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select class="form-select" id="payment_status" name="payment_status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <!-- Train Filter -->
                    <div class="col-md-3">
                        <label for="train_id" class="form-label">Train</label>
                        <select class="form-select" id="train_id" name="train_id">
                            <option value="">All Trains</option>
                            @foreach($trains as $train)
                                <option value="{{ $train->id }}" {{ request('train_id') == $train->id ? 'selected' : '' }}>
                                    {{ $train->name }} ({{ $train->train_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Journey Date -->
                    <div class="col-md-3">
                        <label for="journey_date" class="form-label">Journey Date</label>
                        <input type="date" class="form-control" id="journey_date" name="journey_date" 
                               value="{{ request('journey_date') }}">
                    </div>

                    <!-- From Date -->
                    <div class="col-md-2">
                        <label for="from_date" class="form-label">Booking From</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" 
                               value="{{ request('from_date') }}">
                    </div>

                    <!-- To Date -->
                    <div class="col-md-2">
                        <label for="to_date" class="form-label">Booking To</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" 
                               value="{{ request('to_date') }}">
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-2">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Booking List</h5>
        </div>
        <div class="card-body p-0">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>PNR</th>
                                <th>User</th>
                                <th>Train</th>
                                <th>Journey Date</th>
                                <th>Seats</th>
                                <th>Fare</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Booked On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->booking_reference }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $booking->train->name }}</div>
                                        <small class="text-muted">{{ $booking->train->train_number }}</small>
                                    </td>
                                    <td>{{ $booking->journey_date->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $booking->number_of_seats }} seats</span>
                                        <br>
                                        <small class="text-muted">{{ implode(', ', array_slice($booking->seat_numbers, 0, 3)) }}{{ count($booking->seat_numbers) > 3 ? '...' : '' }}</small>
                                    </td>
                                    <td>৳{{ number_format($booking->total_fare, 2) }}</td>
                                    <td>
                                        @if($booking->booking_status === 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->booking_status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->booking_status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($booking->booking_status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->payment_status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($booking->payment_status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->payment_status === 'refunded')
                                            <span class="badge bg-info">Refunded</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($booking->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $booking->booking_date->format('d M, Y') }}</div>
                                        <small class="text-muted">{{ $booking->booking_date->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($booking->canBeCancelled())
                                                <a href="{{ route('admin.bookings.cancel-confirm', $booking) }}" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   title="Cancel Booking">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
                        </div>
                        <div>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No bookings found</h5>
                    <p class="text-muted">Try adjusting your search filters</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td {
        vertical-align: middle;
    }
</style>
@endpush
