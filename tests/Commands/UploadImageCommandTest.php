<?php

namespace JustBetter\AkeneoImages\Tests\Commands;

use Illuminate\Support\Facades\Bus;
use JustBetter\AkeneoImages\Jobs\UploadImageJob;
use JustBetter\AkeneoImages\Models\Image;
use JustBetter\AkeneoImages\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UploadImageCommandTest extends TestCase
{
    #[Test]
    public function it_can_dispatch_jobs(): void
    {
        Bus::fake();

        /** @var Image $image */
        $image = Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path::',
        ]);

        $this->artisan('akeneo-image:upload '.$image->id);

        Bus::assertDispatched(UploadImageJob::class, 1);
    }
}
