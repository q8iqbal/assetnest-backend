<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const USER_PICTURE_PATH = '/upload/user/';
    const ASSET_PICTURE_PATH = '/upload/asset/';
    const COMPANY_PICTURE_PATH = '/upload/company/';
    const ASSET_ATTACHMENT_PATH = '/upload/user/';
    
    protected function respondWithToken($token , $user)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => $user,
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
                $this->responseRequestError('Cannot upload file');
            }
        } else {
            $this->responseRequestError('File not found');
        }
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
        ], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        );
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error', 
            'error' => $message,
        ], $statusCode)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        );
    }
}

?>