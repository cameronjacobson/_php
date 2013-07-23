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


// _.reduce
var_dump(_([1,2,3])->reduce(function($memo, $num){
	return $memo+$num;
},0)->data);

// _.reduceRight
var_dump(_([[1,2],[3,4],[5,6]])->reduceRight(function($a, $b){
	return array_merge($a,$b);
},array())->data);



// _.find
var_dump(_([1,2,3,4,5])->find(function($value){
	return !($value%4);
})->data);

// _.filter
var_dump(_([1,2,3,4,5])->filter(function($value){
	return $value <= 3;
})->data);

// _.where
$listOfPlays = [
	["title"=>"Cymbeline", "author"=>"Shakespeare", "year"=>1611],
	["title"=>"The Tempest", "author"=>"Shakespeare", "year"=>1611],
	["title"=>"Julius Caesar", "author"=>"Shakespeare", "year"=>1599]
];
var_dump(_($listOfPlays)->where(["author"=>"Shakespeare", "year"=>1611])->data);

// _.findWhere
$listOfPlays = [
	["title"=>"Cymbeline", "author"=>"Shakespeare", "year"=>1611],
	["title"=>"The Tempest", "author"=>"Shakespeare", "year"=>1611],
	["title"=>"Julius Caesar", "author"=>"Shakespeare", "year"=>1599]
];
var_dump(_($listOfPlays)->findWhere(["author"=>"Shakespeare", "year"=>1611])->data);

var_dump(_([1,2,3,4,5,6])->reject(function($num){return $num %2 == 0;})->data);

var_dump(_([1,2,3,4,5,6])->every(function($num){return $num > 0;})->data);
var_dump(_([1,2,3,4,5,6])->every(function($num){return $num < 0;})->data);

var_dump(_([1,2,3,4,5,6])->some(function($num){return $num > 5;})->data);
var_dump(_([1,2,3,4,5,6])->some(function($num){return $num > 6;})->data);

var_dump(_([1,2,3,4,5,6])->contains(3)->data);
var_dump(_([1,2,3,4,5,6])->contains(9)->data);

echo 'MYRSORT'.PHP_EOL;

var_dump(_([[1,2,3],[4,5,6]])->invoke('myrsort')->data);




// HELPER CLASSES / FUNCTIONS

function myrsort($data){
	rsort($data);
	return $data;
}

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

