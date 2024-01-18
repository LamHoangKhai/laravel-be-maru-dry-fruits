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
        $logPath = "logs.json";
        $log = json_decode(file_get_contents($logPath, true));
        $date = $request->date;
        $times = [];

        foreach ($log as  $data) {
            if ($date === $data->date) {
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
        }
        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $times]);
    }

    public function httpCode(Request $request)
    {
        $logPath = "logs.json";
        $log = json_decode(file_get_contents($logPath, true));
        $date = $request->date;
        $times = [];

        foreach ($log as  $data) {
            if ($date === $data->date) {
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
        }

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $times]);
    }

    public function responseTime(Request $request)
    {
        $logPath = "logs.json";
        $log = json_decode(file_get_contents($logPath, true));
        $date = $request->date;
        $times = [];

        foreach ($log as  $data) {
            if ($date === $data->date) {
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
        }

        return response()->json(['status_code' => 200, 'msg' => "Kết nối thành công nha bạn.", "data" => $times]);
    }
}
