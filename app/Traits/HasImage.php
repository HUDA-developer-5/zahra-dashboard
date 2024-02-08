<?php

namespace App\Traits;

use App\Helpers\FilesHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public static function fileFullPath($file): string
    {
        if (!$file) {
            return '';
        }
//        return config('filesystems.CDN_AWS_URL') . '/' . $file;
        return Storage::disk(config('filesystems.default'))->url($file);
    }

    public function setImageAttributeValue($value, string $attribute_name): void
    {
        // or use your own disk, defined in config/filesystems.php
        $disk = config('filesystems.default');
        // destination path relative to the disk above

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            if (isset($this->{$attribute_name}) && !empty($this->{$attribute_name})) {
                Storage::disk($disk)->delete($this->{$attribute_name});
            }
            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        if ($value) {
            // 0. Make the image
            $full_path = self::uploadImage($value, self::$destination_path);

            // 3. Delete the previous image, if there was one.
            if (isset($this->{$attribute_name}) && !empty($this->{$attribute_name})) {
                Storage::disk($disk)->delete($this->{$attribute_name});
            }

            $this->attributes[$attribute_name] = $full_path;
        }
    }

    public static function uploadImage(UploadedFile $file, string $destination_path): string
    {
        return $file->storePublicly(FilesHelper::getRootFolder($destination_path), config('filesystems.default'));
    }

    public static function deleteImage($path): bool
    {
        if ($path) {
            return Storage::disk(config('filesystems.default'))->delete($path);
        }
        return true;
    }

    public function setVideoAttributeValue($value, string $attribute_name): void
    {
        // or use your own disk, defined in config/filesystems.php
        $disk = config('filesystems.default');
        // destination path relative to the disk above
        if ($value == null) {
            // delete from disk
            if (isset($this->{$attribute_name}) && !empty($this->{$attribute_name})) {
                Storage::disk($disk)->delete($this->{$attribute_name});
            }
            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        if ($value) {
            // Generate a unique file name or use the original file name
            $filename = uniqid() . '.' . $value->getClientOriginalExtension();
            // Specify the S3 disk and path where the file should be stored
            $path = FilesHelper::getRootFolder(self::$destination_path) . '/' . $filename;
            $disk = Storage::disk(config('filesystems.default'));
            $disk->put($path, fopen($value, 'r+'));
            // Optionally, you can also set the visibility of the uploaded file
            $disk->setVisibility($path, 'public');

            // 3. Delete the previous one, if there was new one.
            if (isset($this->{$attribute_name}) && !empty($this->{$attribute_name})) {
                Storage::disk(config('filesystems.default'))->delete($this->{$attribute_name});
            }

            $this->attributes[$attribute_name] = $path;
        }
//        $this->uploadFileToDisk($file, $attribute_name, config('filesystems.default'), FilesHelper::getRootFolder(self::$destination_path));
    }
}