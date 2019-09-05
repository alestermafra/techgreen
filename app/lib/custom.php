<?php
include APP . DS . 'lib' . DS . 'utils.php';
include APP . DS . 'lib' . DS . 'view_utils.php';

// App::import('Unidade', 'Model');
// App::import('UnidadeNegocio', 'Model');
// App::import('Regiao', 'Model');
// App::import('Distrito', 'Model');
// App::import('Setor', 'Model');
// App::import('Pessoa', 'Model');
// App::import('Usuario', 'Model');

// $cps = 100;
// $cun = 1;
// $cung = 1;
// $crei = 1;
// $cdio = 1;
// $cset = 1;
// for($un = 1; $un <= 3; $un++, $cun++) {
	// Unidade::insert(
		// array(
			// 'cen' => 1,
			// 'clang' => 2,
			// 'sun' => "u{$un}",
			// 'nun' => "u{$un}",
			// 'OBS' => "u{$un}",
			// 'RA' => 1,
			// 'AR' => 1
		// )
	// );
	// Pessoa::insert(
		// array(
			// 'cun' => $cun,
			// 'sps' => "u{$un}",
			// 'nps' => "u{$un}",
			// 'OBS' => "u{$un}",
			// 'flg_sys' => 1,
			// 'RA' => 1,
			// 'AR' => 1
		// )
	// );
	// Usuario::insert(
		// array(
			// 'cps' => $cps,
			// 'cna' => 3,
			// 'cnger' => 3,
			// 'cen' => 1,
			// 'cun' => $cun,
			// 'cod' => $cun,
			// 'clang' => 2,
			// 'chora_in' => 8,
			// 'chora_out' => 19,
			// 'cdsm_in' => 2,
			// 'cdsm_out' => 6,
			// 'lg' => "u{$un}",
			// 'pwd' => "u{$un}",
			// 'email' => "u{$un}@u{$un}.com",
			// 'RA' => 1,
			// 'AR' => 1
		// )
	// );
	// $cps++;
	
	// for($ung = 1; $ung <= 3; $ung++, $cung++) {
		// UnidadeNegocio::insert(
			// array(
				// 'cun' => $cun,
				// 'sung' => "u{$un}u{$ung}",
				// 'nung' => "u{$un}u{$ung}",
				// 'OBS' => "u{$un}u{$ung}",
				// 'RA' => 1,
				// 'AR' => 1,
			// )
		// );
		// Pessoa::insert(
			// array(
				// 'cun' => $cun,
				// 'sps' => "u{$un}u{$ung}",
				// 'nps' => "u{$un}u{$ung}",
				// 'OBS' => "u{$un}u{$ung}",
				// 'flg_sys' => 1,
				// 'RA' => 1,
				// 'AR' => 1
			// )
		// );
		// Usuario::insert(
			// array(
				// 'cna' => 4,
				// 'cnger' => 4,
				// 'cod' => $cung,
				// 'lg' => "u{$un}u{$ung}",
				// 'pwd' => "u{$un}u{$ung}",
				// 'email' => "u{$un}u{$ung}@u{$un}u{$ung}.com",
				// 'cps' => $cps,
				// 'cen' => 1,
				// 'cun' => $cun,
				// 'clang' => 2,
				// 'chora_in' => 8,
				// 'chora_out' => 19,
				// 'cdsm_in' => 2,
				// 'cdsm_out' => 6,
				// 'RA' => 1,
				// 'AR' => 1
			// )
		// );
		// $cps++;
		
		// for($rei = 1; $rei <= 3; $rei++, $crei++) {
			// Regiao::insert(
				// array(
					// 'cung' => $cung,
					// 'srei' => "u{$un}u{$ung}r{$rei}",
					// 'nrei' => "u{$un}u{$ung}r{$rei}",
					// 'OBS' => "u{$un}u{$ung}r{$rei}",
					// 'RA' => 1,
					// 'AR' => 1,
				// )
			// );
			// Pessoa::insert(
				// array(
					// 'cun' => $cun,
					// 'sps' => "u{$un}u{$ung}r{$rei}",
					// 'nps' => "u{$un}u{$ung}r{$rei}",
					// 'OBS' => "u{$un}u{$ung}r{$rei}",
					// 'flg_sys' => 1,
					// 'RA' => 1,
					// 'AR' => 1
				// )
			// );
			// Usuario::insert(
				// array(
					// 'cna' => 5,
					// 'cnger' => 5,
					// 'cod' => $crei,
					// 'lg' => "u{$un}u{$ung}r{$rei}",
					// 'pwd' => "u{$un}u{$ung}r{$rei}",
					// 'email' => "u{$un}u{$ung}r{$rei}@u{$un}u{$ung}r{$rei}.com",
					// 'cps' => $cps,
					// 'cen' => 1,
					// 'cun' => $cun,
					// 'clang' => 2,
					// 'chora_in' => 8,
					// 'chora_out' => 19,
					// 'cdsm_in' => 2,
					// 'cdsm_out' => 6,
					// 'RA' => 1,
					// 'AR' => 1
				// )
			// );
			// $cps++;
			
			// for($dio = 1; $dio <= 3; $dio++, $cdio++) {
				// Distrito::insert(
					// array(
						// 'crei' => $crei,
						// 'sdio' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'ndio' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'OBS' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'RA' => 1,
						// 'AR' => 1,
					// )
				// );
				// Pessoa::insert(
					// array(
						// 'cun' => $cun,
						// 'sps' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'nps' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'OBS' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'flg_sys' => 1,
						// 'RA' => 1,
						// 'AR' => 1
					// )
				// );
				// Usuario::insert(
					// array(
						// 'cna' => 6,
						// 'cnger' => 6,
						// 'cod' => $cdio,
						// 'lg' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'pwd' => "u{$un}u{$ung}r{$rei}d{$dio}",
						// 'email' => "u{$un}u{$ung}r{$rei}d{$dio}@u{$un}u{$ung}r{$rei}d{$dio}.com",
						// 'cps' => $cps,
						// 'cen' => 1,
						// 'cun' => $cun,
						// 'clang' => 2,
						// 'chora_in' => 8,
						// 'chora_out' => 19,
						// 'cdsm_in' => 2,
						// 'cdsm_out' => 6,
						// 'RA' => 1,
						// 'AR' => 1
					// )
				// );
				// $cps++;
				
				// for($set = 1; $set <= 3; $set++, $cset++) {
					// Setor::insert(
						// array(
							// 'cdio' => $cdio,
							// 'sset' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'nset' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'OBS' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'RA' => 1,
							// 'AR' => 1,
						// )
					// );
					// Pessoa::insert(
						// array(
							// 'cun' => $cun,
							// 'sps' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'nps' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'OBS' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'flg_sys' => 1,
							// 'RA' => 1,
							// 'AR' => 1
						// )
					// );
					// Usuario::insert(
						// array(
							// 'cna' => 7,
							// 'cnger' => 7,
							// 'cod' => $cset,
							// 'lg' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'pwd' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}",
							// 'email' => "u{$un}u{$ung}r{$rei}d{$dio}s{$set}@u{$un}u{$ung}r{$rei}d{$dio}s{$set}.com",
							// 'cps' => $cps,
							// 'cen' => 1,
							// 'cun' => $cun,
							// 'clang' => 2,
							// 'chora_in' => 8,
							// 'chora_out' => 19,
							// 'cdsm_in' => 2,
							// 'cdsm_out' => 6,
							// 'RA' => 1,
							// 'AR' => 1
						// )
					// );
					// $cps++;
				// }
			// }
		// }
	// }
// }

/* grava o log na ticket */
//App::import('Tickets', 'Model');
//Tickets::insert();


