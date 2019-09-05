<?php

class Attachment {
	
	public static function have_uploads($key="attachments") {
		return isset($_FILES[$key]);
	}
	
	public static function save_all($key="attachments", $dir=WEBROOT . DS . "attachments") {
		if(!static::have_uploads($key)) {
			return false;
		}
		
		if(!file_exists($dir)) {
			if(!mkdir($dir, 0755, true)) {
				return false;
			}
		}
		
		$count = sizeof($_FILES[$key]["name"]);
		
		for($i = 0; $i < $count; $i++) {
			if(!move_uploaded_file($_FILES[$key]["tmp_name"][$i], $dir . DS . $_FILES[$key]["name"][$i])) {
				continue;
			}
		}
	}
	
	public static function get_attachments($dir) {
		if(!file_exists($dir)) {
			return false;
		}
		
		/*
			scandir($dir) retorna o nome dos arquivos do diretório $dir.
			array_diff com array('..', '.') para remover essas duas pastas do scandir($dir).
		*/
		$files = array_diff(scandir($dir), array('..', '.'));
		
		foreach($files as &$f) {
			$f = array(
				'name' => $f,
				'dir' => $dir . DS . $f,
				'url' => str_replace(WEBROOT, '', $dir) . DS . $f
			);
		}
		
		return $files;
	}
	
	public static function delete_attachment($dir) {
		unlink($dir);
	}
}