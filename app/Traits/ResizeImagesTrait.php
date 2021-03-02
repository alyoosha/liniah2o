<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 17.11.2020
 * Time: 9:43
 */

namespace App\Traits;


trait ResizeImagesTrait
{
    public static function resizeImage530($image) {
        $width530 = 530;
        $height530 = 530;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width530/$height530 > $ratio_orig) {
            $width530 = $height530*$ratio_orig;
        } else {
            $height530 = $width530/$ratio_orig;
        }


        $image_p530 = imagecreatetruecolor($width530, $height530);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p530, $image, 0, 0, 0, 0, $width530, $height530, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p530;

    }

    public static function resizeImage355($image) {
        $width355 = 355;
        $height355 = 355;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width355/$height355 > $ratio_orig) {
            $width355 = $height355*$ratio_orig;
        } else {
            $height355 = $width355/$ratio_orig;
        }

        $image_p355 = imagecreatetruecolor($width355, $height355);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p355, $image, 0, 0, 0, 0, $width355, $height355, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p355;
    }

    public static function resizeImage710($image) {
        $width710 = 710;
        $height710 = 710;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width710/$height710 > $ratio_orig) {
            $width710 = $height710*$ratio_orig;
        } else {
            $height710 = $width710/$ratio_orig;
        }

        $image_p710 = imagecreatetruecolor($width710, $height710);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p710, $image, 0, 0, 0, 0, $width710, $height710, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p710;
    }

    public static function resizeImage535($image) {
        $width535= 535;
        $height535 = 535;

        list($width_orig, $height_orig) = getimagesize(storage_path('app/') . $image);

        $ratio_orig = $width_orig/$height_orig;

        if ($width535/$height535 > $ratio_orig) {
            $width535 = $height535*$ratio_orig;
        } else {
            $height535 = $width535/$ratio_orig;
        }

        $image_p535 = imagecreatetruecolor($width535, $height535);

        $image = imagecreatefromjpeg(storage_path('app/') . $image);

        imagecopyresampled($image_p535, $image, 0, 0, 0, 0, $width535, $height535, $width_orig, $height_orig);
        imagedestroy($image);

        return $image_p535;
    }

    public static function convertResource($image) {
        ob_start();
        imagejpeg($image, null, 90);
        $binary = ob_get_clean();
        $string = $binary;

        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);
        return $stream;
    }
}