<?php

namespace Sid\Framework;

use Sid\Framework\Dispatcher\Path;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface KernelInterface
{
    public function getNotFoundPath() : ?Path;

    public function setNotFoundPath(Path $notFoundPath);



    public function handle(Request $request) : Response;
}
