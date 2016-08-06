<?php

namespace Sid\Framework\Kernel\ReturnHandler;

use Sid\Framework\View;

use Sid\Framework\Dispatcher\Path;

use Sid\Framework\Kernel\ReturnHandlerInterface;

use Symfony\Component\HttpFoundation\Request;

class ImplicitView implements ReturnHandlerInterface
{
    /**
     * @var View
     */
    protected $view;



    public function __construct(View $view)
    {
        $this->view = $view;
    }



    public function handle(Request $request, Path $path, $returnedValue)
    {
        if ($returnedValue !== null) {
            return $returnedValue;
        }



        $controller = $path->getController();
        $action     = $path->getAction();



        $path = str_replace("\\", "/", ltrim($controller, "\\")) . "/" . $action;



        return $this->view->render($path);
    }
}
