<?php

namespace Sid\Framework;

use Sid\Framework\Dispatcher\Path;

use Symfony\Component\HttpFoundation\Request;

interface KernelInterface
{
    public function getNotFoundPath();

    public function setNotFoundPath(Path $notFoundPath);



    public function handle(Request $request);
}
