<form action="<?php echo $this->url('/painel/inserir_pj') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Cadastrar velejador</span>
</nav>

<?php if(isset($error)): ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<?php echo $error ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif ?>

<div class="container-fluid">
	<div class="card">
		<div class="card-header bg-dark text-white">
			Dados da empresa
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="small text-muted">Empresa</label>
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
				<label class="small text-muted">CNPJ</label>
				<input name="cnpj" type="text" class="form-control form-control-sm cnpj-mask" placeholder="Insira o CNPJ da empresa" value="<?php echo _isset($_POST['cnpj'], '') ?>" autocomplete="off">
			</div>
		</div>
	</div>
	
	<div class="form-group text-right">
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/painel/pj') ?>">Cancelar</a>
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
	};
	
	function bindCNPJMask() {
		$(".cnpj-mask").mask('00.000.000/0000-00');
	}
})();
</script>