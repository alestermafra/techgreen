<h2 style="padding: 20px; font-weight: lighter;">Nova Unidade de Negócio</h2>

<div style="padding: 0 20px">
	<form action="<?php echo $this->url('/UnidadeNegocio/confirmarInsercao') ?>" method="POST">
		<div class="form-group">
			<label for="cun">Unidade</label>
			<select name="cun" id="cun" class="form-control">
				<?php  
					foreach($unidades as $u){
						echo '<option value="' . $u['cun'].'">' . $u['nun'] . '</option>';
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="sung">Sigla</label>
			<input name="sung" id="sung" type="text" class="form-control" placeholder="Sigla/Abreviação (opcional)" maxlength="10"></input>
		</div>
		
		<div class="form-group">
			<label for="nung">Nome</label>
			<input name="nung" id="nung" type="text" class="form-control" placeholder="Nome Completo" maxlength="100" required autofocus></input>
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
		
		<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/UnidadeNegocio') ?>">Cancelar</a>
		<button type="submit" class="btn btn-sm btn-success">Inserir</button>
	</form>
</div>