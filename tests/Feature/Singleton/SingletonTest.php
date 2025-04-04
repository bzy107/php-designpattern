<?php

use Singleton\Singleton;

it('can be the same instance', function () {
    $first = Singleton::getInstance();
    $second = Singleton::getInstance();
    $third = new Singleton();

    expect([$first, $second, $third])
        ->toContainOnlyInstancesOf(Singleton::class);

    $this->assertSame($first, $second);
    $this->assertNotSame($second, $third);
});
