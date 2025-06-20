<?php

namespace JustBetter\AkeneoImages\Tests\Actions;

use Illuminate\Support\Facades\Storage;
use JustBetter\AkeneoImages\Actions\CleanupImages;
use JustBetter\AkeneoImages\Models\Image;
use JustBetter\AkeneoImages\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CleanupImagesTest extends TestCase
{
    #[Test]
    public function it_cleans_up_imags(): void
    {

        Storage::fake('::disk::');
        Storage::disk('::disk::')->put('::path_1::', '::content::');
        Storage::disk('::disk::')->put('::path_2::', '::content::');

        Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path_1::',
            'hash' => md5('::content::'),
            'created_at' => now()->subDays(31),
        ]);

        Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path_2::',
            'hash' => md5('::content::'),
            'created_at' => now()->subDays(29),
        ]);

        $action = app(CleanupImages::class);
        $action->cleanup(30);

        $this->assertDatabaseCount(Image::class, 1);

        $this->assertFalse(Storage::disk('::disk::')->exists('::path_1::'));
    }
}
