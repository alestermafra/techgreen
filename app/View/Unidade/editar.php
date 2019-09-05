<h2 style="padding: 20px; font-weight: lighter;">Editar Unidade</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/unidade/confirmarEdicao') ?>" method="POST">
	
		<input type="hidden" name="cun" value="<?php echo $unidade['cun']?>"></input>
		
    	<div class="form-group">
			<label for="nen">Entidade</label>
			<div style="font-weight: bold;"><?php echo $unidade['nen'] ?></div>
		</div>
		
		<div class="form-group">
			<label for="sun">Sigla</label>
			<input name="sun" id="sun" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10" value="<?php echo $unidade['sun']?>"></input>
		</div>
		
		<div class="form-group">
			<label for="nun">Nome</label>
			<input name="nun" id="nun" type="text" class="form-control" placeholder="Nome Completo" maxlength="100" required autofocus value="<?php echo $unidade['nun']?>"></input>
		</div>
		
		<div class="form-group">
			<label for="clang">Idioma</label>
			<select name="clang" class="form-control">
			<?php  
				foreach($idiomas as $lang){
					echo '<option value="' . $lang['clang'] . '"';
						if($lang['clang'] == $unidade['clang']) {
							echo 'selected="selected"';
						}
					echo '>' . $lang['nlang'] . '</option>';
				}
			?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="OBS">Obs.</label>
			<textarea name="OBS" id="OBS" class="form-control" maxlength="255" placeholder="Observação (opcional)"><?php echo $unidade['OBS']?></textarea>
		</div>
		
		<div class="form-check">
			<input name="RA" id="RA" type="checkbox" class="form-check-input" <?php echo $unidade['RA']? 'checked':'' ?>>
			<label for="RA" class="form-check-label">Ativo</label>
		</div>
		
		<br />
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/unidade') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Editar</button>
	</form>
</div>