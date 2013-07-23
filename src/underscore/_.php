<?php

namespace underscore;

use ReflectionClass;
use ReflectionProperty;

class _
{
	use Traits\Collections;

	private $data;

	public function __construct($data){
		$this->setConstructorData($data);
	}

	private function strictEquals($val1, $val2){
		switch(strtolower(gettype($val1))){
			case 'boolean':
				return $val1 === (bool)$val2;
				break;
			case 'integer':
				return $val1 === (int)$val2;
				break;
			case 'double':
				return $val1 === (double)$val2;
				break;
			case 'string':
				return $val1 === (string)$val2;
				break;
			case 'array':
				return $val1 === (array)$val2;
				break;
			case 'object':
				return $val1 === (object)$val2;
				break;
			default:
				return false;
				break;
		}
	}

	private function bindTo(callable &$iterator, $context = null){
		$iterator = empty($context) ? $iterator : $iterator->bindTo($context, get_class($context));
	}

	private function setConstructorData($data){
		$this->data = array();
		if(is_object($data)){
			$reflect = new ReflectionClass($data);
			$props = $reflect->getProperties(
				ReflectionProperty::IS_PUBLIC 
				| ReflectionProperty::IS_PROTECTED 
				| ReflectionProperty::IS_PRIVATE
			);
			foreach($props as $prop){
				if($prop->isPrivate() || $prop->isProtected()){
					$prop->setAccessible(true);
				}
				$this->data[$prop->getName()] = $prop->getValue($reflect->newInstanceWithoutConstructor());
			}
		}
		else{
			foreach($data as $k=>$v){
				$this->data[$k] = $v;
			}
		}
	}

	public function __get($name){
		switch($name){
			default:
				return $this->data;
				break;
		}
	}
}
