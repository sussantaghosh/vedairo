<?php
$srcFile = __DIR__ . '/../logo.png';
if (!file_exists($srcFile)) {
    echo "logo.png not found\n";
    exit(1);
}

$src = @imagecreatefrompng($srcFile);
if (!$src) {
    echo "Failed to load PNG\n";
    exit(1);
}

$w = imagesx($src);
$h = imagesy($src);
echo "Source: {$w}x{$h}\n";

$imgDir = __DIR__ . '/../public/images';
if (!is_dir($imgDir)) {
    mkdir($imgDir, 0755, true);
}

// Copy original to public/logo.png and public/images/logo.png
copy($srcFile, __DIR__ . '/../public/logo.png');
copy($srcFile, $imgDir . '/logo.png');

// Web logo (360px width)
$tw = 360;
$th = (int) ($h * ($tw / $w));
$dst = imagecreatetruecolor($tw, $th);
imagealphablending($dst, false);
imagesavealpha($dst, true);
imagecopyresampled($dst, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
imagepng($dst, $imgDir . '/logo-web.png', 7);

// Favicon / Icon size (80x80)
$size = 80;
$iconDst = imagecreatetruecolor($size, $size);
imagealphablending($iconDst, false);
imagesavealpha($iconDst, true);
imagecopyresampled($iconDst, $src, 0, 0, 0, 0, $size, $size, $w, $h);
imagepng($iconDst, $imgDir . '/logo-icon.png', 7);
imagepng($iconDst, __DIR__ . '/../public/favicon.png', 7);

imagedestroy($src);
imagedestroy($dst);
imagedestroy($iconDst);

echo "Successfully generated web logos!\n";
