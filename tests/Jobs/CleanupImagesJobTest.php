<?php

declare(strict_types=1);

namespace JustBetter\AkeneoImages\Tests\Jobs;

use JustBetter\AkeneoImages\Contracts\CleansupImages;
use JustBetter\AkeneoImages\Jobs\CleanupImagesJob;
use JustBetter\AkeneoImages\Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

final class CleanupImagesJobTest extends TestCase
{
    #[Test]
    public function it_calls_action(): void
    {
        $this->mock(CleansupImages::class, function (MockInterface $mock): void {
            $mock
                ->shouldReceive('cleanup')
                ->with(30)
                ->once();
        });

        CleanupImagesJob::dispatch(30);
    }

    #[Test]
    public function it_has_the_correct_tags(): void
    {
        $this->assertSame(
            [
                'days:30',
            ],
            (new CleanupImagesJob(30))->tags(),
        );
    }
}
