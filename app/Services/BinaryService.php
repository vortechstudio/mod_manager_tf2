<?php

namespace App\Services;

class BinaryService
{
    public function checkImageMagick()
    {
        $output = shell_exec('magick -version');
        return str_contains($output, "ImageMagick");
    }

    public function installImageMagick()
    {
        $uri = 'https://imagemagick.org/archive/binaries/ImageMagick-7.1.1-39-portable-Q16-HDRI-x86.zip';
        \File::makeDirectory(public_path('bin/modvalidator'), 0777, true);
        $outputDir = public_path('bin/imagemagick');
        $archivePath = $outputDir . "/ImageMagick.tar.gz";

        file_put_contents($archivePath, fopen($uri, 'r'));

        exec("tar -xvzf " . $archivePath . " -C " . $outputDir);

        unlink($archivePath);
    }

    function checkModValidator()
    {
        return file_exists(public_path('bin/modvalidator/mod_validator.exe'));
    }

    public function installModValidator()
    {
        $uri = 'https://www.transportfever2.com/wiki/lib/exe/fetch.php?media=modding:tools:tf2_modvalidator_public_v0.10.0.zip';
        \File::makeDirectory(public_path('bin/modvalidator'), 0777, true);
        $outputDir = public_path('bin/modvalidator');
        $archivePath = $outputDir. "/modValidator.zip";

        file_put_contents($archivePath, fopen($uri, 'r'));

        exec("unzip ". $archivePath. " -d ". $outputDir);
        rename($outputDir."/TF2_ModValidator_Public.exe", $outputDir."/mod_validator.exe");

        unlink($archivePath);
    }
}
