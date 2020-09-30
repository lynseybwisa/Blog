<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

//middleware to authorize each request token
class JWTMiddleware
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

        $message = '';

        try{
            //check token validation
            JWTAuth::parseToken()->authenticate();
            return $next($request);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            $message = 'token expired';
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            $message = 'token invalid';
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e){
            $message = 'provide token';
        }
        return response()->json([
            'success' => false,
            'message' => $message
        ]);
    }
}
