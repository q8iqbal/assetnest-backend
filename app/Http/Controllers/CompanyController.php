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
        $this->middleware('auth');
    }

    public function index()
    {
        $companies = Company::all();

        return response()->json($companies);
    }
    
    public function show($id)
    {
        $company = Company::find($id);

        return response()->json($company);
    }

    public function store(Request $request)
    {
        $company = Company::create($request->all());

        return response()->json($company, 201);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json($company, 200);
    }

    public function destroy($id)
    {
        Company::findOrFail($id)->delete();

        return response('Deleted Successfully', 200);
    }
}
