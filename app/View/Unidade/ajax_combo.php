<select id='ajax_combo_un' name='cun' class='form-control'>
<?php foreach($unlist as $un): ?>
	<option value="<?php echo $un['cun'] ?>"><?php echo $un['nun'] ?></option>
<?php endforeach; ?>
</select>