<style>
	.table {
		text-align: center;
	}
</style>

<h2 style="padding: 20px; font-weight: lighter;">Unidades</h2>

<div style="padding: 0 20px">
<div>
	<a href="<?php echo $this->url('/unidade/inserir') ?>" class="btn btn-sm btn-success" role="button">Inserir Novo</a>
</div>

<?php
	$edit_btn = function($cps) {
		return '<a class="btn btn-sm btn-secondary" href="' . $this->url('/unidade/editar/' . $cps) . '">Editar</a>';
	};
	$negrito = function($v) {
		return '<b>' . $v . '</b>';
	};
	echo $this->element(
		'hierarquia_lista_table',
		array(
			'titles' => array('id', 'Entidade', 'Idioma', 'Sigla', 'Unidade', 'Dt Inserção', 'Ativo', 'Ação'),
			'fields' => array('cun', 'nen', 'nlang', 'sun', 'nun', 'TS', 'RA',    'cun'),
			'fn' => array($negrito,   null,  null,   null,  null,  null, 'fn_sn', $edit_btn),
			'data' => $unidades
		)
	);
?>

<?php
	echo $this->element(
		'paginator',
		array(
			'link' => '/unidade/lista',
			'page' => $page,
			'paginas' => $qtd_p
		)
	);
?>
</div>