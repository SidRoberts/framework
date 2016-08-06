<?php

namespace Sid\Framework;

class Url
{
    /**
     * @var string
     */
    protected $baseUri;



    public function __construct(string $baseUri = "")
    {
        $this->baseUri = $baseUri;
    }



    public function getBaseUri() : string
    {
        return $this->baseUri;
    }



    public function get(string $uri = "") : string
    {
        $uri = rtrim($this->baseUri, "/") . "/" . ltrim($uri, "/");

        return $uri;
    }
}
