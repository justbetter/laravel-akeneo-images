<?php

namespace JustBetter\AkeneoImages\Commands;

use Illuminate\Console\Command;
use JustBetter\AkeneoImages\Jobs\CleanupImagesJob;

class CleanupImagesCommand extends Command
{
    protected $signature = 'akeneo-image:cleanup {--days=}';

    protected $description = 'Cleanup images that are older than the specified number of days.';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        CleanupImagesJob::dispatch($days);

        return static::SUCCESS;
    }
}
