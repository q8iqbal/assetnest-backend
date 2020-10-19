<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $companies = Company::all();
        $this->responseRequestSuccess($companies);
    }
    
    public function show($id)
    {
        $company = Company::findOrFail($id);
        $this->responseRequestSuccess($company);
    }

    public function store(Request $request)
    {
        $this->validateJson($request, 'company' ,Company::getValidationRules());
        $company = Company::create($request->json()->get('company'));
        $this->responseRequestSuccess($company);
    }

    public function update(Request $request, $id)
    {
        $this->validateJson($request, 'company' ,Company::getValidationRules());
        $company = Company::findOrFail($id);
        $company->update($request->json()->get('company'));
        $this->responseRequestSuccess($company);
    }

    public function destroy($id)
    {
        Company::findOrFail($id)->delete();
        $this->responseRequestSuccess(null);
    }
}
