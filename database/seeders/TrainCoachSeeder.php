<?php

namespace Database\Seeders;

use App\Models\Train;
use App\Models\TrainCoach;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class TrainCoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trains = Train::all();

        foreach ($trains as $train) {
            // Skip if train already has coaches
            if ($train->coaches()->count() > 0) {
                continue;
            }

            // Get seat configuration from train
            $seatConfig = $train->seat_configuration ?? [];

            // Skip if no seat configuration
            if (empty($seatConfig)) {
                continue;
            }

            $order = 1;

            // Create coaches based on seat configuration
            if (isset($seatConfig['ac_first']) && $seatConfig['ac_first'] > 0) {
                $this->createCoachWithSeats($train->id, 'A', 'AC First Class', 'ac_first', $seatConfig['ac_first'], $order++);
            }

            if (isset($seatConfig['ac_chair']) && $seatConfig['ac_chair'] > 0) {
                $numCoaches = ceil($seatConfig['ac_chair'] / 60); // 60 seats per coach
                for ($i = 1; $i <= $numCoaches; $i++) {
                    $seatsInCoach = min(60, $seatConfig['ac_chair'] - (($i - 1) * 60));
                    $this->createCoachWithSeats($train->id, 'B' . $i, 'AC Chair Car', 'ac_chair', $seatsInCoach, $order++);
                }
            }

            if (isset($seatConfig['first_class']) && $seatConfig['first_class'] > 0) {
                $numCoaches = ceil($seatConfig['first_class'] / 72); // 72 seats per coach
                for ($i = 1; $i <= $numCoaches; $i++) {
                    $seatsInCoach = min(72, $seatConfig['first_class'] - (($i - 1) * 72));
                    $this->createCoachWithSeats($train->id, 'C' . $i, 'First Class', 'first_class', $seatsInCoach, $order++);
                }
            }

            if (isset($seatConfig['second_class']) && $seatConfig['second_class'] > 0) {
                $numCoaches = ceil($seatConfig['second_class'] / 80); // 80 seats per coach
                for ($i = 1; $i <= $numCoaches; $i++) {
                    $seatsInCoach = min(80, $seatConfig['second_class'] - (($i - 1) * 80));
                    $this->createCoachWithSeats($train->id, 'D' . $i, 'Second Class', 'second_class', $seatsInCoach, $order++);
                }
            }

            if (isset($seatConfig['sleeper']) && $seatConfig['sleeper'] > 0) {
                $numCoaches = ceil($seatConfig['sleeper'] / 48); // 48 sleeper berths per coach
                for ($i = 1; $i <= $numCoaches; $i++) {
                    $seatsInCoach = min(48, $seatConfig['sleeper'] - (($i - 1) * 48));
                    $this->createCoachWithSeats($train->id, 'S' . $i, 'Sleeper', 'sleeper', $seatsInCoach, $order++, 2); // 2 seats per row for sleeper
                }
            }
        }
    }

    /**
     * Create a coach and its seats.
     */
    private function createCoachWithSeats($trainId, $coachNumber, $coachName, $coachType, $totalSeats, $order, $seatsPerRow = 4)
    {
        $totalRows = ceil($totalSeats / $seatsPerRow);

        $coach = TrainCoach::create([
            'train_id' => $trainId,
            'coach_number' => $coachNumber,
            'coach_name' => $coachName,
            'coach_type' => $coachType,
            'total_seats' => $totalSeats,
            'seats_per_row' => $seatsPerRow,
            'total_rows' => $totalRows,
            'layout_config' => [
                'aisle_position' => $seatsPerRow == 4 ? 2 : 1, // Aisle after 2nd seat for 4-seat rows
            ],
            'order' => $order,
            'is_active' => true,
        ]);

        // Create seats
        $seatNumber = 1;
        for ($row = 1; $row <= $totalRows; $row++) {
            for ($col = 1; $col <= $seatsPerRow; $col++) {
                if ($seatNumber > $totalSeats) break;

                // Determine seat type
                $seatType = 'middle';
                if ($seatsPerRow == 4) {
                    if ($col == 1 || $col == 4) {
                        $seatType = 'window';
                    } elseif ($col == 2 || $col == 3) {
                        $seatType = 'aisle';
                    }
                } elseif ($seatsPerRow == 2) {
                    $seatType = $col == 1 ? 'window' : 'aisle';
                } elseif ($seatsPerRow == 3) {
                    $seatType = $col == 1 ? 'window' : ($col == 3 ? 'aisle' : 'middle');
                }

                Seat::create([
                    'train_coach_id' => $coach->id,
                    'seat_number' => $coachNumber . '-' . $seatNumber,
                    'row_number' => $row,
                    'column_number' => $col,
                    'seat_type' => $seatType,
                    'is_available' => true,
                    'is_reserved' => false,
                ]);

                $seatNumber++;
            }
        }
    }
}
