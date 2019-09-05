<?php
	/* parametros para inserir na paginação. */
	$url_get = '?';
	foreach($_GET as $k => $v) {
		if($k === 'page') {
			continue;
		}
		$url_get .= "&$k=$v";
	}
	
	//excel
	if($excel == 1){
		$arquivo_nome = "Relatório_Diária_Velejador-".date("d/m/Y");
		 
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-Type: text/html; charset=utf-8");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"$arquivo_nome.xls\"" );
		header ("Content-Description: PHP Generated Data" );
		
		echo '<meta http-equiv="content-type" content="text/html;charset=utf-8" />';
	}
?>

<?php if(!$excel): //excel?>
<nav class="navbar navbar-light">
	<span class="navbar-brand">Relatório de Diária de Velejadore</span>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/diariavelejador/relatorio') ?>" method="GET" id="form">
				<div class="form-row">
                	<div class="form-group col-xl-1">
						<label class="small text-muted">Mês</label>
						<select name="mes" class="form-control form-control-sm" onchange="this.form.submit()">
							<?php foreach($cmes as $cmes): ?>
								<option value="<?php echo $cmes['cmes'] ?>"<?php echo _isset($_GET['mes'], date("n")) === $cmes['cmes']? ' selected' : '' ?>><?php echo $cmes['smes'] ?></option>
							<?php endforeach ?>
						</select>
					 </div>
					 
					 <div class="form-group col-xl-1">
						<label class="small text-muted">Ano</label>
						<select name="ano" class="form-control form-control-sm" onchange="this.form.submit()">
							<?php foreach($can as $can): ?>
								<option value="<?php echo $can['can'] ?>"<?php echo _isset($_GET['ano'], date("Y")) === $can['can']? ' selected' : '' ?>><?php echo $can['can'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
                
                    <div class="form-group col-xl-4">
						<label class="small text-muted">Equipamento</label>
						<select name="produto" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="todos">Todos</option>
							<?php foreach($produtos as $prod): ?>
								<option value="<?php echo $prod['cprod'] ?>"<?php echo _isset($_GET['produto'], 0) === $prod['cprod']? ' selected' : '' ?>><?php echo $prod['nprod'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					
					<div class="form-group col-xl-2">
						<label class="small text-muted">Plano</label>
						<select name="plano" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="todos">Todos</option>
							<?php foreach($planos as $d): ?>
								<option value="<?php echo $d['ctabela'] ?>"<?php echo _isset($_GET['plano'], 0) === $d['ctabela']? ' selected' : '' ?>><?php echo $d['ntabela'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
                    
                    <div class="form-group col-xl-4 text-right align-bottom">
                    	<input type="hidden" value="0" name="excel" id="excel"/>
                        <br />
                        <button onclick="gera_excel()" role="button" class="btn btn-sm btn-success" title="Gerar excel">
                         	<i class="material-icons align-middle md-18">cloud_download</i> Excel
                        </button>
                    </div>
				</div>	
			</form>
		</div>
	</div>
</div>

<br />
<?php endif //excel?>

<?php if(empty($list)): ?>
	<div class="container-fluid small text-center">
		Nenhum registro para exibir.
	</div>
<?php else: ?>
	<div class="table-responsive">
		<table class="table table-sm table-hover">
			<thead class="thead-light">
				<tr>
					<th scope="col" class="small">Id</th>
					<th scope="col" class="small">Nome</th>
					<th scope="col" class="small">Equipamento</th>
					<th scope="col" class="small">Plano</th>
                    <th scope="col" class="small">Data</th>
                    <th scope="col" class="small">Descrição</th>
                    <th scope="col" class="small">Valor</th>
				</tr>
			</thead>
			<tbody>
            	<?php (float) $valor_total = 0; ?>
				<?php foreach($list as $d): ?>
					<tr>
						<td nowrap><?php echo $d['cdiaria'] ?></td>
						<td nowrap><?php echo $d['nps'] ?></td>
						<td nowrap><?php echo $d['nprod'] ?></td>
                        <td nowrap><?php echo $d['ntabela'] ?></td>
						<td nowrap><?php echo $d['cdia'].'/'.$d['cmes'].'/'.$d['can'] ?></td>
                        <td nowrap><?php echo $d['descricao'] ?></td>
                        <td nowrap><?php echo $d['valor'] ?></td>
					</tr>
                <?php $valor_total = $valor_total + $d['valor'];?>
				<?php endforeach; ?>
                <tr>
                	<td colspan="6"></td>
                    <td>R$<b> <?php echo $valor_total;?></b></td>
                </tr>
			</tbody>
		</table>
	</div>

	<?php if(!$excel): //excel?>		
        <div class="container-fluid text-right small">
            Total de registros: <?php echo $count ?>
        </div>
    <?php endif//excel?>
<?php endif ?>


<script type="text/javascript">
	function gera_excel() {
		document.getElementById('excel').value = 1;
  		document.getElementById('form').submit();
		setTimeout(volta_zero, 3000);
	}
	
	function volta_zero(){
		document.getElementById('excel').value = 0
	}
</script>