<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // header('Access-Control-Allow-Origin:*');
        // header('Access-Control-Allow-Headers:Content-type,X-Auth-Token,Authorization, Origin');
        header("Access-Control-Allow-Headers: ACCEPT, CONTENT-TYPE, X-CSRF-TOKEN");
        header("Access-Control-Allow-Methods: PUT,GET, POST, OPTIONS, DELETE");
        return $next($request);
    }
}