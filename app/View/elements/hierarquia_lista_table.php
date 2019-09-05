<table class="table table-sm table-striped table-hover">
	<thead>
		<tr>
			<?php foreach($titles as $t): ?>
				<th scope="col"><?php echo $t ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $d): ?>
			<tr>
				<?php foreach($fields as $k => $f): ?>
					<td>
						<?php
							if(isset($fn) && $fn[$k] !== null) {
								echo $fn[$k]($d[$f],$d);
							}
							else {
								echo $d[$f];
							}
						?>
					</td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
   </tbody>
</table>