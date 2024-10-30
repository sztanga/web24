<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    private const CACHE_TTL = 600;
    private const CACHE_COMPANIES_LIST_KEY = 'companies_list';
    private const CACHE_COMPANY_KEY_PREFIX = 'company_';

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
        return Cache::remember(self::CACHE_COMPANIES_LIST_KEY, self::CACHE_TTL, function () {
            return Company::all();
        });
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
     *     @OA\Response(response=201, description="Company created successfully", @OA\JsonContent()),
     *     @OA\Response(response=400, description="Bad request", @OA\JsonContent())
     * )
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());

        Cache::forget(self::CACHE_COMPANIES_LIST_KEY);

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
     *     @OA\Response(response=200, description="Company data", @OA\JsonContent()),
     *     @OA\Response(response=404, description="Company not found", @OA\JsonContent())
     * )
     */
    public function show($id)
    {
        $cacheKey = self::CACHE_COMPANY_KEY_PREFIX . $id;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return Company::findOrFail($id);
        });
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
     *     @OA\Response(response=200, description="Company updated successfully", @OA\JsonContent()),
     *     @OA\Response(response=400, description="Bad request", @OA\JsonContent())
     * )
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->validated());

        Cache::forget(self::CACHE_COMPANY_KEY_PREFIX . $id);
        Cache::forget(self::CACHE_COMPANIES_LIST_KEY);

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
     *     @OA\Response(response=204, description="Company deleted successfully", @OA\JsonContent()),
     *     @OA\Response(response=404, description="Company not found", @OA\JsonContent())
     * )
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        Cache::forget(self::CACHE_COMPANY_KEY_PREFIX . $id);
        Cache::forget(self::CACHE_COMPANIES_LIST_KEY);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
