<?php

namespace JustBetter\AkeneoImages\Commands;

use Illuminate\Console\Command;
use JustBetter\AkeneoImages\Jobs\ProcessImageJob;

class ProcessImageCommand extends Command
{
    protected $signature = 'akeneo-image:process {disk} {path} {--force}';

    protected $description = 'Process an image for Akeneo';

    public function handle(): int
    {
        /** @var string $disk */
        $disk = $this->argument('disk');

        /** @var string $path */
        $path = $this->argument('path');

        /** @var bool $force */
        $force = $this->option('force');

        ProcessImageJob::dispatch($disk, $path, null, $force);

        return static::SUCCESS;
    }
}
