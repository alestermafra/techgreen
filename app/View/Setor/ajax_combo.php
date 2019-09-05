<?php if($cset): ?>
	<select id='ajax_combo_set' name='cset' class='form-control' disabled>
		<?php foreach($setlist as $set): ?>
			<option value="<?php echo $set['cset'] ?>"<?php echo $set['cset'] == $cset? ' selected': '' ?>><?php echo $set['nset'] ?></option>
		<?php endforeach; ?>
	</select>
<?php else: ?>
	<select id='ajax_combo_set' name='cset' class='form-control'>
		<option value="0" selected>Selecione</option>
		<?php foreach($setlist as $set): ?>
			<option value="<?php echo $set['cset'] ?>"><?php echo $set['nset'] ?></option>
		<?php endforeach; ?>
	</select>
<?php endif ?>