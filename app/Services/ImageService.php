<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
  public static function upload($imageFile, $folderName, $width, $height)
  {
    try {
      $file = is_array($imageFile) ? $imageFile['image'] : $imageFile;

      $manager = new ImageManager(new Driver());
      $image = $manager->read($file->path());

      $fileName = self::generateFileName($file);
      $resizedImage = $image->resize($width, $height)->encode();

      Storage::put('public/' . $folderName . '/' . $fileName, $resizedImage);

      return $fileName;
    } catch (\Exception $e) {
      throw new \Exception('画像のアップロードに失敗しました。' . $e->getMessage());
    }
  }

  private static function generateFileName($file)
  {
    return uniqid() . '.' . $file->getClientOriginalExtension();
  }
  
  public static function uploadUser($imageFile, $folderName)
  {
    $width = 320;
    $height = 240;

    return self::upload($imageFile, $folderName, $width, $height);
  }

  public static function uploadBigThumbnail($imageFile, $folderName)
  {
    $width = 1920;
    $height = 1080;

    return self::upload($imageFile, $folderName, $width, $height);
  }

  public static function uploadMiddleThumbnail($imageFile, $folderName)
  {
    $width = 880;
    $height = 640;

    return self::upload($imageFile, $folderName, $width, $height);
  }

  public static function uploadSmallThumbnail($imageFile, $folderName)
  {
    $width = 640;
    $height = 480;

    return self::upload($imageFile, $folderName, $width, $height);
  }

  public static function uploadLogo($imageFile, $folderName)
  {
    $width = 120;
    $height = 120;

    return self::upload($imageFile, $folderName, $width, $height);
  }
}
