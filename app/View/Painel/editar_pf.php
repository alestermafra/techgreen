<?php
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
?>

<form action="<?php echo $this->url('/painel/editar_pf/' . $clientepf['cps']) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Editar velejador</span>
</nav>

<?php if(isset($error)): ?>
	<div class="container-fluid">
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?php echo $error ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
<?php endif ?>

<div class="container-fluid">
	<div class="card">
		<div class="card-header bg-dark text-white">
			Dados pessoais
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="small text-muted">Nome</label>
				<input name="nps" type="text" class="form-control form-control-sm" placeholder="Nome completo" value="<?php echo _isset($_POST['nps'], $clientepf['nps']) ?>" autocomplete="off" required>
			</div>
			<div class="form-group">
				<label class="small text-muted">Classificação</label>
				<select name="cseg" class="form-control form-control-sm">
					<?php foreach($segmentacoes as $seg): ?>
						<option value="<?php echo $seg['cseg'] ?>"<?php echo $seg['cseg'] == _isset($_POST['cseg'], $clientepf['cseg'])? ' selected' : '' ?>><?php echo $seg['nseg'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="form-group">
				<div class="form-row">
					<div class="col-sm-6">
						<label class="small text-muted">CPF</label>
						<input name="cpf" type="text" class="form-control form-control-sm cpf-mask" placeholder="Insira o CPF do cliente" value="<?php echo _isset($_POST['cpf'], $clientepf['cpf']) ?>" autocomplete="off">
					</div>
					<div class="col-sm-6">
						<label class="small text-muted">RG</label>
						<input name="rg" type="text" class="form-control form-control-sm" placeholder="Insira o RG do cliente" value="<?php echo _isset($_POST['rg'], $clientepf['rg']) ?>" autocomplete="off">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="small text-muted">Profissão</label>
				<input name="profissao" type="text" class="form-control form-control-sm" placeholder="Profissão do cliente" value="<?php echo _isset($_POST['profissao'], $clientepf['profissao']) ?>"/>
			</div>
			<div class="form-group">
				<label class="small text-muted">Data de Nascimento</label>
				<div class="form-row">
					<div class="col">
						<select name="d_nasc" id="d_nasc-input" class="form-control form-control-sm">
							<option value="0">Dia</option>
							<?php for($d = 1; $d <= 31; $d++): ?>
								<option value="<?php echo $d ?>"<?php echo $d == _isset($_POST['d_nasc'], $clientepf['d_nasc'])? ' selected' : '' ?>><?php echo str_pad($d, 2, '0', STR_PAD_LEFT) ?></option>
							<?php endfor ?>
						</select>
					</div>
					<div class="col">
						<select name="m_nasc" class="form-control form-control-sm">
							<option value="0">Mês</option>
							<?php $nome_meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']; ?>
							<?php for($m = 1; $m <= 12; $m++): ?>
								<option value="<?php echo $m ?>"<?php echo $m == _isset($_POST['m_nasc'], $clientepf['m_nasc'])? ' selected' : '' ?>><?php echo $nome_meses[$m] ?></option>
							<?php endfor ?>
						</select>
					</div>
					<div class="col">
						<select name="a_nasc" class="form-control form-control-sm">
							<option value="0">Ano</option>
							<?php for($y = date('Y'); $y >= date('Y') - 100; $y--): ?>
								<option value="<?php echo $y ?>"<?php echo $y == _isset($_POST['a_nasc'], $clientepf['a_nasc'])? ' selected' : '' ?>><?php echo $y ?></option>
							<?php endfor ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-6">
						<label class="small text-muted">Peso</label>
						<input name="peso" id="peso-input" type="text" class="form-control form-control-sm" placeholder="Peso (kg)" value="<?php echo _isset($_POST['peso'], $clientepf['peso']) ?>" autocomplete="off">
					</div>
					<div class="col-md-6">
						<label class="small text-muted">Equipe</label>
						<input name="equipe" id="equipe-input" type="text" class="form-control form-control-sm" placeholder="Equipe" value="<?php echo _isset($_POST['equipe'], $clientepf['equipe']) ?>" autocomplete="off">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="small text-muted">Dependentes</label>
				<input name="dependente1" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente1'], $clientepf['dependente1']) ?>" autocomplete="off"></input>
			</div>
			<div class="form-group">
				<input name="dependente2" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente2'], $clientepf['dependente2']) ?>" autocomplete="off"></input>
			</div>
			<div class="form-group">
				<input name="dependente3" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente3'], $clientepf['dependente3']) ?>" autocomplete="off"></input>
			</div>
			<div class="form-group">
				<input name="dependente4" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente4'], $clientepf['dependente4']) ?>" autocomplete="off"></input>
			</div>
			<div class="form-group">
				<input name="dependente5" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente5'], $clientepf['dependente5']) ?>" autocomplete="off"></input>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header bg-dark text-white">
			Informações de contato
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="small text-muted">Email</label>
				<input name="email" type="text" id="email-input" class="form-control form-control-sm" value="<?php echo _isset($_POST['email'], $clientepf['email']) ?>" placeholder="exemplo@exemplo.com" autocomplete="off">
			</div>
			<div class="form-group">
				<?php if(empty(_isset($_POST['telefones'], $clientepf['telefones']))): ?>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label class="small text-muted">Tipo de Telefone</label>
							<select name="telefones[0][ctfone]" class="form-control form-control-sm">
								<?php foreach($tipos_telefone as $t): ?>
									<option value="<?php echo $t['ctfone'] ?>"><?php echo $t['ntfone'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group col-md-9">
							<label class="small text-muted">Telefone</label>
							<input name="telefones[0][fone]" type="text" class="form-control form-control-sm mask-fone"></input>
						</div>
					</div>
				<?php else: ?>
					<?php foreach(_isset($_POST['telefones'], $clientepf['telefones']) as $i => $tel): ?>
						<div class="form-row">
							<?php if(isset($tel['cfone'])): ?>
								<input name="telefones[<?php echo $i ?>][cfone]" type="hidden" value="<?php echo $tel['cfone'] ?>"></input>
							<?php endif ?>
							<input name="telefones[<?php echo $i ?>][flg_principal]" type="hidden" value="<?php echo $tel['flg_principal'] ?>"></input>
							<div class="form-group col-md-3">
								<?php if($i === 0): ?><label class="small text-muted">Tipo de Telefone</label><?php endif ?>
								<select name="telefones[<?php echo $i ?>][ctfone]" class="form-control form-control-sm">
									<?php foreach($tipos_telefone as $t): ?>
										<option value="<?php echo $t['ctfone'] ?>"<?php echo $t['ctfone'] == $tel['ctfone']? ' selected' : '' ?>><?php echo $t['ntfone'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group col-md-9">
								<?php if($i === 0): ?><label class="small text-muted">Número de Telefone</label><?php endif ?>
								<input name="telefones[<?php echo $i ?>][fone]" type="text" class="form-control form-control-sm mask-fone" value="<?php echo $tel['fone'] ?>"></input>
							</div>
						</div>
					<?php endforeach ?>
				<?php endif; ?>
				
				<template id="tel-tmplt">
					<div class="form-row">
						<div class="form-group col-md-3">
							<input name="telefones[{{index}}][flg_principal]" type="hidden" value="0"></input>
							<select name="telefones[{{index}}][ctfone]" class="form-control form-control-sm">
								<?php foreach($tipos_telefone as $t): ?>
									<option value="<?php echo $t['ctfone'] ?>"><?php echo $t['ntfone'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group col-md-9">
							<input name="telefones[{{index}}][fone]" type="text" class="form-control form-control-sm mask-fone"></input>
						</div>
					</div>
				</template>
				
				<div id="outros-telefones-container"></div>
				
				<div style="text-align: right">
					<button type="button" class="btn btn-sm btn-link add-tel-form">Adicionar Telefone</button>
				</div>
			</div>
		</div>
	</div>
    
    <div class="card">
    	<div class="card-header bg-dark text-white">
        	Primeiro contato
        </div>
        <div class="card-body">
        	<div class="form-group">
            	<label class="small text-muted">Data do primeiro contato</label>
                	<div class="form-row">
                    	<div class="col">
                        	<select name="d_contato" id="d_contato-input" class="form-control form-control-sm">
                            <option value="0">Dia</option>
                           <?php for($d = 1; $d <= 31; $d++): ?>
								<option value="<?php echo $d ?>"<?php echo $d == _isset($_POST['d_contato'], $clientepf['d_contato'])? ' selected' : '' ?>><?php echo str_pad($d, 2, '0', STR_PAD_LEFT) ?></option>
							<?php endfor ?>
                            </select>
                         </div>
                         <div class="col">
                         	<select name="m_contato" class="form-control form-control-sm">
                            <option value="0">Mês</option>
                            <?php $nome_meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']; ?>
							<?php for($m = 1; $m <= 12; $m++): ?>
								<option value="<?php echo $m ?>"<?php echo $m == _isset($_POST['m_contato'], $clientepf['m_contato'])? ' selected' : '' ?>><?php echo $nome_meses[$m] ?></option>
							<?php endfor ?>
                            </select>
                         </div>
                         <div class="col">
                         	<select name="a_contato" class="form-control form-control-sm">
                            <option value="0">Ano</option>
                            <?php for($y = date('Y'); $y >= date('Y') - 100; $y--): ?>
								<option value="<?php echo $y ?>"<?php echo $y == _isset($_POST['a_contato'], $clientepf['a_contato'])? ' selected' : '' ?>><?php echo $y ?></option>
							<?php endfor ?>
                            </select>
                         </div>
             		</div>
        		</div>
    		</div>
    </div>
	
    <div class="card">
		<div class="card-header bg-dark text-white">
			Canais de Contato
		</div>
		<div class="card-body">
			<div class="form-row">
			<?php foreach($canais_contato as $a => $c_c): ?>
				<?php
					$czcanalcontato = false;
					$obscontato = '';
					foreach($clientepf['canais_contato'] as $cliente_canalcontato) {
						if($cliente_canalcontato['ccanalcontato'] == $c_c['ccanalcontato']) {
							$czcanalcontato = $cliente_canalcontato['czcanalcontato'];
							if($c_c['flg_obs'] == 1) {
								$obscontato = $cliente_canalcontato['OBS'];
							}
							break;
						}
					}
				?>
				<div class="col-md-3">
					<div class="form-check">
						<?php if($czcanalcontato): ?>
							<input type="hidden" name="canais_contato[<?php echo $a ?>][czcanalcontato]" value="<?php echo $czcanalcontato ?>"></input>
						<?php endif ?>
						<input type="checkbox" name="canais_contato[<?php echo $a ?>][ccanalcontato]" value="<?php echo $c_c['ccanalcontato'] ?>"<?php echo $czcanalcontato? ' checked' : '' ?>></input>
						<label class="form-check-label"><?php echo $c_c['ncanalcontato'] ?></label>
						<?php if($c_c['flg_obs']): ?>
							<input type="text" class="form-control form-control-sm" name="canais_contato[<?php echo $a ?>][OBS]" value="<?php echo $obscontato ?>"></input>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>
			</div>
		</div>
	</div>
    
	<div class="card">
		<div class="card-header bg-dark text-white">
			Canais de conhecimento
		</div>
		<div class="card-body">
			<div class="form-row">
			<?php foreach($canais as $i => $c): ?>
				<?php
					$czcanal = false;
					$obs = '';
					foreach($clientepf['canais'] as $cliente_canal) {
						if($cliente_canal['ccanal'] == $c['ccanal']) {
							$czcanal = $cliente_canal['czcanal'];
							if($c['flg_obs'] == 1) {
								$obs = $cliente_canal['OBS'];
							}
							break;
						}
					}
				?>
				<div class="col-md-3">
					<div class="form-check">
						<?php if($czcanal): ?>
							<input type="hidden" name="canais[<?php echo $i ?>][czcanal]" value="<?php echo $czcanal ?>"></input>
						<?php endif ?>
						<input type="checkbox" name="canais[<?php echo $i ?>][ccanal]" value="<?php echo $c['ccanal'] ?>"<?php echo $czcanal? ' checked' : '' ?>></input>
						<label class="form-check-label"><?php echo $c['ncanal'] ?></label>
						<?php if($c['flg_obs']): ?>
							<input type="text" class="form-control form-control-sm" name="canais[<?php echo $i ?>][OBS]" value="<?php echo $obs ?>"></input>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header bg-dark text-white">
			Interesses
		</div>
		<div class="card-body">
			<?php $i = 0; foreach($interesses_por_categoria as $categoria => $interesses): ?>
				<h5><?= $categoria ?></h5>
				<div class="form-row">
					<?php foreach($interesses as $interesse): ?>
						<?php
							$czinteresse = false;
							foreach($clientepf['interesses'] as $cliente_interesse) {
								if($cliente_interesse['ctinteresse'] == $interesse['ctinteresse']) {
									$czinteresse = $cliente_interesse['czinteresse'];
								}
							}
						?>
						<div class="col-md-3">
							<div class="form-check">
								<?php if($czinteresse): ?>
									<input type="hidden" name="interesses[<?php echo $i ?>][czinteresse]" value="<?php echo $czinteresse ?>"></input>
								<?php endif ?>
								<input type="checkbox" name="interesses[<?= $i; ?>][ctinteresse]" value="<?= $interesse["ctinteresse"] ?>"<?= _isset($_POST['interesses'][$i]['ctinteresse'], $czinteresse)? 'checked' : '' ?>></input>
								<label class="form-check-label"><?= $interesse["ntinteresse"] ?></label>
							</div>
						</div>
					<?php $i++; endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="card">
		<div class="card-header bg-dark text-white">
			Observação
		</div>
		<div class="card-body">
			<div class="form-group">
				<textarea name="observacao" class="form-control form-control-sm" placeholder="Oservação"><?= $_POST['observacao'] ?? $clientepf['observacao'] ?? '' ?></textarea>
			</div>
		</div>
	</div>

	
	<div class="form-group text-right">
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/painel/overview_pf/'.$clientepf['cps']) ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir">
	</div>
</div>
	
</form>

<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
	});
	
	function bindEvents() {
		bindFoneMask();
		bindCPFMask();
		$(".add-tel-form").click(add_tel_form);
	};
	

	function bindCPFMask() {
		$(".cpf-mask").mask('000.000.000-00');
	}
	
	function bindFoneMask() {
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
		$("[name$='[fone]']").mask(fone_mask);
	}
	
	function add_tel_form() {
		var index = $("[name$='\\[fone\\]']").length;
		
		var tmplt = $("#tel-tmplt").html();
		var html = tmplt.replace(/{{index}}/g, index);
		
		$("#outros-telefones-container").append(html);
		bindFoneMask();
	};
})();
</script>
