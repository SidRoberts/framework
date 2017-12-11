<?php

namespace Sid\Framework;

interface ResolverInterface
{
    public function typehintClass(string $className, array $custom = []);

    public function typehintMethod($class, string $method, array $custom = []);
}
