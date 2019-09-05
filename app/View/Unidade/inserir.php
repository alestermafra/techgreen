<h2 style="padding: 20px; font-weight: lighter;">Nova Unidade</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/unidade/confirmarInsercao') ?>" method="POST">
		<div class="form-group">
			<label for="cen">Entidade</label>
			<select name="cen" id="cen" class="form-control">
				<?php  
					foreach($entidades as $u){
						echo '<option value="' . $u['cen'].'">' . $u['nen'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="sun">Sigla</label>
			<input name="sun" id="sun" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10"></input>
		</div>
		
		<div class="form-group">
			<label for="nun">Nome</label>
			<input name="nun" id="nun" type="text" class="form-control" placeholder="Nome Completo" maxlength="100" required autofocus></input>
		</div>
		
		<div class="form-group">
			<label for="clang">Idioma</label>
			<select name="clang" class="form-control">
				<?php  
					foreach($idiomas as $lang){
						echo '<option value="' . $lang['clang'] . '">' . $lang['nlang'] . '</option>';
					}
				?>
			</select>
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
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/unidade') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Inserir</button>
	</form>
</div>