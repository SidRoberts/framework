<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Converters;

class ConverterController extends Controller
{
    /**
     * @Uri("/converter/double/{i}")
     *
     * @Converters(
     *     i="Converter\Doubler"
     * )
     */
    public function double(int $i)
    {
    }
}
