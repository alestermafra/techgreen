<?php
include APP . DS . 'lib' . DS . 'utils.php';
include APP . DS . 'lib' . DS . 'view_utils.php';

function can($action) {
	$user = Auth::user();
	switch($action) {
		case 'add-guarderia':
			if($user['cps'] == 5) { // camila nao pode add guarderia
				return false;
			}
			break;

		case 'edit-guarderia':
			if($user['cps'] == 5) {
				return false;
			}
			break;
	}

	return true;
}
/* grava o log na ticket */
//App::import('Tickets', 'Model');
//Tickets::insert();


