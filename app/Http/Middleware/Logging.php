<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $stored =  'logs.json';

        // Calculate response time


        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);

        $durationInMicroseconds = floor(($endTime - $startTime) * 1000);

        // read and write log to file json
        $oldLog = json_decode(file_get_contents($stored, true));
        if ($request->id) {
            $body = ["id" => $request->id];
        } else {
            $body = $request->all();
        }

        $logData = [
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'body' => $body,
            'userAgent' => $request->header()['user-agent'],
            'httpCode' => $response->getStatusCode(),
            'date' => Carbon::createFromTimestamp($_SERVER["REQUEST_TIME"])->format('Y-m-d'),
            'time' => Carbon::createFromTimestamp($_SERVER["REQUEST_TIME"])->format('H:i:s'),
            'duration' => $durationInMicroseconds
        ];
        array_push($oldLog, $logData);
        $newLog = json_encode($oldLog, JSON_PRETTY_PRINT);
        file_put_contents($stored, $newLog);
        return $response;
    }
}
