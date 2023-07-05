<?php

namespace App\Http\Controllers\Features\Action;

use App\Http\Controllers\Controller;
use App\Http\Resources\Util\ApiResource;
use App\Models\Features\EntityDefinition;

class InfoController extends Controller
{   
    public function index()
    {
        $data = [
            'entity_definition' => EntityDefinition::get()->first()
        ];
        
        $infoCollect = collect($data)->merge(['user' => auth()->user()]);

        return new ApiResource($infoCollect->toArray());
    }
}
