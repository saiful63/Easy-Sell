<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Log;

class SessionAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->session()->get('email');
        $user_id = $request->session()->get('user_id');
        if($email!==null){
            $request->headers->set('email',$email);
            $request->headers->set('user_id',$user_id);
            return $next($request);
        }else{
            return redirect()->route('LoginPage');
        }

    }
}
