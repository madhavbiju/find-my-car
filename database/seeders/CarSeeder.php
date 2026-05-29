<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Services\CarScoringService;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'car' => ['make' => 'Maruti Suzuki', 'model' => 'Alto K10', 'variant' => 'VXi', 'body_type' => 'hatchback', 'price' => 506000, 'mileage' => 24.39, 'safety_rating' => 2.0, 'average_review_rating' => 4.1],
                'specifications' => ['engine_cc' => 998, 'power_bhp' => 66, 'torque_nm' => 89, 'airbags' => 2, 'adas' => false, 'sunroof' => false, 'boot_space_l' => 214, 'ground_clearance_mm' => 160, 'fuel_tank_capacity_l' => 27, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Maruti Suzuki', 'model' => 'Swift', 'variant' => 'ZXi', 'body_type' => 'hatchback', 'price' => 829000, 'mileage' => 24.8, 'safety_rating' => 3.0, 'average_review_rating' => 4.3],
                'specifications' => ['engine_cc' => 1197, 'power_bhp' => 80, 'torque_nm' => 112, 'airbags' => 6, 'adas' => false, 'sunroof' => false, 'boot_space_l' => 265, 'ground_clearance_mm' => 163, 'fuel_tank_capacity_l' => 37, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Hyundai', 'model' => 'i20', 'variant' => 'Asta', 'body_type' => 'hatchback', 'price' => 933000, 'mileage' => 20.0, 'safety_rating' => 3.0, 'average_review_rating' => 4.2],
                'specifications' => ['engine_cc' => 1197, 'power_bhp' => 82, 'torque_nm' => 115, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 311, 'ground_clearance_mm' => 170, 'fuel_tank_capacity_l' => 37, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Tata', 'model' => 'Tiago', 'variant' => 'XZ Plus', 'body_type' => 'hatchback', 'price' => 729000, 'mileage' => 19.0, 'safety_rating' => 4.0, 'average_review_rating' => 4.3],
                'specifications' => ['engine_cc' => 1199, 'power_bhp' => 85, 'torque_nm' => 113, 'airbags' => 2, 'adas' => false, 'sunroof' => false, 'boot_space_l' => 242, 'ground_clearance_mm' => 170, 'fuel_tank_capacity_l' => 35, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Tata', 'model' => 'Tiago EV', 'variant' => 'XZ Plus Tech LUX', 'body_type' => 'hatchback', 'price' => 1149000, 'mileage' => 315.0, 'safety_rating' => 4.0, 'average_review_rating' => 4.3],
                'specifications' => ['engine_cc' => 0, 'power_bhp' => 74, 'torque_nm' => 114, 'airbags' => 2, 'adas' => false, 'sunroof' => false, 'boot_space_l' => 240, 'ground_clearance_mm' => 165, 'fuel_tank_capacity_l' => 0, 'fuel_type' => 'electric', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'Honda', 'model' => 'Amaze', 'variant' => 'VX', 'body_type' => 'sedan', 'price' => 916000, 'mileage' => 18.6, 'safety_rating' => 4.0, 'average_review_rating' => 4.2],
                'specifications' => ['engine_cc' => 1199, 'power_bhp' => 89, 'torque_nm' => 110, 'airbags' => 2, 'adas' => false, 'sunroof' => false, 'boot_space_l' => 420, 'ground_clearance_mm' => 170, 'fuel_tank_capacity_l' => 35, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Maruti Suzuki', 'model' => 'Dzire', 'variant' => 'ZXi', 'body_type' => 'sedan', 'price' => 880000, 'mileage' => 22.4, 'safety_rating' => 2.0, 'average_review_rating' => 4.4],
                'specifications' => ['engine_cc' => 1197, 'power_bhp' => 89, 'torque_nm' => 113, 'airbags' => 2, 'adas' => false, 'sunroof' => false, 'boot_space_l' => 378, 'ground_clearance_mm' => 163, 'fuel_tank_capacity_l' => 37, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Honda', 'model' => 'City', 'variant' => 'ZX', 'body_type' => 'sedan', 'price' => 1510000, 'mileage' => 17.8, 'safety_rating' => 5.0, 'average_review_rating' => 4.5],
                'specifications' => ['engine_cc' => 1498, 'power_bhp' => 119, 'torque_nm' => 145, 'airbags' => 6, 'adas' => true, 'sunroof' => true, 'boot_space_l' => 506, 'ground_clearance_mm' => 165, 'fuel_tank_capacity_l' => 40, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Skoda', 'model' => 'Slavia', 'variant' => 'Style 1.0 TSI', 'body_type' => 'sedan', 'price' => 1529000, 'mileage' => 19.4, 'safety_rating' => 5.0, 'average_review_rating' => 4.4],
                'specifications' => ['engine_cc' => 999, 'power_bhp' => 114, 'torque_nm' => 178, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 521, 'ground_clearance_mm' => 179, 'fuel_tank_capacity_l' => 45, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Maruti Suzuki', 'model' => 'Brezza', 'variant' => 'ZXi', 'body_type' => 'compact-suv', 'price' => 1114000, 'mileage' => 19.8, 'safety_rating' => 4.0, 'average_review_rating' => 4.4],
                'specifications' => ['engine_cc' => 1462, 'power_bhp' => 102, 'torque_nm' => 137, 'airbags' => 2, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 328, 'ground_clearance_mm' => 198, 'fuel_tank_capacity_l' => 48, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Hyundai', 'model' => 'Venue', 'variant' => 'SX', 'body_type' => 'compact-suv', 'price' => 1105000, 'mileage' => 17.5, 'safety_rating' => 0.0, 'average_review_rating' => 4.2],
                'specifications' => ['engine_cc' => 1197, 'power_bhp' => 82, 'torque_nm' => 114, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 350, 'ground_clearance_mm' => 190, 'fuel_tank_capacity_l' => 45, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Kia', 'model' => 'Sonet', 'variant' => 'HTX', 'body_type' => 'compact-suv', 'price' => 1149000, 'mileage' => 18.3, 'safety_rating' => 0.0, 'average_review_rating' => 4.3],
                'specifications' => ['engine_cc' => 998, 'power_bhp' => 118, 'torque_nm' => 172, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 385, 'ground_clearance_mm' => 205, 'fuel_tank_capacity_l' => 45, 'fuel_type' => 'petrol', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'Tata', 'model' => 'Nexon', 'variant' => 'Fearless', 'body_type' => 'compact-suv', 'price' => 1259000, 'mileage' => 17.4, 'safety_rating' => 5.0, 'average_review_rating' => 4.5],
                'specifications' => ['engine_cc' => 1199, 'power_bhp' => 118, 'torque_nm' => 170, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 382, 'ground_clearance_mm' => 208, 'fuel_tank_capacity_l' => 44, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Mahindra', 'model' => 'XUV 3XO', 'variant' => 'AX5', 'body_type' => 'compact-suv', 'price' => 1069000, 'mileage' => 18.9, 'safety_rating' => 5.0, 'average_review_rating' => 4.6],
                'specifications' => ['engine_cc' => 1197, 'power_bhp' => 110, 'torque_nm' => 200, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 364, 'ground_clearance_mm' => 201, 'fuel_tank_capacity_l' => 42, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Tata', 'model' => 'Nexon EV', 'variant' => 'Empowered Plus LR', 'body_type' => 'compact-suv', 'price' => 1929000, 'mileage' => 465.0, 'safety_rating' => 5.0, 'average_review_rating' => 4.5],
                'specifications' => ['engine_cc' => 0, 'power_bhp' => 143, 'torque_nm' => 215, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 350, 'ground_clearance_mm' => 205, 'fuel_tank_capacity_l' => 0, 'fuel_type' => 'electric', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'Hyundai', 'model' => 'Creta', 'variant' => 'SX (O)', 'body_type' => 'suv', 'price' => 1742000, 'mileage' => 17.4, 'safety_rating' => 0.0, 'average_review_rating' => 4.5],
                'specifications' => ['engine_cc' => 1497, 'power_bhp' => 113, 'torque_nm' => 144, 'airbags' => 6, 'adas' => true, 'sunroof' => true, 'boot_space_l' => 433, 'ground_clearance_mm' => 190, 'fuel_tank_capacity_l' => 50, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Kia', 'model' => 'Seltos', 'variant' => 'HTX', 'body_type' => 'suv', 'price' => 1520000, 'mileage' => 17.0, 'safety_rating' => 3.0, 'average_review_rating' => 4.4],
                'specifications' => ['engine_cc' => 1497, 'power_bhp' => 113, 'torque_nm' => 144, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 433, 'ground_clearance_mm' => 190, 'fuel_tank_capacity_l' => 50, 'fuel_type' => 'petrol', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Tata', 'model' => 'Harrier', 'variant' => 'Fearless Plus', 'body_type' => 'suv', 'price' => 2249000, 'mileage' => 16.8, 'safety_rating' => 5.0, 'average_review_rating' => 4.6],
                'specifications' => ['engine_cc' => 1956, 'power_bhp' => 168, 'torque_nm' => 350, 'airbags' => 7, 'adas' => true, 'sunroof' => true, 'boot_space_l' => 445, 'ground_clearance_mm' => 205, 'fuel_tank_capacity_l' => 50, 'fuel_type' => 'diesel', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'MG', 'model' => 'Hector', 'variant' => 'Sharp Pro', 'body_type' => 'suv', 'price' => 1972000, 'mileage' => 15.5, 'safety_rating' => 0.0, 'average_review_rating' => 4.2],
                'specifications' => ['engine_cc' => 1956, 'power_bhp' => 168, 'torque_nm' => 350, 'airbags' => 6, 'adas' => true, 'sunroof' => true, 'boot_space_l' => 587, 'ground_clearance_mm' => 192, 'fuel_tank_capacity_l' => 60, 'fuel_type' => 'diesel', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'Mahindra', 'model' => 'Scorpio-N', 'variant' => 'Z8', 'body_type' => 'suv', 'price' => 1874000, 'mileage' => 15.0, 'safety_rating' => 5.0, 'average_review_rating' => 4.6],
                'specifications' => ['engine_cc' => 2198, 'power_bhp' => 172, 'torque_nm' => 400, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 460, 'ground_clearance_mm' => 187, 'fuel_tank_capacity_l' => 57, 'fuel_type' => 'diesel', 'transmission' => 'manual'],
            ],
            [
                'car' => ['make' => 'MG', 'model' => 'Windsor EV', 'variant' => 'Exclusive', 'body_type' => 'suv', 'price' => 1450000, 'mileage' => 331.0, 'safety_rating' => 0.0, 'average_review_rating' => 4.4],
                'specifications' => ['engine_cc' => 0, 'power_bhp' => 134, 'torque_nm' => 200, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 604, 'ground_clearance_mm' => 186, 'fuel_tank_capacity_l' => 0, 'fuel_type' => 'electric', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'Hyundai', 'model' => 'Ioniq 5', 'variant' => 'RWD', 'body_type' => 'suv', 'price' => 4605000, 'mileage' => 631.0, 'safety_rating' => 5.0, 'average_review_rating' => 4.7],
                'specifications' => ['engine_cc' => 0, 'power_bhp' => 214, 'torque_nm' => 350, 'airbags' => 6, 'adas' => true, 'sunroof' => true, 'boot_space_l' => 527, 'ground_clearance_mm' => 163, 'fuel_tank_capacity_l' => 0, 'fuel_type' => 'electric', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'Maruti Suzuki', 'model' => 'Grand Vitara', 'variant' => 'Zeta Plus Hybrid', 'body_type' => 'suv', 'price' => 1843000, 'mileage' => 27.9, 'safety_rating' => 0.0, 'average_review_rating' => 4.3],
                'specifications' => ['engine_cc' => 1490, 'power_bhp' => 114, 'torque_nm' => 141, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 265, 'ground_clearance_mm' => 210, 'fuel_tank_capacity_l' => 45, 'fuel_type' => 'hybrid', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'Toyota', 'model' => 'Innova HyCross', 'variant' => 'ZX (O) Hybrid', 'body_type' => 'suv', 'price' => 3098000, 'mileage' => 23.2, 'safety_rating' => 0.0, 'average_review_rating' => 4.5],
                'specifications' => ['engine_cc' => 1987, 'power_bhp' => 184, 'torque_nm' => 206, 'airbags' => 6, 'adas' => true, 'sunroof' => true, 'boot_space_l' => 300, 'ground_clearance_mm' => 185, 'fuel_tank_capacity_l' => 52, 'fuel_type' => 'hybrid', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'Jeep', 'model' => 'Compass', 'variant' => 'Model S', 'body_type' => 'suv', 'price' => 2833000, 'mileage' => 14.9, 'safety_rating' => 5.0, 'average_review_rating' => 4.3],
                'specifications' => ['engine_cc' => 1956, 'power_bhp' => 168, 'torque_nm' => 350, 'airbags' => 6, 'adas' => false, 'sunroof' => true, 'boot_space_l' => 438, 'ground_clearance_mm' => 205, 'fuel_tank_capacity_l' => 60, 'fuel_type' => 'diesel', 'transmission' => 'automatic'],
            ],
            [
                'car' => ['make' => 'MG', 'model' => 'Gloster', 'variant' => 'Savvy', 'body_type' => 'suv', 'price' => 3999000, 'mileage' => 13.9, 'safety_rating' => 5.0, 'average_review_rating' => 4.2],
                'specifications' => ['engine_cc' => 1996, 'power_bhp' => 212, 'torque_nm' => 480, 'airbags' => 6, 'adas' => true, 'sunroof' => true, 'boot_space_l' => 343, 'ground_clearance_mm' => 210, 'fuel_tank_capacity_l' => 75, 'fuel_type' => 'diesel', 'transmission' => 'automatic'],
            ],
        ];

        $scoring = app(CarScoringService::class);

        foreach ($cars as $data) {
            $car = Car::query()->updateOrCreate(
                collect($data['car'])->only(['make', 'model', 'variant'])->all(),
                $data['car'],
            );

            $car->specification()->updateOrCreate(
                ['car_id' => $car->id],
                ['specifications' => $data['specifications']],
            );

            $car->load('specification');

            $scoring->calculateScores($car);
        }
    }
}
