<?php

namespace Sid\Framework;

use Sid\Framework\Router\Route;

interface ConverterInterface
{
    public function convert(string $value);
}
