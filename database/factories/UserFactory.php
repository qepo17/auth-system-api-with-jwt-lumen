<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->username,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' =>  app('hash')->make('12345'),
            'bio' => $this->faker->sentence(1),
            'github' => 'github.com/' . $this->faker->unique()->username,
            'twitter' => 'twitter.com/' . $this->faker->unique()->username,
            'location' => $this->faker->country,
        ];
    }
}
