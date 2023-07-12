<?php

namespace App\Http\Controllers;

use App\Http\Library\ApiHelpers;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Util\ApiResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Register new user from guest middleware
     */
    public function register(RegisterRequest $request) {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'=>$request->safe()->name,
                'email'=>$request->safe()->email,
                'password'=>$request->safe()->password,
            ]);

            $info = $request->safe()->only('first_name','last_name','phone');
            $user->userInfo()->create($info); //userInfo
            $userName = $request->safe()->first_name." ".$request->safe()->last_name;

            $address = 
            collect($request->safe()->address)->merge([
                'is_choosen_address'=>TRUE,
                'receiver_name'=>$userName
            ])
            ?: throw new Exception("Bad Input",400);
            
            $user->address()->create($address->toArray());
            

            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            return $e;
            return $this->fail(400,"something went Error, check your input again");
        }
        
        return $this->onSuccess(['account'=>$user],'Account Created',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // for admin auth
    public function store(Request $request)
    {
        $validated = $request->validated();
        // create user not done

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
        User::find($id)->delete();
        return $this->succeed(200,'User Deleted');
    }
}
