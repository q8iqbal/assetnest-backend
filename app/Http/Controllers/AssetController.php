<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware('auth:api');
        $this->middleware('auth.json');
    }

    public function index()
    {
        $asset = Asset::class;
        $assets = QueryBuilder::for($asset)
            ->allowedFilters(['code','name','location'])
            ->allowedSorts(['name','location','code'])
            ->get();
        $this->responseRequestSuccess($assets);
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        $asset['history'] = $asset->assetHistory()->get(['date' , 'status' , 'id']);

        foreach($asset['history'] as $hist){
            $user = AssetHistory::find($hist['id'])
            ->user()
            ->withTrashed()
            ->get('name')
            ->all();
            
            $hist['user'] = $user[0]['name'];
        }

        $this->responseRequestSuccess($asset);
    }

    public function store(Request $request)
    {
        $this->validateJson($request, 'asset' , Asset::getValidationRules());

        $data = $request->json()->get('asset');
        $data['company_id'] = Auth::user()->company_id;
        $asset = Asset::firstOrNew($data);

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
