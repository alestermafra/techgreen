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
<div class="titulo">QUALIFICAÇÃO DA EMBARCAÇÃO</div>


<p>Dados<hr /></p>
<table cellpadding="2" cellspacing="0" border="0" width="100%" >
    <tr>
        <td width="10%">Nome:</td>	<td width="40%"><b><?=$equipamento['nome']?></b></td>
        <td width="10%">Responsável:</td> <td width="40%"><b><?=$equipamento['nps']?></b></td>
    </tr>
    <tr>
        <td>Marca:</td> <td><b><?=$equipamento['marca']?></b></td>
        <td>Tipo:</td> <td><b><?=$equipamento['nlinha']?></b></td>
    </tr>
    <tr>
        <td>Modelo:</td> <td><b><?=$equipamento['nprod']?></b></td>
        <td>Tamanho:</td> <td><b><?=$equipamento['tamanho']?></b></td>
    </tr>
    <tr>
        <td>Cor:</td> <td><b><?=$equipamento['cor']?></b></td>
        <td>Ano:</td> <td><b><?=$equipamento['ano']?></b></td>
    </tr>
    <tr>
        <td>Estado:</td> <td><b><?=$equipamento['estado_geral']?></b></td>
    </tr>
    <tr>
        <td>Em venda?</td> <td><b><?php if($equipamento['flg_venda'] ==1) {echo 'Sim';} else {echo 'Não';}  ?></b></td>
    <?php if($equipamento['flg_venda'] ==1):?>
        <td>Valor de venda</td> <td><b><?php echo $equipamento['valor_venda'] ?></b></td>
    <?php endif?>
    </tr>
</table>

<br />
<br />

<p>Equipamentos<hr /></p>
<div class="corpo">
<?php if(!isset($pertences) || empty($pertences)): ?>
Nenhum equipamento cadastrado.
<?php else: ?>
<table cellpadding="2" cellspacing="0" border="0" width="100%" >
    <tr>
		<td><b>Nome</b></td>
		<td><b>Marca</b></td>
		<td><b>Modelo</b></td>
		<td><b>Tamanho</b></td>
		<td><b>Cor</b></td>
		<td><b>Ano</b></td>
		<td><b>Estado Geral</b></th>
	</tr>
<?php foreach($pertences as $p): ?>
	<tr>
		<td><?php echo $p['npertence'] ?></td>
		<td><?php echo $p['marca'] ?></td>
		<td><?php echo $p['modelo'] ?></td>
		<td><?php echo $p['tamanho'] ?></td>
		<td><?php echo $p['cor'] ?></td>
		<td><?php echo $p['ano'] ?></td>
		<td><?php echo $p['estado_geral'] ?></td>
	</tr>
<?php endforeach ?>
</table>
<?php endif ?>
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
	<td><?=$equipamento['nps']?></td>
	<td></td>
    <td style="text-align:right;">PÊRA NÁUTICA LTDA ME</td>
</tr>
</table>