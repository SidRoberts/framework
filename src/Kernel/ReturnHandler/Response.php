<?php

namespace Sid\Framework\Kernel\ReturnHandler;

use Sid\Container\Container;

use Sid\Framework\Dispatcher\Path;

use Sid\Framework\Kernel\ReturnHandlerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Response implements ReturnHandlerInterface
{
    /**
     * @var Container
     */
    protected $container;



    public function __construct(Container $container)
    {
        $this->container = $container;
    }



    public function handle(Request $request, Path $path, $returnedValue)
    {
        if ($returnedValue instanceof SymfonyResponse) {
            return $returnedValue;
        }



        $response = $this->container->get("response");

        if (!($response instanceof SymfonyResponse)) {
            $response = new SymfonyResponse();
        }



        $response->setContent(
            $returnedValue
        );

        return $response;
    }
}
