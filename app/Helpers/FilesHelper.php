<?php

namespace App\Helpers;


use App\Traits\HasImage;

class FilesHelper
{
    use HasImage;

    public static function filePath($file): string
    {
        if (!$file) {
            return '';
        }
        return url(self::fileFullPath($file));
    }

    public static function getRootFolder(string $destination_path): string
    {
        // set root folder based on environment
        $root_folder = "local";
        if (app()->environment('production')) {
            $root_folder = "production";
        }
        if (app()->environment(['staging', 'testing', 'development'])) {
            $root_folder = "staging";
        }
        return $root_folder . "/public/uploads/" . $destination_path;
    }
}
