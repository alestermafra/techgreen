<h2 style="padding: 20px; font-weight: lighter;">Novo Distrito</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/distrito/confirmarInsercao') ?>" method="POST">
		<div class="form-group">
			<label for="crei">Região</label>
			<select name="crei" id="crei" class="form-control">
				<?php  
					foreach($regioes as $u){
						echo '<option value="' . $u['crei'].'">' . $u['nrei'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="sdio">Sigla</label>
			<input name="sdio" id="sdio" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10"></input>
		</div>
		
		<div class="form-group">
			<label for="ndio">Nome</label>
			<input name="ndio" id="ndio" type="text" class="form-control" placeholder="Nome do Distrito" maxlength="100" required autofocus></input>
		</div>
		
		<div class="form-group">
			<label for="OBS">Obs.</label>
			<textarea name="OBS" id="OBS" class="form-control" maxlength="255" placeholder="Observação (opcional)"></textarea>
		</div>
		
		<div class="form-check">
			<input name="RA" id="RA" type="checkbox" class="form-check-input" checked>
			<label for="RA" class="form-check-label">Ativo</label>
		</div>
		
		<br />
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/distrito') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Inserir</button>
	</form>
</div>