<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Login User using email and password
     *
     * @param LoginUserRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $user = User::query()->whereEmail($data["email"])->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json([
                    "success" => false,
                    "message" => "Invalid credentials"
                ], 401);
            }

            $ability = [$user->role->name];

            return response()->json([
                "success" => true,
                "token" => $user->createToken("auth_token", $ability)->plainTextToken,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
