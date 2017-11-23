<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use XS;

class UpdateCache1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ling:updateCache1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新 阅读推荐 缓存 ';

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

        $this->info('update cache 1');

        $xs = new XS('indexone');
        $xs->search->setSort('create_date',false);
        $xs->search->setQuery("category:娱乐");
        $xs->search->setLimit(8);
        $recommendation = $xs->search->search();

        Cache::put('movie:recommendation',$recommendation, 60*6+3); //6 小时 + 3分钟

    }
}
