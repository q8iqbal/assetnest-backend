<?php

namespace App\Http\Middleware;

use Closure;

class JsonCheck
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
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])
            && !$request->isJson()
        ) {
            return response()->json([
                'message' => 'data must be jeson'
            ],406);
        }

        return $next($request);
    }
}
