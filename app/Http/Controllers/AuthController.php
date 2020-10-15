<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register', 'jsonLoginCheck']]);
    }

    public function validateJson(Request $request){
        if ($request->isJson()){

            $validateUser = Validator::make($request->get('user'),User::getValidationRules());
            $validateCompany = Validator::make($request->get('company'),Company::getValidationRules());

            if($validateCompany->fails() || $validateUser->fails()){
                return response()->json([
                    'message' => $validateCompany->errors()->all(),
                ],401);
            }

        }else{
            return response()->json([
                'message' => 'data must must be json'
            ],401);
        }
    }

    public function register(Request $request){
        return $this->validateJson($request);

        $userInput = $request->json()->get('user');
        $companyInput = $request->json()->get('company');

        try{
            $company = Company::firstOrNew([
                'name' => $companyInput['name'],
            ]);
            $user = User::firstOrNew([
                'email' => $userInput['email'],
            ]);
            
            if(!$company->exists || !$user->exists){

                $company = Company::create($companyInput);
                $company['owner_id'] = $user['id'];
                $company->save();

                $user = User::firstOrNew($userInput);
                $user['role_id'] = 3;
                $user['company_id'] = $company['id'];
                $user->save();
                
            }else{
                return response()->json([
                    'company' => $company,
                    'user' => $user,
                    'massage' => 'user or company already exist',
                ], 404);
            }

            return response()->json([
                'company' => $company,
                'user' => $user,
                'massage' => 'user created',
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'error' => $e,
                'massage' => 'user create failed',
            ], 404);
        }
    }

    public function login(Request $request){
        $this->validate($request, User::getLoginValidationRules());
        $credentials = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}