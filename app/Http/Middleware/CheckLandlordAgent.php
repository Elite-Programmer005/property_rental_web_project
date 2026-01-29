<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLandlordAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if ($user && in_array($user->role, ['landlord', 'agent', 'admin'])) {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'You are not authorized to list properties.');
    }
}