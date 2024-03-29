<?php

namespace JustBetter\AkeneoImages\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustBetter\AkeneoImages\Contracts\ProcessesImage;

class ProcessImageJob implements ShouldBeUnique, ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $disk,
        public string $path,
        public ?array $meta = null,
        public bool $force = false
    ) {
        $this->onQueue(config('akeneo-images.queue'));
    }

    public function handle(ProcessesImage $contract): void
    {
        $contract->process($this->disk, $this->path, $this->meta, $this->force);
    }

    public function uniqueId(): string
    {
        return $this->disk.':'.$this->path;
    }

    public function tags(): array
    {
        return [
            $this->disk,
            $this->path,
            $this->force,
        ];
    }
}
