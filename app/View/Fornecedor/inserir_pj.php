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
		init();
	});
	
	function bindEvents() {
		/* mask */
		$("[name='cnpj']").mask((val) => val.length <= 18 ? '00.000.000/0000-00' : '00.000.000/0000-00');
	};
	
	function init() {
		
	};
})();
</script>