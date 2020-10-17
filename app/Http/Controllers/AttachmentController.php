<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use App\Models\AssetAttachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        $attachment = AssetAttachment::all();
    
        $out = [
            "massage" => "list_attachment",
            "result" => $attachment,
        ];

        return response()->json($out, 200); 
    }
    public function show($id){
        $attachment = AssetAttachment::find($id);

        $out = [
            "massage" => "assetAttachment_".$id,
            "result" => $attachment,
        ];

        return response()->json($out, 200); 
    }
    public function store(Request $request){
            $this->validateJson($request, 'attachment' , AssetAttachment::getValidateRules());
            
            $attachment = $request->json()->get('attachment');
            $insert = AssetAttachment::create($attachment);
            
            if($insert){
                $out = [
                    "message" => "success_insert_data",
                    "result" => $attachment,
                    "code" => 200,
                ];
            } else {
                $out = [
                    "message" => "vailed_insert_data",
                    "result" => $attachment,
                    "code" => 404,
                ];
            }
            
            return response()->json($out, $out['code']);
    }
    public function update(Request $request, $id){
            $this->validateJson($request, 'attachment' ,AssetAttachment::getValidateRules());
            
            $attachmentNew = $request->json()->get('attachment');
            $attachment = AssetAttachment::find($id);

            $update = $attachment->update($attachmentNew);

            if($update){
                $out = [
                    "message" => "success_update_data",
                    "result" => $attachment,
                    "code" => 200,
                ];
            } else {
                $out = [
                    "message" => "vailed_update_data",
                    "result" => $attachment,
                    "code" => 404,
                ];
            }

            return response()->json($out, $out['code']);
    }
    public function destroy($id){
        $attachment = AssetAttachment::find($id);

        if(!$attachment){
            $data = [
                "message" => "id not found",
            ];
        }else{
            $attachment->delete();
            $data = [
                "message" => "success_deleted",
            ];
        }
    
        return response()->json($data, 200);
    }
}
