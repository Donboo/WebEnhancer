<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AuxClass {
	private $name;
	private $value;
	
	public function __construct($name, $value){
		$this->name = $name;
		$this->value = $value;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getValue(){
		return $this->value;
	}
	
}