<?php

namespace JustBetter\AkeneoImages\Actions;

use Illuminate\Support\Facades\Storage;
use JustBetter\AkeneoImages\Contracts\CleansupImages;
use JustBetter\AkeneoImages\Models\Image;

class CleanupImages implements CleansupImages
{
    public function cleanup(int $days): void
    {
        Image::query()
            ->where('created_at', '<=', now()->subDays($days))
            ->get()
            ->each(function (Image $image): void {
                if (Storage::disk($image->disk)->exists($image->path)) {
                    Storage::disk($image->disk)->delete($image->path);
                }

                $image->delete();
            });
    }

    public static function bind(): void
    {
        app()->singleton(CleansupImages::class, static::class);
    }
}
