<?php

namespace Sid\Framework\Kernel\ReturnHandler;

use Sid\Framework\Dispatcher\Path;

use Sid\Framework\Kernel\ReturnHandlerInterface;

use Symfony\Component\HttpFoundation\Request;

class ExitCode implements ReturnHandlerInterface
{
    public function handle(Request $request, Path $path, $returnedValue)
    {
        if (!is_numeric($returnedValue)) {
            return 0;
        }

        return (int) $returnedValue;
    }
}
