<?php

namespace App\Http\Controllers\Features\Action;

use App\Http\Controllers\Controller;
use App\Http\Resources\Util\ApiResource;
use App\Models\Features\EntityDefinition;
use App\Models\User;


class InfoController extends Controller
{   
    public function index()
    {
        $data = [
            'entity_definition' => EntityDefinition::get()->first()
        ];
        return new ApiResource($data, ['user' => User::find(auth()->user()->id)->first(['id', 'name', 'email','role'])]);
    }
}
