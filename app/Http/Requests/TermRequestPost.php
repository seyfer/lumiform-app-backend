<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TermRequestPost extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // No jokes, the longest movie title is 226 characters long
            // https://www.filmcomment.com/article/top-20-longest-movie-titles/
            'term' => 'required|string|max:226',
        ];
    }
}
