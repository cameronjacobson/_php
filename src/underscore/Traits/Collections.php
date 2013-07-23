<?php

namespace underscore\Traits;

trait Collections
{
	public function each(callable $iterator, $context = null){
		$this->bindTo($iterator, $context);
		if(is_array($this->data)){
			foreach($this->data as $k=>$v){
				$this->data[$k] = call_user_func_array($iterator, array( 'value'=>$v, 'key'=>$k, 'data'=>$this->data));
			}
		}
		return $this;
	}

	public function map(callable $iterator, $context = null){
		$this->bindTo($iterator, $context);
		if(is_array($this->data)){
			foreach($this->data as $k=>$v){
				$this->data[$k] = call_user_func_array($iterator, array( 'value'=>$v, 'key'=>$k));
			}
		}
		return $this;
	}

	public function reduce(callable $iterator, $memo, $context = null){
		$this->bindTo($iterator, $context);
		if(is_array($this->data)){
			foreach($this->data as $num){
				$memo = call_user_func_array($iterator, array( 'memo'=>$memo, 'num'=>$num));
			}
		}
		$this->data = $memo;
		return $this;
	}

	public function reduceRight(callable $iterator, $memo, $context = null){
		$this->bindTo($iterator, $context);
		if(is_array($this->data)){
			foreach(array_reverse($this->data) as $num){
				$memo = call_user_func_array($iterator, array( $memo, $num));
			}
		}
		$this->data = $memo;
		return $this;
	}

	public function find(callable $iterator, $context = null){
		$this->bindTo($iterator, $context);
		$return = null;
		if(is_array($this->data)){
			foreach($this->data as $value){
				if(call_user_func_array($iterator, array($value))){
					$return = $value;
					break;
				}
			}
		}
		$this->data = $return;
		return $this;
	}

	public function filter(callable $iterator, $context = null){
		$this->bindTo($iterator, $context);
		$return = array();
		if(is_array($this->data)){
			foreach($this->data as $key => $value){
				if(call_user_func_array($iterator, array($value))){
					$return[$key] = $value;
				}
			}
		}
		$this->data = $return;
		return $this;
	}

	public function where(array $properties){
		$return = array();
		foreach($this->data as $key=>$value){
			$matches = true;
			foreach($properties as $k=>$v){
				if(!($matches = $this->strictEquals($v, $value[$k]))){
					break;
				}
			}
			if($matches){
				$return[$key] = $value;
			}
		}
		$this->data = $return;
		return $this;
	}

	public function findWhere(array $properties){
		$return = array();
		foreach($this->data as $key=>$value){
			$matches = true;
			foreach($properties as $k=>$v){
				if(!($matches = $this->strictEquals($v, $value[$k]))){
					break;
				}
			}
			if($matches){
				$this->data = $value;
				return $this;
			}
		}
		$this->data = $return;
		return $this;
	}

	public function reject(callable $iterator, $context = null){
		$this->bindTo($iterator, $context);
		$return = array();
		if(is_array($this->data)){
			foreach($this->data as $key => $value){
				if(!call_user_func_array($iterator, array($value))){
					$return[] = $value;
				}
			}
		}
		$this->data = $return;
		return $this;
	}

	public function every(callable $iterator = null, $context = null){
		$this->bindTo($iterator, $context);
		$return = true;
		if(is_array($this->data)){
			foreach($this->data as $key => $value){
				if(!call_user_func_array($iterator, array($value))){
					$return = false;
					break;
				}
			}
		}
		$this->data = $return;
		return $this;
	}

	public function some(callable $iterator = null, $context = null){
		$this->bindTo($iterator, $context);
		$return = false;
		if(is_array($this->data)){
			foreach($this->data as $key => $value){
				if(call_user_func_array($iterator, array($value))){
					$return = true;
					break;
				}
			}
		}
		$this->data = $return;
		return $this;
	}

	public function contains($value){
		$this->data = in_array($value, $this->data);
		return $this;
	}

	public function invoke($methodName, $arguments = null){
		$return = array();
		if(is_array($this->data)){
			foreach($this->data as $key => $value){
				$args = array($value);
				if(!empty($arguments)){
					$args[] = $arguments;
				}
				$return[$key] = call_user_func_array($methodName, $args);
			}
		}
		$this->data = $return;
		return $this;
	}
}
