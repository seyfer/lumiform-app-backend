<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = ['term', 'last_used_at'];

    protected $dates = ['last_used_at'];

    public function movies() {
        return $this->hasMany(Movie::class, 'term_id');
    }
}
