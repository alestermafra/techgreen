<h2 style="padding: 20px; font-weight: lighter;">Novo Setor</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/setor/confirmarInsercao') ?>" method="POST">
		<div class="form-group">
			<label for="cdio">Distrito</label>
			<select name="cdio" id="cdio" class="form-control">
				<?php  
					foreach($distritos as $u){
						echo '<option value="' . $u['cdio'].'">' . $u['ndio'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="sset">Sigla</label>
			<input name="sset" id="sset" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10"></input>
		</div>
		
		<div class="form-group">
			<label for="nset">Nome</label>
			<input name="nset" id="nset" type="text" class="form-control" placeholder="Nome do Setor" maxlength="100" required autofocus></input>
		</div>
		
		<div class="form-group">
			<label for="OBS">Obs.</label>
			<textarea name="OBS" id="OBS" class="form-control" maxlength="255" placeholder="Observação (opcional)"></textarea>
		</div>
		
		<div class="form-check">
			<input name="RA" id="RA" type="checkbox" class="form-check-input" checked></input>
			<label for="RA" class="form-check-label">Ativo</label>
		</div>
		
		<br />
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/setor') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Inserir</button>
	</form>
</div>