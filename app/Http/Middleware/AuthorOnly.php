<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $param)
    {
        $data = $request->route()->parameter($param);

        if($request->user()->isNot($data->user)) {
            return response()->json([
                'message' => 'Not Found.'
            ], Response::HTTP_NOT_FOUND);
        }
        
        return $next($request);
    }
}
