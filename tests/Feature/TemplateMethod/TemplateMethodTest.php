<?php

use TemplateMethod\Display\ChapterDisplay;
use TemplateMethod\Display\StringDisplay;

it('can be templateMethod', function () {
    $char = new ChapterDisplay('abc');
    $character = '++++++abcabcabcabcabc------';

    expect($character)
        ->toBeString()
        ->toBe($char->display());

    $str = new StringDisplay('def');
    $string = '<<<<defdefdefdefdef>>>>';

    expect($string)
        ->toBeString()
        ->toBe($str->display());
});
