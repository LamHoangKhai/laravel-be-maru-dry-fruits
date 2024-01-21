<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class Logging extends Controller
{
    public function view()
    {
        return view("logging");
    }

    public function method(Request $request)
    {
        $date = $request->date;
        $fileName = $date . '.json';
        $storagePath = storage_path("log-json/" . $fileName);
        $log = json_decode(file_get_contents($storagePath, true));
        $times = [];

        for ($i = 0; $i < 24; $i++) {
            $time = Carbon::parse("00:00")->addHours($i)->format('H:i');
            $times[$time] = ["GET" => 0, "POST" => 0];
        }


        foreach ($log as  $data) {
            $roundedHour = date('H', ceil(strtotime($data->time))) . ":00";
            $method = $data->method;
            if (isset($times[$roundedHour])) {
                if (isset($times[$roundedHour][$method])) {
                    $times[$roundedHour][$method] += 1;
                } else {
                    $times[$roundedHour][$method] = 1;
                }
            } else {
                $times[$roundedHour]  = [];
                $times[$roundedHour][$method] = 1;
            }
        }
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $times]);
    }

    public function httpCode(Request $request)
    {
        $date = $request->date;
        $fileName = $date . '.json';
        $storagePath = storage_path("log-json/" . $fileName);
        $log = json_decode(file_get_contents($storagePath, true));
        $times = [];

        for ($i = 0; $i < 24; $i++) {
            $time = Carbon::parse("00:00")->addHours($i)->format('H:i');
            $times[$time] = ["200" => 0, "404" => 0, "429" => 0, "500" => 0];
        }


        foreach ($log as  $data) {
            $roundedHour = date('H', ceil(strtotime($data->time))) . ":00";
            $httpCode = $data->httpCode;
            if (isset($times[$roundedHour])) {
                if (isset($times[$roundedHour][$httpCode])) {
                    $times[$roundedHour][$httpCode] += 1;
                } else {
                    $times[$roundedHour][$httpCode] = 1;
                }
            } else {
                $times[$roundedHour]  = [];
                $times[$roundedHour][$httpCode] = 1;
            }
        }

        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $times]);
    }

    public function responseTime(Request $request)
    {

        $date = $request->date;
        $fileName = $date . '.json';
        $storagePath = storage_path("log-json/" . $fileName);
        $log = json_decode(file_get_contents($storagePath, true));
        $times = [];

        for ($i = 0; $i < 24; $i++) {
            $time = Carbon::parse("00:00")->addHours($i)->format('H:i');
            $times[$time] = ["duration" => 0];
        }


        foreach ($log as  $data) {
            $roundedHour = date('H', ceil(strtotime($data->time))) . ":00";
            $duration = $data->duration;
            if (isset($times[$roundedHour])) {
                if (isset($times[$roundedHour]['duration']) && $times[$roundedHour]['duration'] <=  $duration) {
                    $times[$roundedHour]['duration'] =  $duration;
                }
            } else {
                $times[$roundedHour]  = [];
                $times[$roundedHour]['duration'] =  $duration;
            }
        }
        return response()->json(['status_code' => 200, 'msg' => "Success", "data" => $times]);
    }
}
