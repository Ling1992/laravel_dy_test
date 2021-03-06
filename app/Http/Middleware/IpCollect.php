<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IpCollect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        DB::table("ip_collection")->insert([
            'ip'=>$request->ip(),
            'request_url'=>$request->getRequestUri(),
            'user_agent'=>$request->userAgent() ?? ""
        ]);
        info($request->ip());
        info($request->getRequestUri());
        info($request->userAgent());

        if (Cache::has("blacklist:".$request->ip()) || !$request->userAgent()) {
            return response("block", 503);
        }
        if (isMobile()) {
            Log::info('是移动端访问');
            $request->offsetSet('is_mobile',true);
        }
        return $next($request);
    }
}
