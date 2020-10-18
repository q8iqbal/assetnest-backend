<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
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
        $assets = Asset::all();
        $this->responseRequestSuccess($assets);
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        $this->responseRequestSuccess($asset);
    }

    public function store(Request $request)
    {
        $this->validateJson($request, 'assets' , Asset::getValidationRules());
            
        $data = $request->json()->get('asset');
        $asset = Asset::create($data);

        $this->responseRequestSuccess($asset);
    }

    public function update(Request $request, $id)
    {
        $this->validateJson($request, 'assets' ,Asset::getValidationRules());

        $assetNew = $request->json()->get('asset');
        $asset = Asset::findOrFail($id)->update($assetNew);

        $this->responseRequestSuccess($asset);
    }

    public function destroy($id)
    {
        Asset::findOrFail($id)->delete();
        $this->responseRequestSuccess(null);
    }
}
