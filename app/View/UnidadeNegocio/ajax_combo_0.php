<select id='ajax_combo_ung' name='cung' class='form-control'>
	<option value="0" selected disabled>Todos</option>
<?php foreach($unglist as $ung): ?>
	<option value="<?php echo $ung['cung'] ?>"><?php echo $ung['nung'] ?></option>
<?php endforeach; ?>
</select>