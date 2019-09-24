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
	<span class="navbar-brand">Aulas/Cursos</span>
	<div>
		<a href="<?php echo $this->url('/aula/inserir') ?>" class="btn btn-sm btn-success" role="button" title="Novo registro">Adicionar</a>
	</div>
</nav>

<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/aula') ?>">
				<div class="form-row">
					<div class="form-group col-xl-2">
						<label class="small text-muted invisible">Search</label>
						<input name="search_value" type="search" placeholder="Procurar..." value="<?php echo _isset($_GET['search_value'], '') ?>" autofocus class="form-control form-control-sm"></input>
					</div>
					
					<div class="col-xl-4 d-none d-xl-block"></div>
					
					<div class="form-group col-xl-1">
						<label class="small text-muted">Mês</label>
						<select name="mes" class="form-control form-control-sm" onchange="this.form.submit()">
							<?php foreach($cmes as $cmes): ?>
								<option value="<?php echo $cmes['cmes'] ?>"<?php echo _isset($_GET['mes'], date("n")) === $cmes['cmes']? ' selected' : '' ?>><?php echo $cmes['smes'] ?></option>
							<?php endforeach ?>
						</select>
					 </div>
					 
					 <div class="form-group col-xl-1">
						<label class="small text-muted">Ano</label>
						<select name="ano" class="form-control form-control-sm" onchange="this.form.submit()">
							<?php foreach($can as $can): ?>
								<option value="<?php echo $can['can'] ?>"<?php echo _isset($_GET['ano'], date("Y")) === $can['can']? ' selected' : '' ?>><?php echo $can['can'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					
					<div class="form-group col-xl-2">
						<label class="small text-muted">Plano/Carga horária</label>
						<select name="plano" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="todos">Todos</option>
							<?php foreach($planos as $d): ?>
								<option value="<?php echo $d['cplano'] ?>"<?php echo _isset($_GET['plano'], 0) === $d['cplano']? ' selected' : '' ?>><?php echo $d['nplano'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					
					<div class="form-group col-xl-2">
						<label class="small text-muted">Ordenação</label>
						<select name="order" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="data"<?php echo isset($_GET['order']) && $_GET['order'] === "data"? ' selected':'' ?>>Data de Criação</option>
							<option value="plano"<?php echo isset($_GET['order']) && $_GET['order'] === "plano"? ' selected':'' ?>>Plano</option>
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
					<th scope="col" class="small">Nome</th>
                    <th scope="col" class="small">Instrutor</th>
                    <th scope="col" class="small">Subtitulo</th>
					<th scope="col" class="small">Data</th>
                    <th scope="col" class="small">Horário</th>
					<th scope="col" class="small">Qtd Part</th>
					<th scope="col" class="small">Plano/Carga</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $d): ?>
					<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/aula/view/' . $d['caula']) ?>'">
						<td nowrap><?php echo $d['caula'] ?></td>
						<td nowrap><?php echo $d['nlinha']?></td>
                        <td nowrap><?php echo $d['instrutor'] ?></td>
                        <td nowrap><?php echo $d['subtitulo'] ?></td>
						<td nowrap><?php echo $d['cdia'].'/'.$d['cmes'].'/'.$d['can'] ?></td>
                        <td nowrap><?php echo $d['chora'].'h'.$d['cminuto'] ?></td>
                        <td nowrap><?php echo (!$d['qtd']? '0' : $d['qtd']) ?></td>
						<td nowrap><?php echo $d['nplano'] ?></td>
					</tr>
				<?php endforeach; ?>
		   </tbody>
		</table>
	</div>
		
	<nav>
		<ul class="pagination pagination-sm justify-content-center">
			<li class="page-item <?php echo $page === 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/aula' . $url_get . '&page=1') ?>">Primeira</a>
			</li>
			<li class="page-item <?php echo $page <= 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/aula' . $url_get . '&page=' . ($page - 1)) ?>">Anterior</a>
			</li>
			<li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $page ?></a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/aula' . $url_get . '&page=' . ($page + 1)) ?>">Próxima</a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/aula' . $url_get . '&page=' . $pages) ?>">Última</a></li>
		</ul>
	</nav>
		
	<div class="container-fluid text-right small">
		Total de registros: <?php echo $count ?>
	</div>
<?php endif ?>

<br />