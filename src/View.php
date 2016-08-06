<?php

namespace Sid\Framework;

use Sid\Framework\View\EngineInterface;

class View
{
    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @var array
     */
    protected $variables = [];



    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }



    public function getEngine() : EngineInterface
    {
        return $this->engine;
    }



    public function getVariable(string $name)
    {
        return $this->variables[$name];
    }

    public function setVariable(string $name, $value)
    {
        $this->variables[$name] = $value;
    }



    public function getVariables() : array
    {
        return $this->variables;
    }



    public function render(string $path) : string
    {
        return $this->engine->render(
            $path,
            $this->variables
        );
    }
}
