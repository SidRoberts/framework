<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\Parameters;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Requirements;

class MathController extends Controller
{
    /**
     * @Uri("/math/add/{a}/{b}")
     *
     * @Requirements(
     *     a="\d+",
     *     b="\d+"
     * )
     */
    public function addition(Parameters $parameters)
    {
        $a = $parameters->get("a");
        $b = $parameters->get("b");

        return $a + $b;
    }
}
