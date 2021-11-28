<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'mobile_number' => $this->faker->regexify('09[0-9]{9}')
        ];
    }
}
