<?php
include APP . DS . 'lib' . DS . 'utils.php';
include APP . DS . 'lib' . DS . 'view_utils.php';

function can($action) {
	$user = Auth::user();
	$permissoes = Usuario::getPermissoes($user['cusu']);

	return $user['admin'] || in_array($action, $permissoes);
}
/* grava o log na ticket */
//App::import('Tickets', 'Model');
//Tickets::insert();
