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

        $this->updateVideoOptions($response);

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

        $response = $this->vimeo->request($videoUri);

        if ($response['status'] === 200) {
            return $response["body"]["duration"];
        }

        return null;
    }

    public function getVideoUrl($videoId)
    {
        $videoUri = "/videos/$videoId";

        $response = $this->vimeo->request($videoUri);

        if ($response['status'] === 200) {
            return $response['body']["link"];
        }

        return null;
    }

    public function updateVideoOptions($videoUri)
    {
        $response = $this->vimeo->request("$videoUri", [
            'embed' => [
                'buttons' => [
                    'like' => false,
                    'share' => false,
                    'watchlater' => false,
                    'embed' => false,
                    "add" => false,
                ],
                'logos' => [
                    'vimeo' => false,
                    'custom' => [
                        'active' => false,
                        'link' => 'https://elmullim.com',
                        'sticky' => true
                    ]
                ],
                'title' => [
                    'name' => 'hide',
                    'owner' => 'hide',
                    'portrait' => 'hide'
                ],
                'domains' =>['localhost:5173', 'elmullim.com'],
            ],
            'playback' => [
                'quality' => [
                    'type' => 'hls',
                    'custom' => [
                        'bitrates' => [240, 360, 540, 720, 1080]
                    ]
                ],
                'resolution' => '1080p'
            ],
            'privacy' => [
                'view' => 'unlisted',
                "dawnload" => false,
                'embed' => 'public',
            ],
        ], "PATCH");
    }

}