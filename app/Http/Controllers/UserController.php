<?php

namespace App\Http\Controllers;

use App\Models\AssetHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedSort;
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
        $this->middleware('auth.json' , ['except' => ['restore']]);
    }

    public function index(){
        $user = User::where('role', '!=', 'owner')
                ->where('company_id', Auth::user()->company_id);

        $users = QueryBuilder::for($user)
        ->allowedFilters(['name','role'])
        ->allowedSorts('name')
        ->paginate(10);
        $this->responseRequestSuccess($users);          
    }

    public function show($id){
        $user = User::where('company_id',Auth::user()->company_id)
                ->findOrFail($id);
        $this->responseRequestSuccess($user);
    }

    public function store(Request $request){
        $this->validateJson($request, 'user' ,User::getValidationRules());
        $user = $request->json()->get('user');

        $user['company_id'] = Auth::user()->company_id;
        $user['password'] = Hash::make($user['password']);
        $createdUser = User::create($user);

        $this->responseRequestSuccess($createdUser);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('company_id',Auth::user()->company_id)
                ->findOrFail($id);

        $data = $request->json()->get('user');
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
            $user->update($data);
        }else{
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'image' => $data['image'],
            ]);
        }
        $this->responseRequestSuccess($user);
    }
    
    public function destroy($id)
    {
        $user = User::where('company_id',Auth::user()->company_id)
        ->findOrFail($id)
        ->delete();

        $this->responseRequestSuccess($user);
    }

    public function erased()
    {
        $user = User::onlyTrashed()
        ->where('company_id',Auth::user()->company_id);

        $users = QueryBuilder::for($user)
        ->allowedFilters('name')
        ->allowedSorts('name')
        ->paginate(10);
        $this->responseRequestSuccess($users);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()
        ->where('id',$id)
        ->where('company_id',Auth::user()->company_id)
        ->restore();

        $this->responseRequestSuccess($user);
    }

    public function assetHolded($id){
        // User::where('company_id',Auth::user()->company_id)
        //         ->findOrFail($id)
        //         ->asset()
        //         ->where('assets.status','!=', 'available')
        //         ->firstOrFail();

        $asset = User::where('company_id',Auth::user()->company_id)
                ->findOrFail($id)
                ->asset()
                ->where('assets.status','!=', 'available');
        
        $assets = QueryBuilder::for($asset)
        ->allowedFilters(['assets.status','assets.name', 'assets.type'])
        ->allowedSorts(['assets.status','assets.name', 'assets.type'])
        ->paginate(10);
        $this->responseRequestSuccess($assets);
    }

    public function assetHistory($id){
        User::where('company_id', Auth::user()->company_id)->findOrFail($id);
        // AssetHistory::where('user_id', $id)->firstOrFail();

        $temp = AssetHistory::where('user_id', $id);

        $history = QueryBuilder::for($temp)
        ->select('asset_histories.*','assets.name', 'assets.image')
        ->join('assets', 'assets.id', 'asset_histories.asset_id')
        ->allowedFilters(['asset_histories.status', 'assets.name', 'assets.type'])
        ->allowedSorts([
            'asset_histories.status', 
            'assets.name', 
            'assets.type', 
            'asset_histories.date',
            AllowedSort::field('date', 'asset_histories.date' ),
            AllowedSort::field('status', 'asset_histories.status' )
        ])
        ->paginate(10);
        
        $this->responseRequestSuccess($history);
    }

    public function changePassword(Request $request,$id){
        $newPassword = Hash::make($request->json()->get('user')['password']);
        
        User::where('company_id',Auth::user()->company_id)->findOrFail($id);

        User::find($id)->update([
            'password' => $newPassword,
        ]);
        
        $this->responseRequestSuccess("password changed");
    }
}