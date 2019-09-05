<?php

class Inflector {
	private static $_cache = array();
	
	private static function _cache($type, $key, $value = false) {
		$type = '_' . $type;
		$key = '_' . $key;
		if($value !== false) {
			static::$_cache[$type][$key] = $value;
			return $value;
		}
		if(!isset(static::$_cache[$type][$key])) {
			return false;
		}
		return static::$_cache[$type][$key];
	}
	
	/* transforma uma string em camel case. ex: unidade_negocio retorna UnidadeNegocio */
	public static function camelize($lowerCaseWord, $separator = '_') {
		if(!($result = static::_cache('camelize', $lowerCaseWord))) {
			$result = explode($separator, $lowerCaseWord);
			foreach($result as &$word) {
				$word = mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
			}
			$result = implode('', $result);
			static::_cache('camelize', $lowerCaseWord, $result);
		}
		return $result;
	}
}