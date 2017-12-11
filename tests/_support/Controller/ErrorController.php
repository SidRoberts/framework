<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\Router\Route\Uri;

use Symfony\Component\HttpFoundation\Response;

class ErrorController extends Controller
{
    /**
     * @Uri("/error/404")
     */
    public function notFound()
    {
        return new Response(
            "not found",
            RESPONSE::HTTP_NOT_FOUND
        );
    }
}
