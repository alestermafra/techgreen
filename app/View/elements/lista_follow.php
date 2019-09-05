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
								echo $fn[$k]($d[$f]);
							}
							else {
								echo $d[$f];
							}
						?>
					</td>
				<?php endforeach; ?>
			</tr>
            	<?php foreach($descricao as $desc): ?>
            	<tr class="text-left">
                	<td colspan="<?php echo count($d); ?>">
                    	<b>Desc:</b> <?php echo $d[$desc]; ?>
                        <dt>&nbsp;</dt>
                    </td>
                </tr>
                <?php endforeach; ?>
		<?php endforeach; ?>
   </tbody>
</table>