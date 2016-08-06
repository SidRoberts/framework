<?php

namespace Converter;

use Sid\Framework\ConverterInterface;

class Doubler implements ConverterInterface
{
    public function convert(string $value) : int
    {
        return ($value * 2);
    }
}
