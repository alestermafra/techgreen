<?php
	/* parametros para inserir na paginação. */
	$url_get = '?';
	if(isset($_GET['search_value'])) {
		$url_get .= "&search_value={$_GET['search_value']}";
	}
	if(isset($_GET['order'])) {
		$url_get .= "&order={$_GET['order']}";
	}
	if(isset($_GET['ativo'])) {
		$url_get .= "&ativo={$_GET['ativo']}";
	}
?>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Fornecedores</span>
    
	<div>
    	<div class="btn-group">
            <a href="<?php echo $this->url('/fornecedor/fornecedores_pf') ?>" class="btn btn-sm btn-secondary active">Pessoa Física</a>
            <a href="<?php echo $this->url('/fornecedor/fornecedores_pj') ?>" class="btn btn-sm btn-secondary">Pessoa Juridica</a>
		</div>
		<a href="<?php echo $this->url('/fornecedor/inserir_pf') ?>" class="btn btn-sm btn-success" role="button" title="Novo registro">Adicionar</a>
	</div>
</nav>


<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/fornecedor/fornecedores_pf') ?>" method="GET">
				<div class="form-row">
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="d-none d-sm-block"> </label>
						<input type="search" name="search_value" class="form-control form-control-sm" placeholder="Procurar..." value="<?php echo _isset($_GET['search_value'], '') ?>"></input>
					</div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2 d-none d-lg-block"></div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2 d-none d-lg-block"></div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2 d-none d-lg-block"></div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="small text-muted">Ordenação</label>
						<select name="order" class="form-control form-control-sm" onchange="this.form.submit()">
							<option disabled>Ordenar por</option>
                            <option value="nome"<?php echo isset($_GET['order']) && $_GET['order'] === "nome"? ' selected':'' ?>>Nome</option>
                            <option value="data"<?php echo isset($_GET['order']) && $_GET['order'] === "data"? ' selected':'' ?>>Data de Inserção</option>
						</select>
					</div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="small text-muted">Mostrar</label>
						<select name="ativo" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="1" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 1 ? ' selected':'' ?> >Ativos</option>
                            <option value="0" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 0 ? ' selected':'' ?> >Inativos</option>
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
					<th scope="col" class="small">id</th>
					<th scope="col" class="small">Nome</th>
					<th scope="col" class="small">Tipo</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($list as $d): ?>
			<tr>
				<td nowrap style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/fornecedor/overview_pf/' . $d['cps']) ?>'"><?php echo $d['cps'] ?></td>
				<td nowrap style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/fornecedor/overview_pf/' . $d['cps']) ?>'"><?php echo $d['nps'] ?></td>
				<td nowrap style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/fornecedor/overview_pf/' . $d['cps']) ?>'"><?php echo $d['ntfornec'] ?></td>
			</tr>
			<?php endforeach; ?>
		   </tbody>
		</table>
	</div>
		
	<nav>
		<ul class="pagination pagination-sm justify-content-center">
			<li class="page-item <?php echo $page === 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/fornecedor' . $url_get . '&page=1') ?>">Primeira</a>
			</li>
			<li class="page-item <?php echo $page <= 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/fornecedor' . $url_get . '&page=' . ($page - 1)) ?>">Anterior</a>
			</li>
			<li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $page ?></a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/fornecedor' . $url_get . '&page=' . ($page + 1)) ?>">Próxima</a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/fornecedor' . $url_get . '&page=' . $pages) ?>">Última</a></li>
		</ul>
	</nav>
		
	<div class="container-fluid text-right small">
		Total de registros: <?php echo $count ?>
	</div>
<?php endif ?>

<br />