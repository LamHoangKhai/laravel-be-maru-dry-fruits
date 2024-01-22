<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $storagePath;
    public $data;

    public $startTime;

    public $endTime;
    public function __construct($storagePath, $data, $startTime)
    {
        $this->storagePath = $storagePath;
        $this->data = $data;
        $this->startTime = $startTime;
        $this->endTime = microtime(true);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $durationInMicroseconds = floor(($this->endTime - $this->startTime) * 1000);

        $this->data["duration"] = $durationInMicroseconds;

        if (file_exists($this->storagePath)) {
            $oldLog = json_decode(file_get_contents($this->storagePath, true));
            array_push($oldLog, $this->data);
            $newLog = json_encode($oldLog, JSON_PRETTY_PRINT);
            file_put_contents($this->storagePath, $newLog);
        } else {
            $newArray[] = $this->data;
            $newLog = json_encode($newArray, JSON_PRETTY_PRINT);
            file_put_contents($this->storagePath, $newLog);
        }
    }
}
