<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Response;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::with('company')->get();
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());
        return response()->json($employee, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return Employee::with('company')->findOrFail($id);
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->validated());

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
