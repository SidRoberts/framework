<?php

namespace Sid\Framework\Router;

use Sid\Framework\Dispatcher\Path;

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

    public function getParams() : array
    {
        return $this->params;
    }
}
