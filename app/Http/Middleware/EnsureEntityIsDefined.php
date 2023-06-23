<?php

namespace App\Http\Middleware;

use App\Models\Features\EntityDefinition;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEntityIsDefined
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return response()->json(auth()->user());
        if (EntityDefinition::all()->isEmpty() && !auth()->user()->role === 'admin') {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['success'=>false,'message' => "api server aren't ready, Contact Admin",'status'=>503], 503);
        }
        return $next($request);
    }
}
