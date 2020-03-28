<style>
	body{
		font-family:arial;
		font-size: 12px;
		max-width: 700px;
	}
	
	table{
		font-size:13px;
	}

	.titulo{
		text-align: center;
		font-size: 15px;
		text-decoration:underline;
		font-weight:bold;
		padding-bottom:1em;
	}
	.corpo{
		text-align: justify;
  		text-justify: inter-word;
	}
</style>

<div class="titulo"><img src="<?php echo $this->url('/img/logo.png')?>"  width="100"/></div>
<div class="titulo">CONTRATO PARTICULAR DE VELEJADOR MASTER</div>


<p>Pelo presente instrumento, de um lado, como contratante:</p>
<table cellpadding="2" cellspacing="0" border="1" width="100%" >
    <tr>
        <td colspan="3">Nome: <?=$clientepf['nps']?></td>
    </tr>
    <tr>
        <td colspan="3">E-mail: <?=$clientepf['email']?></td>
    </tr>
    <tr>
        <td>Data de Nascimento: <?=$clientepf['d_nasc'].'/'.$clientepf['m_nasc'].'/'.$clientepf['a_nasc']?></td> 	
        <td>CPF: <?=$clientepf['cpf']?></td> 	 <td>RG: <?=$clientepf['rg']?></td>
    </tr>
    <?php if($endereco) :?>
    <tr>
        <td colspan="2">End.: <?=$endereco['endr']?></td> <td>Nº <?=$endereco['no']?> </td>
    </tr>
    <tr>
        <td>Complemento: <?=$endereco['endcmplt']?></td> <td colspan="2">Bairro: <?=$endereco['bai']?></td>
    </tr>
    <tr>
        <td>Cidade: <?=$endereco['cidade']?></td> <td>UF: <?=$endereco['uf']?></td>	<td>CEP: <?=$endereco['cep']?></td>
    </tr>
    <?php endif ?>
    <tr>
    	<td colspan="3">
    	<?php foreach($clientepf['telefones'] as $tel): ?>
        	Tel. <?php echo $tel['ntfone'] ?> : <?php echo $tel['fone'] ?> <br />
        <?php endforeach ?>
        </td>
    </tr>
</table>

<div class="corpo">
<p>doravante designado simplesmente <b>PROPRIETÁRIO</b>; e de outro lado, <b>PÊRA NÁUTICA LTDA. – ME</b>, com sede na Rua Valentim Ramos Delano nº 151, nesta Capital, inscrita no CNPJ sob nº 67.403.097/0001-54 e no CCM sob nº 2.027.261-0, doravante designada simplesmente <b>PÊRA</b>, tem entre si justo e contratado o seguinte:</p>
<p><b>1. DOS EQUIPAMENTOS E SEUS ACESSÓRIOS</b><br />
  1.1 O PROPRIETARIO acompanhará a vistoria de entrada de seu equipamento(s) e acessório(s), descriminados valores unitários de mercado para efeito de seguro. <br />
  1.2 Eventuais alterações no(s) equipamento(s) e acessório(s) deverão ser comunicados ao ATENDIMENTO para que seja feita a alteração no Sistema de guarderia. <br />
  1.3 Caso o PROPRIETÁRIO não comunique as modificações a PÊRA NÁUTICA não se responsabilizará pelo equipamento ou acessório que não esteja no Sistema de guarderia. <br />
  1.4 O VELEJADOR poderá utilizar seu(s) equipamento(s) durante o horário de funcionamento da PÊRA NÁUTICA, sendo que o mesmo será responsável por sua montagem, retirada do depósito, transporte até a área náutica, lavagem e devolução ao depósito. O VELEJADOR comprometesse, ainda, a utilizar colete salva-vidas durante o velejo.<br />
  Horário de funcionamento é:<br />
  Terça a Sexta dás 10h ás 18h<br />
  Sabados, domingos e feriados: dás 9h ás 18h<br />
  Natal: 24/12 abertos dás 9h ás 13h e 25/12 fechado.<br />
  Reveion:31/12 e 01/01 fechados.<br />
  Feriados e Eleição os horários de funcionamento estarão fixados no mural da Pera Náutica.<br />
  1.5 O(s) equipamento(s) e acessório(s) serão controlados através de um sistema de saída e entrada, sendo que poderá ser retirado por quem o VELEJADOR indicar em autorização escrita e assinada. A pessoa indicada deverá solicitar ao funcionário da PÊRA NÁUTICA que retire ou reponha o(s) equipamento(s) e acessório(s) do VELEJADOR no galpão. <br />
  1.6 A PERA NÁUITCA colocará à disposição do VELEJADOR local adequado à lavagem de seu equipamento.<br />
  1.7 O VELEJADOR poderá transferir seu(s) equipamento(s) e acessório(s) para as sedes da BL3 ILHABELA em Ilhabela/SP – base Armação e base Engenho d’Água, mediante consulta prévia da disponibilidade de guarderia junto ao local pretendido,</p>
