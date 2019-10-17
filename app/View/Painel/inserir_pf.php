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

<form action="<?php echo $this->url('/painel/inserir_pf') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Cadastrar cliente</span>
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
				Dados Pessoais
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Nome</label>
					<input name="nps" type="text" class="form-control form-control-sm" placeholder="Nome completo" value="<?php echo _isset($_POST['nps'], '') ?>" autocomplete="off" autofocus required>
				</div>
				<div class="form-group">
					<label class="small text-muted">Classificação</label>
					<select name="cseg" class="form-control form-control-sm">
						<?php foreach($segmentacoes as $seg): ?>
							<option value="<?php echo $seg['cseg'] ?>"<?php echo isset($_POST['cseg']) && $seg['cseg'] == $_POST['cseg']? ' selected' : '' ?>><?php echo $seg['nseg'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-sm-6">
							<label class="small text-muted">CPF</label>
							<input name="cpf" type="text" class="form-control form-control-sm" placeholder="Insira o CPF do cliente" value="<?php echo _isset($_POST['cpf'], '') ?>" autocomplete="off">
						</div>
						<div class="col-sm-6">
							<label class="small text-muted">RG</label>
							<input name="rg" type="text" class="form-control form-control-sm" placeholder="Insira o RG do cliente" value="<?php echo _isset($_POST['rg'], '') ?>" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="small text-muted">Profissão</label>
					<input name="profissao" type="text" class="form-control form-control-sm" placeholder="Profissão do cliente" value="<?php echo _isset($_POST['profissao'], '') ?>">
				</div>
				<div class="form-group">
					<label class="small text-muted">Data de Nascimento</label>
					<div class="form-row">
						<div class="col">
							<select name="d_nasc" id="d_nasc-input" class="form-control form-control-sm">
								<option value="0">Dia</option>
								<?php for($d = 1; $d <= 31; $d++): ?>
									<option value="<?php echo $d ?>"<?php echo isset($_POST['d_nasc']) && $d == $_POST['d_nasc']? ' selected' : '' ?>><?php echo str_pad($d, 2, '0', STR_PAD_LEFT) ?></option>
								<?php endfor ?>
							</select>
						</div>
						<div class="col">
							<select name="m_nasc" class="form-control form-control-sm">
								<option value="0">Mês</option>
								<?php $nome_meses = [1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']; ?>
								<?php for($m = 1; $m <= 12; $m++): ?>
									<option value="<?php echo $m ?>"<?php echo isset($_POST['m_nasc']) && $m == $_POST['m_nasc']? ' selected' : '' ?>><?php echo $nome_meses[$m] ?></option>
								<?php endfor ?>
							</select>
						</div>
						<div class="col">
							<select name="a_nasc" class="form-control form-control-sm">
								<option value="0">Ano</option>
								<?php for($y = date('Y'); $y >= date('Y') - 100; $y--): ?>
									<option value="<?php echo $y ?>"<?php echo isset($_POST['a_nasc']) && $y == $_POST['a_nasc']? ' selected' : '' ?>><?php echo $y ?></option>
								<?php endfor ?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-6">
							<label class="small text-muted">Peso</label>
							<input name="peso" id="peso-input" type="text" class="form-control form-control-sm" placeholder="Peso (kg)" value="<?php echo _isset($_POST['peso'], '') ?>" autocomplete="off">
						</div>
						<div class="col-md-6">
							<label class="small text-muted">Equipe</label>
							<input name="equipe" id="equipe-input" type="text" class="form-control form-control-sm" placeholder="Equipe" value="<?php echo _isset($_POST['equipe'], '') ?>" autocomplete="off">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="small text-muted">Dependentes</label>
					<input name="dependente1" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente1'], '') ?>" autocomplete="off"></input>
				</div>
				<div class="form-group">
					<input name="dependente2" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente2'], '') ?>" autocomplete="off"></input>
				</div>
				<div class="form-group">
					<input name="dependente3" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente3'], '') ?>" autocomplete="off"></input>
				</div>
				<div class="form-group">
					<input name="dependente4" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente4'], '') ?>" autocomplete="off"></input>
				</div>
				<div class="form-group">
					<input name="dependente5" type="text" class="form-control form-control-sm" placeholder="Nome do dependente (grau familiar/conhecido)" value="<?php echo _isset($_POST['dependente5'], '') ?>" autocomplete="off"></input>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Informações de Contato
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Email</label>
					<input name="email" type="text" id="email-input" class="form-control form-control-sm" placeholder="exemplo@exemplo.com" value="<?php echo _isset($_POST['email'], '') ?>" autocomplete="off">
				</div>
				<div class="form-row">
					<div class="form-group col-md-3">
						<label class="small text-muted">Tipo de Telefone</label>
						<select name="telefones[0][ctfone]" class="form-control form-control-sm">
							<?php foreach($tipos_telefone as $t): ?>
								<option value="<?php echo $t['ctfone'] ?>"<?php echo isset($_POST['telefones'][0]['ctfone']) && $t['ctfone'] == $_POST['telefones'][0]['ctfone']? ' selected' : '' ?>><?php echo $t['ntfone'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-md-9">
						<label class="small text-muted">Telefone</label>
						<input name="telefones[0][fone]" type="text" class="form-control form-control-sm fone-mask" value="<?php echo _isset($_POST['telefones'][0]['fone'], '') ?>"></input>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-3">
						<label class="small text-muted">Tipo de Telefone</label>
						<select name="telefones[1][ctfone]" class="form-control form-control-sm">
							<?php foreach($tipos_telefone as $t): ?>
								<option value="<?php echo $t['ctfone'] ?>"<?php echo isset($_POST['telefones'][1]['ctfone']) && $t['ctfone'] == $_POST['telefones'][1]['ctfone']? ' selected' : '' ?>><?php echo $t['ntfone'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-md-9">
						<label class="small text-muted">Telefone</label>
						<input name="telefones[1][fone]" type="text" class="form-control form-control-sm fone-mask" value="<?php echo _isset($_POST['telefones'][1]['fone'], '') ?>"></input>
					</div>
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
					<div class="col-md-3">
						<div class="form-check">
							<input type="checkbox" name="canais[<?php echo $i ?>][ccanal]" value="<?php echo $c['ccanal'] ?>"></input>
							<label class="form-check-label"><?php echo $c['ncanal'] ?></label>
							<?php if($c['flg_obs']): ?>
								<input type="text" class="form-control form-control-sm" name="canais[<?php echo $i ?>][OBS]" value="<?php echo _isset($_POST['canais'][$i]['OBS']) ?>"></input>
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
							<div class="col-md-3">
								<div class="form-check">
									<input type="checkbox" name="interesses[<?= $i; ?>][ctinteresse]" value="<?= $interesse["ctinteresse"] ?>"<?= isset($_POST['interesses'][$i]['ctinteresse'])? 'checked' : '' ?>></input>
									<label class="form-check-label"><?= $interesse["ntinteresse"] ?></label>
								</div>
							</div>
						<?php $i++; endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/painel/pf') ?>">Cancelar</a>
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
		bindCPFMask();
		bindFoneMask();
	}
	
	function bindCPFMask() {
		$(".cpf-mask").mask("000.000.000.00");
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
		$(".fone-mask").mask(fone_mask);
	}
})();
</script>
