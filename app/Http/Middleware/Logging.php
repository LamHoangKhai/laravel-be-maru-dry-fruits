<?php

namespace App\Http\Middleware;

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
        $fileName = Carbon::createFromTimestamp($_SERVER["REQUEST_TIME"])->format('Y-m-d') . ".json";
        $storagePath = storage_path("log-json/" . $fileName);

        // Calculate response time

        $startTime = $request->server()["REQUEST_TIME_FLOAT"];

        $response = $next($request);

        $endTime = microtime(true);

        $durationInMicroseconds = floor(($endTime - $startTime) * 1000);

        // read and write log to file json

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
        
        if (file_exists($storagePath)) {

            $oldLog = json_decode(file_get_contents($storagePath, true));
            array_push($oldLog, $logData);
            $newLog = json_encode($oldLog, JSON_PRETTY_PRINT);
            file_put_contents($storagePath, $newLog);

        } else {

            $newArray[] = $logData;
            $newLog = json_encode($newArray, JSON_PRETTY_PRINT);
            File::put($storagePath, $newLog);

        }

        return $response;
    }
}
