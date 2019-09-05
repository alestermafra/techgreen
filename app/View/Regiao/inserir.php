<h2 style="padding: 20px; font-weight: lighter;">Nova Região</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/regiao/confirmarInsercao') ?>" method="POST">
		<div class="form-group">
			<label for="cung">Unidade de Negócio</label>
			<select name="cung" id="cung" class="form-control">
				<?php  
					foreach($ungs as $u){
						echo '<option value="' . $u['cung'].'">' . $u['nung'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="srei">Sigla</label>
			<input name="srei" id="srei" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10"></input>
		</div>
		
		<div class="form-group">
			<label for="nrei">Nome</label>
			<input name="nrei" id="nrei" type="text" class="form-control" placeholder="Nome Completo" maxlength="100" required autofocus></input>
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
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/regiao') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Inserir</button>
	</form>
</div>