<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class UploadHelper
{
    /**
     * Upload file ke folder tertentu
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string|null $prefix
     * @param string|null $oldFileName
     * @return string $fileName (nama file baru)
     */
    public static function uploadFile($file, $folder, $prefix = null, $oldFileName = null)
    {
        $basePath = Config::get('app.upload_base_path');

        $uploadPath = $basePath . '/' . $folder;

        // Hapus file lama kalau ada
        if ($oldFileName && file_exists($uploadPath . '/' . $oldFileName)) {
            @unlink($uploadPath . '/' . $oldFileName);
        }

        // Generate nama file
        $fileName = ($prefix ?? 'file') . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Pastikan folder upload ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Pindahkan file
        $file->move($uploadPath, $fileName);

        return $fileName;
    }

    /**
     * Hapus file saja
     *
     * @param string $folder
     * @param string $fileName
     * @return void
     */
    public static function deleteFile($folder, $fileName)
    {
        $basePath = Config::get('app.upload_base_path');
        $filePath = $basePath . '/' . $folder . '/' . $fileName;

        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}
