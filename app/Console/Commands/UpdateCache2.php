<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCache2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ling:updateCache2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新 券广告 缓存';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->info('update cache 2');
        // 大淘客
        $url = sprintf(env('DATAOKE_KEY_API_TOP100_URL'), env('DATAOKE_KEY_API_KEY'));

        $client = new Client();
        $response = $client->request('GET', $url);
        if ($response->getStatusCode() == 200) {
            if ($response->getBody()) {
                $result  =  \GuzzleHttp\json_decode($response->getBody());
                if(isset($result->result)){

                    $data = $result->result;
                    $arr = []; // 4 * 5

                    $index = 0;
                    foreach ($data as $item) {
                        if ($index > 19) {
                            break;
                        }
                        $arr[$index]['id'] = $item->ID;
                        $arr[$index]['title']  = $item->Title;
                        $arr[$index]['d_title']  = $item->D_title;
                        $arr[$index]['d_title']  = $item->D_title;
                        $arr[$index]['pic']  = $item->Pic;
                        $arr[$index]['category_id']  = $item->Cid;
                        $index ++ ;
                    }
                    Cache::put('movie:quan_ad_list',$arr, 60*1+3);  // 1 小时 + 3分钟
                }
            }
        }
    }
}
