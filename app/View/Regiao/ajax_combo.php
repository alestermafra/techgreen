<?php if($crei): ?>
	<select id='ajax_combo_rei' name='crei' class='form-control' disabled>
		<?php foreach($reilist as $rei): ?>
			<option value="<?php echo $rei['crei'] ?>"<?php echo $rei['crei'] == $crei? ' selected': '' ?>><?php echo $rei['nrei'] ?></option>
		<?php endforeach; ?>
	</select>
<?php else: ?>
	<select id='ajax_combo_rei' name='crei' class='form-control'>
		<option disabled selected>Selecione</option>
		<?php foreach($reilist as $rei): ?>
			<option value="<?php echo $rei['crei'] ?>"><?php echo $rei['nrei'] ?></option>
		<?php endforeach; ?>
	</select>
<?php endif ?>