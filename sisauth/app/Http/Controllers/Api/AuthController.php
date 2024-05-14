<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\POST(
     *     path="/api/auth/login",
     *     tags={"Authentication"},
     *     summary="Login",
     *     description="Login",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *          @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *          @OA\Property(property="password", type="string", format="password", example="password")
     *          ),
     *      ),
     *      @OA\Response(response=200, description="Login" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Refresh Token",
     *     description="Endpoint para atualizar o token JWT.",
     *     operationId="authRefresh",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="Token JWT atualizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example="3600")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token expirado ou inválido",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * @OA\GET(
     *     path="/api/auth/profile",
     *     tags={"Authentication"},
     *     summary="Authenticated User Profile",
     *     description="User Profile",
     *     @OA\Response(response=200, description="Authenticated User Profile" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     *     security={{"bearerAuth": {} }}
     * )
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    /**
     * Change user's password.
     *
     * @OA\Post(
     *      path="/api/auth/change-password",
     *      operationId="changePassword",
     *      tags={"Authentication"},
     *      summary="Change user's password",
     *      description="Change the password of the authenticated user.",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Password change request data",
     *          @OA\JsonContent(
     *              required={"email", "old_password", "new_password"},
     *              @OA\Property(property="email", type="string", format="email", example="user@exemple.com"),
     *              @OA\Property(property="old_password", type="string", format="password", description="Current password", example="oldPassword123"),
     *              @OA\Property(property="new_password", type="string", format="password", description="New password", example="newPassword123")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Password changed successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Password changed successfully"),
     *              @OA\Property(property="user", ref="#/components/schemas/User")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The email provided does not match the email of the authenticated user.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated.")
     *          )
     *      )
     * )
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = auth()->user();

        // Verifica se o email fornecido corresponde ao email do usuário autenticado
        if ($request->email !== $user->email) {
            return response()->json(['message' => 'O email fornecido não corresponde ao email do usuário autenticado.'], 400);
        }

        // Verifica se a senha antiga fornecida corresponde à senha atual do usuário
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'A senha antiga não corresponde.'], 400);
        }

        // Atualiza a senha do usuário
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Senha do usuário alterada com sucesso',
            'user' => $user,
        ], 200);
    }
}
