<?php

namespace Sid\Framework;

class Parameters
{
    /**
     * @var array
     */
    protected $parameters;



    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }




    public function get(string $name)
    {
        if (!isset($this->parameters[$name])) {
            throw new \Exception(
                sprintf(
                    "Parameter not found (%s)",
                    $name
                )
            );
        }

        return $this->parameters[$name];
    }
}
