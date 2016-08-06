<?php

namespace Sid\Framework\View\Engine;

use Sid\Framework\View\EngineInterface;

class None implements EngineInterface
{
    public function render(string $path, array $variables) : string
    {
        return "";
    }
}
