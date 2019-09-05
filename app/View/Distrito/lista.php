<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Distritos</h2>

<div style="padding: 0 20px">
<div>
	<a href="<?php echo $this->url('/distrito/inserir') ?>" class="btn btn-sm btn-success" role="button">Inserir Novo</a>
	<a href="<?php echo $this->url('/distrito/pesquisar') ?>" class="btn btn-sm btn-light" role="button">Pesquisar</a>
</div>

<?php
	$edit_btn = function($id) {
		return '<a class="btn btn-sm btn-secondary" href="' . $this->url('/distrito/editar/' . $id) . '">Editar</a>';
	};
	$negrito = function($v) {
		return '<b>' . $v . '</b>';
	};
	echo $this->element(
		'hierarquia_lista_table',
		array(
			'titles' => array('id',		'Região',	'Sigla',	'Distrito',	'Dt Inserção',	'Ativo',	'Ação'),
			'fields' => array('cdio',	'nrei',		'sdio',		'ndio',		'TS',			'RA',		'cdio'),
			'fn' => array($negrito,		null,		null,		$negrito,	null,			'fn_sn',	$edit_btn),
			'data' => $lista
		)
	);
?>

<?php
	echo $this->element(
		'paginator',
		array(
			'link' => '/distrito/lista',
			'page' => $page,
			'paginas' => $qtd_p
		)
	);
?>
</div>