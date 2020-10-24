<?php

namespace App\Http\Controllers;

use App\Models\AssetHistory;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class AssetHistoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $companyId = Auth::user()->company_id;
        $hist = AssetHistory::class;
        $hists = QueryBuilder::for($hist)
        ->select('asset_histories.*','assets.name as asset', 'users.name as user')
        ->join('assets', 'assets.id', 'asset_histories.asset_id')
        ->join('users', 'users.id', 'asset_histories.user_id')
        ->where('users.company_id', $companyId)
        ->allowedFilters(['asset_histories.status', 'assets.name', 'users.name'])
        ->allowedSorts(['asset_histories.status', 'assets.name', 'users.name'])
        ->get();
        $this->responseRequestSuccess($hists);
    }

    public function destroy($id){
        AssetHistory::find($id)->delete();
        $this->responseRequestSuccess(null);
    }
}