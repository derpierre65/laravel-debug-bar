<?php


namespace LaravelDebugBar;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaravelDebugBar
{
    public static function getDebug(): array
    {
        // fallback if LARAVEL_START is undefined
        if (!defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }

        $queries = DB::connection()->getQueryLog();
        $executionTime = round(microtime(true) - LARAVEL_START, 2);

        $queryTypes = [
            'select' => 0,
            'insert' => 0,
            'update' => 0,
            'delete' => 0,
        ];
        foreach ($queries as $query) {
            foreach ($queryTypes as $type => &$count) {
                if (Str::startsWith(strtolower($query['query']), $type)) {
                    $count++;
                    break;
                }
            }
        }

        $queryTypes = array_merge(['all' => count($queries)], $queryTypes);

        return [
            'queries' => json_encode($queryTypes),
            'queryLog' => json_encode($queries),
            'memoryPeak' => self::formatFilesize(memory_get_peak_usage(true)),
            'executionTime' => $executionTime,
            'executionTimeDebug' => round(microtime(true) - LARAVEL_START, 2),
        ];
    }

    private static function formatFilesize(int $byte, int $precision = 2): string
    {
        $symbol = 'Byte';
        if ($byte >= 1000) {
            $byte /= 1000;
            $symbol = 'kB';
        }
        if ($byte >= 1000) {
            $byte /= 1000;
            $symbol = 'MB';
        }
        if ($byte >= 1000) {
            $byte /= 1000;
            $symbol = 'GB';
        }
        if ($byte >= 1000) {
            $byte /= 1000;
            $symbol = 'TB';
        }

        return round($byte, $precision) . ' ' . $symbol;
    }
}