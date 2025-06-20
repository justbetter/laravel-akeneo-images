<?php

namespace JustBetter\AkeneoImages\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use JustBetter\AkeneoImages\Contracts\CleansupImages;

class CleanupImagesJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(
        public int $days,
    ) {
        $this->onQueue(config('akeneo-images.queue'));
    }

    public function handle(CleansupImages $contract): void
    {
        $contract->cleanup($this->days);
    }

    public function tags(): array
    {
        return [
            'days:'.$this->days,
        ];
    }
}
