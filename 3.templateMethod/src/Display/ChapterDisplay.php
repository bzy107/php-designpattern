<?php

namespace TemplateMethod\Display;

class ChapterDisplay extends AbstractDisplay
{
    public function __construct(private string $string)
    {
    }

    public function opens(): string
    {
        return '++++++';
    }

    public function prints(): string
    {
        return $this->string;
    }

    public function closes(): string
    {
        return '------';
    }
}
