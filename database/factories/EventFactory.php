<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name();
        $slug = Str::slug($name);
        $start = fake()->dateTimeInInterval('-1 months', '+3 months');
        $end = Carbon::parse($start)->addDays(rand(1, 7));
        return [
            'name' => $name,
            'slug' => $slug,
            'start_at' => $start,
            'end_at' => $end
        ];
    }
}
