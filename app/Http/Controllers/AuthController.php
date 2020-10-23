<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register']]);
        $this->middleware('auth.json', ['except' => ['login']]);
    }

    public function register(Request $request){
        $this->validateJson($request, 'user' ,User::getValidationRules());
        $this->validateJson($request, 'company' ,Company::getValidationRules());
        
        $userInput = $request->json()->get('user');
        $companyInput = $request->json()->get('company');

        $company = Company::firstOrNew([
            'name' => $companyInput['name'],
        ]);
        $user = User::firstOrNew([
            'email' => $userInput['email'],
        ]);
        
        if(!$company->exist && !$user->exists){

            $company= Company::create($companyInput);
            $company->save();

            $user = User::firstOrNew($userInput);
            $user['password'] = Hash::make($userInput['password']);
            $user['role'] = 'owner';
            $user['company_id'] = $company->id;
            $user->save();

            $this->responseRequestSuccess([
                'user' => $user,
                'company' => $company,
            ]);
        }

        $this->responseRequestError([
            'message' => 'user and company already exist',
        ],406);
    }

    public function login(Request $request){
        $this->validate($request, User::getLoginValidationRules());
        $credentials = $request->only(['email', 'password']);

        try {
            if (! $token = Auth::attempt($credentials)) {
                $this->responseRequestError(['invalid_credentials'], 401);
            }
        } catch (Exception $e) {
            $this->responseRequestError(['could_not_create_token'], 500);
        }

        return $this->respondWithToken($token , Auth::user());
    }

    public function logout()
    {
        Auth::logout();
        $this->responseRequestSuccess(['massage'=>'logout sucess']);
    }
}