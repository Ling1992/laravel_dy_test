<?php

namespace App\Http\Controllers\Index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use XS;
use XSDocument;

class ApiController extends Controller
{
    function addDyOne(Request $request){

//        $xs = new XS("dyone");
//        $doc = new XSDocument;  // 使用默认字符集
        $params = $request->all();
        print Log::info('ling',$params);

//        $doc->setFields($params);
//        $xs->index->update($doc);
//        $xs->index->flushIndex();

    }
}