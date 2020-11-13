<?php

namespace App\Http\Controllers;

use App\Models\AssetHistory;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
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
        ->select(
            'asset_histories.date as date',
            'asset_histories.status as status',
            'assets.name as asset',
            'assets.code as code' , 
            'users.name as user'
        )
        ->join('assets', 'assets.id', 'asset_histories.asset_id')
        ->join('users', 'users.id', 'asset_histories.user_id')
        ->where('users.company_id', $companyId)
        ->allowedFilters(['status', 'asset', 'code', 'user', 'date' , AllowedFilter::scope('between')])
        ->allowedSorts(['status', 'asset', 'code', 'user', 'date'])
        ->paginate(10);
        $this->responseRequestSuccess($hists);
    }

    public function destroy($id){
        AssetHistory::find($id)->delete();
        $this->responseRequestSuccess(null);
    }
}