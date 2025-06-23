<?php

namespace JustBetter\AkeneoImages\Tests\Jobs;

use JustBetter\AkeneoImages\Contracts\ProcessesImage;
use JustBetter\AkeneoImages\Jobs\ProcessImageJob;
use JustBetter\AkeneoImages\Models\Image;
use JustBetter\AkeneoImages\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class ProcessImageJobTest extends TestCase
{
    #[Test]
    public function it_can_process_images(): void
    {
        $this->mock(ProcessesImage::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('process')
                ->with('::disk::', '::path::', ['key' => 'value'], false)
                ->once()
                ->andReturn(new Image);
        });

        ProcessImageJob::dispatch('::disk::', '::path::', ['key' => 'value'], false);
    }

    #[Test]
    public function it_has_the_correct_tags(): void
    {
        $this->assertEquals(
            [
                '::disk::',
                '::path::',
                false,
            ],
            (new ProcessImageJob('::disk::', '::path::', ['key' => 'value'], false))->tags(),
        );
    }
}
