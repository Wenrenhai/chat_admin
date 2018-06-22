<?php

namespace App\Http\Middleware;

use Closure;
use App\MyClass\WApi;
class AuthApi
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
        // dd($request->toArray());
        if(!isset($request->app_key))  {
           return response()->json([
            'status'=>false,
            'message'=>'缺少app_key'
            ], 401);
        }
        if($request->app_key==config('app.key')){
            return $next($request);
        }else{
            // dd(4);
            return response()->json([
                'status'=>false,
                'message'=>'app_key不正确'
            ], 401);
        }
    }
}
