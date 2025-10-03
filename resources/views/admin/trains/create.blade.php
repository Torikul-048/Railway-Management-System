@extends('layouts.admin')

@section('title', 'Add New Train - Railway Management System')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center py-3">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Add New Train Schedule</h1>
            <p class="text-muted">Create a new train schedule with complete details</p>
        </div>
        <div>
            <a href="{{ route('admin.trains.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Trains
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Train Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Train Schedule Details</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.trains.store') }}">
                        @csrf

                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="train_number" class="form-label fw-bold">Train Number *</label>
                                <input type="text" 
                                       class="form-control @error('train_number') is-invalid @enderror" 
                                       id="train_number" 
                                       name="train_number" 
                                       value="{{ old('train_number') }}" 
                                       placeholder="e.g., 12345" 
                                       required>
                                @error('train_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Train Name *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="e.g., Rajdhani Express" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Type and Route -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-bold">Train Type *</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select Train Type</option>
                                    <option value="express" {{ old('type') == 'express' ? 'selected' : '' }}>Express</option>
                                    <option value="local" {{ old('type') == 'local' ? 'selected' : '' }}>Local</option>
                                    <option value="mail" {{ old('type') == 'mail' ? 'selected' : '' }}>Mail</option>
                                    <option value="passenger" {{ old('type') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                                    <option value="intercity" {{ old('type') == 'intercity' ? 'selected' : '' }}>Intercity</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="route" class="form-label fw-bold">Route Description *</label>
                                <input type="text" 
                                       class="form-control @error('route') is-invalid @enderror" 
                                       id="route" 
                                       name="route" 
                                       value="{{ old('route') }}" 
                                       placeholder="e.g., Delhi - Mumbai via Kota" 
                                       required>
                                @error('route')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Station Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="source_station" class="form-label fw-bold">Source Station *</label>
                                <input type="text" 
                                       class="form-control @error('source_station') is-invalid @enderror" 
                                       id="source_station" 
                                       name="source_station" 
                                       value="{{ old('source_station') }}" 
                                       placeholder="e.g., New Delhi" 
                                       required>
                                @error('source_station')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="destination_station" class="form-label fw-bold">Destination Station *</label>
                                <input type="text" 
                                       class="form-control @error('destination_station') is-invalid @enderror" 
                                       id="destination_station" 
                                       name="destination_station" 
                                       value="{{ old('destination_station') }}" 
                                       placeholder="e.g., Mumbai Central" 
                                       required>
                                @error('destination_station')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Timing Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="departure_time" class="form-label fw-bold">Departure Time *</label>
                                <input type="time" 
                                       class="form-control @error('departure_time') is-invalid @enderror" 
                                       id="departure_time" 
                                       name="departure_time" 
                                       value="{{ old('departure_time') }}" 
                                       required>
                                @error('departure_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="arrival_time" class="form-label fw-bold">Arrival Time *</label>
                                <input type="time" 
                                       class="form-control @error('arrival_time') is-invalid @enderror" 
                                       id="arrival_time" 
                                       name="arrival_time" 
                                       value="{{ old('arrival_time') }}" 
                                       required>
                                @error('arrival_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Arrival time must be after departure time</div>
                            </div>
                        </div>

                        <!-- Seat and Fare Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="total_seats" class="form-label fw-bold">Total Seats *</label>
                                <input type="number" 
                                       class="form-control @error('total_seats') is-invalid @enderror" 
                                       id="total_seats" 
                                       name="total_seats" 
                                       value="{{ old('total_seats') }}" 
                                       min="1" 
                                       max="1000" 
                                       placeholder="e.g., 200" 
                                       required>
                                @error('total_seats')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="fare_per_seat" class="form-label fw-bold">Fare per Seat (₹) *</label>
                                <input type="number" 
                                       class="form-control @error('fare_per_seat') is-invalid @enderror" 
                                       id="fare_per_seat" 
                                       name="fare_per_seat" 
                                       value="{{ old('fare_per_seat') }}" 
                                       min="1" 
                                       step="0.01" 
                                       placeholder="e.g., 500.00" 
                                       required>
                                @error('fare_per_seat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : 'selected' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="facilities" class="form-label fw-bold">Facilities</label>
                                <input type="text" 
                                       class="form-control @error('facilities') is-invalid @enderror" 
                                       id="facilities" 
                                       name="facilities" 
                                       value="{{ old('facilities') }}" 
                                       placeholder="e.g., AC, WiFi, Food, Charging Points">
                                @error('facilities')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Additional information about the train...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.trains.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Train Schedule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Help/Information Card -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-2"></i>Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Train Number:</strong> Must be unique across the system
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Timing:</strong> Arrival time must be after departure time
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Stations:</strong> Source and destination must be different
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Seats:</strong> Available seats will be set equal to total seats initially
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <strong>Status:</strong> Set to 'Active' to make train bookable
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection