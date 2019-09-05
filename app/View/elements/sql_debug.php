<?php

App::import('Connection', 'Model');

$queries = Connection::$queries;
?>
<div>
	<h3 style="padding: 10px; ">Sql debug</h3>
	<?php foreach($queries as $q): ?>
		<?php $q = preg_replace('#\s+#', ' ', $q); ?>
		<div style="border: 1px solid #ddd; padding: 10px; font-family: courier; font-size: 16px;">
			<div><?= $q; ?></div>
		</div>
	<?php endforeach; ?>
</div>