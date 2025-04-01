<?php

namespace Adapter\Adapter\Legacy;

class Banner
{
    public function __construct(public string $string)
    {
    }

    public function showWithParentheses(): string
    {
        return '(' . $this->string . ')' ;
    }

    public function showWithAsterisk(): string
    {
        return '*' . $this->string . '*';
    }
}
