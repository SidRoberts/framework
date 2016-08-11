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



    public function render(string $path, array $variables) : string
    {
        return $this->engine->render(
            $path,
            $variables
        );
    }
}
