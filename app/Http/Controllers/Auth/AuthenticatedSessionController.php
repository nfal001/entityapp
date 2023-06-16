<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{

    /**
     * * generate Bearer token, mostly used for mobile & Postman
     */
    public function generateBearerToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_agent' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        
        $identifier = $request->user_agent."_".base64_encode(now()->toISOString());
        $email = $request->email;

        $token = $user->createToken($email."_".$identifier)->plainTextToken;
        return response()->json(['status'=>'success','data'=>['type'=>'Bearer','token'=>$token],"code"=>200]);
    }

    /**
     * * revoke Bearer Token
     */

    public function revokeBearerToken(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status'=>'success',"message"=>"Token Revoked","code"=>200]);
    }


    //  * Auth Web Session Below

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
