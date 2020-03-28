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
		$arquivo_nome = "Relatório_Guarderia_".date("d/m/Y");
		 
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
	<span class="navbar-brand">Relatório de Guarderia</span>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/guardaria/relatorio') ?>" method="GET" id="form">
				<div class="form-row">
                	<div class="form-group col-xl-2">
						<label class="small text-muted">Mostrar</label>
						<select name="ativo" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="1" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 1 ? ' selected':'' ?> >Ativos</option>
                            <option value="0" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 0 ? ' selected':'' ?> >Inativos</option>
                        </select>
					</div>
                    
					<div class="form-group col-xl-1">
						<label class="small text-muted">Tipo</label>
						<select name="linha" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="todos">Todos</option>
							<?php foreach($linha as $lin): ?>
								<option value="<?php echo $lin['clinha'] ?>"<?php echo _isset($_GET['linha'], 0) === $lin['clinha']? ' selected' : '' ?>><?php echo $lin['nlinha'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
                    
                    <div class="form-group col-xl-3">
						<label class="small text-muted">Modelo</label>
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
								<option value="<?php echo $d['cplano'] ?>"<?php echo _isset($_GET['plano'], 0) === $d['cplano']? ' selected' : '' ?>><?php echo $d['nplano'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
                    
                    <div class="form-group col-xl-2">
						<label class="small text-muted">Embarcações</label>
						<select name="equipamento_venda" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="0" <?php echo isset($_GET['equipamento_venda']) && $_GET['equipamento_venda'] == 0 ? ' selected':'' ?> >Todos</option>
                            <option value="1" <?php echo isset($_GET['equipamento_venda']) && $_GET['equipamento_venda'] == 1 ? ' selected':'' ?> >Em venda</option>
                            <option value="2" <?php echo isset($_GET['equipamento_venda']) && $_GET['equipamento_venda'] == 2 ? ' selected':'' ?> >Fora de venda</option>
                        </select>
					</div>
                    
                    <div class="form-group col-xl-2 text-right align-bottom">
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
					<th scope="col" class="small">Pessoa</th>
                    <th scope="col" class="small">Embarcação</th>
                    <th scope="col" class="small">Em venda?</th>
                    <th scope="col" class="small">Valor Venda</th>
					<th scope="col" class="small">Tipo</th>
                    <th scope="col" class="small">Modelo</th>
					<th scope="col" class="small">Plano</th>
                    <th scope="col" class="small">Dia Venc</th>
                    <th scope="col" class="small">Status</th>
                    <th scope="col" class="small">Valor</th>
				</tr>
			</thead>
			<tbody>
            	<?php 
				$fn_ativo = function($x) { //funcao pra ativo
					if($x == 1){
						$a = 'Ativo';
					}else{
						$a= 'Inativo';
					}
					return $a;
				};
				
				$fn_sn = function($x) { //funcao pra ativo
					if($x == 1){
						$a = 'Sim';
					}else{
						$a= 'Não';
					}
					return $a;
				};
				(float) $valor_total = 0;
				(float) $valor_total_venda = 0; ?>
				<?php foreach($list as $d): ?>
					<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/guardaria/view/' . $d['cguardaria']) ?>'">
						<td nowrap><?php echo $d['cguardaria'] ?></td>
						<td nowrap><?php echo $d['nps'] ?></td>
                        <td nowrap><?php echo $d['nome'] ?></td>
                        <td nowrap><?php echo $fn_sn($d['flg_venda']) ?></td>
                        <td nowrap class="text-right"><?php echo $d['valor_venda'] ?></td>
						<td nowrap><?php echo $d['nlinha'] ?></td>
                        <td nowrap><?php echo $d['nprod'] ?></td>
                        <td nowrap><?php echo $d['nplano'] ?></td>
						<td nowrap><?php echo $d['d_vencimento'] ?></td>
                        <td nowrap><?php echo $fn_ativo($d['ativo']) ?></td>
                        <td nowrap class="text-right"><?php echo $d['valor'] + $d['valor_extra'] ?></td>
					</tr>
                <?php 
					$valor_total = $valor_total + ($d['valor'] + $d['valor_extra']);
					$valor_total_venda = $valor_total_venda + ($d['valor_venda']);
				?>
				<?php endforeach; ?>
                <tr>
                	<td colspan="4"></td>
                	<td class="text-right" title="Valor total para valores de venda">R$<b> <?php echo $valor_total_venda;?></b></td>
                	<td colspan="5"></td>
                    <td class="text-right" title="Valor total para serviço de guarderia">R$<b> <?php echo $valor_total;?></b></td>
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