@extends('layouts.app')

@section('title', 'Search Trains')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Search Train Schedule</h1>
            <p class="text-lg text-gray-600">Find your perfect train journey</p>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-8">
            <form action="{{ route('trains.search') }}" method="GET" class="space-y-6">
                <!-- Quick Search Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Source Station -->
                    <div>
                        <label for="source_station" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            From (Source)
                        </label>
                        <input type="text" 
                               id="source_station" 
                               name="source_station" 
                               value="{{ request('source_station') }}"
                               list="source_stations"
                               placeholder="e.g., Dhaka"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <datalist id="source_stations">
                            @foreach($stations ?? [] as $station)
                                <option value="{{ $station }}">
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Destination Station -->
                    <div>
                        <label for="destination_station" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            To (Destination)
                        </label>
                        <input type="text" 
                               id="destination_station" 
                               name="destination_station" 
                               value="{{ request('destination_station') }}"
                               list="destination_stations"
                               placeholder="e.g., Chittagong"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <datalist id="destination_stations">
                            @foreach($stations ?? [] as $station)
                                <option value="{{ $station }}">
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Journey Date -->
                    <div>
                        <label for="journey_date" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Journey Date
                        </label>
                        <input type="date" 
                               id="journey_date" 
                               name="journey_date" 
                               value="{{ request('journey_date', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <!-- Advanced Filters Toggle -->
                <div x-data="{ showAdvanced: {{ request()->hasAny(['train_number', 'route', 'departure_time', 'train_type']) ? 'true' : 'false' }} }">
                    <button type="button" 
                            @click="showAdvanced = !showAdvanced"
                            class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center">
                        <span x-text="showAdvanced ? 'Hide Advanced Filters' : 'Show Advanced Filters'"></span>
                        <svg class="w-4 h-4 ml-1 transform transition-transform" :class="{'rotate-180': showAdvanced}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Advanced Filters -->
                    <div x-show="showAdvanced" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        
                        <!-- Train Number -->
                        <div>
                            <label for="train_number" class="block text-sm font-medium text-gray-700 mb-2">Train Number</label>
                            <input type="text" 
                                   id="train_number" 
                                   name="train_number" 
                                   value="{{ request('train_number') }}"
                                   placeholder="e.g., 701"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Route -->
                        <div>
                            <label for="route" class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                            <input type="text" 
                                   id="route" 
                                   name="route" 
                                   value="{{ request('route') }}"
                                   list="routes"
                                   placeholder="e.g., Dhaka-Chittagong"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <datalist id="routes">
                                @foreach($routes ?? [] as $route)
                                    <option value="{{ $route }}">
                                @endforeach
                            </datalist>
                        </div>

                        <!-- Train Type -->
                        <div>
                            <label for="train_type" class="block text-sm font-medium text-gray-700 mb-2">Train Type</label>
                            <select id="train_type" 
                                    name="train_type"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Types</option>
                                <option value="express" {{ request('train_type') === 'express' ? 'selected' : '' }}>Express</option>
                                <option value="local" {{ request('train_type') === 'local' ? 'selected' : '' }}>Local</option>
                                <option value="intercity" {{ request('train_type') === 'intercity' ? 'selected' : '' }}>Intercity</option>
                                <option value="mail" {{ request('train_type') === 'mail' ? 'selected' : '' }}>Mail</option>
                                <option value="passenger" {{ request('train_type') === 'passenger' ? 'selected' : '' }}>Passenger</option>
                            </select>
                        </div>

                        <!-- Departure Time -->
                        <div>
                            <label for="departure_time" class="block text-sm font-medium text-gray-700 mb-2">Departure Time</label>
                            <input type="time" 
                                   id="departure_time" 
                                   name="departure_time" 
                                   value="{{ request('departure_time') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Search Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search Trains
                    </button>
                    @if(request()->hasAny(['train_number', 'route', 'source_station', 'destination_station', 'departure_time', 'train_type', 'journey_date']))
                        <a href="{{ route('trains.search') }}" 
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Search Results -->
        @if(isset($trains))
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">
                        @if($hasSearch ?? false)
                            Search Results
                            <span class="text-lg font-normal text-gray-600">({{ $trains->total() }} trains found)</span>
                        @else
                            Available Trains
                            <span class="text-lg font-normal text-gray-600">({{ $trains->total() }} trains)</span>
                        @endif
                    </h2>
                </div>

                @if($trains->count() > 0)
                    <div class="space-y-4">
                        @foreach($trains as $train)
                            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                                        <!-- Train Info -->
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between mb-3">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $train->name }}</h3>
                                                    <div class="flex items-center gap-3 text-sm text-gray-600">
                                                        <span class="font-medium">{{ $train->train_number }}</span>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                            @if($train->type === 'express') bg-blue-100 text-blue-800
                                                            @elseif($train->type === 'intercity') bg-purple-100 text-purple-800
                                                            @elseif($train->type === 'local') bg-green-100 text-green-800
                                                            @else bg-gray-100 text-gray-800 @endif">
                                                            {{ ucfirst($train->type) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Route Info -->
                                            <div class="flex items-center gap-4 mb-3">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-3">
                                                        <div class="text-center">
                                                            <p class="text-2xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($train->departure_time)->format('H:i') }}</p>
                                                            <p class="text-sm text-gray-600 font-medium">{{ $train->source_station }}</p>
                                                        </div>
                                                        <div class="flex-1 flex items-center">
                                                            <div class="h-0.5 bg-gray-300 flex-1"></div>
                                                            <svg class="w-5 h-5 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                            <div class="h-0.5 bg-gray-300 flex-1"></div>
                                                        </div>
                                                        <div class="text-center">
                                                            <p class="text-2xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($train->arrival_time)->format('H:i') }}</p>
                                                            <p class="text-sm text-gray-600 font-medium">{{ $train->destination_station }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Additional Info -->
                                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Duration: {{ \Carbon\Carbon::parse($train->departure_time)->diffForHumans(\Carbon\Carbon::parse($train->arrival_time), true) }}
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    Available: {{ $train->available_seats }}/{{ $train->total_seats }} seats
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pricing & Action -->
                                        <div class="flex lg:flex-col items-center lg:items-end justify-between lg:justify-center gap-4">
                                            <div class="text-center lg:text-right">
                                                <p class="text-sm text-gray-600 mb-1">Starting from</p>
                                                <p class="text-3xl font-bold text-blue-600">৳{{ number_format($train->fare_per_seat, 2) }}</p>
                                                <p class="text-xs text-gray-500">per seat</p>
                                            </div>
                                            <div class="flex flex-col gap-2">
                                                <a href="{{ route('trains.details', $train->id) }}" 
                                                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-center whitespace-nowrap">
                                                    View Details
                                                </a>
                                                @if($train->available_seats > 0)
                                                    <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 whitespace-nowrap">
                                                        Book Now
                                                    </button>
                                                @else
                                                    <button disabled class="bg-gray-300 text-gray-500 font-semibold py-3 px-6 rounded-lg cursor-not-allowed whitespace-nowrap">
                                                        Sold Out
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $trains->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-md p-12 text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No Trains Found</h3>
                        <p class="text-gray-600 mb-6">We couldn't find any trains matching your search criteria. Please try different filters.</p>
                        <a href="{{ route('trains.search') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection