<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Schema(
 *   schema="User",
 *   type="object",
 *   title="User",
 *   description="User model",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="User ID",
 *     example=1
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     description="Name of the User",
 *     example="John Doe"
 *   ),
 *   @OA\Property(
 *     property="email",
 *     type="string",
 *     description="Email address of the User",
 *     example="john.doe@example.com"
 *   )
 * )
 */

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     operationId="indexUsers",
     *     tags={"Users"},
     *     summary="Display a listing of users",
     *     description="Returns a list of users",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
}