<p>2. DO PRAZO<br />
  2.1 O prazo para a guarderia do(s) equipamento(s) e acessório(s) do VELEJADOR será conforme o plano abaixo escolhido, com início a partir da data de assinatura deste contrato.<br />
</p>
<p><b>3. DO PAGAMENTO</b><br />
  <b>3.1 O VELEJADOR realizará o pagamento mensal acrescido de 0,08% do valor de seu equipamento destinado ao SEGURO</b><br />
  3.2 O VELEJADOR que tiver um segundo equipamento terá desconto de 20% no valor de sua guarderia.<br />
  3.3 Caso a(s) parcela(s) não seja(m) paga(s) no(s) seu(s) vencimento(s), sobre o débito em aberto será acrescida uma multa de 2% (dois por cento) e mora de 6% (seis por cento) ao mês, sendo que o VELEJADOR será constituído em mora, independentemente de qualquer notificação, interpretação ou aviso judicial ou extrajudicial.<br />
  3.4 No caso de atraso do pagamento da parcela no período maior que 30 dias, o VELEJADOR ficará IMPEDIDO de FREQUENTAR AS DEPENDÊNCIAS DA PERA NÁUTICA, até a quitação das parcelas.<br />
  3.5 Na hipótese da PERA NÁUTICA admitir, em benefício do VELEJADOR, qualquer atraso no pagamento das prestações, essa tolerância não poderá ser considerada como alteração das condições do presente contrato, sendo mero ato de liberalidade da PERA NÁUTICA.<br />
  O presente contrato tem caráter personalíssimo, não podendo o VELEJADOR ceder seus direitos a terceiros sem o consentimento expresso e por escrito da PERA NÁUTICA.</p>
<p><b>4. DA RENOVAÇÃO</b><br />
  4.1 O presente contrato será renovado automaticamente na data de seu vencimento, exceto quando o VELEJADOR ou a PERA NÁUTICA solicitar seu cancelamento, por escrito, no prazo de até 20 (vinte) dias antes do vencimento da parcela, quando então retirará seu(s) equipamento(s) e acessório(s) da guarderia e será rescindido o presente instrumento. </p>
<p><b>5. DA VISTORIA</b><br />
  5.1 Será procedida mensalmente uma vistoria pela PERA NÁUTICA a fim de verificar o(s) equipamento(s), os(s) acessório(s) e seu estado.</p>
<p><b>6. DO USO DAS DEPENDÊNCIAS</b><br />
  6.1 O VELEJEDOR poderá freqüentar livremente as dependências da PERA NÁUTICA, respeitando o horário de funcionamento.<br />
  6.2 A PERA NÁUTICA põe à disposição do VELEJADOR espaço para estacionamento de seu veículo, não se responsabilizando pelos mesmos, nem por eventuais objetos deixados em seu interior.<br />
  6.3 A PERA NÁUTICA se obriga a manter as dependências limpas e em condições de uso pelo VELEJADOR.</p>
<p><b>7. DA ÁREA NÁUTICA</b><br />
  7.2 A PERA NÁUTICA deverá manter a área náutica em condições de uso pelo VELEJADOR.<br />
  7.3 A PERA NÁUTICA não se responsabiliza por danos ocorridos em quaisquer objetos ou equipamentos de propriedade do VELEJADOR deixados sobre a área náutica.</p>
<p><b>8. DOS BENEFÍCIOS</b><br />
  8.1 O VELEJADOR MASTER terá desconto de 10% (dez por cento) sobre os serviços prestados pela PERA NÁUTICA, a tabela de preço se encontra no atendimento. <br />
  8.2 O VELEJADOR MASTER terá livre acesso às sedes da PERA NÁUTICA em São Paulo/SP – Represa de Guarapiranga. E acesso a BL3 IILHABELA em Ilhabela/SP – base Armação e base Engenho d’Água.<br />
  8.3 O VELEJADOR MASTER poderá deixar seu equipamento guardado na sede da BL3 ILHABELA por 1 final de semana sem custo. Se o velejador for passar mais que 1 final de semana na sede da BL3 Ilhabela deverá informar o ATENDIMENTO DA PERA NÁUTICA para que sejam tomadas as devidas providências.</p>
<p>As partes elegem o foro da Comarca da Capital de São Paulo como o único competente para dirimir quaisquer dúvidas ou conhecerem conflitos emergentes do presente contrato, com renúncia a qualquer outro por mais privilegiado que seja.</p>
<p>E, por estarem assim, ajustadas e contratadas, as partes assinam o presente instrumento em duas vias de igual teor.<br />
</p>
</div>

<br />

<p><?php 
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	echo 'São Paulo, ' . strftime('%d de %B de %Y', strtotime('today'));
	?><br /> </p>

<p>&nbsp;</p>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td width="33%">___________________________________</td>
    <td width="33%">&nbsp;</td>
    <td width="33%">___________________________________</td>
</tr>
<tr>
	<td>TITULAR - CONTRATANTE</td>
	<td></td>
    <td style="text-align:right;">PÊRA NÁUTICA LTDA ME</td>
</tr>
</table>