<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Unidades de Negócio</h2>


<div style="padding: 0 20px">
<div>
	<a href="<?php echo $this->url('/UnidadeNegocio/inserir') ?>" class="btn btn-sm btn-success" role="button">Inserir Novo</a>
</div>

<?php
	$edit_btn = function($cps) {
		return '<a class="btn btn-sm btn-secondary" href="' . $this->url('/UnidadeNegocio/editar/' . $cps) . '">Editar</a>';
	};
	$negrito = function($v) {
		return '<b>' . $v . '</b>';
	};
	echo $this->element(
		'hierarquia_lista_table',
		array(
			'titles' => array('id',		'Unidade',	'Sigla',	'Unidade de Negócio',	'Dt Inserção',	'Ativo',	'Ação'),
			'fields' => array('cung',	'nun',		'sung',		'nung',					'TS',			'RA',		'cung'),
			'fn' => array($negrito,		null,		null,		$negrito,				null,			'fn_sn',	$edit_btn),
			'data' => $lista
		)
	);
?>

<?php
	echo $this->element(
		'paginator',
		array(
			'link' => '/UnidadeNegocio/lista',
			'page' => $page,
			'paginas' => $qtd_p
		)
	);
?>
</div>