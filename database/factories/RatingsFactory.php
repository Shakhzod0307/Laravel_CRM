<?php

namespace Database\Factories;

use App\Models\Calls;
use App\Models\Ratings;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RatingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ratings::class;
    private static int $call_id = 0;
    public function definition()
    {
//        $admin = User::where('role', 'admin')->first();
        self::$call_id++;
        return [
            'user_id' => 201,
            'call_id' => self::$call_id,
            'rating' => rand(1, 5),
        ];
    }
}
