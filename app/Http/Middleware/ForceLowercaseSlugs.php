<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ForceLowercaseSlugs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        
        // Check if the path contains uppercase letters
        if (preg_match('/[A-Z]/', $path)) {
            // Convert the entire path to lowercase
            $lowercasePath = strtolower($path);
            
            // Preserve query parameters
            $queryString = $request->getQueryString();
            $redirectUrl = $lowercasePath;
            
            if ($queryString) {
                $redirectUrl .= '?' . $queryString;
            }
            
            // Redirect to lowercase version
            return Redirect::to($redirectUrl, 301);
        }
        
        return $next($request);
    }
}
