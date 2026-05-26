<?php

declare(strict_types=1);

namespace JustBetter\AkeneoImages\Contracts;

use JustBetter\AkeneoImages\Models\Image;

interface UploadsImage
{
    public function upload(Image $image): Image;
}
