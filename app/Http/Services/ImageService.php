<?php

namespace App\Http\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
class ImageService
{
    public $disk;
    public function __construct(){
      $this->disk="public";
    }
    public function uploadImage($file,$folderPath)
    {
        $image = uniqid().'.'.$file->getClientOriginalExtension();

        $file->storeAs($folderPath,$image,['disk'=>$this->disk]);

        return $image;
    }
    public function destroyImage($fileName,$folderPath){
      Storage::disk($this->disk)->delete($folderPath.'/'.$fileName);
    }
    public function imageUrlToBase64($filePath){

      $client= new Client();

      $imageUrl=url(Storage::disk($this->disk)->url($filePath));

      $response = $client->get($imageUrl);

      $imageContent = $response->getBody()->getContents();

      $contentType = $response->getHeader('Content-Type')[0];

      $extension = explode('/', $contentType)[1]; // Get the image extension

      $imageBase64=base64_encode($imageContent);

      $dataUri = "data:image/{$extension};base64,{$imageBase64}";

      return $dataUri;
    }
}

