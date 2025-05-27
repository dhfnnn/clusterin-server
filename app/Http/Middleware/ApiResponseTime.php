<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiResponseTime
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $end = microtime(true);
        $duration = number_format(($end - $start) * 1000); // ms

        // Tambahkan ke header response
        $response->headers->set('X-Response-Time', $duration . 'ms');

        // Kalau API response JSON, tambahkan ke body juga (opsional)
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $original = $response->getData(true);
            $original['response'] = $duration;
            $response->setData($original);
        }
        return $response;
    }
}
