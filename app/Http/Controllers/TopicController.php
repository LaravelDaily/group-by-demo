<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class TopicController extends Controller
{
    public function __invoke()
    {
        $topics = Topic::query()
            ->with(['questions'])
            ->get()
            ->keyBy(function(Topic $topic){
                return \Str::of($topic->name)
                    ->append(' - ')
                    ->append($topic->questions->count());
            });

        return view('topics.topics', [
            'topics' => $topics
        ]);
    }
}
