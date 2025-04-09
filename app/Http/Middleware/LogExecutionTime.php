<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogExecutionTime
{
    public function handle(Request $request, Closure $next): Response
    {

        $startTime = microtime(true);
        
        $response = $next($request);

        $executionTime = microtime(true) - $startTime;
        
        Log::info('Request execution time', [
            'uri' => $request->getRequestUri(),
            'method' => $request->method(),
            'execution_time' => $executionTime,
        ]);
        
        return $response;
    }
}