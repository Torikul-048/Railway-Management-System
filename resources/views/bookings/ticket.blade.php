<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Train Ticket - {{ $booking->booking_reference }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.6;
        }
        .ticket {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #1f2937;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1f2937;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #1f2937;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #6b7280;
        }
        .booking-ref {
            text-align: center;
            background-color: #f3f4f6;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .booking-ref h2 {
            margin: 0;
            color: #1f2937;
            font-size: 18px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 5px;
        }
        .status-confirmed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-completed {
            background-color: #e9d5ff;
            color: #6b21a8;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background-color: #1f2937;
            color: white;
            padding: 8px 10px;
            margin: 0 0 10px 0;
            font-size: 14px;
            font-weight: bold;
        }
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            padding: 8px 10px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            font-weight: bold;
            width: 30%;
        }
        .info-value {
            display: table-cell;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
        }
        .journey-visual {
            text-align: center;
            padding: 15px 0;
            margin: 15px 0;
            background-color: #f9fafb;
            border-radius: 5px;
        }
        .journey-stations {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
        }
        .journey-arrow {
            margin: 0 15px;
            color: #3b82f6;
        }
        .seats-list {
            display: inline-block;
            padding: 5px 10px;
            background-color: #dbeafe;
            border-radius: 3px;
            margin: 2px;
            font-weight: bold;
        }
        .fare-total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #1f2937;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }
        .qr-section {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 5px;
        }
        .important-notice {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px;
            margin-top: 15px;
            font-size: 11px;
        }
        .important-notice h4 {
            margin: 0 0 5px 0;
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            <h1>Railway Management System</h1>
            <p>E-Ticket</p>
        </div>

        <!-- Booking Reference -->
        <div class="booking-ref">
            <h2>Booking Reference: {{ $booking->booking_reference }}</h2>
            <span class="status-badge status-{{ $booking->booking_status }}">
                {{ strtoupper($booking->booking_status) }}
            </span>
        </div>

        <!-- Journey Information -->
        <div class="section">
            <h3 class="section-title">Journey Details</h3>
            
            <div class="journey-visual">
                <span class="journey-stations">{{ $booking->train->source_station }}</span>
                <span class="journey-arrow">→</span>
                <span class="journey-stations">{{ $booking->train->destination_station }}</span>
            </div>

            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Train Name</div>
                    <div class="info-value">{{ $booking->train->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Train Number</div>
                    <div class="info-value">{{ $booking->train->train_number }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Train Type</div>
                    <div class="info-value">{{ ucfirst($booking->train->type) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Journey Date</div>
                    <div class="info-value">{{ $booking->journey_date->format('l, F d, Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Departure Time</div>
                    <div class="info-value">{{ $booking->train->departure_time }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Arrival Time</div>
                    <div class="info-value">{{ $booking->train->arrival_time }}</div>
                </div>
            </div>
        </div>

        <!-- Passenger & Seat Information -->
        <div class="section">
            <h3 class="section-title">Passenger & Seat Information</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Passenger Name</div>
                    <div class="info-value">{{ $booking->user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Number of Seats</div>
                    <div class="info-value">{{ $booking->number_of_seats }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Seat Numbers</div>
                    <div class="info-value">
                        @if(is_array($booking->seat_numbers))
                            @foreach($booking->seat_numbers as $seat)
                                <span class="seats-list">{{ $seat }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <h3 class="section-title">Payment Details</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Fare per Seat</div>
                    <div class="info-value">৳{{ number_format($booking->train->fare_per_seat, 2) }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Payment Method</div>
                    <div class="info-value">{{ ucfirst($booking->payment_method ?? 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Payment Status</div>
                    <div class="info-value">{{ ucfirst($booking->payment_status) }}</div>
                </div>
                @if($booking->payment_reference)
                <div class="info-row">
                    <div class="info-label">Payment Reference</div>
                    <div class="info-value">{{ $booking->payment_reference }}</div>
                </div>
                @endif
            </div>

            <div class="fare-total">
                Total Fare: ৳{{ number_format($booking->total_fare, 2) }}
            </div>
        </div>

        <!-- Booking Information -->
        <div class="section">
            <h3 class="section-title">Booking Information</h3>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Booking Date</div>
                    <div class="info-value">{{ $booking->booking_date->format('F d, Y h:i A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Contact Email</div>
                    <div class="info-value">{{ $booking->user->email }}</div>
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="important-notice">
            <h4>Important Instructions:</h4>
            <ul style="margin: 5px 0; padding-left: 20px;">
                <li>Please carry a valid photo ID proof during the journey.</li>
                <li>Report to the station at least 30 minutes before departure.</li>
                <li>This ticket is non-transferable and valid only for the mentioned date.</li>
                <li>Keep this ticket safe for verification during the journey.</li>
                <li>Cancellation charges may apply as per railway policy.</li>
            </ul>
        </div>

        <!-- QR Code Section (Placeholder) -->
        <div class="qr-section">
            <p><strong>Scan QR Code for Verification</strong></p>
            <p style="margin: 10px 0; color: #6b7280;">{{ $booking->booking_reference }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a computer-generated ticket and does not require a signature.</p>
            <p>For queries, contact Railway Management System Support</p>
            <p>Printed on {{ now()->format('F d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>
