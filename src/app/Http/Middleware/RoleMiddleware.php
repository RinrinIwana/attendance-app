<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ?string $role = null)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // role が指定されていない呼び出しは設定ミスなので拒否
        if ($role === null) {
            abort(403);
        }

        if (auth()->user()->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
