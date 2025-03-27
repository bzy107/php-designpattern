<?php

namespace iterator\Iterator;

interface Iterator
{
    public function hasNext(): bool;

    public function next();
}
