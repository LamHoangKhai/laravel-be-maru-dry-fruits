<?php

namespace App\Http\Middleware;

use App\Jobs\LogProcessingJob;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $fileName = Carbon::createFromTimestamp($request->server()["REQUEST_TIME_FLOAT"])->format('Y-m-d') . ".json";
        $storagePath = storage_path("log-json/" . $fileName);

        if ($request->id) {
            $body = ["id" => $request->id];
        } else {
            $body = $request->all();
        }
        // Calculate response time

        $startTime = $request->server()["REQUEST_TIME_FLOAT"];

        $response = $next($request);

        $endTime = microtime(true);

        $durationInMicroseconds = floor(($endTime - $startTime) * 1000);

        // read and write log to file json
        $data = [
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'body' => $body,
            'userAgent' => $request->header()['user-agent'],
            'httpCode' => $response->getStatusCode(),
            'date' => Carbon::createFromTimestamp($request->server()["REQUEST_TIME_FLOAT"])->format('Y-m-d'),
            'time' => Carbon::createFromTimestamp($request->server()["REQUEST_TIME_FLOAT"])->format('H:i:s'),
            'duration' => $durationInMicroseconds
        ];
        // handle
        LogProcessingJob::dispatchAfterResponse($storagePath, $data);

        return $response;
    }
}
