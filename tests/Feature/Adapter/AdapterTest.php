<?php

use Adapter\PrintBanner;

it('can be adapted', function () {
    $print = new PrintBanner('PrintBanner');
    expect('(PrintBanner)')
        ->toBeString()
        ->toBe($print->printWeak());

    expect('*PrintBanner*')
        ->toBeString()
        ->toBe($print->printStrong());
});
