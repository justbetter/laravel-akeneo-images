<?php

namespace JustBetter\AkeneoImages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JustBetter\AkeneoImages\Concerns\InteractsWithImages;

/**
 * @property int $id
 * @property string $disk
 * @property string $path
 * @property ?string $hash
 * @property ?Carbon $processed_at
 * @property ?string $processed_path
 * @property ?array $meta
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Image extends Model
{
    use InteractsWithImages;

    protected $table = 'akeneo_images';

    protected $casts = [
        'meta' => 'array',
        'processed_at' => 'datetime',
    ];

    protected $guarded = [];

    public function meta(int|string $key, mixed $default = null): mixed
    {
        if (is_null($this->meta)) {
            return $default;
        }

        return data_get($this->meta, $key, $default);
    }
}
