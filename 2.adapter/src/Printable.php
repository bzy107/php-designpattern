<?php

namespace Adapter;

interface Printable
{
    public function printWeak(): string;

    public function printStrong(): string;
}
