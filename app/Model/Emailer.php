<?php
App::import('Table', 'Model');

class Emailer extends Table{
	public static $_table = 'emailer';
	
	public static $_qry = '
		SELECT
			{{fields}}
		FROM emailer
		WHERE emailer.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'emailer.cmailer',
		'emailer.para',
		'emailer.ccopia',
		'emailer.assunto',
		'emailer.corpo',
		'emailer.enviado',
		'emailer.enviado_d',
		'emailer.RA',
		'emailer.AR',
		'emailer.RD',
		'emailer.TS',
	);
	
	public static function nextMail() {
		return static::_find('first', array('conditions' => ' AND enviado = 0', 'order' => 'emailer.cmailer ASC'));
	}
	
	public static function enviado($cmailer, $v) {
		static::update(
			array(
				'enviado' => $v,
				'enviado_d' => 'now()'
			),
			"emailer.cmailer = $cmailer"
		);
	}
}