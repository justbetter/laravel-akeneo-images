<?php

namespace JustBetter\AkeneoImages\Commands;

use Illuminate\Console\Command;
use JustBetter\AkeneoImages\Jobs\UploadImageJob;
use JustBetter\AkeneoImages\Models\Image;

class UploadImageCommand extends Command
{
    protected $signature = 'akeneo-image:upload {image-id}';

    protected $description = 'Upload an image for Akeneo';

    public function handle(): int
    {
        $imageId = $this->argument('image-id');

        /** @var Image $image */
        $image = Image::query()->findOrFail($imageId);

        UploadImageJob::dispatch($image);

        return static::SUCCESS;
    }
}
