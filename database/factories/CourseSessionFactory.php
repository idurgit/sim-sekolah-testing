<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\CourseSession;

class CourseSessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseSession::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'session_date' => fake()->date(),
            'session_note' => fake()->word(),
            'course_id' => Course::factory(),
            'classroom_id' => Classroom::factory(),
        ];
    }
}
