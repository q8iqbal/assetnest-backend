<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    }

    public function index(){
        $users = User::all();
        $this->responseRequestSuccess($users);
    }
    
    public function show($id){
        $user = User::findOrFail($id);
        $this->responseRequestSuccess($user);
    }

    public function store(Request $request){
        $this->validateJson($request, 'user', User::getValidationRules());

        $user = User::create($request->json()->get('user'));
        $this->responseRequestSuccess($user);
    }

    public function update(Request $request, $id)
    {
        $this->validateJson($request, 'user', User::getValidationRules());
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
