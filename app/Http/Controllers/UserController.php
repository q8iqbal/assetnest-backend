<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

    }
    public function show($id){

    }
    public function store(Request $request){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id){
        
    }
}
