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
	<span class="navbar-brand">Velejadores (Pessoa Física)</span>
    
	<div>
    	<div class="btn-group" role="group">
            <a href="<?php echo $this->url('/painel/pf') ?>" class="btn btn-sm btn-secondary active" title="Visualizar PF">Pessoa Física</a>
            <a href="<?php echo $this->url('/painel/pj') ?>" class="btn btn-sm btn-secondary" title="Visualizar PJ">Pessoa Jurídica</a>
		</div>

		<?php if(can('permission-painel-add')): ?>
			<a href="<?php echo $this->url('/painel/inserir_pf') ?>" class="btn btn-sm btn-success" role="button" title="Novo registro">Adicionar</a>
		<?php endif ?>
	</div>
</nav>


<div class="container-fluid">
	<div class="card">
		<div class="card-body py-2">
			<form action="<?php echo $this->url('/painel/pf') ?>" method="GET">
				<div class="form-row">
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="d-none d-sm-block"> </label>
						<input name="search_value" type="search" placeholder="Procurar..." value="<?php echo _isset($_GET['search_value'], '') ?>" autofocus class="form-control form-control-sm"></input>
					</div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2 d-none d-lg-block"></div>
                    
                    <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="small text-muted">Registros</label>
						<select name="filtros" class="form-control form-control-sm" onchange="this.form.submit()">
							<?php $filtro = $_GET['filtros'] ?? ''; ?>
                        	<option value="todos" <?= ($filtro == 'todos')? 'selected' : '' ?>>Todos</option>
                            <option value="com-cpf" <?= ($filtro == 'com-cpf')? 'selected' : '' ?>>Com CPF</option>
                            <option value="sem-cpf" <?= ($filtro == 'sem-cpf')? 'selected' : '' ?>>Sem CPF</option>
                            <option value="com-prim-contato" <?= ($filtro == 'com-prim-contato')? 'selected' : '' ?>>Com 1º Contato</option>
                            <option value="sem-prim-contato" <?= ($filtro == 'sem-prim-contato')? 'selected' : '' ?>>Sem 1º Contato</option>
                        </select>
					</div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="small text-muted">Ordenação</label>
						<select name="order" class="form-control form-control-sm" onchange="this.form.submit()">
							<option value="nome"<?php echo isset($_GET['order']) && $_GET['order'] === "nome"? ' selected':'' ?>>Nome do Velejador</option>
                            <option value="cseg2"<?php echo isset($_GET['order']) && $_GET['order'] === "cseg2"? ' selected':'' ?>>Classificação Primária</option>
                            <option value="segmentacao"<?php echo isset($_GET['order']) && $_GET['order'] === "segmentacao"? ' selected':'' ?>>Classificação Secundária</option>
                            <option value="data"<?php echo isset($_GET['order']) && $_GET['order'] === "data"? ' selected':'' ?>>Data de Inserção</option>
						</select>
					</div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="small text-muted">Ativos/Inativos</label>
						<select name="ativo" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="1" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 1 ? ' selected':'' ?> >Ativos</option>
                            <option value="0" <?php echo isset($_GET['ativo']) && $_GET['ativo'] == 0 ? ' selected':'' ?> >Inativos</option>
                        </select>
					</div>
					
					<div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
						<label class="small text-muted">Mostrar</label>
						<select name="limit" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="20" <?php echo isset($_GET['limit']) && $_GET['limit'] == 20 ? ' selected':'' ?> >20 itens por página</option>
                            <option value="50" <?php echo isset($_GET['limit']) && $_GET['limit'] == 50 ? ' selected':'' ?> >50 itens por páginas</option>
                            <option value="100" <?php echo isset($_GET['limit']) && $_GET['limit'] == 100 ? ' selected':'' ?> >100 itens por páginas</option>
                            <option value="1000" <?php echo isset($_GET['limit']) && $_GET['limit'] == 1000 ? ' selected':'' ?> >1000 itens por páginas</option>
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
					<th scope="col" class="small">Classif. Prim.</th>
					<th scope="col" class="small">Classif. Sec.</th>
                    <th scope="col" class="small">CPF</th>
					<th scope="col" class="small">Telefone</th>
					<th scope="col" class="small">1º Contato</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($list as $d): ?>
				<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/painel/overview_pf/' . $d['cps']) ?>'">
					<td nowrap><?php echo $d['cps'] ?></td>
					<td nowrap><?php echo $d['nps'] ?></td>
					<td nowrap><?php echo $d['classificacao'] ?></td>
					<td nowrap><?php echo $d['nseg'] ?></td>
                    <td nowrap><?php echo cpf_mask($d['cpf']) ?></td>
					<td nowrap><?= fone_mask($d['fone']) ?></td>
					<td nowrap style="width: 150px;"><?= util_data($d['d_contato'], $d['m_contato'], $d['a_contato']) ?></td>
				</tr>
				<?php endforeach; ?>
		   </tbody>
		</table>
	</div>
		
	<nav>
		<ul class="pagination pagination-sm justify-content-center">
			<li class="page-item <?php echo $page === 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/painel/pf' . $url_get . '&page=1') ?>">Primeira</a>
			</li>
			<li class="page-item <?php echo $page <= 1? 'disabled':'' ?>">
				<a class="page-link" href="<?php echo $this->url('/painel/pf' . $url_get . '&page=' . ($page - 1)) ?>">Anterior</a>
			</li>
			<li class="page-item active"><a class="page-link" href="javascript:void(0)"><?php echo $page ?></a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/painel/pf' . $url_get . '&page=' . ($page + 1)) ?>">Próxima</a></li>
			<li class="page-item <?php echo ($pages === 0 || $page === $pages)? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url('/painel/pf' . $url_get . '&page=' . $pages) ?>">Última</a></li>
		</ul>
	</nav>
		
	<div class="container-fluid text-right small">
		Total de registros: <?php echo $count ?>
	</div>
