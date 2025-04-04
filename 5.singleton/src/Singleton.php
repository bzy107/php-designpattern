<?php

namespace Singleton;

class Singleton
{
    private static ?Singleton $instance = null;

    public static function getInstance(): Singleton
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }
}
