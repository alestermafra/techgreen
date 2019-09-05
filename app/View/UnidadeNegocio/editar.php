<h2 style="padding: 20px; font-weight: lighter;">Editar Unidade de Negócio</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/UnidadeNegocio/confirmarEdicao') ?>" method="POST">
	
		<input name="cung" type="hidden" value="<?php echo $unidadeNegocio['cung'] ?>"></input>
	
		<div class="form-group">
			<label for="cun">Unidade</label>
			<select name="cun" id="cun" class="form-control">
				<?php  
					foreach($unidades as $u){
						echo '<option value="' . $u['cun'].'" ' . ($u['cun'] === $unidadeNegocio['cun']? 'selected':'') . '>' . $u['nun'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="sung">Sigla</label>
			<input name="sung" id="sung" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10" value="<?php echo $unidadeNegocio['sung'] ?>"></input>
		</div>
		
		<div class="form-group">
			<label for="nung">Nome</label>
			<input name="nung" id="nung" type="text" class="form-control" placeholder="Nome Completo" maxlength="100" value="<?php echo $unidadeNegocio['nung'] ?>" required autofocus></input>
		</div>
		
		<div class="form-group">
			<label for="OBS">Obs.</label>
			<textarea name="OBS" id="OBS" class="form-control" maxlength="255" placeholder="Observação (opcional)"><?php echo $unidadeNegocio['OBS'] ?></textarea>
		</div>
		
		<div class="form-check">
			<input name="RA" id="RA" type="checkbox" class="form-check-input" <?php echo ($unidadeNegocio['RA'] == 1? 'checked':'') ?>>
			<label for="RA" class="form-check-label">Ativo</label>
		</div>
		
		<br />
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/UnidadeNegocio') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Editar</button>
	</form>
</div>