<?php

namespace Sid\Framework\Test\Unit\View\Engine;

use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        parent::_before();
    }

    protected function _after()
    {
    }



    public function testRender()
    {
        $loader = new Twig_Loader_Filesystem(
            getcwd() . "/tests/_support/views/"
        );

        $twig = new Twig_Environment(
            $loader
        );





        $engine = new \Sid\Framework\View\Engine\Twig($twig);



        $actual = $engine->render(
            "test",
            [
                "abc" => 321,
                "def" => 654,
            ]
        );



        $this->assertEquals(
            "321 654",
            $actual
        );
    }
}
