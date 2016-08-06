<?php

namespace Sid\Framework\Test\Unit\View\Engine;

class PhpTest extends \Codeception\TestCase\Test
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
        $engine = new \Sid\Framework\View\Engine\Php(
            getcwd() . "/tests/_support/views/"
        );



        $actual = $engine->render(
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
