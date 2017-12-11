<?php

namespace Sid\Framework\Router;

use Sid\Framework\Dispatcher\Path;
use Sid\Framework\Parameters;

class Match
{
    /**
     * @var Path
     */
    protected $path;

    /**
     * @var array
     */
    protected $params;



    public function __construct(Path $path, array $params)
    {
        $this->path   = $path;
        $this->params = $params;
    }



    public function getPath() : Path
    {
        return $this->path;
    }

    public function getParams() : Parameters
    {
        return new Parameters($this->params);
    }
}
