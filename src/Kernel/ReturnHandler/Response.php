<?php

namespace Sid\Framework\Kernel\ReturnHandler;

use Sid\Framework\Dispatcher\Path;

use Sid\Framework\Kernel\ReturnHandlerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Response implements ReturnHandlerInterface
{
    public function handle(Request $request, Path $path, $returnedValue)
    {
        if ($returnedValue instanceof SymfonyResponse) {
            return $returnedValue;
        }



        $response = new SymfonyResponse();

        $response->setContent(
            $returnedValue
        );

        return $response;
    }
}
