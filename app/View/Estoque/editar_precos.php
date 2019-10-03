<form action="<?php echo $this->url('/estoque/editar_precos/') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Editar Preço de Produto</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/precos/') ?>">Cancelar</a>
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

    <input type="hidden" value="<?=$produto['cprodd']?>" name="cprodd">

	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Detalhes
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Produto</label> 
					<input type="hidden" name="cprod" value="<?=$produto['cprod']?>" />
                    <input class="form-control form-control-sm" type="text" value="<?=$produto['nprod']?>" disabled="disabled" />
				</div>
                
                <div class="form-group">
					<label class="small text-muted">Tabela</label> 
                    <input class="form-control form-control-sm" type="text" value="<?=$produto['ntabela']?>" disabled="disabled" />
				</div>
                
                <div class="form-group">
					<label class="small text-muted">Plano</label> 
                    <input class="form-control form-control-sm" type="text" value="<?=$produto['nplano']?>" disabled="disabled" />
				</div>
                
                <div class="form-group">
					<label class="small text-muted">Valor</label> 
                    <input type="text" name="valor" id="valor-input" class="form-control form-control-sm" placeholder="R$" value="<?=$produto['valor']?>" />
				</div>
		  </div>
		</div>
		
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/precos/') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
		</div>
	</div>
</form>