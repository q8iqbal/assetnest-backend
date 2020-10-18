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

    public function index()
    {
        $assethistories = AssetHistory::all();
        $this->responseRequestSuccess($assethistories);
    }
    
    public function show($id)
    {
        $assethistory = AssetHistory::findOrFail($id);
        $this->responseRequestSuccess($assethistory);
    }

    public function store(Request $request)
    {
        $this->validateJson($request, 'assethistory' ,AssetHistory::getValidationRules());
        $assethistory = AssetHistory::create($request->json()->get('assethistory'));
        $this->responseRequestSuccess($assethistory);
    }

    public function update(Request $request, $id)
    {
        $this->validateJson($request, 'assethistory' ,AssetHistory::getValidationRules());
        $assethistory = AssetHistory::findOrFail($id);
        $assethistory->update($request->json()->get('assethistory'));
        $this->responseRequestSuccess($assethistory);
    }

    public function destroy($id)
    {
        AssetHistory::findOrFail($id)->delete();
        $this->responseRequestSuccess(null);
    }
}
