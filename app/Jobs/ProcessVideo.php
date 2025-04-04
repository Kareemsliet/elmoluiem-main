<?php

namespace App\Jobs;

use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ProcessVideo implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    
     public $videoPath;
    
     public function __construct($videoPath)
     {
         $this->videoPath = $videoPath;
     }
    /**
     * Execute the job.
     */
    public function handle()
    {
        $upload = (new UploadApi())->upload($this->videoPath, [
            "resource_type" => "video",
            "eager" => [
                [
                    "quality" => "auto:eco", 
                    "format" => "mp4"
                ]
            ]
        ]);

        $compressedVideoUrl = $upload['eager'][0]['secure_url'];

        $videoContent = file_get_contents($compressedVideoUrl);
        
        $compressedFileName = 'compressed_' . basename($this->videoPath);
        
        Storage::disk('public')->put('teachers/lessons/lectures/' . $compressedFileName, $videoContent);
    }
}
