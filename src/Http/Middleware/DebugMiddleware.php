<?php

namespace LaravelDebugBar\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DebugMiddleware
{
    public function handle(Request $request, \Closure $next) {
        $response = $next($request);

        $queries = DB::connection()->getQueryLog();
        $executionTime = microtime(true) - LARAVEL_START;

        $queryTypes = [
            'select' => 0,
            'insert' => 0,
            'update' => 0,
            'delete' => 0,
        ];
        foreach ( $queries as $query ) {
            foreach ( $queryTypes as $type => &$count ) {
                if ( Str::startsWith(strtolower($query['query']), $type) ) {
                    $count++;
                    break;
                }
            }
        }

        $queryTypes['all'] = count($queries);

        $response->headers->add([
            'X-DEBUG-QUERIES' => json_encode($queryTypes),
            'X-DEBUG-QUERY-LOG' => json_encode($queries),
            'X-DEBUG-MEMORY' => format_filesize(memory_get_peak_usage(true)),
            'X-DEBUG-EXECUTION-TIME' => round($executionTime, 2).' (with debug: '.round(microtime(true) - LARAVEL_START, 2).')',
        ]);

        return $response;

        return $response;
    }
}