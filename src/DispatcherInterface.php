<?php

namespace Sid\Framework;

use Sid\Framework\Dispatcher\Path;

/**
 * Takes a Dispatcher\Path object, instantiates the controller and calls the
 * action method.
 */
interface DispatcherInterface
{
    public function dispatch(Path $path, Parameters $parameters);
}
