<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Pessoas</h2>

<div style="padding: 0 20px">
<div>
	<a href="<?php echo $this->url('/pessoa/inserir') ?>" class="btn btn-sm btn-success" role="button">Inserir Novo</a>
	<a href="<?php echo $this->url('/pessoa/pesquisar') ?>" class="btn btn-sm btn-light" role="button">Pesquisar</a>
</div>

<?php
	$edit_btn = function($cps) {
		return '<a class="btn btn-sm btn-secondary" href="' . $this->url('/pessoa/editar/' . $cps) . '">Editar</a>';
	};
	$negrito = function($v) {
		return '<b>' . $v . '</b>';
	};
	echo $this->element(
		'hierarquia_lista_table',
		array(
			'titles' => array('id', 'Sigla', 'Nome', 'Dt Inserção', 'Unidade', 'Uso Sis', 'Ativo', 'Ação'),
			'fields' => array('cps', 'sps', 'nps', 'TS', 'nun', 'flg_sys', 'RA', 'cps'),
			'fn' => array($negrito, null, $negrito, null, null, 'fn_sn', 'fn_sn', $edit_btn),
			'data' => $lista
		)
	);
?>

<?php
	echo $this->element(
		'paginator',
		array(
			'link' => '/pessoa/lista',
			'page' => $page,
			'paginas' => $paginas
		)
	);
?>

<div class="float-right">
	<small class="text-muted">Total de registros: <?php echo $total; ?></small>
</div>

</div>