<?php

namespace JustBetter\AkeneoImages\Concerns;

use Illuminate\Support\Facades\Storage;

trait InteractsWithImages
{
    public function contents(): ?string
    {
        return Storage::disk($this->disk)->get($this->path);
    }

    public function stream(): mixed
    {
        return Storage::disk($this->disk)->readStream($this->path);
    }

    public function generateHash(): ?string
    {
        $content = $this->contents();

        return $content !== null
            ? md5($content)
            : null;
    }

    public function isModified(): bool
    {
        return $this->hash !== $this->generateHash();
    }
}
