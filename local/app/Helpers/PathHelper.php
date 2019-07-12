<?php

if (!function_exists('imagePath')) {
    function imagePath($filename = '', $path = 'originalImagePath')
    {
        return config("cms.{$path}") . $filename;
    }
}

if (!function_exists('imageBasePath')) {
    function imageBasePath($filename = '', $path = 'originalImagePath')
    {
        return asset(config("cms.{$path}") . $filename);
    }
}

if (!function_exists('checkFileExistOnS3')) {
    function checkFileExistOnS3($file_path = null)
    {
        $s3 = \Storage::disk('s3');
        return $s3->exists($file_path);
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($filename = false, $type = 'image', $path = 'originalImagePath', $cdn = false)
    {
        $randomString = random_int(0, PHP_INT_MAX) . strtotime(now());

        if ($cdn == true) {
            $s3 = \Storage::disk('s3');
        }

        if (\Input::hasFile($filename)) {
            $mediaFile = \Input::file($filename);
            $filename = $randomString . '.' . $mediaFile->getClientOriginalExtension();
            if ($type == 'image') {
                if ($cdn == true) {
                    $imagePath = imagePath($filename);
                    $response = $s3->put($imagePath, file_get_contents($mediaFile), 'public');
                } else {
                    $imagePath = imagePath('', $path);
                    $response = $mediaFile->move($imagePath, $filename);
                }
                if ($response) {
                    return $filename;
                }
            } elseif ($type == 'video') {
                if ($cdn == true) {
                    $videoPath = videoPath($filename);
                    $response = $s3->put($videoPath, file_get_contents($mediaFile), 'public');
                } else {
                    $videoPath = videoPath();
                    $response = $mediaFile->move($videoPath, $filename);
                }
                if ($response) {
                    return $filename;
                }
            }
        }

        if ($type == 'thumbnail') {
            $videoFilePath = cdn_link(videoPath($filename));
            $thumbnail_image = $randomString . '.jpg';
            $imagePath = imagePath($thumbnail_image);
            $extC = pathinfo($videoFilePath, PATHINFO_EXTENSION);
            if ($extC == 'mov') {
                exec("ffmpeg -i {$videoFilePath} -c:v libx264 -c:a aac -strict experimental {$imagePath}");
            } else {
                exec("ffmpeg -i {$videoFilePath} -vcodec h264 -acodec aac -strict -2 {$imagePath}");
            }
            exec("ffmpeg  -i {$videoFilePath} -deinterlace -an -ss 2 -f mjpeg -t 1 -r 1 -y -s 400x300 {$imagePath} 2>&1");
            if ($cdn == true) {
                $mediaFile = public_path($imagePath);
                $response = $s3->put($imagePath, file_get_contents($mediaFile), 'public');
            } else {
                $response = true;
            }
            if ($response) {
                if ($cdn == true) {
                    unlink($mediaFile);
                }
                return $thumbnail_image;
            }
        }
        return null;
    }
}
