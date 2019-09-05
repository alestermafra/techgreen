<h2 style="padding: 20px; font-weight: lighter;">Pesquisar Setor</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/setor/listar_pesquisa') ?>" method="POST">
		<div class="form-row">
			<div class="form-group col-md-2">
				<label for="cset">ID</label>
				<input name="cset" id="cset" type="number" class="form-control"  placeholder="ID" maxlength="11" min="1"></input>
			</div>
			
			<div class="form-group col-md-9">
				<label for="nset">Nome</label>
				<input name="nset" id="nset" type="text" class="form-control" placeholder="Nome/Parte do nome do setor" maxlength="100" autofocus></input>
			</div>
		</div>
		
		<small class="form-text text-muted">Insira um dos campos acima e clique no botão <b>Pesquisar</b>. Caso insira os dois, o ID terá prioridade.</small>
		
		<br />
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/setor') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-light">Pesquisar</button>
	</form>
</div>