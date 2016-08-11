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

    public function testRender()
    {
        $engine = new \Sid\Framework\View\Engine\Php(
            getcwd() . "/tests/_support/views/"
        );

        $view = new View($engine);



        $actual = $view->render(
            "test",
            [
                "abc" => 123,
                "def" => 456,
            ]
        );

        $this->assertEquals(
            "123 456",
            $actual
        );
    }
}
