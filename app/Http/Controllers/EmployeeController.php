<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    private const CACHE_TTL = 600;
    private const CACHE_EMPLOYEES_LIST_KEY = 'employees_list';
    private const CACHE_EMPLOYEE_KEY_PREFIX = 'employee_';

    /**
     * @OA\Get(
     *     path="/api/employees",
     *     operationId="getEmployees",
     *     tags={"Employees"},
     *     summary="Get list of employees",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Employee"))
     *     ),
     * )
     */
    public function index()
    {
        return Cache::remember(self::CACHE_EMPLOYEES_LIST_KEY, self::CACHE_TTL, function () {
            return Employee::with('company')->get();
        });
    }

    /**
     * @OA\Post(
     *     path="/api/employees",
     *     operationId="createEmployee",
     *     tags={"Employees"},
     *     summary="Create a new employee",
     *     security={{"BearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(response=400, description="Bad request", @OA\JsonContent())
     * )
     */
    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());

        Cache::forget(self::CACHE_EMPLOYEES_LIST_KEY);

        return response()->json($employee, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/employees/{id}",
     *     operationId="getEmployeeById",
     *     tags={"Employees"},
     *     summary="Get employee by ID",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the employee",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(response=404, description="Employee not found", @OA\JsonContent())
     * )
     */
    public function show($id)
    {
        $cacheKey = self::CACHE_EMPLOYEE_KEY_PREFIX . $id;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return Employee::with('company')->findOrFail($id);
        });
    }

    /**
     * @OA\Put(
     *     path="/api/employees/{id}",
     *     operationId="updateEmployee",
     *     tags={"Employees"},
     *     summary="Update an employee's information",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the employee to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Employee updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Employee")
     *     ),
     *     @OA\Response(response=404, description="Employee not found", @OA\JsonContent())
     * )
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->validated());

        Cache::forget(self::CACHE_EMPLOYEE_KEY_PREFIX . $id);
        Cache::forget(self::CACHE_EMPLOYEES_LIST_KEY);

        return response()->json($employee);
    }

    /**
     * @OA\Delete(
     *     path="/api/employees/{id}",
     *     operationId="deleteEmployee",
     *     tags={"Employees"},
     *     summary="Delete an employee",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the employee to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Employee deleted successfully", @OA\JsonContent()),
     *     @OA\Response(response=404, description="Employee not found", @OA\JsonContent())
     * )
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        Cache::forget(self::CACHE_EMPLOYEE_KEY_PREFIX . $id);
        Cache::forget(self::CACHE_EMPLOYEES_LIST_KEY);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
