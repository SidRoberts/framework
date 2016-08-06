<?php

namespace Controller;

use Sid\Framework\Controller;

use Symfony\Component\HttpFoundation\Response;

class ErrorController extends Controller
{
    public function notFound()
    {
        return new Response(
            "not found",
            RESPONSE::HTTP_NOT_FOUND
        );
    }
}
