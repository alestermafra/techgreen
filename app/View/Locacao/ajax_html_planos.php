<div class="form-group">
	<?php foreach($planos as $i => $plano): ?>
		<div class="form-check">
			<input class="form-check-input" type="radio" name="cplano" id="cplano-radio-<?php echo $i ?>" value="<?php echo $plano['cplano'] ?>" onchange="$('#valor-input').val(<?php echo $plano['valor'] ?>); $('#valor-input').trigger('change');"></input>
			<label class="form-check-label" for="cplano-radio-<?php echo $i ?>">
				<?php echo $plano['nplano'] ?> - R$ <?php echo str_replace(".",",",$plano['valor']) ?>
			</label>
		</div>
	<?php endforeach ?>
</div>
