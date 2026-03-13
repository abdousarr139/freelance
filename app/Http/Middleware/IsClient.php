<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsClient
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Auth::check() || !$user->isClient()) {
            abort(403, 'Accès réservé aux clients.');
        }
        return $next($request);
    }
}