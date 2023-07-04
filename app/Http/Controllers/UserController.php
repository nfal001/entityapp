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
use Throwable;

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
    function register(RegisterRequest $request) {
        DB::beginTransaction();

        try {
            // return $request- >validated();
            // {
            //     "name": "Sayid",
            //     "email": "",
            //     "password": "",
            //     "first_name": "",
            //     "last_name": "",
            //     "phone": "",
            //     "address": {
            //         "addr_name": "default",
            //         "address": "",
            //         "postal_code": "",
            //         "phone": "",
            //         "district": "",
            //         "city": "",
            //         "province": "",
            //         "address_note": ""
            //     }
            // }

            $user = User::create([
                'name'=>$request->safe()->name,
                'email'=>$request->safe()->email,
                'password'=>$request->safe()->password,
            ]);

            $info = $request->safe()->only('first_name','last_name','phone');
            $userInfo = $user->userInfo()->create($info);

            $address = 
            collect($request->safe()->address)->merge(['is_choosen_address'=>1,'receiver_name'=>$request->safe()->first_name." ".$request->safe()->last_name])
            ?: throw new Exception("Bad Input",400);
            
            $user->address()->create($address->toArray());

            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            return $e;
            return $this->fail(400,"something went Error, check your input again");
        }
        return $this->onSuccess($user,'Account Created',200);
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
