<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if(!$request->user()){
            return response()->json(['message' => 'Потрібно бути зареєстрованим'], 403);
        }

        if ($request->user()->role != 1 ) {
            return response()->json(['message' => 'Потрібно бути адміністратором'], 403);
        }

        return $next($request);
    }
}
