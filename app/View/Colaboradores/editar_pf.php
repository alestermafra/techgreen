<form action="<?php echo $this->url('/colaboradores/editar_pf/' . $colaborador['cps']) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Editar colaborador</span>
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
			Dados do colaborador
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="small text-muted">Nome</label>
				<input name="nps" type="text" class="form-control form-control-sm" placeholder="Nome completo" value="<?php echo _isset($_POST['nps'], $colaborador['nps']) ?>" autocomplete="off" required>
			</div>
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-6">
						<label class="small text-muted">CPF</label>
						<input name="cpf" type="text" class="form-control form-control-sm cpf-mask" placeholder="Insira o CPF" value="<?php echo _isset($_POST['cpf'], $colaborador['cpf']) ?>" autocomplete="off">
					</div>
					<div class="col-md-6">
						<label class="small text-muted">RG</label>
						<input name="rg" type="text" class="form-control form-control-sm" placeholder="Insira o RG" value="<?php echo _isset($_POST['rg'], $colaborador['rg']) ?>" autocomplete="off">
					</div>
				</div>
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
				<input name="email" type="text" class="form-control form-control-sm" placeholder="exemplo@exemplo.com.br" value="<?php echo _isset($_POST['email'], $colaborador['email']) ?>" autocomplete="off">
			</div>
			<div class="row">
				<div class="col-md-3">
					<label class="small text-muted">Tipo de Telefone</label>
				</div>
				<div class="col-md-9">
					<label class="small text-muted">Telefone</label>
				</div>
			</div>
			<?php
				$telefones = _isset($_POST['telefones'],  $colaborador['telefones']);
			?>
			<?php 
				if(is_array($telefones) && !empty($telefones)):
					foreach($telefones as $i => $telefone):
					$cfone = _isset($telefone['cfone'], false);
					if($cfone): ?>
						<input type="hidden" name="telefones[<?= $i ?>][cfone]" value="<?= $cfone ?>"></input>
					<?php endif; ?>
					<div class="form-row">
						<div class="form-group col-md-3">
							<select name="telefones[<?= $i ?>][ctfone]" class="form-control form-control-sm">
								<?php foreach($tipos_telefone as $t): ?>
									<option value="<?php echo $t['ctfone'] ?>"<?php echo $telefone['ctfone'] == $t['ctfone']? ' selected' : '' ?>><?php echo $t['ntfone'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group col-md-9">
							<input name="telefones[<?= $i ?>][fone]" type="text" class="form-control form-control-sm fone-mask" value="<?php echo $telefone['fone'] ?>"></input>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php for($i = sizeof($telefones); $i < 3; $i++): ?>
				<div class="form-row">
					<div class="form-group col-md-3">
						<select name="telefones[<?= $i ?>][ctfone]" class="form-control form-control-sm">
							<?php foreach($tipos_telefone as $t): ?>
								<option value="<?php echo $t['ctfone'] ?>"><?php echo $t['ntfone'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-md-9">
						<input name="telefones[<?= $i ?>][fone]" type="text" class="form-control form-control-sm fone-mask"></input>
					</div>
				</div>
			<?php endfor; ?>
		</div>
	</div>
	
	
	
	<div class="form-group text-right">
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/colaboradores/overview_pf/' . $colaborador['cps']) ?>">Cancelar</a>
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
	};
	
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