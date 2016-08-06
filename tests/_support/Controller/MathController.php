<?php

namespace Controller;

use Sid\Framework\Controller;

use Sid\Framework\Router\Annotations\Route;

class MathController extends Controller
{
    /**
     * @Route(
     *     "/math/add/{a}/{b}",
     *     requirements={
     *         "a"="\d+",
     *         "b"="\d+"
     *     }
     * )
     */
    public function addition($a, $b)
    {
        return $a + $b;
    }
}
