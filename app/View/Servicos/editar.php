<form action="<?php echo $this->url('/servicos/editar') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Editar Produto / Serviço</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/servicos/') ?>">Cancelar</a>
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

	<input type="hidden" value="0" name="estoque" />
    <input type="hidden" value="<?=$produto['cprod']?>" name="cprod">

	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Detalhes
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Tipo/Linha</label> 
					<input type="hidden" name="clinha" value="<?=$produto['clinha']?>" />
                    <input class="form-control form-control-sm" type="text" value="<?=$produto['nlinha']?>" disabled="disabled" />
				</div>
                
				<div class="form-group form-row">
					<div class="col-2">
						<label class="small text-muted">Sigla</label> 
						<input name="sprod" type="text" class="form-control form-control-sm" placeholder="Sigla ou abreviação" autocomplete="off" maxlength="10" value="<?=$produto['sprod']?>"/>
					</div>
					<div class="col-10">
						<label class="small text-muted">Nome</label> 
						<input name="nprod" type="text" class="form-control form-control-sm" placeholder="Nome da linha" autocomplete="off" required value="<?=$produto['nprod']?>" />
					</div>
				</div>
		  </div>
		</div>
		
		
		<div class="form-group">
			<label for="descricao-textarea" class="small text-muted">Descrição</label>
			<textarea name="descricao" class="form-control form-control-sm" rows="2" placeholder="(Opcional)"><?=$produto['descricao']?></textarea>
		</div>
        
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/servicos/') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
		</div>
	</div>
</form>