<?php endif ?>

<br />


<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
	});
	
	function bindEvents() {
		bindPhoneMask();
		bindCPFMask();
	};
	
	function bindPhoneMask() {
		let fone_mask = (val) => {
			val = val.replace(/[^0-9]/g, '');
			
			if(val.length <= 8) {
				return '0000-0000';
			}
			if(val.length <= 9) {
				return '00000-0000';
			}
			if(val.length <= 10) {
				return '(00) 0000-0000'; 
			}
			if(val.length <= 11) {
				return '(00) 00000-0000';
			}
			if(val.length <= 12) {
				return '+00 (00) 0000-0000';
			}
			if(val.length <= 13) {
				return '+00 (00) 00000-0000';
			}
		};
		$('.phone').mask(fone_mask);
	};
	
	function bindCPFMask() {
		$('.cpf-mask').mask('000.000.000-00');
	};
	
})();
</script>

<?php
	function cpf_mask($cpf) {
		return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', "$1.$2.$3-$4", $cpf);
	}

	function fone_mask($fone) {
		$len = strlen($fone);

		$pattern = '/(\d{4})(\d{4})/';
		$replace = '$1-$2';

		switch($len) {
			case 9:
				$pattern = '/(\d{5})(\d{4})/';
				$replace = '$1-$2';
			break;

			case 10:
				$pattern = '/(\d{2})(\d{4})(\d{4})/';
				$replace = '($1) $2-$3';
			break;

			case 11:
				$pattern = '/(\d{2})(\d{5})(\d{4})/';
				$replace = '($1) $2-$3';
			break;

			case 12:
				$pattern = '/(\d{2})(\d{2})(\d{4})(\d{4})/';
				$replace = '+$1 ($2) $3-$4';
			break;

			case 13:
				$pattern = '/(\d{2})(\d{2})(\d{5})(\d{4})/';
				$replace = '+$1 ($2) $3-$4';
			break;
		}

		return preg_replace($pattern, $replace, $fone);
	}

	function util_data($d, $m, $y) {
		$ret = '';
		if($d) {
			$ret .= str_pad($d, 2, '0', STR_PAD_LEFT);

			if($m) {
				$ret .= '/' . str_pad($m, 2, '0', STR_PAD_LEFT);

				if($y) {
					$ret .= '/' . $y;
				}
			}
		}
		return $ret;
	}
?>