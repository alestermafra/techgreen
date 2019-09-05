<form action="<?php echo $this->url('/estoque/inserir_linha') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Inserir Linha</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/linhas') ?>">Cancelar</a>
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
					<label class="small text-muted">SubCategoria</label> 
					<input type="hidden" name="cscat" value="2" />
                    <input class="form-control form-control-sm" type="text" value="Produtos Internos" disabled="disabled" />
				</div>
				<div class="form-group form-row">
					<div class="col-2">
						<label class="small text-muted">Sigla</label> 
						<input name="slinha" type="text" class="form-control form-control-sm" placeholder="Sigla ou abreviação" autocomplete="off" maxlength="10"/>
					</div>
					<div class="col-10">
						<label class="small text-muted">Nome</label> 
						<input name="nlinha" type="text" class="form-control form-control-sm" placeholder="Nome da linha" autocomplete="off" required />
					</div>
				</div>
		  </div>
		</div>
		
		
		<div class="form-group">
			<label for="descricao-textarea" class="small text-muted">Descrição</label>
			<textarea name="descricao" class="form-control form-control-sm" rows="2" placeholder="(Opcional)"></textarea>
		</div>
        
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/linhas') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
		</div>
	</div>
</form>