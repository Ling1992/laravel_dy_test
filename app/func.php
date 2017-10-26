<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 23/06/2017
 * Time: 3:27 PM
 */
/**
 * 格式化时间
 *  mixed \Carbon\Carbon $dt / Int $timestamp / String $date / String "now"
 *  date
 */

function format_time($dt=0)
{
    $format = [
        'between_one_minute' => '刚刚',
        'before_minute'      => '分钟前',
        'before_hours'      => '小时前',
        'before_day'      => '天前',
        'before_month'      => '月前',
        'default'            => 'n月d日 H:i',
        'month_day'            => 'n月d日',
        'diff_year_date'             => 'Y年n月d日 H:i',
        'year'             => 'Y年',
        'error'                 => '时间显示错误'
    ];

    //创建对象
    if( is_numeric($dt) ) {

        $dt = Carbon\Carbon::createFromTimestamp($dt);

    } else if( ! $dt instanceof \Carbon\Carbon) {
        //错误时间
        if( $dt == '0000-00-00 00:00:00' || $dt === '0' ) return $format['error'];

        $dt = new Carbon\Carbon($dt);
    }
//    return $dt->format($format['diff_year_date']);
    //今天
    $diff_second = abs ($dt->diffInSeconds() );
    $diff_minute = floor($diff_second / 60);
    $diff_hour = floor($diff_minute / 60);

    if( $diff_hour < 24 ) {

        //1小时内
        if($diff_minute < 60) {

            //一分钟内
            if($diff_second < 60) return $format['between_one_minute'];

            return $diff_minute.$format['before_minute'] ;
        }else {


            return $diff_hour . $format['before_hours'];
        }
    }
    $diff_day = ceil($diff_hour / 24);
    if ($dt->isCurrentMonth()) {
        return $diff_day . $format['before_day'];
    }
    if ($dt->isCurrentYear()) {
        return $dt->format($format['month_day']);
    }

    return $dt->format($format['year']);

}

function filterKey($str){

    $arr = \Illuminate\Support\Facades\Cache::get('key_arr');
    if (!$arr) {
        ## 读取关键字文本
        $content = @file_get_contents(base_path('kwd.txt'));
        // 转换成数组
        $arr = explode("\n", $content);
        \Illuminate\Support\Facades\Cache::put('key_arr',$arr,60*24*2);
    }
    foreach ($arr as $v) {
        if ($v == '') continue;
        if(strpos($str,$v)!==false ){
            $str = str_replace($v,str_pad('',mb_strlen($v),'*'),$str);
        }
    }
    return $str;
}


/**
 * @param $content      -- 过滤 关键字 和 url
 * @return string
 */
function filterContent($content) {
    $content = preg_replace('/src="([^"]+)/i', 'src="'.asset('img/onload.gif').'" data-echo="'.env('img_src_pre','').'\1', $content);
    $content = filterKey($content);
    // $content = str_replace(['data-src'], ['src'], $content);
    return strip_tags($content, "<p><img><iframe>");
}

function filterTitle($id, $content){
    $title = $content;
    if ($content) {
        $title = \Illuminate\Support\Facades\Cache::get('title_'.$id);
        if (!$title) {
            $title = filterKey($content);
            \Illuminate\Support\Facades\Cache::put('title_'.$id,$title,60*24*2);
        }
    }
    return $title;
}

function filterAbstract($id, $content) {
    $abstract = $content;
    if ($content) {
        $abstract = \Illuminate\Support\Facades\Cache::get('abstract_'.$id);
        if (!$abstract) {
            $abstract = filterKey($content);
            \Illuminate\Support\Facades\Cache::put('abstract_'.$id,$abstract,60*24*2);
        }
    }
    return $abstract;
}

