<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function MongoDB\BSON\toJSON;

class IndexController extends Controller
{
    private $recommendation;
    private $category_list;
    private $movie_list;

    public function __construct()
    {
        $this->category_list=[
            'new'=>['key'=>'娱乐','name'=>'最新娱乐'],
            'food'=>['key'=>'美食','name'=>'美食'],
            'game'=>['key'=>'游戏','name'=>'游戏'],
            'fashion'=>['key'=>'时尚','name'=>'时尚'],
            'travel'=>['key'=>'旅游','name'=>'旅游'],
            'photography'=>['key'=>'摄影','name'=>'摄影'],
            'funny'=>['key'=>'搞笑','name'=>'搞笑'],
            'comic'=>['key'=>'动漫','name'=>'动漫'],
            'emotion'=>['key'=>'情感','name'=>'情感']
        ];
    }

    //
    function Index(Request $request)
    {
        $article_list = DB::table('dy_list')->get();
        return view('Index.index')
//            ->with('paginator', $paginator)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('list',$article_list)  // 列表数据
            ->with('category', 'new')  // 类型 key
//            ->with('recommendation', $this->recommendation) // 推荐
//            ->with('movie_list', $this->movie_list) // 57-电影
            ;
    }

    function Content($id , Request $request)
    {
        Log::info($id);

        $data = DB::table('dy_list')->where('id',$id)->first();

        $content = DB::table("dy_content_0{$data->content_table_tag}")->where('id',$data->content_id)->first();
        $data->content = $content->content;
//        dd($data);
        return view('Index.article')
            ->with('data',$data)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('category', 'new')  // 类型 key
//            ->with('recommendation', $this->recommendation) // 推荐
//            ->with('movie_list', $this->movie_list) // 57-电影
            ;
    }


}
