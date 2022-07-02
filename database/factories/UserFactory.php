<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => 'admin',
            'password' => 'e10adc3949ba59abbe56e057f20f883e', // password
            'role' => 2,
            'full_name' => 'Administrator',
            'gender' => 0,
        ];
    }
}
