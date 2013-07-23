<?php

namespace underscore;

use ReflectionClass;
use ReflectionProperty;

class _
{
    private $data;

    public function __construct($data){
        $this->setConstructorData($data);
    }

    public function each(callable $iterator, $context = null){
		$this->bindTo($iterator, $context);
		if(is_array($this->data)){
			foreach($this->data as $k=>$v){
				$this->data[$k] = call_user_func_array($iterator, array(
					'value'=>$v,
					'key'=>$k,
					'data'=>$this->data
				));
			}
		}
		return $this;
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
/*


*/
