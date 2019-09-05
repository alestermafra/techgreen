<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Setores</h2>

<div style="padding: 0 20px">
<div>
	<a href="<?php echo $this->url('/setor/inserir') ?>" class="btn btn-sm btn-success" role="button">Inserir Novo</a>
	<a href="<?php echo $this->url('/setor/pesquisar') ?>" class="btn btn-sm btn-light" role="button">Pesquisar</a>
</div>

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

<?php
	echo $this->element(
		'paginator',
		array(
			'link' => '/setor/lista',
			'page' => $page,
			'paginas' => $qtd_p
		)
	);
?>
</div>