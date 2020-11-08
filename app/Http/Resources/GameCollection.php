<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GameCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\GameResource';

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
