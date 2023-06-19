<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Util\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiHelpers;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::paginate(10);
        return new UserResource($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        //
        return $this->succeed(200,'User Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return $user? new ApiResource($user) : $this->fail(404,'User not Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validated();
        $user = User::find($id);

        $updated = $user->update(['name'=>$validated->name,'email'=>$validated->email,'role'=>$validated->role]);
        return new ApiResource($updated,[],"$id Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);
        return $this->succeed(200,'User Deleted');
    }
}
