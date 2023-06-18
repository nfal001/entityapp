<?php
namespace App\Http\Library;

use Illuminate\Http\JsonResponse;

trait ApiHelpers
{
    protected function isAdmin($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('admin');
        }

        return false;
    }

    protected function isWriter($user): bool
    {

        if (!empty($user)) {
            return $user->tokenCan('writer');
        }

        return false;
    }

    protected function isSubscriber($user): bool
    {
        if (!empty($user)) {
            return $user->tokenCan('subscriber');
        }

        return false;
    }

    protected function onSuccess($data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' =>true,
            'message' => $message,
            'data' => $data,
            'status' => $code,
        ], $code);
    }

    function succeed(int $code, string $message):JsonResponse {
        return response()->json([
            'success'=>false,
            'message' => $message,
            'status' => $code,
        ], $code); 
    }

    protected function fail(int $code, string $message = ''): JsonResponse
    {
        return response()->json([
            'success'=>false,
            'message' => $message,
            'status' => $code,
        ], $code);
    }

    // protected function postValidationRules(): array
    // {
    //     return [
    //         'title' => 'required|string',
    //         'content' => 'required|string',
    //     ];
    // }

    // protected function userValidatedRules(): array
    // {
    //     return [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ];
    // }
}