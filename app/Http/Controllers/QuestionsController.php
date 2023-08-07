<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionsController extends Controller
{
    public function __invoke()
    {
        $questions = Question::query()
            ->with(['topic', 'questionAnswers'])
            ->get()
            ->groupBy(function(Question $question){
                return \Str::of($question->question)
                    ->append(' - ')
                    ->append($question->questionAnswers->count())
                    ->toString();
            });


        return view('questions.questionsList', [
            'questions' => $questions
        ]);
    }
}
