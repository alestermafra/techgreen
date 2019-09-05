<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Regiões</h2>

<div style="padding: 0 20px">
<div>
	<a href="<?php echo $this->url('/regiao/inserir') ?>" class="btn btn-sm btn-success" role="button">Inserir Novo</a>
</div>

<?php
	$edit_btn = function($cps) {
		return '<a class="btn btn-sm btn-secondary" href="' . $this->url('/regiao/editar/' . $cps) . '">Editar</a>';
	};
	$negrito = function($v) {
		return '<b>' . $v . '</b>';
	};
	echo $this->element(
		'hierarquia_lista_table',
		array(
			'titles' => array('id',		'Unidade de Negócio',	'Sigla',	'Região',	'Dt Inserção',	'Ativo',	'Ação'),
			'fields' => array('crei',	'nung',					'srei',		'nrei',		'TS',			'RA',		'crei'),
			'fn' => array($negrito,		null,					null,		$negrito,	null,			'fn_sn',	$edit_btn),
			'data' => $lista
		)
	);
?>

<?php
	echo $this->element(
		'paginator',
		array(
			'link' => '/regiao/lista',
			'page' => $page,
			'paginas' => $qtd_p
		)
	);
?>
</div>