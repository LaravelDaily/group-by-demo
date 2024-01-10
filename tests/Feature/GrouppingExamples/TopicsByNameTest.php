<?php

namespace Tests\Feature\GrouppingExamples;

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Str;
use Tests\TestCase;

class TopicsByNameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\TopicController
     * @return void
     */
    public function test_topics_by_name(): void
    {
        $php = Topic::factory()
            ->hasQuestions(2)
            ->create([
                'name' => 'PHP',
            ]);

        $laravel = Topic::factory()
            ->hasQuestions(1)
            ->create([
                'name' => 'Laravel',
            ]);

        $data = Topic::query()
            ->with(['questions'])
            ->get()
            ->keyBy(function (Topic $topic) {
                return Str::of($topic->name)
                    ->append(' - ')
                    ->append($topic->questions->count());
            })
            ->toArray();

        $expected = [
            'PHP - 2' => [
                'id' => 1,
                'name' => 'PHP',
                'created_at' => $php->created_at->toISOString(),
                'updated_at' => $php->updated_at->toISOString(),
                'questions' => $php->questions->toArray(),
            ],
            'Laravel - 1' => [
                'id' => 2,
                'name' => 'Laravel',
                'created_at' => $laravel->created_at->toISOString(),
                'updated_at' => $laravel->updated_at->toISOString(),
                'questions' => $laravel->questions->toArray(),
            ],
        ];

        $this->assertEquals($expected, $data);
    }
}
