<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Auth::check() || !$user->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
        return $next($request);
    }
}