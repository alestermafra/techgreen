<h2 style="padding: 20px; font-weight: lighter;">Editar Pessoa</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/pessoa/confirmarEdicao') ?>" method="POST">
	
		<input type="hidden" name="cps" value="<?php echo $pessoa['cps']?>"></input>
		
		<div class="form-group">
			<label for="cun">Unidade</label>
			<select name="cun" id="cun" class="form-control">
				<?php  
					foreach($unidades as $u){
						echo '<option value="' . $u['cun'].'" ' . ($pessoa['cun'] === $u['cun']? 'selected':'') . '>' . $u['nun'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="sps">Sigla</label>
			<input name="sps" id="sps" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10" value="<?php echo $pessoa['sps']?>"></input>
		</div>
		
		<div class="form-group">
			<label for="nps">Nome</label>
			<input name="nps" id="nps" type="text" class="form-control" placeholder="Nome Completo" maxlength="100" required autofocus value="<?php echo $pessoa['nps']?>"></input>
		</div>
		
		<div class="form-group">
			<label for="OBS">Obs.</label>
			<textarea name="OBS" id="OBS" class="form-control" maxlength="255" placeholder="Observação (opcional)"><?php echo $pessoa['OBS']?></textarea>
		</div>
		
		<div class="form-check">
			<input name="flg_sys" id="flg_sys" type="checkbox" class="form-check-input" <?php echo $pessoa['flg_sys']? 'checked':'' ?>>
			<label for="flg_sys" class="form-check-label">Uso do sistema</label>
		</div>
		
		<div class="form-check">
			<input name="RA" id="RA" type="checkbox" class="form-check-input" <?php echo $pessoa['RA']? 'checked':'' ?>>
			<label for="RA" class="form-check-label">Ativo</label>
		</div>
		
		<br />
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/pessoa') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Editar</button>
	</form>
</div>