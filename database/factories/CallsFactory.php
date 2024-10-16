<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Calls;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CallsFactory extends Factory
{
    protected $model = Calls::class;

    public function definition()
    {
        $status = $this->faker->randomElement(['pending', 'in_progress', 'completed', 'cancelled']);
        $type = $this->faker->randomElement(['inbound', 'outbound']);
        $startedAt = $this->faker->dateTimeBetween('2010-10-9', '2024-10-9');
        $duration = rand(1,60);
        $endedAt = Carbon::parse($startedAt)->addMinutes($duration) ;

        return [
            'user_id' => rand(1, 50),
            'agent_id' => rand(51, 100),
            'status' => $status,
            'type' => $type,
            'description' => $this->faker->sentence,
            'duration' => $duration,
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
        ];
    }
}
