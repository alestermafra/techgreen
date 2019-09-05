<form action="<?php echo $this->url('/fornecedor/inserir_pj') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Cadastrar fornecedor</span>
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
			Dados da empresa
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="small text-muted">Fornecedor</label>
				<input name="nps" type="text" class="form-control form-control-sm" placeholder="Nome da empresa" value="<?php echo _isset($_POST['nps'], '') ?>" autocomplete="off" autofocus required>
			</div>
			<div class="form-group">
				<label class="small text-muted">Tipo</label>
				<select name="ctfornec" class="form-control form-control-sm">
					<?php foreach($tipos_fornecedor as $tfornec): ?>
						<option value="<?= $tfornec['ctfornec']; ?>"<?= _isset($_POST['ctfornec'], 0) == $tfornec['ctfornec']? ' selected' : '' ?>><?= $tfornec['ntfornec']; ?>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label class="small text-muted">CNPJ</label>
				<input name="cnpj" type="text" class="form-control form-control-sm" placeholder="CNPJ da empresa" value="<?php echo _isset($_POST['cnpj'], '') ?>" autocomplete="off">
			</div>
            <div class="form-group">
				<label class="small text-muted">Especialidade</label>
				<input name="espec" type="text" class="form-control form-control-sm" placeholder="Eletricista, mecânico, etc" value="<?php echo _isset($_POST['espec'], '') ?>" autocomplete="off" autofocus required>
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
				<input name="email" type="text" class="form-control form-control-sm" placeholder="exemplo@exemplo.com.br" value="<?php echo _isset($_POST['email'], '') ?>" autocomplete="off">
			</div>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label class="small text-muted">Tipo de Telefone</label>
					<select name="telefones[0][ctfone]" class="form-control form-control-sm">
						<?php foreach($tipos_telefone as $t): ?>
							<option value="<?php echo $t['ctfone'] ?>"<?php echo isset($_POST['telefones'][0]['ctfone']) && $t['ctfone'] == $_POST['telefones'][0]['ctfone']? ' selected' : ($t['ctfone'] == 5? 'selected' : '') ?>><?php echo $t['ntfone'] ?></option>
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
					<select name="telefones[1][ctfone]" class="form-control form-control-sm">
						<?php foreach($tipos_telefone as $t): ?>
							<option value="<?php echo $t['ctfone'] ?>"<?php echo isset($_POST['telefones'][1]['ctfone']) && $t['ctfone'] == $_POST['telefones'][1]['ctfone']? ' selected' : ($t['ctfone'] == 4? 'selected' : '') ?>><?php echo $t['ntfone'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group col-md-9">
					<input name="telefones[1][fone]" type="text" class="form-control form-control-sm fone-mask" value="<?php echo _isset($_POST['telefones'][1]['fone'], '') ?>"></input>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-3">
					<select name="telefones[1][ctfone]" class="form-control form-control-sm">
						<?php foreach($tipos_telefone as $t): ?>
							<option value="<?php echo $t['ctfone'] ?>"<?php echo isset($_POST['telefones'][1]['ctfone']) && $t['ctfone'] == $_POST['telefones'][1]['ctfone']? ' selected' : ($t['ctfone'] == 4? 'selected' : '') ?>><?php echo $t['ntfone'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group col-md-9">
					<input name="telefones[1][fone]" type="text" class="form-control form-control-sm fone-mask" value="<?php echo _isset($_POST['telefones'][1]['fone'], '') ?>"></input>
				</div>
			</div>
		</div>
	</div>
	
	<div class="form-group text-right">
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/fornecedor/fornecedores_pj') ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir">
	</div>
</div>
	
</form>

<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
		bindFoneMask();
		init();
	});
	
	function bindEvents() {
		/* mask */
		$("[name='cnpj']").mask((val) => val.length <= 18 ? '00.000.000/0000-00' : '00.000.000/0000-00');
	};
	
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
	
	function init() {
		
	};
})();
</script>