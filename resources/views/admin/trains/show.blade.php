@extends('layouts.admin')

@section('title', 'Train Details - Railway Management System')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Train Details</h1>
            <p class="text-muted">{{ $train->train_number }} - {{ $train->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.trains.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Back to Trains
            </a>
            <a href="{{ route('admin.trains.edit', $train) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Train
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Train Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-train me-2"></i>Train Information
                    </h6>
                    <div>
                        @switch($train->status)
                            @case('active')
                                <span class="badge bg-success fs-6">Active</span>
                                @break
                            @case('inactive')
                                <span class="badge bg-secondary fs-6">Inactive</span>
                                @break
                            @case('maintenance')
                                <span class="badge bg-warning fs-6">Maintenance</span>
                                @break
                        @endswitch
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Details -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Basic Details</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Train Number:</td>
                                    <td>{{ $train->train_number }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Name:</td>
                                    <td>{{ $train->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Type:</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($train->type) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Route:</td>
                                    <td>{{ $train->route }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <!-- Station Details -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Route Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Source Station:</td>
                                    <td>{{ $train->source_station }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Destination Station:</td>
                                    <td>{{ $train->destination_station }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Departure Time:</td>
                                    <td>
                                        <i class="fas fa-clock text-success me-1"></i>
                                        {{ $train->departure_time->format('H:i') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Arrival Time:</td>
                                    <td>
                                        <i class="fas fa-clock text-danger me-1"></i>
                                        {{ $train->arrival_time->format('H:i') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Journey Timeline -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">Journey Timeline</h6>
                            <div class="d-flex align-items-center justify-content-between bg-light rounded p-3">
                                <div class="text-center">
                                    <div class="fs-4 fw-bold text-success">{{ $train->departure_time->format('H:i') }}</div>
                                    <div class="text-muted">{{ $train->source_station }}</div>
                                    <small class="text-success">Departure</small>
                                </div>
                                <div class="flex-grow-1 mx-3">
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">{{ $train->route }}</small>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="fs-4 fw-bold text-danger">{{ $train->arrival_time->format('H:i') }}</div>
                                    <div class="text-muted">{{ $train->destination_station }}</div>
                                    <small class="text-danger">Arrival</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($train->facilities || $train->description)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Additional Information</h6>
                                @if($train->facilities)
                                    <div class="mb-3">
                                        <strong>Facilities:</strong>
                                        <div class="mt-1">
                                            @foreach(explode(',', $train->facilities) as $facility)
                                                <span class="badge bg-info me-1">{{ trim($facility) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if($train->description)
                                    <div class="mb-3">
                                        <strong>Description:</strong>
                                        <p class="mt-1 text-muted">{{ $train->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics and Actions -->
        <div class="col-lg-4">
            <!-- Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-chart-pie me-2"></i>Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="bg-primary text-white rounded p-3 mb-3">
                                <div class="fs-3 fw-bold">{{ $train->total_seats }}</div>
                                <div>Total Seats</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success text-white rounded p-3 mb-3">
                                <div class="fs-3 fw-bold">{{ $train->available_seats }}</div>
                                <div>Available</div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-12">
                            <div class="bg-info text-white rounded p-3 mb-3">
                                <div class="fs-4 fw-bold">৳{{ number_format($train->fare_per_seat, 2) }}</div>
                                <div>Fare per Seat</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Occupancy Progress -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Occupancy</label>
                        @php
                            $occupancyPercent = $train->total_seats > 0 ? (($train->total_seats - $train->available_seats) / $train->total_seats) * 100 : 0;
                        @endphp
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $occupancyPercent }}%">
                                {{ round($occupancyPercent) }}%
                            </div>
                        </div>
                        <small class="text-muted">{{ $train->total_seats - $train->available_seats }} of {{ $train->total_seats }} seats booked</small>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.trains.edit', $train) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Train
                        </a>
                        <button class="btn btn-danger" onclick="confirmDelete('{{ $train->id }}', '{{ $train->train_number }}')">
                            <i class="fas fa-trash me-2"></i>Delete Train
                        </button>
                    </div>
                </div>
            </div>

            <!-- Metadata Card -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">
                        <i class="fas fa-info-circle me-2"></i>Metadata
                    </h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        <strong>Created:</strong> {{ $train->created_at->format('M j, Y H:i') }}<br>
                        <strong>Updated:</strong> {{ $train->updated_at->format('M j, Y H:i') }}<br>
                        <strong>ID:</strong> {{ $train->id }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete train <strong id="trainNumber"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(trainId, trainNumber) {
    document.getElementById('trainNumber').textContent = trainNumber;
    document.getElementById('deleteForm').action = `/admin/trains/${trainId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
@endsection