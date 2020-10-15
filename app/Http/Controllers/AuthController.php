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
        $this->validateJson($request);

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

                $user = User::firstOrNew($userInput);
                $user['password'] = Hash::make($userInput['password']);
                $user['role_id'] = 3;
                $user['company_id'] = $company['id'];
                $user->save();

                $company['owner_id'] = $user['id'];
                $company->save();
                
            }else{
                return response()->json([
                    'company' => $company,
                    'user' => $user,
                    'massage' => 'user or company already exist',
                ], 204);
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
            ], 406);
        }
    }

    public function login(Request $request){
        $this->validate($request, User::getLoginValidationRules());
        $credentials = $request->only(['email', 'password']);

        try {
            if (! $token = Auth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function validateJson(Request $request){
        $validateUser = Validator::make($request->get('user'),User::getValidationRules());
        $validateCompany = Validator::make($request->get('company'),Company::getValidationRules());

        if($validateCompany->fails() || $validateUser->fails()){
            return response()->json([
                'message1' => $validateCompany->errors()->all(),
                'message2' => $validateUser->errors()->all(),
            ],406);
        }
    }
}