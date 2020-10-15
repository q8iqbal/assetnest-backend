<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register', 'validateJson']]);
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
        
        if(!$company->exists && !$user->exists){

            $company = Company::create($companyInput);

            $user = User::firstOrNew($userInput);
            $user['password'] = Hash::make($userInput['password']);
            $user['role_id'] = 3;
            $user['company_id'] = $company['id'];
            $user->save();

            $company['owner_id'] = $user['id'];
            $company->save();
            return $this->responseRequestSuccess([$user,$company]);
        }

        $string = [
            'message' => 'user and company already exist',
        ];
        return $this->responseRequestError($string,406);
    }

    public function login(Request $request){
        $this->validate($request, User::getLoginValidationRules());
        $credentials = $request->only(['email', 'password']);

        try {
            if (! $token = Auth::attempt($credentials)) {
                return $this->responseRequestError('invalid_credentials', 401);
            }
        } catch (Exception $e) {
            return $this->responseRequestError('could_not_create_token', 500);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();
        $this->responseRequestSuccess('logout sucess');
    }
}