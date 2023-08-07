<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function __invoke()
    {
        $ageList = User::query()
            ->get()
            ->countBy('age')
            ->sortKeys();

        return view('users.index', [
            'ageList' => $ageList
        ]);
    }
}
