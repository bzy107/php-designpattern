<?php

use FactoryMethod\Factory\IDCardFactory;

it('can use the factory method', function() {
    $factory = new IDCardFactory();
    $card = $factory->create('bob');
    expect('use card for bob')
        ->toBeString()
        ->toBe($card->use());
});
