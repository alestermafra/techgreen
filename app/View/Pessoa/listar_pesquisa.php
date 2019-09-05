<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Resultado da Pesquisa</h2>

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

<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/pessoa') ?>">Cancelar</a>
<a href="<?php echo $this->url('/pessoa/pesquisar') ?>" class="btn btn-sm btn-light" role="button">Nova Pesquisa</a>