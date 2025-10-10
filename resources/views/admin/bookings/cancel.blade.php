@extends('layouts.admin')

@section('title', 'Cancel Booking - ' . $booking->booking_reference)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="h3">Cancel Booking</h2>
                <p class="text-muted">Review booking details and confirm cancellation</p>
            </div>

            <!-- Warning Alert -->
            <div class="alert alert-warning" role="alert">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Cancellation Warning</h5>
                <p class="mb-0">This action will cancel the booking and process a refund according to the cancellation policy. This action cannot be undone.</p>
            </div>

            <!-- Booking Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-ticket-alt"></i> Booking Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">PNR</label>
                            <div class="fw-bold">{{ $booking->booking_reference }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Customer</label>
                            <div class="fw-bold">{{ $booking->user->name }}</div>
                            <small class="text-muted">{{ $booking->user->email }}</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small">Train</label>
                            <div class="fw-bold">{{ $booking->train->name }}</div>
                            <small class="text-muted">{{ $booking->train->train_number }} | {{ $booking->train->source_station }} → {{ $booking->train->destination_station }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Journey Date</label>
                            <div class="fw-bold">{{ $booking->journey_date->format('d M, Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Seats</label>
                            <div class="fw-bold">{{ implode(', ', $booking->seat_numbers) }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Total Fare Paid</label>
                            <div class="fw-bold fs-5 text-success">৳{{ number_format($booking->total_fare, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refund Calculation -->
            <div class="card shadow-sm mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator"></i> Refund Calculation</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Days Until Journey</label>
                                <div class="fw-bold fs-4">{{ now()->diffInDays($booking->journey_date) }} days</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small">Refund Percentage</label>
                                <div class="fw-bold fs-4 text-info">{{ $refundPercentage }}%</div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Original Fare:</span>
                        <span class="fw-bold">৳{{ number_format($booking->total_fare, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Refund ({{ $refundPercentage }}%):</span>
                        <span class="fw-bold text-success">৳{{ number_format($refundAmount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Cancellation Fee:</span>
                        <span class="fw-bold text-danger">-৳{{ number_format($booking->total_fare - $refundAmount, 2) }}</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Total Refund:</h5>
                        <h4 class="mb-0 text-success">৳{{ number_format($refundAmount, 2) }}</h4>
                    </div>

                    <!-- Refund Policy Info -->
                    <div class="alert alert-light mt-3 mb-0">
                        <small>
                            <strong>Refund Policy:</strong>
                            <ul class="mb-0 ps-3">
                                <li>More than 7 days: 90% refund</li>
                                <li>5-7 days: 75% refund</li>
                                <li>3-4 days: 50% refund</li>
                                <li>1-2 days: 25% refund</li>
                                <li>Less than 24 hours: No refund</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Cancellation Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-comment"></i> Cancellation Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="cancellation_reason" class="form-label">
                                Cancellation Reason <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                class="form-control @error('cancellation_reason') is-invalid @enderror" 
                                id="cancellation_reason" 
                                name="cancellation_reason" 
                                rows="3" 
                                required
                                placeholder="Enter the reason for cancellation...">{{ old('cancellation_reason') }}</textarea>
                            @error('cancellation_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Admin Notes (Optional)</label>
                            <textarea 
                                class="form-control @error('admin_notes') is-invalid @enderror" 
                                id="admin_notes" 
                                name="admin_notes" 
                                rows="2"
                                placeholder="Add any internal notes (not visible to customer)...">{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirm_cancel" required>
                            <label class="form-check-label" for="confirm_cancel">
                                I confirm that I want to cancel this booking and process a refund of ৳{{ number_format($refundAmount, 2) }}
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times-circle"></i> Confirm Cancellation
                            </button>
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Go Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Form submission confirmation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
</script>
@endpush
