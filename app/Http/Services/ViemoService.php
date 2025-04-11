<?php

namespace App\Http\Services;

use Vimeo\Vimeo;

class ViemoService
{
    protected $vimeo;

    public function __construct()
    {
        $this->vimeo = new Vimeo(
            "7a68a0c14acb62797322b447da62bce82f6a992c",
            "1lizQBcbBeKKnBLs+JWqjdiN/3xGC7ht32KJwAip+por6LEK9Trls++GioP7NNWVndjP9+RxUsRECX8by+EzSxuGriMw6y1TFBZle3ZfVHODJoLg/xacJDcTWsFS+x+T",
            "fabae0cb7fa36e04577aa79f43055239"
        );
    }

    public function uploadVideo($filePath, $title = '', $description = "")
    {
        $response = $this->vimeo->upload($filePath, [
            'name' => $title,
            'description' => $description,
            'upload' => [
                'approach' => 'tus',
                'size' => filesize($filePath),
            ],
        ]);

        $videoId = explode("/", $response)[2];

        return $videoId;
    }

    public function deleteVideo($videoId)
    {
        $videoUri = "/videos/$videoId";

        try {
            $response = $this->vimeo->request($videoUri, [], 'DELETE');
            return $response['status'] === 204;
        } catch (\Exception $e) {
            return failResponse("Error deleting video: " . $e->getMessage());
        }
    }

    public function getVideoDeuration($videoId)
    {
        $videoUri = "/videos/$videoId";

        $duration = 0;

        for ($i = 0; $i < 5; $i++) {

            $response = $this->vimeo->request($videoUri);

            if (in_array($response["body"]["status"], ['available', 'processing'])) {
                $duration = $response["body"]["duration"];
            }
            
        }

        return $duration;
    }
}