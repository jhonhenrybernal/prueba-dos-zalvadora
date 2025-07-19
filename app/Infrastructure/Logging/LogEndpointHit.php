<?php

namespace App\Infrastructure\Logging;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogEndpointHit
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;

        Log::info('Endpoint hit', [
            'ip' => $request->ip(),
            'route' => $request->path(),
            'duration' => $duration,
        ]);

        return $response;
    }
}