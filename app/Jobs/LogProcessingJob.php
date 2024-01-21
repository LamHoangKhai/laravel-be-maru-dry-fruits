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

    public $request;
    public function __construct($storagePath, $data)
    {
        $this->storagePath = $storagePath;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
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
