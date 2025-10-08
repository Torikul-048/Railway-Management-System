@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Booking History</h1>
            <p class="mt-2 text-gray-600">View and manage all your train bookings</p>
        </div>

        <!-- Status Filters -->
        <div class="mb-6 bg-white rounded-lg shadow p-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('bookings.index') }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Bookings
                </a>
                <a href="{{ route('bookings.index', ['status' => 'confirmed']) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition {{ request('status') === 'confirmed' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Confirmed
                </a>
                <a href="{{ route('bookings.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition {{ request('status') === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Pending
                </a>
                <a href="{{ route('bookings.index', ['status' => 'cancelled']) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition {{ request('status') === 'cancelled' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Cancelled
                </a>
                <a href="{{ route('bookings.index', ['status' => 'completed']) }}" 
                   class="px-4 py-2 rounded-md text-sm font-medium transition {{ request('status') === 'completed' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Completed
                </a>
            </div>
        </div>

        <!-- Bookings List -->
        @if($bookings->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Desktop View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Booking Ref
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Train Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Journey Date
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Seats
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Fare
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->booking_reference }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->booking_date->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->train->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->train->train_number }}</div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $booking->train->source_station }} → {{ $booking->train->destination_station }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->journey_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->train->departure_time }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->number_of_seats }} seat(s)</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            @if(is_array($booking->seat_numbers))
                                                {{ implode(', ', array_slice($booking->seat_numbers, 0, 3)) }}
                                                @if(count($booking->seat_numbers) > 3)
                                                    <span class="text-gray-400">+{{ count($booking->seat_numbers) - 3 }} more</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">৳{{ number_format($booking->total_fare, 2) }}</div>
                                        <div class="text-xs text-gray-500">{{ ucfirst($booking->payment_status) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'confirmed' => 'bg-green-100 text-green-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                'completed' => 'bg-purple-100 text-purple-800',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$booking->booking_status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-col space-y-1">
                                            @if($booking->booking_status === 'confirmed' || $booking->booking_status === 'completed')
                                                <a href="{{ route('bookings.download-ticket', $booking) }}" target="_blank" class="text-blue-600 hover:text-blue-900 transition inline-flex items-center" title="Print Ticket">
                                                    <i class="fas fa-print mr-1"></i>
                                                    <span>Print Ticket</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('bookings.confirmation', $booking) }}" class="text-green-600 hover:text-green-900 transition inline-flex items-center" title="View Details">
                                                <i class="fas fa-eye mr-1"></i>
                                                <span>View Details</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile View -->
                <div class="md:hidden">
                    @foreach($bookings as $booking)
                        <div class="p-4 border-b border-gray-200 hover:bg-gray-50 transition">
                            <!-- Booking Reference & Status -->
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->booking_reference }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->booking_date->format('M d, Y') }}</div>
                                </div>
                                @php
                                    $statusColors = [
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-purple-100 text-purple-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$booking->booking_status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </div>

                            <!-- Train Details -->
                            <div class="mb-3">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->train->name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->train->train_number }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $booking->train->source_station }} → {{ $booking->train->destination_station }}
                                </div>
                            </div>

                            <!-- Journey Info -->
                            <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                                <div>
                                    <span class="text-gray-500">Journey:</span>
                                    <div class="text-gray-900">{{ $booking->journey_date->format('M d, Y') }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Time:</span>
                                    <div class="text-gray-900">{{ $booking->train->departure_time }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Seats:</span>
                                    <div class="text-gray-900">{{ $booking->number_of_seats }} seat(s)</div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Fare:</span>
                                    <div class="text-gray-900 font-medium">৳{{ number_format($booking->total_fare, 2) }}</div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-4 pt-2 border-t border-gray-100">
                                @if($booking->booking_status === 'confirmed' || $booking->booking_status === 'completed')
                                    <a href="{{ route('bookings.download-ticket', $booking) }}" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm transition">
                                        <i class="fas fa-print mr-1"></i>Print Ticket
                                    </a>
                                @endif
                                <a href="{{ route('bookings.confirmation', $booking) }}" class="text-green-600 hover:text-green-900 text-sm transition">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-ticket-alt text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Bookings Found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request('status'))
                        No {{ request('status') }} bookings at the moment.
                    @else
                        You haven't made any bookings yet.
                    @endif
                </p>
                <a href="{{ route('trains.search') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
                    <i class="fas fa-search mr-2"></i>Search Trains
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
