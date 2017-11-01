<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web','namespace' => 'Index'], function(){
    // 控制器在 "App\Http\Controllers\Index" 命名空间下

    Route::get('/', ['uses'=>'IndexController@Index','as'=>'index']);

    Route::get('category/new', function(){
        return redirect()->route('index');
    });

    Route::get('category/{category}','IndexController@category')->where('category','[a-z3]{2,}');

    Route::get('article/{id}',['uses'=>'IndexController@article','as'=>'article'])->where('id', '[0-9]+');
    // 接口
    Route::get('getList/{like?}','IndexController@getList');
    // 内部接口
    Route::get('clearCache/{str}/{admin}', 'AttachController@clearCache')->where(['str' => '[0-9a-zA-Z]+', 'admin' => '[a-z]+']);
    // 添加 ip 到 黑名单
    Route::get('blacklist/addIp/{ips}/{admin}', 'AttachController@addIpToBlacklist')->where(['ips'=>'[0-9\.\,]+', 'admin'=>'[a-z]+']);


    // 后台界面 观察 ip
    Route::get('ipList', 'adminController@index');
    Route::get('ipDetail/{ip}/{date}', 'adminController@detail')->where(['ip'=>'[0-9\.]+', 'date'=>'[0-9\-]+']);

    Route::post('ling/addContent/dy/one','ApiController@addDyOne');
});

//Route::get('ling/test2', 'Index\AttachController@test2');
//Route::get('Content/{id}', 'Index\IndexController@Content');