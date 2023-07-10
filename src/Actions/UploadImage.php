<?php

namespace JustBetter\AkeneoImages\Actions;

use Akeneo\Pim\ApiClient\Api\MediaFileApiInterface;
use JustBetter\AkeneoClient\Client\Akeneo;
use JustBetter\AkeneoImages\Contracts\UploadsImage;
use JustBetter\AkeneoImages\Models\Image;

class UploadImage implements UploadsImage
{
    public function __construct(
        protected Akeneo $akeneo
    ) {
    }

    public function upload(Image $image): Image
    {
        /** @var MediaFileApiInterface $api */
        $api = $this->akeneo->getProductMediaFileApi();

        $path = $api->create($image->stream(), [
            'identifier' => $image->meta('identifier'),
            'attribute' => $image->meta('attribute'),
            'type' => $image->meta('type'),
            'scope' => $image->meta('scope'),
            'locale' => $image->meta('locale'),
        ]);

        $image->processed_path = $path;
        $image->processed_at = now();
        $image->save();

        return $image;
    }

    public static function bind(): void
    {
        app()->singleton(UploadsImage::class, static::class);
    }
}
