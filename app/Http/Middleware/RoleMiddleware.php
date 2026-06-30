<?php

namespace App\Http\Middleware;

use App\Domain\Identity\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if (! in_array($userRole, $roles, true)) {
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}
