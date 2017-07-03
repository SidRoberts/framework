<?php

namespace Sid\Framework;

interface ResolverInterface
{
    public function typehintClass(string $className);

    public function typehintMethod($class, string $method);
}
