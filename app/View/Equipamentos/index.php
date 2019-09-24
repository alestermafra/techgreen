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
	<span class="navbar-brand">Embarcações</span>
	<div>
		<a href="<?php echo $this->url('/equipamentos/inserir') ?>" class="btn btn-sm btn-success" role="button" title="Novo registro">Adicionar</a>
	</div>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/equipamentos') ?>" method="GET">
				<div class="form-row">
					<div class="form-group col-xl-2">
						<label class="small text-muted invisible">Search</label>
						<input name="search_value" type="search" placeholder="Procurar..." value="<?php echo _isset($_GET['search_value'], '') ?>" autofocus class="form-control form-control-sm"></input>
					</div>
					
					<div class="col-xl-6 d-none d-xl-block"></div>
					
					<div class="form-group col-xl-2">
						<label class="small text-muted">Ordenação</label>
						<select name="order" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="pessoa"<?php echo isset($_GET['order']) && $_GET['order'] === "pessoa"? ' selected':'' ?>>Pessoa</option>
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
					<th scope="col" class="small">Pessoa</th>
					<th scope="col" class="small">Embarcação</th>
					<th scope="col" class="small">Tipo</th>
                    <th scope="col" class="small">Modelo</th>
                    <th scope="col" class="small">Venda?</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$fn_ativo = function($x) { //funcao pra ativo
						if($x == 1){
							$a = 'Sim';
						}else{
							$a= 'Não';
						}
						return $a;
					};
					
					foreach($list as $d): ?>
					<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/equipamentos/view/' . $d['cequipe']) ?>'">
                    	<td nowrap><?php echo $d['cequipe'] ?></td>
						<td nowrap><?php echo $d['nps'] ?></td>
						<td nowrap><?php echo $d['nome'] ?></td>
						<td nowrap><?php echo $d['nlinha'] ?></td>
                        <td nowrap><?php echo $d['nprod'] ?></td>
                        <td nowrap><?php echo $fn_ativo($d['flg_venda']) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	
	<nav>
		<ul class="pagination pagination-sm justify-content-center">
			<li class="page-item <?php echo $page === 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/equipamentos' . $url_get . '&page=1') ?>">Primeira</a>
			</li>
			<li class="page-item <?php echo $page <= 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/equipamentos' . $url_get . '&page=' . ($page - 1)) ?>">Anterior</a>
			</li>
			<li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $page ?></a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/equipamentos' . $url_get . '&page=' . ($page + 1)) ?>">Próxima</a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/equipamentos' . $url_get . '&page=' . $pages) ?>">Última</a></li>
		</ul>
	</nav>
	
	<div class="container-fluid text-right small">
		Total de registros: <?php echo $count ?>
	</div>
<?php endif ?>

<br />