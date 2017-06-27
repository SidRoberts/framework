<?php

namespace Sid\Framework;

use Sid\Container\Container;

use Sid\Framework\Dispatcher\Path;

/**
 * Takes a Dispatcher\Path object, instantiates the controller and calls the
 * action method. It uses \Sid\Container\Container to typehint the controller
 * constructor and inject all sorts of lovely goodness.
 */
class Dispatcher
{
    /**
     * @var Container
     */
    protected $container;



    public function __construct(Container $container)
    {
        $this->container = $container;
    }



    public function dispatch(Path $path, array $params = [])
    {
        $controllerName = $path->getController();
        $action         = $path->getAction();



        $controller = $this->resolveController($controllerName);



        $returnedValue = call_user_func_array(
            [
                $controller,
                $action,
            ],
            $params
        );

        return $returnedValue;
    }

    protected function resolveController(string $controllerName)
    {
        $resolver = $this->container->getResolver();

        $controller = $resolver->typehintClass($controllerName);

        return $controller;
    }
}
