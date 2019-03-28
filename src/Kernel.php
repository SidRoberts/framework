<?php

namespace Sid\Framework;

use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Router\Match;
use Sid\Framework\Router\Exception\RouteNotFoundException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel implements KernelInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var DispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var Path|null
     */
    protected $notFoundPath = null;



    public function __construct(RouterInterface $router, DispatcherInterface $dispatcher)
    {
        $this->router     = $router;
        $this->dispatcher = $dispatcher;
    }



    public function getNotFoundPath() : ?Path
    {
        return $this->notFoundPath;
    }

    public function setNotFoundPath(Path $notFoundPath)
    {
        $this->notFoundPath = $notFoundPath;
    }



    public function handle(Request $request) : Response
    {
        try {
            $match = $this->router->handle(
                $request->getRequestUri(),
                $request->getMethod()
            );
        } catch (RouteNotFoundException $e) {
            if ($this->notFoundPath === null) {
                throw $e;
            }

            $match = new Match(
                $this->notFoundPath,
                []
            );
        }



        $returnedValue = $this->dispatcher->dispatch(
            $match->getPath(),
            $match->getParams()
        );



        if ($returnedValue instanceof Response) {
            return $returnedValue;
        }



        $response = new Response();

        $response->setContent(
            $returnedValue
        );

        return $response;
    }
}
