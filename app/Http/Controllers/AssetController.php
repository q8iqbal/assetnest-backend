<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
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
        $assets = Asset::all();
    
        $out = [
            "massage" => "list_asset",
            "result" => $assets,
        ];

        return response()->json($out, 200); 
    }
    public function show($id){
        $asset = Asset::find($id);

        $out = [
            "massage" => "asset_".$id,
            "result" => $asset,
        ];

        return response()->json($out, 200); 
    }
    public function store(Request $request){
        if($request->isMethod('post')){
            $this->validateJson($request, 'asset' , Asset::getValidateRules());
            
            $asset = $request->json()->get('asset');
            $assetImg = $this->uploadImage();

            $insert = Asset::create($asset);
            
            if($insert){
                $out = [
                    "message" => "success_insert_data",
                    "result" => $asset,
                    "code" => 200,
                ];
            } else {
                $out = [
                    "message" => "vailed_insert_data",
                    "result" => $asset,
                    "code" => 404,
                ];
            }
            
            return response()->json($out, $out['code']);
        }
    }
    public function update(Request $request, $id){
        if($request->isMethod('put')){
            $this->validateJson($request, 'asset' ,Asset::getValidateRules());
            
            $assetNew = $request->json()->get('asset');
            $asset = Asset::find($id);

            $update = $asset->update($assetNew);

            if($update){
                $out = [
                    "message" => "success_update_data",
                    "result" => $asset,
                    "code" => 200,
                ];
            } else {
                $out = [
                    "message" => "vailed_update_data",
                    "result" => $asset,
                    "code" => 404,
                ];
            }

            return response()->json($out, $out['code']);
        }
    }
    public function destroy($id){
        $asset = Asset::find($id);

        if(!$asset){
            $data = [
                "message" => "id not found",
            ];
        }else{
            $asset->delete();
            $data = [
                "message" => "success_deleted",
            ];
        }
    
        return response()->json($data, 200);
    }
}
