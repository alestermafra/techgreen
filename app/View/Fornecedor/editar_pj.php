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
                <div class="form-group">
				<label class="small text-muted">Especialidade</label>
				<input name="espec" type="text" class="form-control form-control-sm" placeholder="Eletricista, mecânico, etc" value="<?php echo _isset($_POST['espec'], $fornecedor['espec']) ?>" autocomplete="off" autofocus required>
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
					<input name="email" type="text" id="email-input" class="form-control form-control-sm" value="<?php echo _isset($_POST['email'], $fornecedor['email']) ?>" placeholder="exemplo@exemplo.com" autocomplete="off">
				</div>
				<div class="form-group">
					<?php if(empty(_isset($_POST['telefones'], $fornecedor['telefones']))): ?>
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
						<?php foreach(_isset($_POST['telefones'], $fornecedor['telefones']) as $i => $tel): ?>
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
		bindFoneMask();
		bindCNPJMask();
		$(".add-tel-form").click(add_tel_form);
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
		$("[name$='[fone]']").mask(fone_mask);
	}
	
	function bindCNPJMask() {
		$(".cnpj-mask").mask('00.000.000/0000-00');
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