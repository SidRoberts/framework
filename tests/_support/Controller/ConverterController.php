<?php

namespace Tests\Controller;

use Sid\Framework\Controller;
use Sid\Framework\Parameters;
use Sid\Framework\Router\Route\Converters;
use Sid\Framework\Router\Route\Uri;

class ConverterController extends Controller
{
    /**
     * @Uri("/converter/double/{i}")
     *
     * @Converters(
     *     i="Tests\Converter\Doubler"
     * )
     */
    public function double(Parameters $parameters)
    {
        $i = $parameters->get("i");
    }
}
