<?php
App::import('NivelAcesso', 'Model');
App::import('Unidade', 'Model');
App::import('UnidadeNegocio', 'Model');
App::import('Regiao', 'Model');
App::import('Distrito', 'Model');
App::import('Setor', 'Model');

class Hierarquia {
	
	public static function cna_to_hie(int $cna) {
		$h = array(
			NivelAcesso::UNIDADE => 'Unidade',
			NivelAcesso::UNIDADE_DE_NEGOCIO => 'UnidadeNegocio',
			NivelAcesso::REGIAO => 'Regiao',
			NivelAcesso::DISTRITO => 'Distrito',
			NivelAcesso::SETOR => 'Setor',
		);
		
		return _isset($h[$cna], null);
	}
}