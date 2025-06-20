<?php

namespace JustBetter\AkeneoImages\Tests\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoImages\Actions\UploadImage;
use JustBetter\AkeneoImages\Models\Image;
use JustBetter\AkeneoImages\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UploadImageTest extends TestCase
{
    #[Test]
    public function it_can_upload_images(): void
    {
        Storage::fake('::disk::')->put('::path::', '::content::');

        Akeneo::fake();

        Http::fake([
            'akeneo/api/rest/v1/media-files' => Http::response(null, 201, [
                'Location' => 'akeneo/api/rest/v1/media-files/code',
            ]),
        ]);

        $meta = [
            'identifier' => '::identifier::',
            'attribute' => '::attribute::',
            'type' => '::type::',
            'scope' => '::scope::',
            'locale' => '::locale::',
        ];

        /** @var Image $image */
        $image = Image::query()->create([
            'disk' => '::disk::',
            'path' => '::path::',
            'hash' => md5('::content::'),
            'meta' => $meta,
        ]);

        /** @var UploadImage $action */
        $action = app(UploadImage::class);
        $action->upload($image);

        $this->assertEquals('code', $image->processed_path);
        $this->assertNotNull($image->processed_at);
    }
}
