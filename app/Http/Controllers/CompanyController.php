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
        $this->middleware('auth.json');
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

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->json()->get('company'));
        $this->responseRequestSuccess($company);
    }
}
