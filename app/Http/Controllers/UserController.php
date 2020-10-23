<?php

namespace App\Http\Controllers;

use App\Models\AssetHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
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

    public function index(){
        $user = User::where('role', '!=', 'owner');
        $users = QueryBuilder::for($user)
        ->allowedFilters('name')
        ->allowedSorts('name')
        ->paginate(10);
        $this->responseRequestSuccess($users);          
    }

    public function show($id){
        $user = User::findOrFail($id);
        $user['history'] = $user->assetHistory()
                            ->orderBy('date', 'desc')
                            ->limit(5)
                            ->get();

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
        $user = $request->json()->get('user');
        $user['company_id'] = Auth::user()->company_id;
        $createdUser = User::create($user);
        $this->responseRequestSuccess($createdUser);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->json()->get('user'));
        $this->responseRequestSuccess($user);
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id)->delete();
        $this->responseRequestSuccess($user);
    }

    public function erased()
    {
        $user = User::onlyTrashed();
        $users = QueryBuilder::for($user)
        ->allowedFilters('name')
        ->allowedSorts('name')
        ->paginate(10);
        $this->responseRequestSuccess($users);
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
        ->allowedFilters(['assets.status','assets.name', 'assets.type'])
        ->allowedSorts(['assets.status','assets.name', 'assets.type'])
        ->paginate(10);
        $this->responseRequestSuccess($assets);
    }

    public function assetHistory($id){
        $temp = AssetHistory::where('user_id', $id);

        $history = QueryBuilder::for($temp)
        ->select('asset_histories.*','assets.name', 'assets.image')
        ->join('assets', 'assets.id', 'asset_histories.asset_id')
        ->allowedFilters(['asset_histories.status', 'assets.name', 'assets.type'])
        ->get();
        $this->responseRequestSuccess($history);
    }
}
