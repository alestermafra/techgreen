<select id='ajax_combo_set' name='cset' class='form-control'>
	<option value="0" selected>Todos</option>
<?php foreach($setlist as $set): ?>
	<option value="<?php echo $set['cset'] ?>"><?php echo $set['nset'] ?></option>
<?php endforeach; ?>
</select>