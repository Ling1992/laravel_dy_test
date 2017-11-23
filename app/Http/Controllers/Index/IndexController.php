<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use XS;
use XSTokenizerScws;

class IndexController extends Controller
{
    private $recommendation=[];
    private $quan_ad_list=[];
    private $category_list;
    private $paginator;
    private $xs;

    public function __construct()
    {
        $this->category_list=[
            'new'=>['key'=>'最新','name'=>'最新电影'],
            'gy'=>['key'=>'国语','name'=>'国语电影'],
            'wdy'=>['key'=>'微电影','name'=>'微电影'],
            'jd'=>['key'=>'经典高清','name'=>'经典高清电影'],
            'dhdy'=>['key'=>'动画电影','name'=>'动画电影'],
            '3d'=>['key'=>'3D电影','name'=>'3D 电影'],
            'gj'=>['key'=>'国剧','name'=>'国产剧'],
            'rh'=>['key'=>'日韩剧','name'=>'日韩剧'],
            'mj'=>['key'=>'欧美剧','name'=>'欧美剧'],
            'zy'=>['key'=>'综艺','name'=>'综艺节目']
        ];

        $this->xs = new XS('dytwo');
        $this->paginator = $paginator = new Paginator(null,20);

        //  阅读推荐
        if (Cache::has('movie:recommendation')){

            $this->recommendation = Cache::get('movie:recommendation');

        }

        // 淘宝券 广告！！

        if (Cache::has('quan_ad_list')){

            $this->quan_ad_list = Cache::get('movie:quan_ad_list');

        }


    }

    //
    function Index()
    {
        $this->xs->search->setSort('update_time',false);
        $this->xs->search->setQuery("category:".$this->category_list['new']['key']);
        $this->xs->search->setLimit($this->paginator->perPage(),($this->paginator->currentPage() -1 ) * $this->paginator->perPage());

        $article_list = $this->xs->search->search();
        $count = $this->xs->search->getLastCount();

        $paginator =new LengthAwarePaginator($this->paginator->items(), $count, $this->paginator->perPage(), $this->paginator->currentPage(), [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $this->paginator->getPageName(),
        ]);
        Log::info('index');
        return view('Index.index')
            ->with('paginator', $paginator)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('list',$article_list)  // 列表数据
            ->with('category','new')  // 类型 key
            ->with('recommendation', $this->recommendation) // 推荐
            ;
    }

    function category($category){
        Log::info($category);
        $this->xs->search->setSort('update_time',false);
        $this->xs->search->setQuery("category:".$this->category_list[$category]['key']);
        $this->xs->search->setLimit($this->paginator->perPage(),($this->paginator->currentPage() -1 ) * $this->paginator->perPage());

        $article_list = $this->xs->search->search();
        $count = $this->xs->search->getLastCount();

        $paginator =new LengthAwarePaginator($this->paginator->items(), $count, $this->paginator->perPage(), $this->paginator->currentPage(), [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $this->paginator->getPageName(),
        ]);

        return view('Index.index')
            ->with('paginator', $paginator)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('list',$article_list)  // 列表数据
            ->with('category', $category)  // 类型 key
            ->with('recommendation', $this->recommendation) // 推荐
            ;
    }

    function article($id, Request $request){

        $tokenizer = new XSTokenizerScws;

        $this->xs->setScheme($this->getXSFieldScheme());

        $this->xs->search->setQuery("dy_id:".$id);
        $this->xs->search->setLimit(1);

        $article_list = $this->xs->search->search();

        $data = $article_list[0];

        $category = 'new';
        foreach ($this->category_list as $k => $v) {
            if ($v['name'] == $data->f('category')) {
                $category = $k;
            }
        }

        $top = $tokenizer->getTops($data->f('title'), 5, 'n,nr,ns,nt,nz,v');

        $temp = [];

        if (count($top) >=1 ) {
            foreach ($top as $v) {
                $temp[] = $v['word'];
            }
        }
        $data->setFields(['keyWord'=>implode(', ', $temp)]);
        $content = $data->content;
        if ( ! $request->input('is_mobile')) {
            $key_words1 = "下载地址";
            $key_words2 = "【下载地址】";
            if (strpos($data->content, $key_words2)) {
                $content = preg_replace("/{$key_words2}[\s\S]*/", '', $content);
            }else if (strrpos($data->content, $key_words1)) {
                $content = preg_replace("/{$key_words1}[\s\S]*/", '', $content);
            }else{
                $content = preg_replace('/<table[\S\s]*<\/table>/', '', $content);
                $content = preg_replace('/<a[\S\s]*<\/a>/', '', $content);
            }
        }else{
            $content = $content . '<a href="http://mp.weixin.qq.com/s/kLcblJIAuEH73OjLXhRf3A">>>磁力电驴等链接使用说明<<</a>
            <br>
            <a href="https://pan.baidu.com/login?adapt=pc">>>进入百度yun电脑版<<</a>';
        }
        $data->setFields(['content'=>$content]);
        return view('Index.article')
            ->with('data',$data)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('category', $category)  // 类型 key
            ->with('recommendation', $this->recommendation) // 推荐
            ;

    }

    private function getXSFieldScheme(){
        $scheme = new \XSFieldScheme();

        $scheme->addField('dy_id', array('type' => 'id'));
        $scheme->addField('category', array('index' => 'self', 'tokenizer' => 'full'));
        $scheme->addField('title', array('index' => 'none', 'tokenizer' => 'none'));
        $scheme->addField('name', array('type' => 'title'));
        $scheme->addField('image_url', array('index' => 'none', 'tokenizer' => 'none'));
        $scheme->addField('content', array('index' => 'none', 'tokenizer' => 'none', 'cutlen' => 0));
        $scheme->addField('update_time', array('type' => 'numeric'));

        return $scheme;
    }
    function Content($id)
    {
        Log::info($id);

        $data = DB::table('dy_list')->where('id',$id)->first();

        $content = DB::table("dy_content_0{$data->content_table_tag}")->where('id',$data->content_id)->first();
        $data->content = $content->content;
        return view('Index.content')
            ->with('data',$data)
            ->with('category_list',$this->category_list)  //菜单栏
            ->with('category', 'new')  // 类型 key
            ->with('recommendation', $this->recommendation) // 推荐
            ;
    }


}
