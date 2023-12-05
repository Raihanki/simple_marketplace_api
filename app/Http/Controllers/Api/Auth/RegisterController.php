<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * API for Register User
     *
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $data['isSeller'] ? $data['role_id'] = 1 : $data['role_id'] = 2;
            $user = User::create($data);
            return response()->json([
                "success" => true,
                "message" => "User created successfully",
                "data" => $user
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
