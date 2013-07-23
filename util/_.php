<?php

require_once(dirname(__DIR__).'/src/underscore/_.php');

use underscore\_;

function _($data){
    return new _($data);
}

