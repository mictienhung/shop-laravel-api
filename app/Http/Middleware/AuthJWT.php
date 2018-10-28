<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthJWT
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
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json([
                'msg' => 'Token is Expired'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'msg' => 'Token is Invalid'
            ], 401);
        } catch(JWTException $e) {
            return response()->json([
                'msg' => 'Token is Invalid'
            ], 401);
        }
        return $next($request);
    }
}
