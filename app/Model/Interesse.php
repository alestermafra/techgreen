<?php

class Interesse extends Table {
	public $ctinteresse; /* int */
	public $ntinteresse; /* string */
	
	public $categoria; /* string */
	
	public function set_ctinteresse(int $ctinteresse) {
		$this->ctinteresse = $ctinteresse;
		return $this;
	}
	
	public function get_ctinteresse() {
		return $this->ctinteresse;
	}
	
	public function set_ntinteresse(string $ntinteresse) {
		$this->ntinteresse = $ntinteresse;
		return $this;
	}
	
	public function get_ntinteresse() {
		return $this->ntinteresse;
	}
	
	public function set_categoria(string $categoria) {
		$this->categoria = $categoria;
		return $this;
	}
	
	public function get_categoria() {
		return $this->categoria;
	}
	
	public function save() {
		
	}
}