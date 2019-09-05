<?php
	$url_get = '?';
	if(isset($_GET['search_value'])) {
		$url_get .= "&search_value={$_GET['search_value']}";
	}
	if(isset($_GET['order'])) {
		$url_get .= "&order={$_GET['order']}";
	}
	if(isset($_GET['limit'])) {
		$url_get .= "&limit={$_GET['limit']}";
	}
?>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Serviços</span>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/servicos') ?>" method="GET">
				<div class="form-row">
					<div class="form-group col-xl-2">
						<label class="small text-muted invisible">Search</label>
						<input name="search_value" type="search" placeholder="Procurar..." value="<?php echo _isset($_GET['search_value'], '') ?>" autofocus class="form-control form-control-sm"></input>
					</div>
					
					<div class="form-group col-xl-4">
						<label class="small text-muted">Tipo/Linha</label>
						<select name="linha" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="todos">Todos</option>
							<?php foreach($linhas as $ln): ?>
								<option value="<?php echo $ln['clinha'] ?>"<?php echo _isset($_GET['linha'], 0) === $ln['clinha']? ' selected' : '' ?>><?php echo $ln['nscat'].' > '.$ln['nlinha'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					
					<div class="form-group col-xl-2">
						<label class="small text-muted">Ordenação</label>
						<select name="order" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="produto"<?php echo isset($_GET['order']) && $_GET['order'] === "produto"? ' selected':'' ?>>Por Serviço/Produto</option>
							<option value="linha"<?php echo isset($_GET['order']) && $_GET['order'] === "linha"? ' selected':'' ?>>Por Tipo/Linha</option>
							<option value="subcategoria"<?php echo isset($_GET['order']) && $_GET['order'] === "subcategoria"? ' selected':'' ?>>Por SubCategoria</option>
						</select>
					</div>
                    
                    <div class="form-group col-xl-2">
						<label class="small text-muted">Mostrar</label>
						<select name="limit" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="20"<?php echo _isset($_GET['limit'], 20) == 20? ' selected':'' ?>>20 itens por página</option>
							<option value="50"<?php echo _isset($_GET['limit'], 20) == 50? ' selected':'' ?>>50 itens por página</option>
							<option value="100"<?php echo _isset($_GET['limit'], 20) == 100? ' selected':'' ?>>100 itens por página</option>
						</select>
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
					<th scope="col" class="small">Id</th>
					<th scope="col" class="small">SubCategoria</th>
                    <th scope="col" class="small">Tipo/Linha</th>
                    <th scope="col" class="small">Sigla</th>
					<th scope="col" class="small">Serviço/Produto</th>
					<th scope="col" class="small">Descrição</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($list as $d): ?>
					<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/servicos/editar/' . $d['cprod']) ?>'">
						<td nowrap><?php echo $d['cprod'] ?></td>
						<td nowrap><?php echo $d['nscat'] ?></td>
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
				<a class="page-link" href="<?php echo $this->url('/servicos' . $url_get . '&page=1') ?>">Primeira</a>
			</li>
			<li class="page-item <?php echo $page <= 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/servicos' . $url_get . '&page=' . ($page - 1)) ?>">Anterior</a>
			</li>
			<li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $page ?></a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/servicos' . $url_get . '&page=' . ($page + 1)) ?>">Próxima</a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/servicos' . $url_get . '&page=' . $pages) ?>">Última</a></li>
		</ul>
	</nav>
	
	<div class="container-fluid text-right small">
		Total de registros: <?php echo $count ?>
	</div>
<?php endif ?>