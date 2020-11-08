<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class GamePost extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'term' => 'required|exists:terms,id',
            'user' => 'required|exists:users,id',
            'movies' => 'required|array|size:' . Config::get('app.game.NUMBER_STEPS'),
            'movies.*.id' => 'required|exists:movies,id|distinct',
            'movies.*.guessing' => 'required|numeric|min:0|max:5',
        ];
    }
}
