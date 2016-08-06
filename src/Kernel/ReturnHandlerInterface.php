<?php

namespace Sid\Framework\Kernel;

use Sid\Framework\Dispatcher\Path;

use Symfony\Component\HttpFoundation\Request;

interface ReturnHandlerInterface
{
    public function handle(Request $request, Path $path, $returnedValue);
}
