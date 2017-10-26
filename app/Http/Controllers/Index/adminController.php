<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    //
    function index(Request $request){

        $create_date = $request->input('create_date');
        if (!$create_date) {
            $create_date = date('Y-m-d', time());
        }

        $list = DB::table('ip_collection')
            ->select(DB::raw('count(*) as count, ip, DATE_FORMAT(create_date,"%Y-%m-%d") as create_date, id'))
            ->where('create_date', 'like', $create_date.'%')
            ->groupBy('ip')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.index')
            ->with('list', $list)
            ->with('create_date', $create_date);
    }
    function detail($ip, $create_date){
        $list = DB::table('ip_collection')
            ->where('create_date', 'like', $create_date.'%')
            ->where('ip', $ip)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.detail')
            ->with('list', $list)
            ;
    }
}
