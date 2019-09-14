<?php

namespace Sid\Framework;

use Sid\ContainerResolver\ResolverInterface;
use Sid\Framework\Dispatcher\Path;

/**
 * Takes a Dispatcher\Path object, instantiates the controller and calls the
 * action method. It uses a Resolver to typehint the controller constructor and
 * inject all sorts of lovely goodness.
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var ResolverInterface
     */
    protected $resolver;



    public function __construct(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }



    public function dispatch(Path $path, Parameters $parameters)
    {
        $controllerName = $path->getController();
        $action         = $path->getAction();



        $controller = new $controllerName;

        $returnedValue = $this->resolver->typehintMethod(
            $controller,
            $action,
            [
                "parameters" => $parameters,
            ]
        );

        return $returnedValue;
    }
}
