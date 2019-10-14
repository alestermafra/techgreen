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
	<span class="navbar-brand">Ocorrências</span>
</nav>


<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/ocorrencia') ?>">	
				<div class="form-row">
					<div class="form-group col-sm-3">
						<label class="small text-muted invisible">Search</label>
						<input name="search_value" type="search" placeholder="Procurar..." value="<?php echo _isset($_GET['search_value'], '') ?>" autofocus class="form-control form-control-sm"></input>
					</div>
					
					<div class="form-group col-sm"></div>
					
					<div class="form-group col-md-2">
						<label><small>Mostrar</small></label>
						<select name="tipo" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="todos">Todos</option>
							<option value="equipamento" <?php echo _isset($_GET['tipo'], 0) === "equipamento" ? ' selected' : '' ?>>Equipamentos</option>
							<option value="pessoa" <?php echo _isset($_GET['tipo'], 0) === "pessoa" ? ' selected' : '' ?>>Pessoas</option>
						</select>
					</div>
					
					<div class="form-group col-sm-2">
						<label><small>Ordenar</small></label>
						<select name="order" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="data"<?php echo isset($_GET['order']) && $_GET['order'] === "data"? ' selected':'' ?>>Data</option>
							<option value="nome"<?php echo isset($_GET['order']) && $_GET['order'] === "nome"? ' selected':'' ?>>Nome de Pessoa</option>
							<option value="equipamento"<?php echo isset($_GET['order']) && $_GET['order'] === "equipamento"? ' selected':'' ?>>Equipamento</option>
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
					<td><label><small><b>#</b></small></label></td>
                    <td><label><small>ID</small></label></td>
					<td><label><small>Nome</small></label></td>
					<td><label><small>Equipamento</small></label></td>
					<td><label><small>Assunto</small></label></td>
                    <td><label><small>Descrição</small></label></td>
                    <td><label><small>Data</small></label></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $d): ?> 
					<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/ocorrencia/editar/'.$d['cocorrencia'].'/'.$d['codigo'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>'">
						<td><b><?php echo $d['cocorrencia'] ?></b></td>
                        <td><?php echo $d['codigo'] ?></td>
						<td><?php if($d['ctocorrencia']==1) { echo '';} else { echo $d['nps'] ;} ?></td>
						<td><?php if($d['ctocorrencia']==1) { echo $d['nome'] .' ('.$d['responsavel'].')';} else { echo '' ;} ?></td>
                        <td><?php echo $d['assunto'] ?></td>
                        <td><?php echo $d['descricao'] ?></td>
						<td><?php echo $d['data'] ?></td>
					</tr>
				<?php endforeach; ?>
		   </tbody>
		</table>
	</div>
		
		<nav>
			<ul class="pagination pagination-sm justify-content-center">
				<li class="page-item <?php echo $page === 1? 'disabled':'' ?>">
					<a class="page-link" href="<?php echo $this->url('/ocorrencia' . $url_get . '&page=1') ?>">Primeira</a>
				</li>
				<li class="page-item <?php echo $page <= 1? 'disabled':'' ?>">
					<a class="page-link" href="<?php echo $this->url('/ocorrencia' . $url_get . '&page=' . ($page - 1)) ?>">Anterior</a>
				</li>
				<li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $page ?></a></li>
				<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/ocorrencia' . $url_get . '&page=' . ($page + 1)) ?>">Próxima</a></li>
				<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/ocorrencia' . $url_get . '&page=' . $pages) ?>">Última</a></li>
			</ul>
		</nav>
		
	<div class="container-fluid text-right small">
		Total de registros: <?php echo $count ?>
	</div>
<?php endif ?>