<?php

namespace JustBetter\AkeneoImages\Tests\Actions;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use JustBetter\AkeneoImages\Actions\ProcessImage;
use JustBetter\AkeneoImages\Jobs\UploadImageJob;
use JustBetter\AkeneoImages\Models\Image;
use JustBetter\AkeneoImages\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProcessImageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake();
        Storage::fake('::disk::')->put('::path::', '::content::');
    }

    #[Test]
    public function it_can_dispatch_upload_image_jobs(): void
    {
        /** @var ProcessImage $action */
        $action = app(ProcessImage::class);

        $image = $action->process('::disk::', '::path::');

        Bus::assertDispatched(UploadImageJob::class, 1);

        $this->assertNotNull($image->hash);
    }

    #[Test]
    public function it_can_skip_non_modified(): void
    {
        Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path::',
            'hash' => md5('::content::'),
        ]);

        /** @var ProcessImage $action */
        $action = app(ProcessImage::class);
        $action->process('::disk::', '::path::');

        Bus::assertNotDispatched(UploadImageJob::class);
    }

    #[Test]
    public function it_can_force_non_modified(): void
    {
        Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path::',
            'hash' => md5('::content::'),
        ]);

        /** @var ProcessImage $action */
        $action = app(ProcessImage::class);
        $action->process('::disk::', '::path::', null, true);

        Bus::assertDispatched(UploadImageJob::class, 1);
    }

    #[Test]
    public function it_can_skip_non_existing_files(): void
    {
        /** @var ProcessImage $action */
        $action = app(ProcessImage::class);

        $image = $action->process('::disk::', '::non-existing::');

        Bus::assertNotDispatched(UploadImageJob::class);

        $this->assertNull($image->hash);
    }
}
