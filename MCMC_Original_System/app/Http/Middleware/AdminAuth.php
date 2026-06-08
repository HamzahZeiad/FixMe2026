<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_id')) {
            Log::warning('Admin middleware: No admin session found', [
                'url' => $request->url(),
                'session_id' => session()->getId(),
                'all_session' => session()->all()
            ]);
            return redirect()->route('login')->with('error', 'Please login as administrator');
        }

        return $next($request);
    }
}
