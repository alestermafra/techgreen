<form action="<?php echo $this->url('/pertences/inserir/') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Cadastrar equipamento</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/equipamentos/view/' . $cequip) ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
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
			Detalhes
        </div>		
		
		<div class="card-body">
			<div class="form-group">
				<label><small>Embarcação</small></label>
				<select name="cequipe" class="form-control form-control-sm">
					<option value="0">Selecione</option>
					<?php foreach($equipamentos as $equip): ?>
						<option value="<?php echo $equip['cequipe'] ?>"<?php echo $equip['cequipe'] === $cequip? ' selected' : '' ?>><?php echo $equip['nome'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="form-group">
				<label for="npertence-input"><small>Nome do equipamento</small></label>
				<input name="npertence" id="npertence-input" type="text" class="form-control form-control-sm" placeholder="Nome do pertence" autocomplete="off" value="<?php echo _isset($_POST['npertence'], '') ?>" autofocus></input>
			</div>
			<div class="form-group">
				<label for="marca-input"><small>Marca</small></label>
				<input name="marca" id="marca-input" type="text" class="form-control form-control-sm" placeholder="Marca do pertence" autocomplete="off" value="<?php echo _isset($_POST['marca'], '') ?>"></input>
			</div>
			<div class="form-group">
				<label for="modelo-input"><small>Modelo</small></label>
				<input name="modelo" id="modelo-input" type="text" class="form-control form-control-sm" placeholder="Modelo do pertence" autocomplete="off" value="<?php echo _isset($_POST['modelo'], '') ?>"></input>
			</div>
			<div class="form-group">
				<label for="tamanho-input"><small>Tamanho</small></label>
				<input name="tamanho" id="tamanho-input" type="text" class="form-control form-control-sm" placeholder="Tamanho do pertence" autocomplete="off" value="<?php echo _isset($_POST['tamanho'], '') ?>"></input>
			</div>
			<div class="form-group">
				<label for="cor-input"><small>Cor</small></label>
				<input name="cor" id="cor-input" type="text" class="form-control form-control-sm" placeholder="Cor do pertence" autocomplete="off" value="<?php echo _isset($_POST['cor'], '') ?>"></input>
			</div>
			<div class="form-group">
				<label for="ano-input"><small>Ano</small></label>
				<input name="ano" id="ano-input" type="text" class="form-control form-control-sm" placeholder="Ano do pertence" autocomplete="off" value="<?php echo _isset($_POST['ano'], '') ?>"></input>
			</div>
			<div class="form-group">
				<label for="estado_geral-select"><small>Estado</small></label>
				<select name="estado_geral" id="estado_geral-select" class="form-control form-control-sm">
                	<option value="Excelente"<?php echo _isset($_POST['estado_geral'], 0) == 'Excelente'? ' selected' : '' ?>>Excelente</option>
					<option value="Bom"<?php echo _isset($_POST['estado_geral'], 0) == 'Bom'? ' selected' : '' ?>>Bom</option>
					<option value="Médio"<?php echo _isset($_POST['estado_geral'], 0) == 'Médio'? ' selected' : '' ?>>Médio</option>
					<option value="Ruim"<?php echo _isset($_POST['estado_geral'], 0) == 'Ruim'? ' selected' : '' ?>>Ruim</option>
				</select>
			</div>
		</div>
	</div>	
	
	<br/>
	
	<div class="form-group text-right">	
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/equipamentos/view/' . $cequip) ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
	</div>
	
</div>
</form>