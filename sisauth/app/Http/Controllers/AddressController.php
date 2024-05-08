<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema(
 *   schema="Address",
 *   type="object",
 *   title="Address",
 *   description="Address model",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="Address ID",
 *     example=1
 *   ),
 *   @OA\Property(
 *     property="logradouro",
 *     type="string",
 *     description="Street name",
 *     example="123 Main Street"
 *   ),
 *   @OA\Property(
 *     property="numero",
 *     type="string",
 *     description="House number",
 *     example="101"
 *   ),
 *   @OA\Property(
 *     property="bairro",
 *     type="string",
 *     description="Neighborhood",
 *     example="Downtown"
 *   ),
 *   @OA\Property(
 *     property="complemento",
 *     type="string",
 *     description="Address complement",
 *     example="Apartment 5A"
 *   ),
 *   @OA\Property(
 *     property="cep",
 *     type="string",
 *     description="Postal code",
 *     example="12345-678"
 *   )
 * )
 */

class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/addresses/{id}/details",
     *     operationId="showAddressDetails",
     *     tags={"Addresses"},
     *     summary="Display the details of a specific address",
     *     description="Returns the details of a specific address",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the address",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
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
    public function index($id)
    {
        $address = Address::findOrFail($id);
        return response()->json($address);
    }
    /**
     * @OA\Get(
     *     path="/api/addresses/{uid}/user-details",
     *     operationId="showUserAddresses",
     *     tags={"Addresses"},
     *     summary="Display the addresses of a specific user",
     *     description="Returns the addresses of a specific user",
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
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Address"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function getAddresUserId($uid)
    {
        // Carrega o usuário com os endereços relacionados
        $addresses = Address::where('user_id', $uid)->get();

        // Verifica se o usuário foi encontrado
        if (!$addresses) {
            // Retorna uma resposta de erro se o usuário não for encontrado
            return response()->json(['error' => 'addresses not found'], 404);
        }


        // Retorna os endereços como JSON
        return response()->json($addresses);
    }




    /**
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
     *         @OA\JsonContent(ref="#/components/schemas/Address")
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

        // Associe o user_id ao endereço
        $validatedData['user_id'] = $uid;

        $address = Address::create($validatedData);

        return response()->json($address, Response::HTTP_CREATED);
    }



    /**
     * @OA\Put(
     *     path="/api/addresses/{id}/update",
     *     operationId="updateAddress",
     *     tags={"Addresses"},
     *     summary="Update an existing address",
     *     description="Updates an existing address with the provided details",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the address",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Address")
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
        ]);

        $address->update($validatedData);

        return response()->json($address);
    }

    /**
     * @OA\Delete(
     *     path="/api/addresses/{id}/delete",
     *     operationId="deleteAddress",
     *     tags={"Addresses"},
     *     summary="Delete an address",
     *     description="Deletes an existing address",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the address",
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
