<?php

declare(strict_types=1);

namespace JustBetter\AkeneoImages\Contracts;

interface CleansupImages
{
    public function cleanup(int $days): void;
}
