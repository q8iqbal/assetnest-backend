<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }

    public function uploadImage(Request $request, $destination_path = '/upload/user/', $fileKey = 'image')
    {
        $user = (object) ['image' => ""];

        if ($request->hasFile($fileKey)) {
            $original_filename = $request->file($fileKey)->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file($fileKey)->move('.'.$destination_path, $image)) {
                return $user->image = $destination_path . $image;
            } else {
                return $this->responseRequestError('Cannot upload file');
            }
        } else {
            return $this->responseRequestError('File not found');
        }
    }

    public function validateJson(Request $request, $key , $rule){
        $validate = Validator::make($request->get($key), $rule);

        if($validate->fails()){
            return $this->responseRequestError(
                $validate,
                406
            );
        }
    }

    protected function responseRequestSuccess($ret)
    {
        return response()->json([
            'status' => 'success', 
            'data' => $ret,
        ], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json([
            'status' => 'error', 
            'error' => $message,
        ], $statusCode)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}

?>