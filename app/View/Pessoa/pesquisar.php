<h2 style="padding: 20px; font-weight: lighter;">Pesquisar Pessoa</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/pessoa/listar_pesquisa') ?>" method="POST">
		<div class="form-row">
			<div class="form-group col-md-2">
				<label for="cps">ID</label>
				<input name="cps" id="cps" type="number" class="form-control"  placeholder="ID" maxlength="11" min="1"></input>
			</div>
			
			<div class="form-group col-md-9">
				<label for="nps">Nome</label>
				<input name="nps" id="nps" type="text" class="form-control" placeholder="Nome/Parte do nome" maxlength="100" autofocus></input>
			</div>
		</div>
		
		<small class="form-text text-muted">Insira um dos campos acima e clique no botão <b>Pesquisar</b>. Caso insira os dois, o ID terá prioridade.</small>
		
		<br />
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/pessoa') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-light">Pesquisar</button>
	</form>
</div>