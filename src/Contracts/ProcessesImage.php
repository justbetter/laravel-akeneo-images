<?php

namespace JustBetter\AkeneoImages\Contracts;

use JustBetter\AkeneoImages\Models\Image;

interface ProcessesImage
{
    public function process(string $disk, string $path, ?array $meta = null, bool $force = false): Image;
}
