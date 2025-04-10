<?php

namespace Labi9\Elegan\Contracts;

interface EleganInterface
{
    public function struct(bool $auth, string $path, array $params, string $name): string;
}
