<?php

namespace Adapter\Adapter;

use Adapter\Adapter\Legacy\Banner;

class PrintBanner extends Banner implements Printable
{
    public function printWeak(): string
    {
        return parent::showWithParentheses();
    }

    public function printStrong(): string
    {
        return parent::showWithAsterisk();
    }
}
