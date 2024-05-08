<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/login",
     *   summary="Login User",
     *   description="Login user and returns a JWT token",
     *   operationId="loginUser",
     *   tags={"Authentication"},
     *   @OA\RequestBody(
     *     required=true,
     *     description="User login credentials",
     *     @OA\JsonContent(
     *       required={"email", "password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password")
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful login",
     *     @OA\JsonContent(
     *       @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1Qi..."),
     *       @OA\Property(property="token_type", type="string", example="bearer"),
     *       @OA\Property(property="expires_in", type="integer", example=3600)
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Invalid credentials"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Could not create token"
     *   )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // Caso algo esteja errado com o JWT
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return $this->respondWithToken($token);
    }



    /**
     * @OA\Get(
     *   path="/api/logout",
     *   summary="Logout User",
     *   description="Logs out the user and invalidate the token",
     *   operationId="logoutUser",
     *   tags={"Authentication"},
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="Successful logout",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Successfully logged out")
     *     )
     *   )
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Return a JSON response with the token data.
     *
     * @param string $token JWT Token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60 // tempo de vida do token
        ]);
    }
}
