<?php
	$permissoes = [
		'permission-agenda-view',
		'permission-agenda-add',
		'permission-agenda-edit',
		'permission-agenda-destroy',
		'permission-painel-view',
		'permission-painel-add',
		'permission-painel-edit',
		'permission-painel-destroy',
		'permission-brecho-view',
		'permission-brecho-add',
		'permission-brecho-edit',
		'permission-brecho-destroy',
		'permission-administracao-view',
		'permission-administracao-add',
		'permission-administracao-edit',
		'permission-administracao-destroy',
		'permission-guarderias-view',
		'permission-guarderias-add',
		'permission-guarderias-edit',
		'permission-guarderias-destroy',
		'permission-aulas-view',
		'permission-aulas-add',
		'permission-aulas-edit',
		'permission-aulas-destroy',
		'permission-locacoes-view',
		'permission-locacoes-add',
		'permission-locacoes-edit',
		'permission-locacoes-destroy',
		'permission-tabela_precos-view',
		'permission-tabela_precos-add',
		'permission-tabela_precos-edit',
		'permission-tabela_precos-destroy',
		'permission-relatorios-view',
		'permission-relatorios-add',
		'permission-relatorios-edit',
		'permission-relatorios-destroy',
		'permission-usuarios-view',
		'permission-usuarios-add',
		'permission-usuarios-edit',
		'permission-usuarios-destroy'
	];
?>

<form action="<?php echo $this->url('/usuario/inserir') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Novo Usuário</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/usuario') ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Inserir" />
	</div>
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
				Dados
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="nome-input" class="small text-muted">Nome</label> 
					<input name="nps" id="nome-input" type="text" class="form-control form-control-sm" placeholder="Nome completo" value="<?php echo _isset($_POST['nps'], '') ?>" autocomplete="off" autofocus required>
				</div>
				<div class="form-group">
					<label for="login-inpu" class="small text-muted">Login</label> 
					<input name="lg" id="login-input" type="text" class="form-control form-control-sm" placeholder="Ex: login@provedor.com" maxlength="50" value="<?php echo _isset($_POST['lg'], '') ?>" required autocomplete="off">
				</div>
				<div class="form-group">
					<label class="small text-muted">Senha</label> 
					<input name="pwd" id="senha-input" type="password" class="form-control form-control-sm" placeholder="Digite uma senha" maxlength="20" required>
				</div>
				<div class="form-group">
					<label class="small text-muted">Email</label> 
					<input name="email" id="email-input" type="email" class="form-control form-control-sm" placeholder="email@email.com" maxlength="50" value="<?php echo _isset($_POST['email'], '') ?>" required></input>
				</div>
				<div class="form-group">
					<label class="small text-muted">Admin?</label> 
					<select name="admin" id="admin-select" class="form-control form-control-sm">
						<option value="0">Não</option>
						<option value="1" <?= ($_POST['admin'] ?? 0) == 1? 'selected' : ''?>>Sim</option>
					</select>
				</div>
				<div class="form-group">
					<label class="small text-muted">Permissões (se não for admin)</label>
					<?php foreach($permissoes as $permissao): ?>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="permissoes[]" value="<?= $permissao ?>" id="<?= $permissao ?>-checkbox" <?= isset($_POST['permissoes']) && in_array($permissao, $_POST['permissoes'])? 'checked' : '' ?>>
							<label class="form-check-label" for="<?= $permissao ?>-checkbox">
								<?= $permissao ?>
							</label>
						</div>
					<?php endforeach ?>
				</div>
		  </div>
		</div>
		
		<br>
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/usuario') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Inserir"/>
		</div>
	</div>
</form>