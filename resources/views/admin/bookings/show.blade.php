@extends('layouts.admin')

@section('title', 'Booking Details - ' . $booking->booking_reference)

@section('content')
<div class="container-fluid">
    <!-- Header with Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0">Booking Details</h2>
            <p class="text-muted mb-0">PNR: <strong>{{ $booking->booking_reference }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Booking Information -->
        <div class="col-lg-8">
            <!-- Status Overview -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Booking Status</h5>
                    <div>
                        @if($booking->booking_status === 'confirmed')
                            <span class="badge bg-success fs-6">Confirmed</span>
                        @elseif($booking->booking_status === 'pending')
                            <span class="badge bg-warning fs-6">Pending</span>
                        @elseif($booking->booking_status === 'cancelled')
                            <span class="badge bg-danger fs-6">Cancelled</span>
                        @else
                            <span class="badge bg-secondary fs-6">{{ ucfirst($booking->booking_status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Booking Reference (PNR)</label>
                            <div class="fw-bold">{{ $booking->booking_reference }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Booking Date</label>
                            <div class="fw-bold">{{ $booking->booking_date->format('d M, Y h:i A') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Payment Status</label>
                            <div>
                                @if($booking->payment_status === 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($booking->payment_status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($booking->payment_status === 'refunded')
                                    <span class="badge bg-info">Refunded</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($booking->payment_status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Payment Method</label>
                            <div class="fw-bold">{{ $booking->payment_method ? ucfirst($booking->payment_method) : 'N/A' }}</div>
                        </div>
                        @if($booking->payment_reference)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Payment Reference</label>
                                <div class="fw-bold">{{ $booking->payment_reference }}</div>
                            </div>
                        @endif
                        @if($booking->booking_status === 'cancelled' && $booking->refund_amount)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Refund Amount</label>
                                <div class="fw-bold text-success">৳{{ number_format($booking->refund_amount, 2) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Journey Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-train"></i> Journey Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Train</label>
                            <div class="fw-bold fs-5">{{ $booking->train->name }}</div>
                            <div class="text-muted">{{ $booking->train->train_number }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">From</label>
                            <div class="fw-bold">{{ $booking->train->source_station }}</div>
                            <div class="text-muted small">Departure: {{ $booking->train->departure_time }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">To</label>
                            <div class="fw-bold">{{ $booking->train->destination_station }}</div>
                            <div class="text-muted small">Arrival: {{ $booking->train->arrival_time }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Journey Date</label>
                            <div class="fw-bold">{{ $booking->journey_date->format('l, d F Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Duration</label>
                            <div class="fw-bold">{{ $booking->train->duration }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chair"></i> Seat Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Number of Seats</label>
                            <div class="fw-bold fs-4">{{ $booking->number_of_seats }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Total Fare</label>
                            <div class="fw-bold fs-4 text-success">৳{{ number_format($booking->total_fare, 2) }}</div>
                        </div>
                    </div>
                    
                    <label class="text-muted small">Seat Details</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Seat Number</th>
                                    <th>Coach</th>
                                    <th>Coach Type</th>
                                    <th>Row</th>
                                    <th>Column</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($seats as $seat)
                                    <tr>
                                        <td><strong>{{ $seat->seat_number }}</strong></td>
                                        <td>{{ $seat->trainCoach->coach_number }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $seat->trainCoach->coach_type)) }}</span>
                                        </td>
                                        <td>{{ $seat->row_number }}</td>
                                        <td>{{ $seat->column_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Passenger Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Passenger Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="text-muted small">Passenger Name</label>
                            <div class="fw-bold">{{ $booking->passenger_details['name'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Age</label>
                            <div class="fw-bold">{{ $booking->passenger_details['age'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Gender</label>
                            <div class="fw-bold">{{ ucfirst($booking->passenger_details['gender'] ?? 'N/A') }}</div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Contact Phone</label>
                            <div class="fw-bold">{{ $booking->passenger_details['contact_phone'] ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Contact Email</label>
                            <div class="fw-bold">{{ $booking->passenger_details['contact_email'] ?? 'N/A' }}</div>
                        </div>
                    </div>

                    @if($booking->special_requests)
                        <div class="mt-3">
                            <label class="text-muted small">Special Requests</label>
                            <div class="alert alert-info mb-0">{{ $booking->special_requests }}</div>
                        </div>
                    @endif

                    @if(isset($booking->passenger_details['admin_notes']))
                        <div class="mt-3">
                            <label class="text-muted small">Admin Notes</label>
                            <div class="alert alert-warning mb-0">{{ $booking->passenger_details['admin_notes'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar - Actions -->
        <div class="col-lg-4">
            <!-- User Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Name</label>
                        <div class="fw-bold">{{ $booking->user->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <div>{{ $booking->user->email }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Phone</label>
                        <div>{{ $booking->user->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small">User ID</label>
                        <div><code>{{ $booking->user->id }}</code></div>
                    </div>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-cog"></i> Admin Actions</h5>
                </div>
                <div class="card-body">
                    @if($booking->canBeCancelled())
                        <a href="{{ route('admin.bookings.cancel-confirm', $booking) }}" 
                           class="btn btn-danger w-100 mb-2">
                            <i class="fas fa-times-circle"></i> Cancel Booking
                        </a>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This booking cannot be cancelled.
                            @if($booking->booking_status === 'cancelled')
                                It has already been cancelled.
                            @elseif($booking->journey_date->isPast())
                                The journey date has passed.
                            @endif
                        </div>
                    @endif

                    <!-- Update Status Form -->
                    <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label for="booking_status" class="form-label small">Update Status</label>
                            <select name="booking_status" id="booking_status" class="form-select form-select-sm">
                                <option value="pending" {{ $booking->booking_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->booking_status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $booking->booking_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ $booking->booking_status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label small">Notes (Optional)</label>
                            <textarea name="notes" id="notes" class="form-control form-control-sm" rows="2" placeholder="Add notes..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-clock"></i> Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Created At</label>
                        <div>{{ $booking->created_at->format('d M, Y h:i A') }}</div>
                        <small class="text-muted">{{ $booking->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small">Last Updated</label>
                        <div>{{ $booking->updated_at->format('d M, Y h:i A') }}</div>
                        <small class="text-muted">{{ $booking->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
