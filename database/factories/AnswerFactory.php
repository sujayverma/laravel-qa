<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use  App\Models\User;

class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    { 
        return [
            //
            'body' => $this->faker->paragraph(rand(3,7), true),
            'user_id' => User::pluck('id')->random()
        ];
    }
}
