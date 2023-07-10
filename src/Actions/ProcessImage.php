<?php

namespace JustBetter\AkeneoImages\Actions;

use JustBetter\AkeneoImages\Contracts\ProcessesImage;
use JustBetter\AkeneoImages\Jobs\UploadImageJob;
use JustBetter\AkeneoImages\Models\Image;

class ProcessImage implements ProcessesImage
{
    public function process(string $disk, string $path, ?array $meta = null, bool $force = false): Image
    {
        /** @var Image $image */
        $image = Image::query()->updateOrCreate([
            'disk' => $disk,
            'path' => $path,
        ], [
            'meta' => $meta,
        ]);

        if (! $force && ! $image->isModified()) {
            return $image;
        }

        $image->hash = $image->generateHash();
        $image->save();

        UploadImageJob::dispatch($image);

        return $image;
    }

    public static function bind(): void
    {
        app()->singleton(ProcessesImage::class, static::class);
    }
}
