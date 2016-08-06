<?php

namespace Controller;

use Sid\Framework\Controller;
use Sid\Framework\View;

use Sid\Framework\Router\Annotations\Route;

class ImplicitViewController extends Controller
{
    /**
     * @var View
     */
    protected $view;



    public function __construct(View $view)
    {
        $this->view = $view;
    }



    public function implicit()
    {
        // Nothing is returned as a view should be rendered implicitly.
    }

    public function returnsString()
    {
        return "this is a string";
    }

    public function alreadyRendersView()
    {
        $this->view->setVariable("abc", "ABC");
        $this->view->setVariable("def", "DEF");

        return $this->view->render("test");
    }
}
