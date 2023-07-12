<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Features\EntityRequest;
use App\Http\Resources\Features\EntityResource;
use App\Models\Entity;
use Exception;
use Illuminate\Support\Facades\DB;

class EntityController extends Controller
{
    use ApiHelpers;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entity = Entity::latest()->get()->each(function ($item) {
            return collect($item)->merge(['rating' => rand(3, 10)])->toArray();
        });
        return new EntityResource($entity);
    }

    /**
     * Store a newly created Entity in storage.
     */
    public function store(EntityRequest $request)
    {
        DB::beginTransaction();

        try {
            $entity = collect($request->safe()->except('entity_detail'))->merge(['user_id' => $request->user()->id]);

            $createdEntity = Entity::create($entity->toArray());

            $entityDetail = $request->safe()->entity_detail;

            $createdEntity->entityDetail()->create($entityDetail);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->fail(400, "Something Wrong, Please Check Your Input Again");
        }

        return $this->onSuccess($createdEntity, "Successfully create Entity", 200);
    }

    /**
     * Display the specified Entity.
     */
    public function show(string $id)
    {
        $completeEntity = Entity::with('entityDetail')->findOrFail($id);

        return $this->onSuccess($completeEntity, "Succefully Fetch Entity Detail", 200);
    }

    /**
     * Update the specified Entity in storage.
     */
    public function update(string $id)
    {
        $completeEntity = Entity::with('entityDetail')->findOrFail($id);

        if ($completeEntity->user_id !== auth()->user()->id) {
            return $this->fail(401, "Entity Does not Belong to user");
        }
    }

    /**
     * Remove the specified Entity from storage.
     */
    public function destroy(Entity $entity)
    {
        if ($entity->user_id !== auth()->user()->id) {
            return $this->fail(401, "Entity Does not Belong to user");
        }

        $entity->delete();
        return $this->succeed(200, "Entity Deleted");
    }

    /**
     * List Entity ForUser
     */
    public function userIndex()
    {
        $entities = Entity::ready()->latest()->get()->each(function ($entity) {
            $entity->rating = rand(4, 10);
        });
        return $this->onSuccess($entities->toArray(), 'Success Fetch Entity', 200);
    }

    public function userIndexOptional()
    {
        $entities = Entity::ready()->latest()->with('entityDetail')->get()->each(function ($entity) {
            $entity->rating = rand(4, 10);
        });
        return $this->onSuccess($entities->toArray(), 'Success Fetch Entity', 200);
    }

    /**
     * 
     */
    public function userShow(string $id)
    {
        $completeEntity = Entity::with('entityDetail')->findOrFail($id);

        $processedCompleteEntity = collect($completeEntity)->merge(['rating' => rand(5, 10)]);

        /**
         * Draft, flatten data  
         */
        // $processedCompleteEntity = $processedCompleteEntity->dot()->mapWithKeys(function ($value, $key) {
        //     return [str_replace('.', '_',$key) => $value];
        // });
        
        return $this->onSuccess($processedCompleteEntity->toArray(), "Succefully Fetch Entity Detail", 200);
    }
}
