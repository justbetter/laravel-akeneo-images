<?php

namespace JustBetter\AkeneoImages\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\AkeneoImages\Contracts\UploadsImage;
use JustBetter\AkeneoImages\Models\Image;

class UploadImageJob implements ShouldQueue, ShouldBeUnique
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Image $image,
    ) {
        $this->onQueue(config('akeneo-images.queue'));
    }

    public function handle(UploadsImage $contract): void
    {
        $contract->upload($this->image);
    }

    public function uniqueId(): int
    {
        return $this->image->id;
    }

    public function tags(): array
    {
        return [
            $this->image->id,
        ];
    }
}
