<?php


class Enter
{
    public function returnFalse()
    {
        return false;
    }

    public function returnTrue()
    {
        return true;
    }

    public function returnString()
    {
        return 'string!!';
    }
}


$enter = new Enter();

if ($in = $enter->returnString()) { // こう書くとながい関数を再度書く手間を省ける $inの少ない文字で済む
    echo $in.PHP_EOL;
} else {
    echo 'false!!!'.PHP_EOL;
}


