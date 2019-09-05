<?php
App::import('Connection', 'Model');
App::import('Auth', 'Model');

class Menu {
	
	public static function getMenu($cna) {
		$connection = new Connection();
		$menu = $connection->prepared(
			'SELECT 
				s.cmenu, s.nmenu 
			FROM smenu s 
				INNER JOIN zsmenu z ON z.cmenu = s.cmenu AND z.cna = ? 
			WHERE s.RA = 1 and z.RA = 1 
			ORDER BY ordmenu;',
			'i',
			$cna
		);
		
		foreach($menu as &$mn){
			$sub = Menu::getSubMenu($mn['cmenu']);
			$mn['sub'] = $sub;
		}
		
		return $menu;
	}
	
	
	public static function getSubMenu($cmenu){
		$user = Auth::user();
		$cna = $user['cna'];
		
		$connection = new Connection();
		$submenu = $connection->prepared(
			'SELECT 
				s.nsmenu, s.lnkmenu, s.obs
			 FROM ssmenu s
			 	INNER JOIN zssmenu z ON z.cssmenu = s.cssmenu
			 WHERE s.RA = 1
			 	AND z.cna = '.$cna.'
			 	AND z.RA = 1 
			 	AND s.cmenu = ?
			 ORDER BY s.ordsmenu;',
			 'i',
			 $cmenu
		);
		return $submenu;
		
	}
	
}