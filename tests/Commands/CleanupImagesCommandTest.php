<?php

namespace JustBetter\AkeneoImages\Tests\Commands;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoImages\Commands\CleanupImagesCommand;
use JustBetter\AkeneoImages\Jobs\CleanupImagesJob;
use JustBetter\AkeneoImages\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CleanupImagesCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        $this->artisan(CleanupImagesCommand::class, [
            '--days' => 30,
        ]);

        Bus::assertDispatched(CleanupImagesJob::class);
    }
}
