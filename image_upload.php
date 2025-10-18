<?php

function resize_image($srcPath, $destPath, $maxWidth, $maxHeight) {
    list($width, $height, $type) = getimagesize($srcPath);
    $ratio = min($maxWidth / $width, $maxHeight / $height, 1);
    $newW = (int)($width * $ratio);
    $newH = (int)($height * $ratio);

    switch ($type) {
        case IMAGETYPE_JPEG:
            $srcImg = imagecreatefromjpeg($srcPath); break;
        case IMAGETYPE_PNG:
            $srcImg = imagecreatefrompng($srcPath); break;
        case IMAGETYPE_GIF:
            $srcImg = imagecreatefromgif($srcPath); break;
        default:
            return false;
    }

    $dstImg = imagecreatetruecolor($newW, $newH);

    if($type == IMAGETYPE_PNG){
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);
    }

    imagecopyresampled($dstImg, $srcImg, 0,0,0,0, $newW, $newH, $width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG: imagejpeg($dstImg, $destPath, 85); break;
        case IMAGETYPE_PNG: imagepng($dstImg, $destPath); break;
        case IMAGETYPE_GIF: imagegif($dstImg, $destPath); break;
    }

    imagedestroy($srcImg);
    imagedestroy($dstImg);
    return true;
}
