<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;

class CheckCountry
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
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        
        $body = Location::get($ip);
       
        
        #else if(env('APP_URL') == 'https://central-jobs.com/public/' || env('APP_URL') == 'https://central-jobs.com/'){
        #    return $next($request);
        #}
         return $next($request);
    }

    
}
