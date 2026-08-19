<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload file.
     */
    public static function upload(
        UploadedFile $file,
        string $folder
    ): string {

        return $file->store($folder, 'local');

    }

    /**
     * Replace file lama dengan file baru.
     */
    public static function replace(
        UploadedFile $file,
        ?string $oldFile,
        string $folder
    ): string {

        if (
            $oldFile &&
            Storage::disk('local')->exists($oldFile)
        ) {

            Storage::disk('local')->delete($oldFile);

        }

        return self::upload($file, $folder);

    }

    /**
     * Hapus file.
     */
    public static function delete(?string $file): void
    {

        if (
            $file &&
            Storage::disk('local')->exists($file)
        ) {

            Storage::disk('local')->delete($file);

        }

    }
}