<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $topicList = [
            [
                'name' => 'Laravel',
                'questions' => [
                    [
                        'name' => 'Who is the creator of Laravel?',
                        'answers' => [
                            ['name' => 'Taylor', 'is_correct' => true],
                            ['name' => 'Povilas', 'is_correct' => false],
                            ['name' => 'Freek', 'is_correct' => false],
                        ]
                    ],
                    [
                        'name' => 'What is the latest version?',
                        'answers' => [
                            ['name' => '15', 'is_correct' => false],
                            ['name' => '13', 'is_correct' => false],
                            ['name' => '10', 'is_correct' => true],
                            ['name' => '9', 'is_correct' => false],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'PHP',
                'questions' => [
                    [
                        'name' => 'What is the current PHP version?',
                        'answers' => [
                            ['name' => '8.2', 'is_correct' => true],
                            ['name' => '7.5', 'is_correct' => false],
                            ['name' => '8.0', 'is_correct' => false],
                        ]
                    ],
                    [
                        'name' => 'How does empty PHP Array look like?',
                        'answers' => [
                            ['name' => 'array{}', 'is_correct' => false],
                            ['name' => 'arr[]', 'is_correct' => false],
                            ['name' => '[]', 'is_correct' => true],
                            ['name' => 'char[]', 'is_correct' => false],
                        ]
                    ],
                ]
            ]
        ];

        foreach ($topicList as $item) {
            $topic = Topic::create(['name' => $item['name']]);
            foreach ($item['questions'] as $questionInfo) {
                $question = $topic->questions()->create([
                    'question' => $questionInfo['name']
                ]);
                foreach ($questionInfo['answers'] as $answer) {
                    $question->questionAnswers()->create([
                        'answer' => $answer['name'],
                        'is_correct' => $answer['is_correct']
                    ]);
                }
            }
        }
    }
}
