<?php

namespace Controller;

use Sid\Framework\Controller;
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
    public function show($id)
    {
    }
}
