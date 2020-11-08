<?php

namespace App\Services\movie;

class MovieScoreService
{
    public function generateRandomScore() {
        return mt_rand(0, 50) / 10;
    }
}
