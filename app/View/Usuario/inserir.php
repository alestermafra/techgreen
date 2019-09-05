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
					<label class="small text-muted">Nível de Acesso</label> 
					<select name="cna" id="nivel_acesso-select" class="form-control form-control-sm" required>
						<option disabled selected>Selecione</option>
						<?php foreach($niveis_acesso as $nivel_acesso): ?>
							<option
								value="<?php echo $nivel_acesso['cna'] ?>"
								<?php echo (_isset($_POST['cna'], 0) == $nivel_acesso['cna']? ' selected' : '') ?>
							>
								<?php echo $nivel_acesso['nna'] ?>
							</option>
						<?php endforeach ?>
					</select>
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