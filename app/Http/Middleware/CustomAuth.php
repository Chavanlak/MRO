<?php

// namespace App\Http\Middleware;

// use Closure;

// class CustomAuth
// {
//     public function handle($request, Closure $next)
//     {
//         if (!session()->has('logged_in')) {
//             return redirect()->route('login.form');
//         }

//         return $next($request);
//     }
// }
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CustomAuth
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('logged_in')) {
            return redirect('/login');
        }

        return $next($request);
    }
}


?>