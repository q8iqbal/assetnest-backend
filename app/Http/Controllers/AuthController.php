<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register']]);
    }

    public function register(Request $request){
        $this->validate($request, User::getValidationRules());
        $this->validate($request, Company::getValidationRules());

        try{
            $company = Company::firstOrNew([
                'logo' => $request->input('logo'),
                'name' => $request->input('company_name'),
                'address' => $request->input('address'),
                'description' => $request->input('description'),
                'phone' => $request->input('phone'),
            ]);
            
            if(!$company->exists){
                $company->save();
            }else{
                return response()->json([
                    'company' => $company,
                    'massage' => 'company already exist',
                ], 404);
            }

            $user = User::firstOrNew([
                'role_id' => 1,
                'company_id' => $company->id,
                'name' => $request->input('user_name'),
                'password' => Hash::make($request->input('password')),
                'email' => $request->input('email'),
                'photo' => $request->input('photo'),
            ]);

            if(!$user->exists){
                $user->save();
            }else{
                return response()->json([
                    'company' => $user,
                    'massage' => 'user already exist',
                ], 404);
            }
            Company::find($company->id)->update(['owner_id'=>$user->id]);
            $company->save();

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