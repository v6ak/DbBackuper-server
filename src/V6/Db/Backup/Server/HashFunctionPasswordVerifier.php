<?php

final class V6_Db_Backup_Server_HashFunctionPasswordVerifier{
	
	private $hashFunction;
	
	private $hashValue;
	
	private function __construct($hashFunction, $hashValue){
		if(!is_callable($hashFunction)){
			throw new InvalidArgumentException('$hashFunction has to be valid callback')
		}
		$this->hashFunction = $hashFunction;
		$this->hashValue = $hashValue;
	}
	
	public function verify($pwd){
		return call_user_func($this->hashFunction, $pdw) == $this->hashValue;
	}
	
	public static function create($hashFunction, $hashValue){
		return new array(new self($hashFunction, $hashValue), 'verify');
	}
	
}