<?php

namespace App\Http\Controllers;

use App\Models\AssetHistory;
use Illuminate\Http\Request;

class AssetHistoryController extends Controller
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
    
    public function store(Request $request)
    {
        $this->validateJson($request, 'assethistory' ,AssetHistory::getValidationRules());
        $assethistory = AssetHistory::create($request->json()->get('assethistory'));
        $this->responseRequestSuccess($assethistory);
    }
}
