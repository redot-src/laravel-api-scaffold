<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

trait CanUploadFile
{
    /**
     * Upload file to path.
     */
    public function uploadFile(UploadedFile $file, string $path = ''): string
    {
        $path = 'uploads/' . $path;
        $directory = dirname(public_path($path));
        File::ensureDirectoryExists($directory, 0755, true);

        $extension = $file->getClientOriginalExtension();
        $originalName = basename($file->getClientOriginalName(), '.' . $extension);
        $filename = Str::slug($originalName) . '-' . Str::random(8) . '.' . $extension;

        $file->move($path, $filename);

        return URL::to($path . '/' . $filename);
    }

    /**
     * Delete file from path.
     */
    public function deleteFile(string $path): bool
    {
        return File::delete(public_path($path));
    }

    /**
     * Delete file from path.
     */
    public function deleteFileFromUrl(string $url): bool
    {
        $path = str_replace(URL::to('/'), '', $url);

        return $this->deleteFile($path);
    }
}
