<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\JwtToken;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('token');
        $res = JwtToken::VerifyToken($token);
        if($res==='unauthorize'){
          return response()->json('No a valid');
        }else{
            $request->headers->set('userEmail',$res->userEmail);
            $request->headers->set('id',$res->id);
            return $next($request);
        }
    }
}
