<?php
	/* interesses */
	$interesses_por_categoria = array();
	foreach($interesses as $interesse) {
		$ex = explode(" - ", $interesse["ntinteresse"], 2);
		if(!isset($ex[1])) {
			$categoria = "Categoria Desconhecida";
			$nome = $ex[0];
		}
		else {
			$categoria = $ex[0];
			$nome = $ex[1];
		}
		$interesse["ntinteresse"] = $nome;
		$interesses_por_categoria[$categoria] = _isset($interesses_por_categoria[$categoria], array());
		array_push($interesses_por_categoria[$categoria], $interesse);
	}
	
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
							<?php foreach($segmentacoes as $s): ?>
								<option value="<?php echo $s['cseg'] ?>"<?php echo _isset($_GET['seg'], '') === $s['cseg']? ' selected' : '' ?>><?php echo $s['nseg'] ?></option>
							<?php endforeach ?>
                            	<option value="todos">Todos</option>
						</select>
					</div>
                    
                    <div class="col-xl-1"></div>
                    
                    <div class="form-group col-xl-1">
						<label class="small text-muted">Dia de contato</label>
						<select name="dia" class="form-control form-control-sm" onchange="this.form.submit()">
                        	<option value="0">Todos</option>
							<?php foreach($cdia as $cdia): ?>
								<option value="<?php echo $cdia['cdia'] ?>"<?php echo _isset($_GET['dia'], 0) === $cdia['cdia']? ' selected' : '' ?>><?php echo $cdia['cdia'] ?></option>
							<?php endforeach ?>
						</select>
					 </div>
                    
                    <div class="form-group col-xl-1">
						<label class="small text-muted">Mês de contato</label>
						<select name="mes" class="form-control form-control-sm" onchange="this.form.submit()">
                        	<option value="0">Todos</option>
							<?php foreach($cmes as $cmes): ?>
								<option value="<?php echo $cmes['cmes'] ?>"<?php echo _isset($_GET['mes'], 0) === $cmes['cmes']? ' selected' : '' ?>><?php echo $cmes['smes'] ?></option>
							<?php endforeach ?>
						</select>
					 </div>
					 
					 <div class="form-group col-xl-1">
						<label class="small text-muted">Ano de contato</label>
						<select name="ano" class="form-control form-control-sm" onchange="this.form.submit()">
                        	<option value="0">Todos</option>
							<?php for($y = date('Y'); $y >= date('Y') - 100; $y--): ?>
								<option value="<?php echo $y ?>"<?php echo $y == _isset($_GET['ano'], 0)? ' selected' : '' ?>><?php echo $y ?></option>
							<?php endfor ?>
						</select>
					</div>
                    
                     <div class="col-xl-2"></div>
                    
                    <div class="form-group col-xl-2 text-right align-bottom">
                    	<input type="hidden" value="0" name="excel" id="excel"/>
                        <br />
                        <button onclick="gera_excel()" role="button" class="btn btn-sm btn-success" title="Gerar excel">
                         	<i class="material-icons align-middle md-18">cloud_download</i> Excel
                        </button>
                    </div>
				</div>	
                
                <div class="form-row">
                	<div class="form-group col-xl">
                    <?php $i = 0; foreach($interesses_por_categoria as $categoria => $interesses): ?>
                        <label class="small text-muted"><?= $categoria ?></label>
                        <div class="form-row">
                            <?php foreach($interesses as $interesse): ?>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox"  name="ctinteresse<?=$interesse["ctinteresse"]?>"  value="<?=$interesse["ctinteresse"]?>" <?= _isset($_GET['ctinteresse'.$interesse["ctinteresse"]])? 'checked' : '' ?>  onchange="this.form.submit()">
                                        <label class="form-check-label form-control-sm"><?= $interesse["ntinteresse"] ?></label>
                                    </div>
                                </div>
                            <?php $i++; endforeach; ?>
                        </div>
                    <?php endforeach; ?>
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
                    <th scope="col" class="small">Data Contato</th>
                    <th scope="col" class="small">Telefone</th>
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
					<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/painel/overview_pf/' . $d['cps']) ?>'">
						<td nowrap><?php echo $d['cps'] ?></td>
						<td nowrap><?php echo $d['nps'] ?></td>
                        <td nowrap><?php echo $d['nseg'] ?></td>
                        <td nowrap><?php echo $fn_ativo($d['ativo']) ?></td>
						<td nowrap><?php if($d['d_contato'] && $d['m_contato'] && $d['a_contato']) {echo $d['d_contato'].'/'.$d['m_contato'].'/'.$d['a_contato'];} ?></td>
                        <td nowrap>
                        	<?php if($_GET['excel']): ?>
                            <?php echo $d['fone']; ?>
                            <?php else:?>
                        	<input type="text" readonly class="form-control-plaintext p-0 m-0 phone" value="<?php echo $d['fone'] ?>" />
                            <?php endif;?>
                        </td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endif ?>


<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
	});
	
	function bindEvents() {
		bindPhoneMask();
	}
	
	function bindPhoneMask() {
		let fone_mask = (val) => {
			val = val.replace(/[^0-9]/g, '');
			
			if(val.length <= 8) {
				return '0000-0000';
			}
			if(val.length <= 9) {
				return '00000-0000';
			}
			if(val.length <= 10) {
				return '(00) 0000-0000'; 
			}
			if(val.length <= 11) {
				return '(00) 00000-0000';
			}
			if(val.length <= 12) {
				return '+00 (00) 0000-0000';
			}
			if(val.length <= 13) {
				return '+00 (00) 00000-0000';
			}
		};
		$('.phone').mask(fone_mask);
	};
})();

	
	function gera_excel() {
		document.getElementById('excel').value = 1;
  		document.getElementById('form').submit();
		setTimeout(volta_zero, 3000);
	}
	
	function volta_zero(){
		document.getElementById('excel').value = 0
	}
</script>