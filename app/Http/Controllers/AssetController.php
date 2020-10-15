<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(){
        $assets = Asset::all();//OrderBy("id", "DESC")->paginate(10);
    
        $out = [
            "massage" => "list_asset",
            "result" => $assets,
        ];

        return response()->json($out, 200); 
    }

    public function view($id){
        $asset = Asset::find($id);

        $out = [
            "massage" => "asset_".$id,
            "result" => $asset,
        ];

        return response()->json($out, 200); 
    }

    public function store(Request $request){
        if($request->isMethod('post')){
            $this->validate($request, Asset::getValidateRules());
            
            $data = [         
                'user_id' => $request->input('user_id'),
                'type_id' => $request->input('type_id'),
                'status_id' => $request->input('status_id'),
                'company_id' => $request->input('company_id'),
                'product_code' => $request->input('product_code'),
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'price' => $request->input('price'),
            ];
            
            $insert = Asset::create($data);
            
            if($insert){
                $out = [
                    "message" => "success_insert_data",
                    "result" => $data,
                    "code" => 200,
                ];
            } else {
                $out = [
                    "message" => "vailed_insert_data",
                    "result" => $data,
                    "code" => 404,
                ];
            }
            
            return response()->json($out, $out['code']);
        }
    }

    public function update(Request $request, $id){
        if($request->isMethod('put')){
            $this->validate($request, Asset::getValidateRules());

            $asset = Asset::find($id);

            $data = [
                'user_id' => $request->input('user_id'),
                'type_id' => $request->input('type_id'),
                'status_id' => $request->input('status_id'),
                'company_id' => $request->input('company_id'),
                'product_code' => $request->input('product_code'),
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'price' => $request->input('price'),
            ];

            $update = $asset->update($data);

            if($update){
                $out = [
                    "message" => "success_update_data",
                    "result" => $data,
                    "code" => 200,
                ];
            } else {
                $out = [
                    "message" => "vailed_update_data",
                    "result" => $data,
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
