<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    
    protected function respondWithToken($token , $user)
    {
        throw new HttpResponseException(response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => $user,
        ], 200) );
    }

    public function validateJson(Request $request, $key , $rule){
        $validate = Validator::make($request->json()->get($key), $rule);
        if($validate->fails()){
            $this->responseRequestError(
                $validate->errors(),
                406
            );
        }
    }

    protected function responseRequestSuccess($ret)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'success', 
            'data' => $ret,
        ], 200));
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error', 
            'error' => $message,
        ], $statusCode));
    }
}

?>