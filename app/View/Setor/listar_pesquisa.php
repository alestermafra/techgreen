<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Resultado da Pesquisa</h2>

<?php
	$edit_btn = function($id) {
		return '<a class="btn btn-sm btn-secondary" href="' . $this->url('/setor/editar/' . $id) . '">Editar</a>';
	};
	$negrito = function($v) {
		return '<b>' . $v . '</b>';
	};
	echo $this->element(
		'hierarquia_lista_table',
		array(
			'titles' => array('id',		'Distrito',	'Sigla',	'Setor',	'Dt Inserção',	'Ativo',	'Ação'),
			'fields' => array('cset',	'ndio',		'sset',		'nset',		'TS',			'RA',		'cset'),
			'fn' => array($negrito,		null,		null,		$negrito,	null,			'fn_sn',	$edit_btn),
			'data' => $lista
		)
	);
?>

<a class="btn btn-sm btn-danger" role="button" href="<?php echo $this->url('/setor') ?>">Cancelar</a>
<a href="<?php echo $this->url('/setor/pesquisar') ?>" class="btn btn-sm btn-light" role="button">Nova Pesquisa</a>