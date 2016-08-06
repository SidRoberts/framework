<?php

namespace Sid\Framework\View;

interface EngineInterface
{
    public function render(string $path, array $variables) : string;
}
