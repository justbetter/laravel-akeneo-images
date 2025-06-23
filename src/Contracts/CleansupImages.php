<?php

namespace JustBetter\AkeneoImages\Contracts;

interface CleansupImages
{
    public function cleanup(int $days): void;
}
