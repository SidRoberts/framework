<?php

namespace Sid\Framework\Dispatcher;

use Sid\Framework\Dispatcher\Exception\ControllerNotFoundException;
use Sid\Framework\Dispatcher\Exception\ActionNotFoundException;

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
                $controller . " controller class does not exist."
            );
        }

        // Check if the method exists in the controller
        if (!method_exists($controller, $action)) {
            throw new ActionNotFoundException(
                "'" . $controller . "::" . $action . "()' was not found."
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
