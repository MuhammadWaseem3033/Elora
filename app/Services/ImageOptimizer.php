<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RuntimeException;
use Throwable;

class ImageOptimizer
{
    public function optimize(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 2000,
        int $maxHeight = 2000,
        int $quality = 100
    ): string {
        if (! $file->isValid()) {
            throw new RuntimeException('Invalid uploaded image.');
        }

        if ($maxWidth < 1 || $maxHeight < 1) {
            throw new RuntimeException('Invalid image dimensions.');
        }

        if ($quality < 1 || $quality > 100) {
            throw new RuntimeException('Image quality must be between 1 and 100.');
        }

        $image = (new ImageManager(new Driver()))
            ->read($file->getRealPath());

        $image->scaleDown($maxWidth, $maxHeight);

        $filename = Str::uuid() . '.webp';

        $path = public_path(trim($directory, '/\\'));

        if (! is_dir($path) && ! mkdir($path, 0755, true) && ! is_dir($path)) {
            throw new RuntimeException('Unable to create image directory.');
        }

        $fullPath = $path . DIRECTORY_SEPARATOR . $filename;

        try {
            $image->toWebp($quality)->save($fullPath);

            if (! file_exists($fullPath) || filesize($fullPath) === 0) {
                throw new RuntimeException('Image optimization failed.');
            }
        } catch (Throwable $exception) {
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            throw $exception;
        }

        return trim($directory, '/\\') . '/' . $filename;
    }
}
