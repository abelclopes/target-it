<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *     schema="Role",
 *     title="Role",
 *     description="Role object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the role"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the role"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp"
 *     )
 * )
 */

class RoleController extends Controller
{
    /**
     * Assign roles to a user.
     *
     * @OA\Post(
     *     path="/api/users/{user}/assign-role",
     *     tags={"Roles"},
     *     summary="Assign roles to a user",
     *     description="Assign roles to a user by user ID.",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"roles"},
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Roles assigned successfully"
     *     )
     * )
     */
    public function assignRole(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);

        return response()->json(['message' => 'Roles assigned successfully']);
    }

    /**
     * Revoke roles from a user.
     *
     * @OA\Post(
     *     path="/api/users/{user}/revoke-role",
     *     tags={"Roles"},
     *     summary="Revoke roles from a user",
     *     description="Revoke roles from a user by user ID.",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"roles"},
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Roles revoked successfully"
     *     )
     * )
     */
    public function revokeRole(Request $request, User $user)
    {
        $user->roles()->detach($request->roles);

        return response()->json(['message' => 'Roles revoked successfully']);
    }

    /**
     * Get roles of a user.
     *
     * @OA\Get(
     *     path="/api/users/{user_id}/roles",
     *     tags={"Roles"},
     *     summary="Get roles of a user",
     *     description="Get roles of a user by user ID.",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Roles retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Role")
     *             )
     *         )
     *     )
     * )
     */
    public function getUserRoles(User $user)
    {
        try {
            $user = User::findOrFail($user->id);
            $roles = $user->roles;
            return response()->json(['roles' => $roles]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
    }



    /**
     * Get all roles.
     *
     * @OA\Get(
     *     path="/api/roles",
     *     tags={"Roles"},
     *     summary="Get all roles",
     *     description="Get all available roles.",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Roles retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Role")
     *             )
     *         )
     *     )
     * )
     */
    public function getAllRoles()
    {
        return response()->json(['roles' => Role::all()]);
    }
}
