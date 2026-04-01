<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware {
    public function handle(Request $request, Closure $next, string $role = 'staff'): Response {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in.');
        }
        if ($role === 'admin' && !auth()->user()->isAdmin()) {
            abort(403, 'Administrator access required.');
        }
        return $next($request);
    }
}
