<?php

namespace TemplateMethod\Display;

abstract class AbstractDisplay
{
    abstract public function opens(): string;

    abstract public function prints(): string;

    abstract public function closes(): string;

    final public function display(): string
    {
        $display = $this->opens();
        for ($i = 0; $i < 5; $i++) {
            $display .= $this->prints();
        }
        $display .= $this->closes();
        return $display;
    }
}
