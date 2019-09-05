<form action="<?php echo $this->url('/contatos/inserir/' . $pessoa['cps']) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Cadastrar contato</span>
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
			Dados do contato
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="small text-muted">Empresa</label> <?php echo $pessoa['nps'] ?>
			</div>
			<div class="form-group">
				<label class="small text-muted">Nome</label>
				<input name="nps" type="text" class="form-control form-control-sm" placeholder="Nome do Contato" value="<?php echo _isset($_POST['nps'], '') ?>" autocomplete="off" autofocus required>
			</div>
			<div class="row">
				<div class="col-md-4 form-group">
					<label class="small text-muted">Cargo</label>
					<input name="profissao" type="text" class="form-control form-control-sm" placeholder="Cargo do Contato" value="<?php echo _isset($_POST['profissao'], '') ?>" autocomplete="off">
				</div>
				<div class="col-md-4 form-group">
					<label class="small text-muted">E-mail</label>
					<input name="email" type="text" class="form-control form-control-sm" placeholder="E-mail do Contato" value="<?php echo _isset($_POST['email'], '') ?>" autocomplete="off">
				</div>
				<div class="col-md-4 form-group">
					<label class="small text-muted">Telefone</label>
					<input name="telefones[0][ctfone]" type="hidden" value="5"></input>
					<input name="telefones[0][fone]" type="text" class="form-control form-control-sm fone-mask" value="<?php echo _isset($_POST['telefone']['fone'], '') ?>" autocomplete="off"></input>
				</div>
			</div>
		</div>
	</div>
</div>
        	
<div class="container-fluid">
	<div class="form-group text-right">
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/contatos/back/' . $pessoa['cps']) ?>">Cancelar</a>
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