function filterArticle($id, $content) {
    $article = $content;
    if ($content) {
        $article = \Illuminate\Support\Facades\Cache::get('article_'.$id);
        if (!$article) {
            $content = articleFilter($content);
            $content = htmlspecialchars_decode($content);
            $content = articleFilterAfter($content);
            $article = filterContent($content);
            \Illuminate\Support\Facades\Cache::put('article_'.$id,$article,60*24*2);
        }
    }
    return $article;
}

function urlFilter($url, $type=0){
    if (strpos($url,'//') === 0) {
        return "http:".$url;
    }
    return $url;
}

function articleFilter($content){
    // 过滤  <!--相关新闻 begin--> <!--相关新闻 end-->  2017-09-05
    // 过滤  <!--相关专题 begin--> <!--相关专题 end-->  2017-09-05
    // 过滤  <!-- 责任编辑&版权 begin--> <!-- 责任编辑&版权 begin-->  2017-09-05
    // author_id = 5954781019 环球网
    $content = preg_replace('/<!--相关新闻 begin-->[\s\S]*<!--相关新闻 end-->/', '', $content);
    $content = preg_replace('/<!--相关专题 begin-->[\s\S]*<!--相关专题 end-->/', '', $content);
    $content = preg_replace('/<!-- 责任编辑&版权 begin-->[\s\S]*<!-- 责任编辑&版权 begin-->/', '', $content);

    // 过滤 <script></script>
    $content = preg_replace('/<script(?:(?!<script)[\S\s])*<\/script>/', '', $content);
    // 过滤 <div style="display:none" id="yuanweninfo">url:http://m.gmw.cn/toutiao/2017-09/12/content_26132659.htm,id:26132659</div>
    $content = preg_replace('/<div(?:(?!<div)[\S\s])*display:none(?:(?!<\/div>)[\S\s])*<\/div>/', '', $content);

    return $content;
}

function articleFilterAfter($content) {
    \Illuminate\Support\Facades\Log::info($content);
    // 过滤 <p> XX 原创栏目 XX </p>
    $content = preg_replace('/<p>(?:(?!<p>)[\S\s])*原创栏目(?:(?!<\/p>)[\S\s])*<\/p>/', '', $content);
    // 过滤 <p> XX 订阅小编 XX </p>
    $content = preg_replace('/<p>(?:(?!<p>)[\S\s])*订阅小编(?:(?!<\/p>)[\S\s])*<\/p>/', '', $content);
    // 过滤 <p> XX 欢迎点赞欢迎评论 XX </p>
    $content = preg_replace('/<p>(?:(?!<p>)[\S\s])*欢迎点赞欢迎评论(?:(?!<\/p>)[\S\s])*<\/p>/', '', $content);
    // 过滤 <p> XX 欢迎关注 XX 的专栏 XX </p>
    $content = preg_replace('/<p>(?:(?!<p>)[\S\s])*欢迎关注(?:(?!<p>)[\S\s])*(?:(?!<\/p>)[\S\s])*的专栏(?:(?!<\/p>)[\S\s])*<\/p>/', '', $content);
    // 过滤 欢迎在评论区回复小编
    $content = preg_replace('/欢迎在评论区回复小编/', '', $content);
    // 过滤 欢迎大家咨询交流
    $content = preg_replace('/欢迎大家咨询交流/', '', $content);

    // 过滤 img 果大蜀黍 关注
    $content = preg_replace('/<img(?:(?!>)[\S\s])*http:\/\/p1\.pstatp\.com\/large\/32220001df597f8ed53e(?:(?!>)[\S\s])*>/', '', $content);

    return $content;
}


function movie_img_filter($url) {
    if (strpos($url, 'read.html5.qq.com')) {
        return $url;
    }
    if (substr($url, 0, 8) == '/images/') {
        return 'http://www.vtalking.cn/' . $url;
    }
    return str_replace("\/", "/", $url);
}

function isMobile() {
    \Illuminate\Support\Facades\Log::info("is_mobile");
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
        \Illuminate\Support\Facades\Log::info(strtolower($_SERVER['HTTP_USER_AGENT']));
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

function isWeixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    } else {
        return false;
    }
}