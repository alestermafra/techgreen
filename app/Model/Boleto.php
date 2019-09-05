<?php
App::import('Table', 'Model');	

App::import('Produto', 'Model');
App::import('Endereco', 'Model');

class Boleto extends Table {
	
	public static $_table = 'eboleto';

	public static $_qry = '
		SELECT
			{{fields}}
		FROM eboleto
			LEFT JOIN eps ON (eps.cps = eboleto.cps)
			LEFT JOIN eprod ON (eprod.cprod = eboleto.cprod)
		WHERE eboleto.RA = 1
			{{conditions}}
		{{group}}
		{{order}}
		{{limit}}
		{{offset}}
	';
	
	public static $_fields = array(
		'eboleto.cboleto',
		'eboleto.dias_prazo_pagamento',
		'eboleto.taxa',
		'eboleto.multa',
		'eboleto.valor_cobrado',
		'eboleto.nosso_numero',
		'eboleto.data_venc',
		'eboleto.pedido',
		'eboleto.cprod',
		'eboleto.cps',
		'eboleto.cpsend',
		'eps.cps',
		'eps.nps',
		'eprod.nprod',
	);
	
	
	/* métodos de criação */
	public static function save($data) {
		return static::create($data);
	}
	
	public static function create($data) {
		if(!isset($data['cprod']) || !Produto::findById($data['cprod'], 'count')) {
			throw new Exception('Produto inválido.');
		}
		if(!isset($data['cpsend']) || !Endereco::findById($data['cpsend'], 'count')) {
			throw new Exception('Endereço inválido.');
		}
		if(!isset($data['cps'])) {
			throw new Exception('Pessoa inválida.');
		}
		
		$ult_nosso_num = static::find('count'); // resgata para nosso número
		$ult_nosso_num ++;
		
		$connection = new Connection();
		
		$eboleto = [
			'dias_prazo_pagamento' => (int) _isset($data['dias_prazo_pagamento'], null),
			'taxa' => (string) _isset($data['taxa'], null),
			'multa' => (string) _isset($data['multa'], null),
			'valor_cobrado' => (string) _isset($data['valor_cobrado'], null),
			'data_venc' => (string) date("Y-m-d" , strtotime($data['datinha'])),
			'nosso_numero' => (int) $ult_nosso_num, 
			'pedido' => (int) _isset($data['pedido'], null),
			'cprod' => (int) _isset($data['cprod'], null),
			'cps' => (int) _isset($data['cps'], null),
			'cpsend' => (int) _isset($data['cpsend'], null),
		];
		$cboleto = $connection->insert('eboleto', $eboleto);
		
		return static::findById($cboleto);
	}
	
	
	public static function find(string $type = 'all', array $params = array()) {
		return parent::_find($type, $params);
	}
	
	public static function findById(int $id, string $type = 'first', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eboleto.cboleto = $id";
		return static::_find($type, $params);
	}
	
	public static function findByCps(int $cps, string $type = 'all', array $params = array()) {
		$params['conditions'] = _isset($params['conditions'], '');
		$params['conditions'] .= " AND eboleto.cps = $cps";
		return static::_find($type, $params);
	}
	
	//-------------------------------------------------------------------------------------------
	/*funções próprias para boletos*/
	public static function digitoVerificador_barra($numero) {
		$resto2 = static::modulo_11($numero, 9, 1);
		$digito = 11 - $resto2;
		 if ($digito == 0 || $digito == 1 || $digito == 10  || $digito == 11) {
			$dv = 1;
		 } else {
			$dv = $digito;
		 }
		 return $dv;
	}
	
	public static function formata_numero($numero,$loop,$insert,$tipo = "geral") {
		if ($tipo == "geral") {
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "valor") {
			/*
			retira as virgulas
			formata o numero
			preenche com zeros
			*/
			$numero = str_replace(",","",$numero);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "convenio") {
			while(strlen($numero)<$loop){
				$numero = $numero . $insert;
			}
		}
		return $numero;
	}

	public static function esquerda($entra,$comp){
		return substr($entra,0,$comp);
	}
	
	public static function direita($entra,$comp){
		return substr($entra,strlen($entra)-$comp,$comp);
	}
	
	public static function fator_vencimento($data) {
		$data = explode("/",$data);
		$ano = $data[2];
		$mes = $data[1];
		$dia = $data[0];
		return(abs((static::_dateToDays("1997","10","07")) - (static::_dateToDays($ano, $mes, $dia))));
	}
	
	public static function _dateToDays($year,$month,$day) {
		$century = substr($year, 0, 2);
		$year = substr($year, 2, 2);
		if ($month > 2) {
			$month -= 3;
		} else {
			$month += 9;
			if ($year) {
				$year--;
			} else {
				$year = 99;
				$century --;
			}
		}
		return ( floor((  146097 * $century)    /  4 ) +
				floor(( 1461 * $year)        /  4 ) +
				floor(( 153 * $month +  2) /  5 ) +
					$day +  1721119);
	}
	
