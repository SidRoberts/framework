<?php

namespace Sid\Framework\Dispatcher;

use Sid\Framework\Dispatcher\Exception\ActionNotFoundException;
use Sid\Framework\Dispatcher\Exception\ControllerNotFoundException;

class Path
{
    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;



    public function __construct(string $controller, string $action)
    {
        // If the controller can't be loaded, we throw an exception.
        if (!class_exists($controller)) {
            throw new ControllerNotFoundException(
                sprintf(
                    "%s controller class does not exist.",
                    $controller
                )
            );
        }

        // Check if the method exists in the controller
        if (!method_exists($controller, $action)) {
            throw new ActionNotFoundException(
                sprintf(
                    "'%s::%s()' was not found.",
                    $controller,
                    $action
                )
            );
        }



        $this->controller = $controller;
        $this->action     = $action;
    }



    public function getController() : string
    {
        return $this->controller;
    }

    public function getAction() : string
    {
        return $this->action;
    }
}
