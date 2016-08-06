<?php

namespace Sid\Framework\View\Engine;

use Sid\Framework\View\EngineInterface;

use Twig_Environment;

class Twig implements EngineInterface
{
    /**
     * @var Twig_Environment
     */
    protected $twig;



    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }



    public function render(string $path, array $variables) : string
    {
        $viewPath = $path . ".twig";

        $content = $this->twig->render(
            $viewPath,
            $variables
        );

        return $content;
    }
}
