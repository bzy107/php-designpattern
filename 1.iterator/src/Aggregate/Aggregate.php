<?php

namespace Iterator\Aggregate;

use Iterator\Iterator\Iterator;

interface Aggregate
{
    public function iterator(): Iterator;
}
