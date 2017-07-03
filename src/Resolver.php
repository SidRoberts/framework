<?php

namespace Sid\Framework;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ReflectionClass;
use ReflectionMethod;

class Resolver implements ResolverInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;



    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }



    public function typehintClass(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->hasMethod("__construct")) {
            return $reflectionClass->newInstance();
        }

        $reflectionMethod = $reflectionClass->getMethod("__construct");

        $params = $this->resolveParams($reflectionMethod);

        return $reflectionClass->newInstanceArgs($params);
    }



    public function typehintMethod($class, string $method)
    {
        $className = get_class($class);

        $reflectionMethod = new ReflectionMethod($className, $method);

        $params = $this->resolveParams($reflectionMethod);

        return call_user_func_array(
            [
                $class,
                $method
            ],
            $params
        );
    }



    protected function resolveParams(ReflectionMethod $reflectionMethod) : array
    {
        $reflectionParameters = $reflectionMethod->getParameters();

        $params = [];

        foreach ($reflectionParameters as $reflectionParameter) {
            $serviceName = $reflectionParameter->getName();

            $paramService = $this->container->get($serviceName);

            $params[] = $paramService;
        }

        return $params;
    }
}
