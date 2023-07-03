<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Http\Requests\Features\EntityRequest;
use App\Http\Resources\Features\EntityResource;
use App\Http\Resources\Util\ApiResource;
use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entity = Entity::all();
        return new EntityResource($entity);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntityRequest $request)
    {
        $validated = $request->validated();
        
        return response()->json($validated);
        $entity = Entity::create([
            'name'=>$validated->name,
            'price'=>$validated->price,
            'city_id'=>$validated->city,
            'entity_status' => $validated->status,
            'district_id'=>$validated->district,
        ]);
        return new ApiResource($entity,[],'Entity Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * List Entity ForUser
     */
    public function userIndex() {
        
    }

    /**
     * 
     */
    public function userShow(Entity $entity) {
        
    }
}
