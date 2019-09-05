<select id='ajax_combo_rei' name='crei' class='form-control'>
	<option value="0" selected>Todos</option>
<?php foreach($reilist as $rei): ?>
	<option value="<?php echo $rei['crei'] ?>"><?php echo $rei['nrei'] ?></option>
<?php endforeach; ?>
</select>