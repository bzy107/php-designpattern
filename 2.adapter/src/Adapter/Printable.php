<?php

namespace Adapter\Adapter;

interface Printable
{
    public function printWeak(): string;

    public function printStrong(): string;
}
