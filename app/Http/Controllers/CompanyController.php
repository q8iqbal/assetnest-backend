<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    
    public function show()
    {
        $company = Company::findOrFail(Auth::user()->company_id);
        $this->responseRequestSuccess($company);
    }

    public function update(Request $request)
    {
        $company = Company::findOrFail(Auth::user()->company_id);
        $company->update($request->json()->get('company'));
        $this->responseRequestSuccess($company);
    }
}
