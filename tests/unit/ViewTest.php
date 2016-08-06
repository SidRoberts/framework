<?php

namespace Sid\Framework\Test\Unit;

use Sid\Framework\View;

class ViewTest extends \Codeception\TestCase\Test
{
    public function testGetEngine()
    {
        $engine = new \Sid\Framework\View\Engine\Php(
            getcwd() . "/tests/_support/views/"
        );



        $view = new View($engine);

        $this->assertEquals(
            $engine,
            $view->getEngine()
        );
    }

    public function testGetAndSetVariable()
    {
        $engine = new \Sid\Framework\View\Engine\Php(
            getcwd() . "/tests/_support/views/"
        );

        $view = new View($engine);



        $view->setVariable("abc", "def");
        $view->setVariable("ghi", "jkl");



        $this->assertEquals(
            "def",
            $view->getVariable("abc")
        );

        $this->assertEquals(
            "jkl",
            $view->getVariable("ghi")
        );
    }

    public function testGetVariables()
    {
        $engine = new \Sid\Framework\View\Engine\Php(
            getcwd() . "/tests/_support/views/"
        );

        $view = new View($engine);



        $this->assertEquals(
            [],
            $view->getVariables()
        );



        $view->setVariable("abc", "def");



        $this->assertEquals(
            [
                "abc" => "def",
            ],
            $view->getVariables()
        );



        $view->setVariable("ghi", "jkl");



        $this->assertEquals(
            [
                "abc" => "def",
                "ghi" => "jkl",
            ],
            $view->getVariables()
        );
    }

    public function testRender()
    {
        $engine = new \Sid\Framework\View\Engine\Php(
            getcwd() . "/tests/_support/views/"
        );

        $view = new View($engine);



        $view->setVariable("abc", 123);
        $view->setVariable("def", 456);



        $actual = $view->render(
            "test"
        );

        $this->assertEquals(
            "123 456",
            $actual
        );
    }
}
