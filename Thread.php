<?php
class Thread {
	private $name;
	private $id;
	private $resArray;
	
	public function __construct($name, $id, $resArray) {
		$this -> name = $name;
		$this -> id = $id;
		$this -> resArray = $resArray;
	}

	public function name() {
		return $this -> name;
	}

	public function id() {
		return $this -> id;
	}

	public function resArray() {
		return $this -> resArray;
	}

}