	public static function modulo_10($num) { 
			$numtotal10 = 0;
			$fator = 2;
	
			// Separacao dos numeros
			for ($i = strlen($num); $i > 0; $i--) {
				// pega cada numero isoladamente
				$numeros[$i] = substr($num,$i-1,1);
				// Efetua multiplicacao do numero pelo (falor 10)
				// 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Itaú
				$temp = $numeros[$i] * $fator; 
				$temp0=0;
				foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
				$parcial10[$i] = $temp0; //$numeros[$i] * $fator;
				// monta sequencia para soma dos digitos no (modulo 10)
				$numtotal10 += $parcial10[$i];
				if ($fator == 2) {
					$fator = 1;
				} else {
					$fator = 2; // intercala fator de multiplicacao (modulo 10)
				}
			}
			
			// várias linhas removidas, vide função original
			// Calculo do modulo 10
			$resto = $numtotal10 % 10;
			$digito = 10 - $resto;
			if ($resto == 0) {
				$digito = 0;
			}
			
			return $digito;
	}

	public static function modulo_11($num, $base=9, $r=0)  {
		/**
		 *   Função:
		 *    Calculo do Modulo 11 para geracao do digito verificador 
		 *    de boletos bancarios conforme documentos obtidos 
		 *    da Febraban - www.febraban.org.br 
		 *
		 *   Entrada:
		 *     $num: string numérica para a qual se deseja calcularo digito verificador;
		 *     $base: valor maximo de multiplicacao [2-$base]
		 *     $r: quando especificado um devolve somente o resto
		 *
		 *   Saída:
		 *     Retorna o Digito verificador.
		 *
		 *   Observações:
		 *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
		 *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
		 */                                        
	
		$soma = 0;
		$fator = 2;
	
		/* Separacao dos numeros */
		for ($i = strlen($num); $i > 0; $i--) {
			// pega cada numero isoladamente
			$numeros[$i] = substr($num,$i-1,1);
			// Efetua multiplicacao do numero pelo falor
			$parcial[$i] = $numeros[$i] * $fator;
			// Soma dos digitos
			$soma += $parcial[$i];
			if ($fator == $base) {
				// restaura fator de multiplicacao para 2 
				$fator = 1;
			}
			$fator++;
		}
	
		/* Calculo do modulo 11 */
		if ($r == 0) {
			$soma *= 10;
			$digito = $soma % 11;
			if ($digito == 10) {
				$digito = 0;
			}
			return $digito;
		} elseif ($r == 1){
			$resto = $soma % 11;
			return $resto;
		}
	}
	
	// Alterada por Glauber Portella para especificação do Itaú
	public static function monta_linha_digitavel($codigo) {
			// campo 1
			$banco    = substr($codigo,0,3);
			$moeda    = substr($codigo,3,1);
			$ccc      = substr($codigo,19,3);
			$ddnnum   = substr($codigo,22,2);
			$dv1      = static::modulo_10($banco.$moeda.$ccc.$ddnnum);
			// campo 2
			$resnnum  = substr($codigo,24,6);
			$dac1     = substr($codigo,30,1);//modulo_10($agencia.$conta.$carteira.$nnum);
			$dddag    = substr($codigo,31,3);
			$dv2      = static::modulo_10($resnnum.$dac1.$dddag);
			// campo 3
			$resag    = substr($codigo,34,1);
			$contadac = substr($codigo,35,6); //substr($codigo,35,5).modulo_10(substr($codigo,35,5));
			$zeros    = substr($codigo,41,3);
			$dv3      = static::modulo_10($resag.$contadac.$zeros);
			// campo 4
			$dv4      = substr($codigo,4,1);
			// campo 5
			$fator    = substr($codigo,5,4);
			$valor    = substr($codigo,9,10);
			
			$campo1 = substr($banco.$moeda.$ccc.$ddnnum.$dv1,0,5) . '.' . substr($banco.$moeda.$ccc.$ddnnum.$dv1,5,5);
			$campo2 = substr($resnnum.$dac1.$dddag.$dv2,0,5) . '.' . substr($resnnum.$dac1.$dddag.$dv2,5,6);
			$campo3 = substr($resag.$contadac.$zeros.$dv3,0,5) . '.' . substr($resag.$contadac.$zeros.$dv3,5,6);
			$campo4 = $dv4;
			$campo5 = $fator.$valor;
			
			return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
	}
	
	public static function geraCodigoBanco($numero) {
		$parte1 = substr($numero, 0, 3);
		$parte2 = static::modulo_11($parte1);
		return $parte1 . "-" . $parte2;
	}
	
}