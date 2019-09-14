<?php

namespace Sid\Framework\Router\Route;

/**
 * @Annotation
 */
class Requirements
{
    /**
     * @var array
     */
    protected $requirements = [];



    public function __construct(array $requirements)
    {
        $this->requirements = $requirements;
    }



    public function toArray() : array
    {
        return $this->requirements;
    }
}
