<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Response;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public function index()
    {
        return Company::with('employees')->get();
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());
        return response()->json($company, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return Company::with('employees')->findOrFail($id);
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->validated());
        return response()->json($company);
    }


    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
