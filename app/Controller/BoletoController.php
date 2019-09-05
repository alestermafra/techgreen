<?php
App::import('AppController', 'Controller');
App::import('Auth', 'Model');

App::import('Boleto', 'Model');

App::import('Guardaria', 'Model');
App::import('Equipamento', 'Model');
App::import('Endereco', 'Model');

App::import('Ocorrencia', 'Model');


class BoletoController extends AppController {
	
	public function boleto_config(int $cguardaria = null, int $cequipe = null){	
		if($this->request->method === 'POST') {
			$data = $_POST;
			try {
				$boleto = Boleto::save($data);
				$ocorrencia = Ocorrencia::inserir_ocorrencia_boleto($boleto['cboleto']);
				$this->redirect('/boleto/view/' . $boleto['cps']);
			}
			catch(Exception $e) {
				$this->view->set('error', $e->getMessage());
			}
		}
		
		$equipamento = Equipamento::findById($cequipe);
		$endereco = Endereco::findByCps($equipamento['cps']);
		
		$this->view->set('guardaria', Guardaria::findById($cguardaria));
		$this->view->set('equipamento', $equipamento);
		$this->view->set('endereco', $endereco);
	}
	
	public function view(int $cps){
		$this->view->set('boleto', Boleto::findByCps($cps, 'all', array('order' => 'data_venc desc')));
		$this->view->set('ocorrencia', Ocorrencia::findByCodigoPessoa($cps, 'all', array('order' => 'eocorrencia.data DESC')));
	}
	
	
	public function visualizar_boleto(int $cboleto) {
		$this->layout = 'layout_limpo';
		
		$boleto = Boleto::findById($cboleto);
		$endereco = Endereco::findById($boleto['cpsend']);
		
		$dias_de_prazo_para_pagamento = $boleto['dias_prazo_pagamento'];
		$taxa_boleto = $boleto['taxa'];
		$data_venc = date(date("d/m/Y", strtotime($boleto['data_venc'])), time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2019"; 
		$valor_cobrado = $boleto['valor_cobrado']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
				
		$dadosboleto["nosso_numero"] = $boleto['nosso_numero'];  // Nosso numero - REGRA: Máximo de 8 caracteres!
		$dadosboleto["numero_documento"] = $boleto['pedido'];	// Num do pedido ou nosso numero 4 numeros
		$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
				
				
		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = $endereco['nps'];
		$dadosboleto["endereco1"] = $endereco['endr'] .", ". $endereco['no']. "  ". $endereco['endcmplt'];
		$dadosboleto["endereco2"] = $endereco['cep'] ." - ".$endereco['bai']." - ".$endereco['cidade']."/".$endereco['uf'];
				
		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento de serviço";
		$dadosboleto["demonstrativo2"] = "Mensalidade referente a serviço prestado pela Pera Náutica<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
		$dadosboleto["demonstrativo3"] = "M.Gold Informática Ltda.";
		$dadosboleto["instrucoes1"] = "- Sr(a). Caixa, cobrar multa de ".$taxa_boleto."% após o vencimento";
		$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
		$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: pera@peranautica.com.br";
		$dadosboleto["instrucoes4"] = "&nbsp; Emitido por M.Gold - Informática Ltda.";
			
		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$dadosboleto["quantidade"] = "";
		$dadosboleto["valor_unitario"] = "";
		$dadosboleto["aceite"] = "";		
		$dadosboleto["especie"] = "R$";
		$dadosboleto["especie_doc"] = "";
				
			
		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
		// DADOS DA SUA CONTA - ITAÚ
		$dadosboleto["agencia"] = "0192"; // Num da agencia, sem digito
		$dadosboleto["conta"] = "19411";	// Num da conta, sem digito
		$dadosboleto["conta_dv"] = "6"; 	// Digito do Num da conta
		
		// DADOS PERSONALIZADOS - ITAÚ
		$dadosboleto["carteira"] = "157";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157
		//$dadosboleto["carteira"] = "112";  // Código da Carteira: 112 - Siscob
				
		// SEUS DADOS
		$dadosboleto["identificacao"] = "Pera Náutica Eireli";
		$dadosboleto["cpf_cnpj"] = "67.403.097/0001-54";
		$dadosboleto["endereco"] = "Rua Valentim Ramos Delano, 151";
		$dadosboleto["cidade_uf"] = "São Paulo / SP";
		$dadosboleto["cedente"] = "Pera Náutica";
				
				
		//---------------------------------
		
		$codigobanco = "341"; //dado Itaú
		$codigo_banco_com_dv = Boleto::geraCodigoBanco($codigobanco);
		$nummoeda = "9"; //dado Itaú
		$fator_vencimento = Boleto::fator_vencimento($dadosboleto["data_vencimento"]);
				
		//valor tem 10 digitos, sem virgula
		$valor = Boleto::formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
		//agencia é 4 digitos
		$agencia = Boleto::formata_numero($dadosboleto["agencia"],4,0);
		//conta é 5 digitos + 1 do dv
		$conta = Boleto::formata_numero($dadosboleto["conta"],5,0);
		$conta_dv = Boleto::formata_numero($dadosboleto["conta_dv"],1,0);
		//carteira 175
		$carteira = $dadosboleto["carteira"];
		//nosso_numero no maximo 8 digitos
		$nnum = Boleto::formata_numero($dadosboleto["nosso_numero"],8,0);
		
			
		$codigo_barras = $codigobanco.$nummoeda.$fator_vencimento.$valor.$carteira.$nnum.Boleto::modulo_10($agencia.$conta.$carteira.$nnum).$agencia.$conta.Boleto::modulo_10($agencia.$conta).'000';
		//----teste 27-06-2019	 -- CARTEIRA 112
		//$codigo_barras = $codigobanco.$nummoeda.$fator_vencimento.$valor.$carteira.$nnum.Boleto::modulo_10($agencia.$conta.$conta_dv.$carteira.$nnum).$agencia.$conta.Boleto::modulo_10($agencia.$conta).'000';
		//---------------fim do teste
		
		// 43 numeros para o calculo do digito verificador
		$dv = Boleto::digitoVerificador_barra($codigo_barras);
		// Numero para o codigo de barras com 44 digitos
		$linha = substr($codigo_barras,0,4).$dv.substr($codigo_barras,4,43);
		
		
		//----teste 27-06-2019		
		$nossonumero = $carteira.'/'.$nnum.'-'.Boleto::modulo_10($agencia.$conta.$carteira.$nnum);
		//----teste 27-06-2019	 -- carteira 112
		$nossonumero = $carteira.'/'.$nnum.'-'.Boleto::modulo_10($agencia.$conta.$conta_dv.$carteira.$nnum);
		//---------------fim do teste
		
		$agencia_codigo = $agencia." / ". $conta."-".Boleto::modulo_10($agencia.$conta);
		
		$dadosboleto["codigo_barras"] = $linha;
		$dadosboleto["linha_digitavel"] = Boleto::monta_linha_digitavel($linha); // verificar
		$dadosboleto["agencia_codigo"] = $agencia_codigo ;
		$dadosboleto["nosso_numero"] = $nossonumero;
		$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;
		
		$this->view->set('dadosboleto', $dadosboleto);	
	}
		
}