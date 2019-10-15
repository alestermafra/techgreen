<?php
App::import("Interesse", "Model");
App::import("Connection", "Model");

class InteresseRepository {
	public function find() {
		$connection = new Connection();
		$db_interesses = $connection->query("SELECT `ctinteresse`, `ntinteresse` FROM `tinteresse` WHERE `RA` = 1");
		$interesses = array();
		foreach($db_interesses as $interesse) {
			$id = $interesse["ctinteresse"];
			$ex = explode(" - ", $interesse["ntinteresse"], 2);
			if(!isset($ex[1])) {
				$categoria = "Unknown";
				$nome = $ex[0];
			}
			else {
				$categoria = $ex[0];
				$nome = $ex[1];
			}
			array_push($interesses, new Interesse($id, $categoria, $nome)); 
		}
		
		return $interesses;
	}
	
	public function findByCps(int $cps) {
		
	}
}