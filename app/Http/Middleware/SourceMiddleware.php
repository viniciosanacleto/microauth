<?php

namespace App\Http\Middleware;

use App\Models\Source;
use Closure;

class SourceMiddleware
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
        $authorization = $request->header('Authorization');

        //Search for token on database
        $sourceToken = Source::where('token',$authorization)->first();
        if(empty($sourceToken)){
            return response()->json([
                'success'=>false,
                'data'=> 'Authorization token in the request header is not valid!'
            ],401);
        }
        return $next($request);
    }
}
