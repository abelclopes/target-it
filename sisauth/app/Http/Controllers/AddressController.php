<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema(
 *   schema="Address",
 *   type="object",
 *   title="Address",
 *   description="Address model",
 *   @OA\Property(property="id", type="integer", description="Address ID", example=1),
 *   @OA\Property(property="logradouro", type="string", description="Street name", example="123 Main Street"),
 *   @OA\Property(property="numero", type="string", description="House number", example="101"),
 *   @OA\Property(property="bairro", type="string", description="Neighborhood", example="Downtown"),
 *   @OA\Property(property="complemento", type="string", description="Address complement", example="Apartment 5A"),
 *   @OA\Property(property="cep", type="string", description="Postal code", example="12345-678"),
 *   @OA\Property(property="user_id", type="integer", description="Associated user ID", example=1)
 * )
 */
class AddressController extends Controller
{
    /**
     * Display the details of a specific address.
     *
     * @OA\Get(
     *     path="/api/addresses/{id}",
     *     operationId="getAddressDetails",
     *     tags={"Addresses"},
     *     summary="Get details of an address",
     *     description="Returns details of a specific address",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the address",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
     *     )
     * )
     */
    public function show($id)
    {
        $address = Address::findOrFail($id);
        return response()->json($address);
    }

    /**
     * Create a new address for a given user.
     *
     * @OA\Post(
     *     path="/api/addresses/{uid}/new",
     *     operationId="storeAddress",
     *     tags={"Addresses"},
     *     summary="Create a new address",
     *     description="Creates a new address associated with the specified user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="uid",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="logradouro", type="string", description="Street name", example="123 Main Street"),
     *             @OA\Property(property="numero", type="string", description="House number", example="101"),
     *             @OA\Property(property="bairro", type="string", description="Neighborhood", example="Downtown"),
     *             @OA\Property(property="complemento", type="string", description="Address complement", nullable=true, example="Apartment 5A"),
     *             @OA\Property(property="cep", type="string", description="Postal code", example="12345-678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Address created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data provided"
     *     )
     * )
     */
    public function store(Request $request, $uid)
    {
        $validatedData = $request->validate([
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:20',
            'bairro' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'cep' => 'required|string|max:20',
        ]);

        $validatedData['user_id'] = $uid;

        $address = Address::create($validatedData);

        return response()->json($address, Response::HTTP_CREATED);
    }

    /**
     * Update an existing address with the provided details.
     *
     * @OA\Put(
     *     path="/api/addresses/{id}",
     *     operationId="updateAddress",
     *     tags={"Addresses"},
     *     summary="Update an existing address",
     *     description="Updates an existing address with the provided details",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the address to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data to update the address",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="logradouro", type="string", description="Street name"),
     *             @OA\Property(property="numero", type="string", description="House number"),
     *             @OA\Property(property="bairro", type="string", description="Neighborhood"),
     *             @OA\Property(property="complemento", type="string", description="Address complement", nullable=true),
     *             @OA\Property(property="cep", type="string", description="Postal code"),
     *             @OA\Property(property="user_id", type="integer", description="Associated user ID")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid data provided"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        $validatedData = $request->validate([
            'logradouro' => 'string|max:255',
            'numero' => 'string|max:20',
            'bairro' => 'string|max:255',
            'complemento' => 'nullable|string|max:255',
            'cep' => 'string|max:20',
            'user_id' => 'integer'
        ]);

        $address->update($validatedData);

        return response()->json($address);
    }

    /**
     * Delete an existing address.
     *
     * @OA\Delete(
     *     path="/api/addresses/{id}",
     *     operationId="deleteAddress",
     *     tags={"Addresses"},
     *     summary="Delete an existing address",
     *     description="Deletes an existing address by ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the address to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Address deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Address not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
