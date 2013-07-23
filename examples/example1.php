<?php

require_once(dirname(__DIR__).'/vendor/autoload.php');
require_once(dirname(__DIR__).'/util/_.php');



// _.each
var_dump(_(new abc())->each(function($value, $key, $data){
    return $value + $this->a;
}, new blah())->data);

var_dump(_([3,4,5,6])->each(function($value, $key, $data){
    return $value + $this->a;
}, new blah())->data);





// HELPER CLASSES

class blah
{
    private $a = 2;
    public function __construct(){}
}

class abc
{
    public $a = 1;
    private static $b = 2;
    protected $c = 3;
    private $d = 4;
    public function __constructor(){}
}

