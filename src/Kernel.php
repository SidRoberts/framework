<?php

namespace Sid\Framework;

use Sid\Framework\Kernel\ReturnHandlerInterface;

use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Router\Match;
use Sid\Framework\Router\Exception\RouteNotFoundException;

use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var Path|null
     */
    protected $notFoundPath = null;

    /**
     * @var array
     */
    protected $returnHandlers = [];



    public function __construct(Router $router, Dispatcher $dispatcher)
    {
        $this->router     = $router;
        $this->dispatcher = $dispatcher;
    }



    public function getNotFoundPath()
    {
        return $this->notFoundPath;
    }

    public function setNotFoundPath(Path $notFoundPath)
    {
        $this->notFoundPath = $notFoundPath;
    }



    public function addReturnHandler(ReturnHandlerInterface $returnHandler)
    {
        $this->returnHandlers[] = $returnHandler;
    }



    public function handle(Request $request)
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



        foreach ($this->returnHandlers as $returnHandler) {
            $returnedValue = $returnHandler->handle(
                $request,
                $match->getPath(),
                $returnedValue
            );
        }



        return $returnedValue;
    }
}
