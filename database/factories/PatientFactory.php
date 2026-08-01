<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $birthDate = $this->faker->dateTimeBetween('-80 years', '-1 year');
        $age = now()->diffInYears($birthDate);

        return [
            'health_record_number' => 'HRN-' . str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'mswd_number' => 'MSWD-' . str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'first_name' => $firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $lastName,
            'suffix' => $this->faker->randomElement(['', 'Jr.', 'Sr.', 'III']),
            'birth_date' => $birthDate,
            'age' => $age,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'civil_status' => $this->faker->randomElement(['single', 'married', 'widowed', 'separated']),
            'place_of_birth' => $this->faker->city . ', ' . $this->faker->state,
            'nationality' => 'Filipino',
            'religion' => $this->faker->randomElement(['Roman Catholic', 'Islam', 'Protestant', 'Iglesia ni Cristo', 'Others']),
            'guardian_name' => $this->faker->name,
            'guardian_relationship' => $this->faker->randomElement(['Mother', 'Father', 'Grandparent', 'Aunt', 'Uncle', 'Sibling']),
            'guardian_contact' => $this->faker->phoneNumber,
            'phone_number' => $this->faker->phoneNumber,
            'mobile_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'house_number' => $this->faker->buildingNumber,
            'street' => $this->faker->streetName,
            'barangay' => 'Barangay ' . $this->faker->lastName,
            'city_municipality' => $this->faker->city,
            'province' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'status' => 'active',
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
