<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'question' => $this->faker->word(),
            'topic_id' => Topic::factory(),
        ];
    }
}
