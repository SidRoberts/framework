<?php

namespace Sid\Framework\Test\Unit\View\Engine;

class NoneTest extends \Codeception\TestCase\Test
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
        $engine = new \Sid\Framework\View\Engine\None();



        $actual = $engine->render(
            "path/to/view",
            [
                "variable1" => 123,
                "variable2" => 456,
            ]
        );



        $this->assertEquals(
            "",
            $actual
        );
    }
}
