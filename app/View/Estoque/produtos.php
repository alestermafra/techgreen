<?php
	/* parametros para inserir na paginação. */
	$url_get = '?';
	foreach($_GET as $k => $v) {
		if($k === 'page') {
			continue;
		}
		if($v) {
			$url_get .= "&$k=$v";
		}
	}
?>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Produtos</span>
	<div>
    	<a href="<?php echo $this->url('/estoque/inserir_produto') ?>" class="btn btn-sm btn-success" role="button" title="Novo produto">Adicionar Produto</a>
	</div>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/estoque/produtos/') ?>" method="GET">
				<div class="form-row">
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="d-none d-sm-block"> </label>
						<input name="search_value" type="search" placeholder="Procurar..." value="<?php echo _isset($_GET['search_value'], '') ?>" autofocus class="form-control form-control-sm"></input>
					</div>
				</div>	
			</form>
		</div>
	</div>
</div>
<br />

<?php if(_isset($_GET['search_value'])): ?>
	<div class="container-fluid small text-lighter">
		Resultados contendo '<?php echo $_GET['search_value'] ?>':
	</div>
<?php endif ?>



<?php if(empty($list)): ?>
	<div class="container-fluid small text-center">
		Nenhum registro para exibir.
	</div>
<?php else: ?>
	<div class="table-responsive">
		<table class="table table-sm table-hover">
			<thead class="thead-light">
				<tr>
					<th scope="col" class="small">id</th>
					<th scope="col" class="small">Linha/Tipo</th>
					<th scope="col" class="small">Sigla</th>
					<th scope="col" class="small">Produto</th>
                    <th scope="col" class="small">Descrição</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $d): ?>
					<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/estoque/editar_produto/' . $d['cprod']) ?>'">
						<td nowrap><?php echo $d['cprod'] ?></td>
						<td nowrap><?php echo $d['nlinha'] ?></td>
						<td nowrap><?php echo $d['sprod'] ?></td>
                        <td nowrap><?php echo $d['nprod'] ?></td>
                        <td nowrap><?php echo $d['descricao'] ?></td>
					</tr>
				<?php endforeach; ?>
		   </tbody>
		</table>
	</div>
		
	<nav>
		<ul class="pagination pagination-sm justify-content-center">
			<li class="page-item <?php echo $page === 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/estoque/produtos/' . $url_get . '&page=1') ?>">Primeira</a>
			</li>
			<li class="page-item <?php echo $page <= 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/estoque/produtos/' . $url_get . '&page=' . ($page - 1)) ?>">Anterior</a>
			</li>
			<li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $page ?></a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/estoque/produtos/' . $url_get . '&page=' . ($page + 1)) ?>">Próxima</a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/estoque/produtos/' . $url_get . '&page=' . $pages) ?>">Última</a></li>
		</ul>
	</nav>
		
	<div class="container-fluid text-right small">
		Total de registros: <?php echo $count ?>
	</div>
<?php endif ?>

<br />