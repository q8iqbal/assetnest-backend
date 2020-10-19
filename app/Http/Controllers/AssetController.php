<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AssetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function index()
    {
        // if(request()->has('sort')){
        //     $assets = QueryBuilder::for(Asset::class)->allowedSorts(['name','id',])->get();
        // }elseif(request()->has('filter')){
        //     $assets = QueryBuilder::for(Asset::class)->allowedFilters(['name'])->get();
        // }else{
        //     $assets = Asset::all();
        // }
        $assets = QueryBuilder::for(Asset::class)
            ->allowedFilters(['code','name',])
            ->allowedSorts(['name','id',])
            ->get();
        $this->responseRequestSuccess($assets);
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        $this->responseRequestSuccess($asset);
    }

    public function showHistory($id){
        $asset = Asset::findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->validateJson($request, 'asset' , Asset::getValidationRules());
            
        $data = $request->json()->get('asset');
        $asset = Asset::create($data);

        $this->responseRequestSuccess($asset);
    }

    public function update(Request $request, $id)
    {
        $this->validateJson($request, 'asset' ,Asset::getValidationRules());

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
