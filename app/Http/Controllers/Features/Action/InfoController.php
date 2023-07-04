<?php

namespace App\Http\Controllers\Features\Action;

use App\Http\Controllers\Controller;
use App\Http\Resources\Util\ApiResource;
use App\Models\Features\EntityDefinition;
use App\Models\User;
use Illuminate\Http\Request;

class InfoController extends Controller
{   
    public function index(Request $request)
    {
        $data = [
            'entity_definition' => EntityDefinition::get()->first()
        ];
        return new ApiResource($data, ['user' => $request->user()]);
    }
}
