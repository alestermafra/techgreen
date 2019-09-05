<?php if($cung): ?>
	<select id='ajax_combo_ung' name='cung' class='form-control' disabled>
		<?php foreach($unglist as $ung): ?>
			<option value="<?php echo $ung['cung'] ?>"<?php echo $ung['cung'] == $cung? ' selected': '' ?>><?php echo $ung['nung'] ?></option>
		<?php endforeach; ?>
	</select>
<?php else: ?>
	<select id='ajax_combo_ung' name='cung' class='form-control'>
		<option disabled selected>Selecione</option>
		<?php foreach($unglist as $ung): ?>
			<option value="<?php echo $ung['cung'] ?>"><?php echo $ung['nung'] ?></option>
		<?php endforeach; ?>
	</select>
<?php endif ?>