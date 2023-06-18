<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetEntity\SetEntityRequest;
use App\Models\Features\EntityDefinition;
class LandingController extends Controller
{
    public function setEntity(SetEntityRequest $request)
    {
        $validated = $request->validated();
        
        if (EntityDefinition::get()->count() !== 0) {
            return response()->json(['success'=>false,'message'=>'entity already defined']);
        };

        if(is_null($validated['entity'])){
            return response()->json($validated,401);
        }

        $generate = EntityDefinition::create(['name'=>$request->entity]);
        return response()->json([$generate]);
    }
}
