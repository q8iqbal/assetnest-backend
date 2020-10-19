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
        $user = User::class;
        $users = QueryBuilder::for($user)
        ->allowedFilters('name')
        ->allowedSorts('name')
        ->get();
        $this->responseRequestSuccess($users);          
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

    public function show($id){
        $user = User::findOrFail($id);
        $user['history'] = $user->assetHistory()
                            ->orderBy('date', 'desc')
                            ->get(['date' , 'status' , 'id']);

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
}
