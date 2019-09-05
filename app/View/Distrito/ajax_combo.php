<?php if($cdio): ?>
	<select id='ajax_combo_dio' name='cdio' class='form-control' disabled>
		<?php foreach($diolist as $dio): ?>
			<option value="<?php echo $dio['cdio'] ?>"<?php echo $dio['cdio'] == $cdio? ' selected': '' ?>><?php echo $dio['ndio'] ?></option>
		<?php endforeach; ?>
	</select>
<?php else: ?>
	<select id='ajax_combo_dio' name='cdio' class='form-control'>
		<option value="0" selected>Selecione</option>
		<?php foreach($diolist as $dio): ?>
			<option value="<?php echo $dio['cdio'] ?>"><?php echo $dio['ndio'] ?></option>
		<?php endforeach; ?>
	</select>
<?php endif ?>