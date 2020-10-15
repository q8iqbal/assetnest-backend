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
        $getPost = Asset::all();//OrderBy("id", "DESC")->paginate(10);
    
        $out = [
            "massage" => "list_asset",
            "result" => $getPost
        ];

        return response()->json($out, 200); 
    }
}
