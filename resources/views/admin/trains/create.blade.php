@extends('layouts.admin')

@section('title', 'Add New Train')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add New Train Schedule</h1>
            <p class="mt-2 text-sm text-gray-600">Create a new train route and schedule</p>
        </div>
        <a href="{{ route('admin.trains.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.trains.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Train Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Train Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       required
                       placeholder="e.g., Suborno Express"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Train Number -->
            <div>
                <label for="train_number" class="block text-sm font-semibold text-gray-700 mb-2">
                    Train Number <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="train_number" 
                       id="train_number" 
                       value="{{ old('train_number') }}"
                       required
                       placeholder="e.g., TR-001"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('train_number') border-red-500 @enderror">
                @error('train_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Train Type -->
            <div>
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                    Train Type <span class="text-red-500">*</span>
                </label>
                <select name="type" 
                        id="type" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('type') border-red-500 @enderror">
                    <option value="">Select Type</option>
                    <option value="express" {{ old('type') == 'express' ? 'selected' : '' }}>Express</option>
                    <option value="local" {{ old('type') == 'local' ? 'selected' : '' }}>Local</option>
                    <option value="mail" {{ old('type') == 'mail' ? 'selected' : '' }}>Mail</option>
                    <option value="passenger" {{ old('type') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                    <option value="intercity" {{ old('type') == 'intercity' ? 'selected' : '' }}>Intercity</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Total Seats -->
            <div>
                <label for="total_seats" class="block text-sm font-semibold text-gray-700 mb-2">
                    Total Seats <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="total_seats" 
                       id="total_seats" 
                       value="{{ old('total_seats') }}"
                       min="1"
                       required
                       placeholder="e.g., 200"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('total_seats') border-red-500 @enderror">
                @error('total_seats')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Route -->
            <div class="md:col-span-2">
                <label for="route" class="block text-sm font-semibold text-gray-700 mb-2">
                    Route <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="route" 
                       id="route" 
                       value="{{ old('route') }}"
                       required
                       placeholder="e.g., Dhaka - Chittagong - Cox's Bazar"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('route') border-red-500 @enderror">
                @error('route')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Source Station -->
            <div>
                <label for="source_station" class="block text-sm font-semibold text-gray-700 mb-2">
                    Source Station <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="source_station" 
                       id="source_station" 
                       value="{{ old('source_station') }}"
                       required
                       placeholder="e.g., Dhaka"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('source_station') border-red-500 @enderror">
                @error('source_station')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Destination Station -->
            <div>
                <label for="destination_station" class="block text-sm font-semibold text-gray-700 mb-2">
                    Destination Station <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="destination_station" 
                       id="destination_station" 
                       value="{{ old('destination_station') }}"
                       required
                       placeholder="e.g., Chittagong"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('destination_station') border-red-500 @enderror">
                @error('destination_station')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Departure Time -->
            <div>
                <label for="departure_time" class="block text-sm font-semibold text-gray-700 mb-2">
                    Departure Time <span class="text-red-500">*</span>
                </label>
                <input type="time" 
                       name="departure_time" 
                       id="departure_time" 
                       value="{{ old('departure_time') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('departure_time') border-red-500 @enderror">
                @error('departure_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Arrival Time -->
            <div>
                <label for="arrival_time" class="block text-sm font-semibold text-gray-700 mb-2">
                    Arrival Time <span class="text-red-500">*</span>
                </label>
                <input type="time" 
                       name="arrival_time" 
                       id="arrival_time" 
                       value="{{ old('arrival_time') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('arrival_time') border-red-500 @enderror">
                @error('arrival_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fare Per Seat -->
            <div>
                <label for="fare_per_seat" class="block text-sm font-semibold text-gray-700 mb-2">
                    Fare Per Seat (৳) <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="fare_per_seat" 
                       id="fare_per_seat" 
                       value="{{ old('fare_per_seat') }}"
                       step="0.01"
                       min="0"
                       required
                       placeholder="e.g., 500.00"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('fare_per_seat') border-red-500 @enderror">
                @error('fare_per_seat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" 
                        id="status" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('status') border-red-500 @enderror">
                    <option value="">Select Status</option>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Facilities -->
            <div class="md:col-span-2">
                <label for="facilities" class="block text-sm font-semibold text-gray-700 mb-2">
                    Facilities <span class="text-gray-400">(Optional)</span>
                </label>
                <input type="text" 
                       name="facilities" 
                       id="facilities" 
                       value="{{ old('facilities') }}"
                       placeholder="e.g., AC, WiFi, Food Service, Charging Points"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('facilities') border-red-500 @enderror">
                @error('facilities')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description <span class="text-gray-400">(Optional)</span>
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3"
                          placeholder="Additional information about the train..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.trains.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg shadow-md transition">
                <svg class="inline-block w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Train Schedule
            </button>
        </div>
    </form>
</div>
@endsection
