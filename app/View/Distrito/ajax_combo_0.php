<select id='ajax_combo_dio' name='cdio' class='form-control'>
	<option value="0" selected>Todos</option>
<?php foreach($diolist as $dio): ?>
	<option value="<?php echo $dio['cdio'] ?>"><?php echo $dio['ndio'] ?></option>
<?php endforeach; ?>
</select>