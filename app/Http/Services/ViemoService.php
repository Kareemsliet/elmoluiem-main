<?php

namespace App\Http\Services;

use Vimeo\Vimeo;

class ViemoService {
    protected $vimeo;

    public function __construct() {
        $this->vimeo = new Vimeo(
            "7a68a0c14acb62797322b447da62bce82f6a992c",
            "1lizQBcbBeKKnBLs+JWqjdiN/3xGC7ht32KJwAip+por6LEK9Trls++GioP7NNWVndjP9+RxUsRECX8by+EzSxuGriMw6y1TFBZle3ZfVHODJoLg/xacJDcTWsFS+x+T",
            "fabae0cb7fa36e04577aa79f43055239"
        );
    }

    public function uploadVideo($filePath,$title,$description) {

        $response = $this->vimeo->upload($filePath, [
            'name' => $title,
            'description' => $description
        ]);

        return $response; // Returns the video URI
    }

    public function deleteVideo($videoUri) {
        try {
            $response = $this->vimeo->request($videoUri, [], 'DELETE');
            return $response['status'] === 204; // Check if deletion was successful
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public Function videoUrl($videoUrl) {
        $urlBase="https://vimeo.com";
        
        $videoUrl=$urlBase.$videoUrl;

        return $videoUrl;
    }



}