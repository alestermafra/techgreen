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
		$arquivo_nome = "Aniversariantes-dia".$_GET['dia']."-mes".$_GET['mes']."__gerado_em_".date("d/m/Y");
		 
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
	<span class="navbar-brand">Aniversariantes do dia</span>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/painel/relatorio_aniversariantes') ?>" method="GET" id="form">
				<div class="form-row">
                	<div class="form-group col-xl-2">
						<label class="small text-muted">Mostrar</label>
						<select name="ativo" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="1" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 1 ? ' selected':'' ?> >Ativos</option>
                            <option value="0" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 0 ? ' selected':'' ?> >Inativos</option>
                        </select>
					</div>
					
                    <div class="col-xl-1"></div>
                    
                    <div class="form-group col-xl-1">
						<label class="small text-muted">Dia</label>
						<select name="dia" class="form-control form-control-sm" onchange="this.form.submit()">
							<?php foreach($cdia as $cdia): ?>
								<option value="<?php echo $cdia['cdia'] ?>"<?php echo _isset($_GET['dia'], date("j")) === $cdia['cdia']? ' selected' : '' ?>><?php echo $cdia['cdia'] ?></option>
							<?php endforeach ?>
						</select>
					 </div>
                    
                    <div class="form-group col-xl-1">
						<label class="small text-muted">Mês</label>
						<select name="mes" class="form-control form-control-sm" onchange="this.form.submit()">
							<?php foreach($cmes as $cmes): ?>
								<option value="<?php echo $cmes['cmes'] ?>"<?php echo _isset($_GET['mes'], date("n")) === $cmes['cmes']? ' selected' : '' ?>><?php echo $cmes['smes'] ?></option>
							<?php endforeach ?>
						</select>
					 </div>
                     
                     <div class="col-xl-5"></div>
                    
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
                    <th scope="col" class="small">Aniversário</th>
                    <th scope="col" class="small">Email</th>
                    <th scope="col" class="small">Telefone</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $d): ?>
					<tr>
						<td nowrap><?php echo $d['cps'] ?></td>
						<td nowrap><?php echo $d['nps'] ?></td>
                        <td nowrap><?php echo $d['d_nasc'].'/'.$d['m_nasc'].'/'.$d['a_nasc'] ?></td>
						<td nowrap><?php if($d['email']) { echo '<a href=mailto:'.$d['email'].'>'.$d['email'].'</a>';} ?></td>
                        <td nowrap><input type="text" readonly class="form-control-plaintext p-0 m-0 phone" value="<?php echo $d['fone'] ?>"></input></td>
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