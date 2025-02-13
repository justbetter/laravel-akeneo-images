<?php

namespace JustBetter\AkeneoImages\Tests\Jobs;

use JustBetter\AkeneoImages\Contracts\UploadsImage;
use JustBetter\AkeneoImages\Jobs\UploadImageJob;
use JustBetter\AkeneoImages\Models\Image;
use JustBetter\AkeneoImages\Tests\TestCase;
use Mockery\MockInterface;

class UploadImageJobTest extends TestCase
{
    /** @test */
    public function it_can_upload_images(): void
    {
        /** @var Image $image */
        $image = Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path::',
        ]);

        $this->mock(UploadsImage::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('upload')
                ->once()
                ->andReturn(new Image);
        });

        UploadImageJob::dispatch($image);
    }

    /** @test */
    public function it_has_the_correct_tags(): void
    {
        /** @var Image $image */
        $image = Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path::',
        ]);

        $this->assertEquals(
            [
                $image->id,
            ],
            (new UploadImageJob($image))->tags(),
        );
    }
}
