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
		$arquivo_nome = "Relatório_Painel_PF_".date("d/m/Y");
		 
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
	<span class="navbar-brand">Relatório de Velejadores</span>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/painel/relatorio') ?>" method="GET" id="form">
				<div class="form-row">
                	<div class="form-group col-xl-2">
						<label class="small text-muted">Mostrar</label>
						<select name="ativo" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="1" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 1 ? ' selected':'' ?> >Ativos</option>
                            <option value="0" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 0 ? ' selected':'' ?> >Inativos</option>
                        </select>
					</div>
					
					<div class="form-group col-xl-2">
						<label class="small text-muted">Classificação</label>
						<select name="seg" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="todos">Todos</option>
							<?php foreach($segmentacoes as $s): ?>
								<option value="<?php echo $s['cseg'] ?>"<?php echo _isset($_GET['seg'], '') === $s['cseg']? ' selected' : '' ?>><?php echo $s['nseg'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
                    
                    <div class="col-xl-6"></div>
                    
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
					<th scope="col" class="small">Nome</th>
                    <th scope="col" class="small">Classificação</th>
                    <th scope="col" class="small">Status</th>
                    <th scope="col" class="small">Email</th>
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
				?>
				<?php foreach($list as $d): ?>
					<tr>
						<td nowrap><?php echo $d['cps'] ?></td>
						<td nowrap><?php echo $d['nps'] ?></td>
                        <td nowrap><?php echo $d['nseg'] ?></td>
                        <td nowrap><?php echo $fn_ativo($d['ativo']) ?></td>
						<td nowrap><?php echo $d['email'] ?></td>
					</tr>
				<?php endforeach; ?>
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