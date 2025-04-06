<?php 

namespace App\Http\Middleware;

use Closure;

class EnsureFrontendRequestsAreStateful
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
