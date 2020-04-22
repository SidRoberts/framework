<?php

namespace Tests;

use Sid\Framework\Parameters;

class ParametersCest
{
    public function get(UnitTester $I)
    {
        $parameters = new Parameters(
            [
                "name" => "Sid",
                "city" => "Busan",
            ]
        );

        $I->assertEquals(
            "Sid",
            $parameters->get("name")
        );

        $I->assertEquals(
            "Busan",
            $parameters->get("city")
        );
    }

    public function getUndefined(UnitTester $I)
    {
        $parameters = new Parameters(
            [
                "name" => "Sid",
                "city" => "Busan",
            ]
        );

        $I->expectThrowable(
            new \Exception("Parameter not found (country)"),
            function () use ($parameters) {
                $country = $parameters->get("country");
            }
        );
    }
}
