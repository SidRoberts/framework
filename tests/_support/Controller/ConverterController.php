<?php

namespace Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Annotations\Route;

class ConverterController extends Controller
{
    /**
     * @Route(
     *     "/converter/double/{i}",
     *     converters={
     *         "i"="Converter\Doubler"
     *     }
     * )
     */
    public function double(int $i)
    {
    }
}
