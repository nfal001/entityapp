<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Features\EntityRequest;
use App\Http\Resources\Features\EntityResource;
use App\Http\Resources\Util\ApiResource;
use App\Models\Entity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntityController extends Controller
{
    use ApiHelpers;
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
        DB::beginTransaction();

        try {
            $entity = collect($request->safe()->except('entity_detail'))->merge('user_id',$request->user()->id);

            $createdEntity = Entity::create($entity->toArray());
            
            $entityDetail = $request->safe()->entity_detail;

            $createdEntity->entityDetail()->create($entityDetail);
            
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            // return $e;
            return $this->fail(400, "Something Wrong, Please Check Your Input Again");
        }
        
        return $this->onSuccess($entity,"Successfully create Entity",200);
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
    public function destroy(Entity $entity)
    {
        $entity->delete();
        return $this->succeed(200,"Entity Deleted");
    }

    /**
     * List Entity ForUser
     */
    public function userIndex()
    {
        $entity = Entity::all();
        return $this->onSuccess($entity, 'Success Fetch Entity', 200);
    }

    /**
     * 
     */
    public function userShow(Entity $entity)
    {
    }
}
