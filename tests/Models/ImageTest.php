<?php

namespace JustBetter\AkeneoImages\Tests\Models;

use JustBetter\AkeneoImages\Models\Image;
use JustBetter\AkeneoImages\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ImageTest extends TestCase
{
    #[Test]
    #[DataProvider('meta')]
    public function it_can_get_meta(?array $meta, int|string $key, mixed $default, mixed $expected): void
    {
        $image = new Image;
        $image->meta = $meta;

        $this->assertEquals($expected, $image->meta($key, $default));
    }

    public static function meta(): array
    {
        return [
            'Default usage' => [
                [
                    'key' => 'value',
                ],
                'key',
                null,
                'value',
            ],
            'Non-existent' => [
                [
                    'key' => 'value',
                ],
                'non-existent',
                null,
                null,
            ],
            'Different default' => [
                [
                    'key' => 'value',
                ],
                'non-existent',
                'default',
                'default',
            ],
            'Without meta' => [
                null,
                'key',
                null,
                null,
            ],
        ];
    }
}
