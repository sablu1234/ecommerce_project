<?php
function image_resize( $source, $destination, $new_width, $new_height ){
    list($width, $height) = getimagesize($source);
    $newimage = imagecreatetruecolor($new_width, $new_height) ;
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $source);
    if($mime == 'image/jpeg'){
        $src = imagecreatefromjpeg($source);
        imagecopyresized($newimage, $src,0,0,0,0, $new_width, $new_height, $width, $height);
        imagejpeg($newimage, $destination);
    }elseif($mime == 'image/png'){
        $src = imagecreatefrompng($source);
        imagecopyresized($newimage, $src,0,0,0,0, $new_width, $new_height, $width, $height);
        imagepng($newimage, $destination);
    }elseif($mime == 'image/gif'){
        $src = imagecreatefromgif($source);
        imagecopyresized($newimage, $src,0,0,0,0, $new_width, $new_height, $width, $height);
        imagegif($newimage, $destination);
    }
}

function image_crop_square($source, $destination, $final_size)
{
    list($width, $height) = getimagesize($source);

    // Determine the square crop size
    $shorter_side = min($width, $height);

    // Center crop calculations
    $crop_x = ($width  - $shorter_side) / 2;
    $crop_y = ($height - $shorter_side) / 2;

    // Create blank final canvas
    $final_img = imagecreatetruecolor($final_size, $final_size);

    // Detect MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $source);

    // Load original image
    if ($mime == 'image/jpeg') {
        $src = imagecreatefromjpeg($source);
    } elseif ($mime == 'image/png') {
        $src = imagecreatefrompng($source);

        imagealphablending($final_img, false);
        imagesavealpha($final_img, true);
    } elseif ($mime == 'image/gif') {
        $src = imagecreatefromgif($source);
    } else {
        return false;
    }

    // Crop → Resize
    imagecopyresampled(
        $final_img,
        $src,
        0, 0,                     // dest x,y
        $crop_x, $crop_y,         // source crop x,y
        $final_size, $final_size, // output size
        $shorter_side, $shorter_side  // crop square size
    );

    // Save
    if ($mime == 'image/jpeg') {
        imagejpeg($final_img, $destination, 90);
    } elseif ($mime == 'image/png') {
        imagepng($final_img, $destination);
    } elseif ($mime == 'image/gif') {
        imagegif($final_img, $destination);
    }

    return true;
}
