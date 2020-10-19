<?php

namespace App\Http\Controllers;

use App\Models\AssetAttachment;
use Illuminate\Http\Request;

class FileController extends Controller
{
    const USER_PICTURE_PATH = '/upload/user/';
    const ASSET_PICTURE_PATH = '/upload/asset/';
    const COMPANY_PICTURE_PATH = '/upload/company/';
    const ASSET_ATTACHMENT_PATH = '/upload/atatchment/';

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

    public function userPicture(Request $request)
    {
        $path  = $this->uploadFile($request, self::USER_PICTURE_PATH , 'image')['path'];
        $this->responseRequestSuccess(['path' => $path]);
    }

    public function companyLogo(Request $request)
    {
        $path  = $this->uploadFile($request, self::COMPANY_PICTURE_PATH , 'image')['path'];
        $this->responseRequestSuccess(['path' => $path]);
    }

    public function assetPicture(Request $request)
    {
        $path  = $this->uploadFile($request, self::ASSET_PICTURE_PATH , 'image')['path'];
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