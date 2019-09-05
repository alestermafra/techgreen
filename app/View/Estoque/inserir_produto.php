<form action="<?php echo $this->url('/estoque/inserir_produto') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Inserir Produto</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/produtos') ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
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

	<input type="hidden" value="1" name="estoque" />

	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Detalhes
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Linha / Tipo</label> 
					<select name="clinha" class="form-control form-control-sm" autofocus>
						<?php foreach($linhas as $l): ?>
							<option value="<?php echo $l['clinha'] ?>">
								<?php echo $l['nlinha'] ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group form-row">
					<div class="col-2">
						<label class="small text-muted">Sigla</label> 
						<input name="sprod" type="text" class="form-control form-control-sm" placeholder="Sigla ou abreviação" autocomplete="off" maxlength="10"/>
					</div>
					<div class="col-10">
						<label class="small text-muted">Nome</label> 
						<input name="nprod" type="text" class="form-control form-control-sm" placeholder="Nome do produto" autocomplete="off" required />
					</div>
				</div>
		  </div>
		</div>
		
		
		<div class="form-group">
			<label for="descricao-textarea" class="small text-muted">Descrição</label>
			<textarea name="descricao" class="form-control form-control-sm" rows="2" placeholder="(Opcional)"></textarea>
		</div>
        
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/produtos') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
		</div>
	</div>
</form>