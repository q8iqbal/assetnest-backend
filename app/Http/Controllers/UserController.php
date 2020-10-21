<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->middleware('auth.json');
    }

    public function index(){
        $user = User::class;
        $users = QueryBuilder::for($user)
        ->allowedFilters('name')
        ->allowedSorts('name')
        ->paginate(10);
        $this->responseRequestSuccess($users);          
    }

    public function show($id){
        $user = User::findOrFail($id);
        $user['history'] = $user->assetHistory()
                            ->orderBy('start_date', 'desc')
                            ->limit(5)
                            ->get(['start_date' ,'finish_date' , 'id']);

        foreach($user['history'] as $hist){
            $asset = AssetHistory::find($hist['id'])
            ->asset()
            ->get('name')
            ->all();
            $hist['name'] = $asset[0]['name'];
        }
        $this->responseRequestSuccess($user);
    }

    public function store(Request $request){
        $this->validateJson($request, 'user' ,User::getValidationRules());
        $user = User::create($request->json()->get('user'));
        $this->responseRequestSuccess($user);
    }

    public function update(Request $request, $id)
    {
        $this->validateJson($request, 'user' ,User::getValidationRules());
        $user = User::findOrFail($id);
        $user->update($request->json()->get('user'));
        $this->responseRequestSuccess($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id)->delete();
        $this->responseRequestSuccess($user);
    }

    public function thrash()
    {
        $user = User::onlyTrashed()->get();
        $this->responseRequestSuccess($user);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->restore();
        $this->responseRequestSuccess($user);
    }

    public function assetHolded($id){
        $asset = User::findOrFail($id)->
                asset()->
                where('assets.status','!=', 'available');
        
        $assets = QueryBuilder::for($asset)
        ->allowedFilters('asset_histories.status')
        ->allowedSorts('assets.name')
        ->paginate(10);
        $this->responseRequestSuccess($assets);
    }

    public function assetHistory($id){
        $temp = AssetHistory::where('user_id', $id);

        $history = QueryBuilder::for($temp)
        ->select('asset_histories.*','assets.name')
        ->join('assets', 'assets.id', 'asset_histories.asset_id')
        ->allowedFilters(['asset_histories.status', 'assets.name'])
        ->get();

        // TO DO querybuilder for history + assetname + assetPic
        $this->responseRequestSuccess($history);
    }
}
