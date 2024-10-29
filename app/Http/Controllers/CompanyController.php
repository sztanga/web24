<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Response;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/companies",
     *     tags={"Companies"},
     *     summary="List all companies",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="A list of companies",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Company"))
     *     )
     * )
     */
    public function index()
    {
        return Company::with('employees')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/companies",
     *     tags={"Companies"},
     *     summary="Create a new company",
     *     security={{"BearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="My Company"),
     *             @OA\Property(property="NIP", type="string", example="1234567890"),
     *             @OA\Property(property="address", type="string", example="123 Street"),
     *             @OA\Property(property="city", type="string", example="Cityville"),
     *             @OA\Property(property="postal_code", type="string", example="12345")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Company created successfully"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());
        return response()->json($company, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/companies/{id}",
     *     tags={"Companies"},
     *     summary="Get a single company by ID",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Company data"),
     *     @OA\Response(response=404, description="Company not found")
     * )
     */
    public function show($id)
    {
        return Company::with('employees')->findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/companies/{id}",
     *     tags={"Companies"},
     *     summary="Update a company",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Company"),
     *             @OA\Property(property="city", type="string", example="Updated City"),
     *             @OA\Property(property="postal_code", type="string", example="54321")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Company updated successfully"),
     *     @OA\Response(response=400, description="Bad request")
     * )
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->validated());
        return response()->json($company);
    }


    /**
     * @OA\Delete(
     *     path="/api/companies/{id}",
     *     tags={"Companies"},
     *     summary="Delete a company",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Company deleted successfully"),
     *     @OA\Response(response=404, description="Company not found")
     * )
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
