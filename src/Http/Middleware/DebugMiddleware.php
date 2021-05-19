<?php

namespace LaravelDebugBar\Http\Middleware;

use Illuminate\Http\Request;
use LaravelDebugBar\LaravelDebugBar;

class DebugMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        $response = $next($request);

        $data = LaravelDebugBar::getDebug();

        $response->headers->add([
            'X-DEBUG-QUERIES' => json_encode($data['queries']),
            'X-DEBUG-QUERY-LOG' => json_encode($data['queryLog']),
            'X-DEBUG-MEMORY' => $data['memoryPeak'],
            'X-DEBUG-EXECUTION-TIME' => $data['executionTime'],
            'X-DEBUG-EXECUTION-TIME-DEBUG' => $data['executionTimeDebug'],
        ]);

        return $response;
    }
}