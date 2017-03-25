<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::find(1);

        return [
            'id'                    => $user->id,
            'name'                  => $user->name,
            'email'                 => $user->email,
            'current_balance'       => $user->current_balance,
            'current_decorator'     => $user->current_decorator,
            'time_notation_per_day' => $user->time_notation_per_day,
        ];
    }
}
