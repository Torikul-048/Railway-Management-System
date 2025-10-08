<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Train Ticket - {{ $booking->booking_reference }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .ticket-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 2px solid #1f2937;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #1f2937;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1f2937;
            font-size: 28px;
            margin-bottom: 10px;
        }
        .header p {
            color: #6b7280;
            font-size: 16px;
        }
        .booking-ref {
            text-align: center;
            background-color: #f3f4f6;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        .booking-ref h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
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
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #1f2937;
            color: white;
            padding: 12px 15px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        .info-table td {
            padding: 12px 15px;
        }
        .info-label {
            font-weight: bold;
            color: #374151;
            width: 35%;
        }
        .info-value {
            color: #1f2937;
        }
        .journey-visual {
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            background-color: #f9fafb;
            border-radius: 8px;
        }
        .journey-stations {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
        }
        .journey-arrow {
            margin: 0 20px;
            color: #3b82f6;
            font-size: 24px;
        }
        .seats-container {
            margin-top: 10px;
        }
        .seat-badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #dbeafe;
            border-radius: 4px;
            margin: 4px;
            font-weight: bold;
            color: #1e40af;
        }
        .fare-total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 3px solid #1f2937;
            color: #1f2937;
        }
        .important-notice {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .important-notice h4 {
            color: #92400e;
            margin-bottom: 10px;
        }
        .important-notice ul {
            margin-left: 20px;
            color: #78350f;
        }
        .important-notice li {
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        .no-print {
            text-align: center;
            margin: 30px 0;
        }
        .no-print button {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin: 0 10px;
        }
        .no-print button:hover {
            background-color: #2563eb;
        }
        .no-print .btn-secondary {
            background-color: #6b7280;
        }
        .no-print .btn-secondary:hover {
            background-color: #4b5563;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .ticket-container {
                border: none;
                padding: 20px;
            }
        }
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">🖨️ Print / Save as PDF</button>
        <button class="btn-secondary" onclick="window.close()">✖ Close</button>
    </div>

    <div class="ticket-container">
        <!-- Header -->
        <div class="header">
            <h1>🚂 Railway Management System</h1>
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
            <div class="section-title">Journey Details</div>
            
            <div class="journey-visual">
                <span class="journey-stations">{{ $booking->train->source_station }}</span>
                <span class="journey-arrow">→</span>
                <span class="journey-stations">{{ $booking->train->destination_station }}</span>
            </div>

            <table class="info-table">
                <tr>
                    <td class="info-label">Train Name</td>
                    <td class="info-value">{{ $booking->train->name }}</td>
                </tr>
                <tr>
                    <td class="info-label">Train Number</td>
                    <td class="info-value">{{ $booking->train->train_number }}</td>
                </tr>
                <tr>
                    <td class="info-label">Train Type</td>
                    <td class="info-value">{{ ucfirst($booking->train->type) }}</td>
                </tr>
                <tr>
                    <td class="info-label">Journey Date</td>
                    <td class="info-value">{{ $booking->journey_date->format('l, F d, Y') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Departure Time</td>
                    <td class="info-value">{{ $booking->train->departure_time }}</td>
                </tr>
                <tr>
                    <td class="info-label">Arrival Time</td>
                    <td class="info-value">{{ $booking->train->arrival_time }}</td>
                </tr>
            </table>
        </div>

        <!-- Passenger & Seat Information -->
        <div class="section">
            <div class="section-title">Passenger & Seat Information</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Passenger Name</td>
                    <td class="info-value">{{ $booking->user->name }}</td>
                </tr>
                <tr>
                    <td class="info-label">Number of Seats</td>
                    <td class="info-value">{{ $booking->number_of_seats }}</td>
                </tr>
                <tr>
                    <td class="info-label">Seat Numbers</td>
                    <td class="info-value">
                        <div class="seats-container">
                            @if(is_array($booking->seat_numbers))
                                @foreach($booking->seat_numbers as $seat)
                                    <span class="seat-badge">{{ $seat }}</span>
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <div class="section-title">Payment Details</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Fare per Seat</td>
                    <td class="info-value">৳{{ number_format($booking->train->fare_per_seat, 2) }}</td>
                </tr>
                <tr>
                    <td class="info-label">Payment Method</td>
                    <td class="info-value">{{ ucfirst($booking->payment_method ?? 'N/A') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Payment Status</td>
                    <td class="info-value">{{ ucfirst($booking->payment_status) }}</td>
                </tr>
                @if($booking->payment_reference)
                <tr>
                    <td class="info-label">Payment Reference</td>
                    <td class="info-value">{{ $booking->payment_reference }}</td>
                </tr>
                @endif
            </table>

            <div class="fare-total">
                Total Fare: ৳{{ number_format($booking->total_fare, 2) }}
            </div>
        </div>

        <!-- Booking Information -->
        <div class="section">
            <div class="section-title">Booking Information</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Booking Date</td>
                    <td class="info-value">{{ $booking->booking_date->format('F d, Y h:i A') }}</td>
                </tr>
                <tr>
                    <td class="info-label">Contact Email</td>
                    <td class="info-value">{{ $booking->user->email }}</td>
                </tr>
            </table>
        </div>

        <!-- Important Notice -->
        <div class="important-notice">
            <h4>⚠️ Important Instructions:</h4>
            <ul>
                <li>Please carry a valid photo ID proof during the journey.</li>
                <li>Report to the station at least 30 minutes before departure.</li>
                <li>This ticket is non-transferable and valid only for the mentioned date.</li>
                <li>Keep this ticket safe for verification during the journey.</li>
                <li>Cancellation charges may apply as per railway policy.</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a computer-generated ticket and does not require a signature.</p>
            <p>For queries, contact Railway Management System Support</p>
            <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
        </div>
    </div>

    <script>
        // Auto-print dialog on page load (user can cancel)
        window.onload = function() {
            // Optional: Uncomment to auto-trigger print dialog
            // setTimeout(() => window.print(), 500);
        };
    </script>
</body>
</html>
