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
        return Asset::all();
    }
    public function show($id){}
    public function store(Request $request){}
    public function update(Request $request, $id){}
    public function destroy($id){}
}
