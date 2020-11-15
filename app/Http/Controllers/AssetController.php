<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\User;
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
        Asset::where('company_id', Auth::user()->company_id);
        $asset = Asset::where('company_id', Auth::user()->company_id);

        $assets = QueryBuilder::for($asset)
            ->allowedFilters(['code','name','location','status','type'])
            ->allowedSorts(['name','location','code','status','type'])
            ->paginate(10);
        $this->responseRequestSuccess($assets);
    }

    public function show($id)
    {
        $asset = Asset::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $this->responseRequestSuccess($asset);
    }

    public function store(Request $request)
    {
        $this->validateJson($request, 'asset' , Asset::getValidationRules());

        $data = $request->json()->get('asset');
        $data['company_id'] = Auth::user()->company_id;

        $asset = Asset::firstOrNew($data);
        //asset name boleh sama 
        $asset['status'] = 'available';

        if(! $asset->exists){
            $asset->save();
            $userId = Auth::user()->id;
            AssetHistory::create([
                'user_id' => $userId,
                'asset_id' => $asset->id,
                'status' => $asset->status,
            ]);
        }

        $this->responseRequestSuccess($asset);
    }

    public function update(Request $request, $id)
    {
        $assetNew = $request->json()->get('asset');
        $asset = Asset::where('company_id', Auth::user()->company_id)->findOrFail($id);

        if($asset->status != $assetNew['status']){
            $userId = Auth::user()->id;
            AssetHistory::create([
                'user_id' => $userId,
                'asset_id' => $asset->id,
                'status' => $asset->status,
            ]);
        }
        $asset->update($assetNew);
        $this->responseRequestSuccess($asset);
    }

    public function destroy($id)
    {
        Asset::where('company_id', Auth::user()->company_id)
        ->findOrFail($id)
        ->delete();
        $this->responseRequestSuccess(null);
    }

    public function attachment($id){
        $attachments = Asset::where('company_id', Auth::user()->company_id)
        ->findOrFail($id)
        ->assetAttachment()
        ->get();
        $this->responseRequestSuccess($attachments);
    }

    public function assetHistory($id){
        Asset::where('company_id', Auth::user()->company_id)->findOrFail($id);

        $temp = AssetHistory::where('asset_id', $id);

        $history = QueryBuilder::for($temp)
        ->select('asset_histories.*','users.name as name')
        ->join('users', 'users.id', 'asset_histories.user_id')
        ->allowedFilters(['status', 'name', 'date'])
        ->allowedSorts(['asset_histories.status', 'users.name'])
        ->paginate(5);
        
        $this->responseRequestSuccess($history);
    }

    public function count(){
        // $temp = Asset::class;
        $temp = Asset::where('company_id', Auth::user()->company_id);

        $count = QueryBuilder::for($temp)
        ->allowedFilters('type')
        ->count();

        $this->responseRequestSuccess($count);
    }

    //delete attachment
}
