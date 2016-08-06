<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\Router\Annotations\Route;

class RequirementsController extends Controller
{
    /**
     * @Route(
     *     "/requirements/{id}",
     *     requirements={
     *         "id"="\d+"
     *     }
     * )
     */
    public function show($id)
    {
    }
}
