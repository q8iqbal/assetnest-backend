<?php

namespace App\Http\Controllers;

use App\Models\AssetAttachment;
use Illuminate\Http\Request;

class FileController extends Controller
{
    const USER_IMAGE_PATH = '/upload/user/';
    const ASSET_IMAGE_PATH = '/upload/asset/';
    const COMPANY_IMAGE_PATH = '/upload/company/';
    const ASSET_ATTACHMENT_PATH = '/upload/attachment/';

    public function uploadFile(Request $request, $destination_path, $fileKey)
    {
        if ($request->hasFile($fileKey)) {
            $original_filename = $request->file($fileKey)->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $file = 'U-' . time() . '.' . $file_ext;

            if ($request->file($fileKey)->move('.'.$destination_path, $file)) {
                return [
                    'filename' => $original_filename,
                    'path' => $destination_path.$file,
                ];
            } else {
                $this->responseRequestError('Cannot upload file');
            }
        } else {
            $this->responseRequestError('File not found');
        }
    }

    public function userImage(Request $request)
    {
        $path  = $this->uploadFile($request, self::USER_IMAGE_PATH , 'image')['path'];
        $this->responseRequestSuccess(['path' => $path]);
    }

    public function companyImage(Request $request)
    {
        $path  = $this->uploadFile($request, self::COMPANY_IMAGE_PATH , 'image')['path'];
        $this->responseRequestSuccess(['path' => $path]);
    }

    public function assetImage(Request $request)
    {
        $path  = $this->uploadFile($request, self::ASSET_IMAGE_PATH , 'image')['path'];
        $this->responseRequestSuccess(['path' => $path]);
    }

    public function assetAttachment(Request $request, $id)
    {
        $attachment  = $this->uploadFile($request, self::ASSET_ATTACHMENT_PATH , 'file');

        $attach = AssetAttachment::create([
            'asset_id' => $id,
            'filename' => $attachment['filename'],
            'path' => $attachment['path'],
        ]);

        $this->responseRequestSuccess(['path' => $attach]);
    }
}
?>