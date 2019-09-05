<form action="<?php echo $this->url('/fornecedor/editar_pj/' . $fornecedor['cps']) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Editar Dados de Fornecedor</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/fornecedor/overview_pj/' . $fornecedor['cps']) ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir">
	</div>
</nav>

<?php if(isset($error)): ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<?php echo $error ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif ?>    

	<input type="hidden" name="cps" value="<?php echo $fornecedor['cps'] ?>">

	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Dados do Fornecedor
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Nome</label>
					<input name="nps" type="text" class="form-control form-control-sm" placeholder="Nome completo" value="<?php echo _isset($_POST['nps'], $fornecedor['nps']) ?>" autocomplete="off" required>
				</div>
				<div class="form-group">
					<label class="small text-muted">Tipo</label>
					<select name="ctfornec" class="form-control form-control-sm">
						<?php foreach($tipos_fornecedor as $tfornec): ?>
							<option value="<?= $tfornec['ctfornec']; ?>"<?= _isset($_POST['ctfornec'], $fornecedor['ctfornec']) == $tfornec['ctfornec']? ' selected' : '' ?>><?= $tfornec['ntfornec']; ?>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label class="small text-muted">CNPJ</label>
					<input name="cnpj" id="cnpj-input" type="text" class="form-control form-control-sm cnpj-mask" placeholder="Insira o CNPJ da empresa" value="<?php echo _isset($_POST['cnpj'], $fornecedor['cnpj']) ?>" autocomplete="off">
				</div>
			</div>
		</div>
		
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/fornecedor/overview_pj/' . $fornecedor['cps']) ?>">Cancelar</a>
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
		bindCNPJMask();
		$(".add-tel-form").click(add_tel_form);
	};
	
	
	function bindCNPJMask() {
		$(".cnpj-mask").mask('00.000.000/0000-00');
	}
})();
</script>