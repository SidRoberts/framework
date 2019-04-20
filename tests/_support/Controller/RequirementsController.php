<?php

namespace Tests\Controller;

use InvalidArgumentException;
use Sid\Framework\Controller;
use Sid\Framework\Parameters;
use Sid\Framework\Router\Route\Uri;
use Sid\Framework\Router\Route\Requirements;

class RequirementsController extends Controller
{
    /**
     * @Uri("/requirements/{id}")
     *
     * @Requirements(
     *     id="\d+"
     * )
     */
    public function show(Parameters $parameters)
    {
        $i = $parameters->get("i");

        if (!preg_match("/^\d+$/", $i) === false) {
            throw new InvalidArgumentException();
        }
    }
}
