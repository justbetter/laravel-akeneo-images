<?php

namespace JustBetter\AkeneoImages\Tests\Commands;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoImages\Jobs\ProcessImageJob;
use JustBetter\AkeneoImages\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProcessImageCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        $this->artisan('akeneo-image:process ::disk:: ::path::');

        Bus::assertDispatched(ProcessImageJob::class, 1);
    }
}
