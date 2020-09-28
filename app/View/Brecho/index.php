<nav class="navbar navbar-light">
	<span class="navbar-brand">Brechó - Lista de Equipamentos</span>
</nav>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <?php if($error = Session::consume('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif ?>

            <?php if($success = Session::consume('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif ?>

            <form method="GET">    
                <div class="form-group">
                    <a href="<?= $this->url('/brecho/create') ?>" class="btn btn-success">Adicionar</a>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>Tipo de Embarcação</label>
                        <select name="tipo_embarcacao" class="form-control" onchange="this.form.submit()">
                            <option value="" selected>Todos</option>
                            <?php foreach($tiposEmbarcacoes as $tipoEmbarcacao): ?>
                                <option value="<?= $tipoEmbarcacao['cprod']; ?>" <?= ($_GET['tipo_embarcacao'] ?? 0) == $tipoEmbarcacao['cprod']? 'selected' : '' ?>><?= $tipoEmbarcacao['nprod']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Exibir Vendidos</label>
                        <select name="exibir_vendidos" class="form-control" onchange="this.form.submit()">
                            <option value="nao_exibir_vendidos" <?= ($_GET['exibir_vendidos'] ?? '') == 'nao_exibir_vendidos'? 'selected' : '' ?>>Não Exibir</option>
                            <option value="exibir_vendidos" <?= ($_GET['exibir_vendidos'] ?? '') == 'exibir_vendidos'? 'selected' : '' ?>>Exibir</option>
                        </select>
                    </div>

                    <div class="col-md-4"></div>
                    
                    <div class="form-group col-md-2">
                        <label>Ordenação</label>
                        <select name="order" class="form-control" onchange="this.form.submit()">
                            <option value="cod_referencia" <?= ($_GET['order'] ?? '') == 'cod_referencia'? 'selected' : ''?>>Cód. Ref.</option>
                            <option value="eprod.nprod" <?= ($_GET['order'] ?? '') == 'eprod.nprod'? 'selected' : ''?>>Tipo de Embarcação</option>
                            <option value="nome" <?= ($_GET['order'] ?? '') == 'nome'? 'selected' : ''?>>Nome do Equipamento</option>
                            <option value="valor" <?= ($_GET['order'] ?? '') == 'valor'? 'selected' : ''?>>Valor</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label>Quantidade por Página</label>
                        <select name="limit" class="form-control" onchange="this.form.submit()">
                            <option value="10" <?= ($_GET['limit'] ?? 0) == 10? 'selected' : ''?>>10</option>
                            <option value="20" <?= ($_GET['limit'] ?? 0) == 20? 'selected' : ''?>>20</option>
                            <option value="50" <?= ($_GET['limit'] ?? 0) == 50? 'selected' : ''?>>50</option>
                            <option value="100" <?= ($_GET['limit'] ?? 0) == 100? 'selected' : ''?>>100</option>
                            <option value="1000" <?= ($_GET['limit'] ?? 0) == 1000? 'selected' : ''?>>1000</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" name="search" class="form-control align-middle" style="display: inline-block; width: auto;" placeholder="Pesquisar" value="<?= $_GET['search'] ?? '' ?>">
                    <button type="submit" class="btn btn-light" data-toggle="tooltip" data-placement="bottom" title="Pesquisar">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <table class="table table-hover">
                <thead>
                    <th>Cód. Ref.</th>
                    <th>Tipo de Embarcação</th>
                    <th>Equipamento</th>
                    <th>Valor</th>
                    <?php if(($_GET['exibir_vendidos'] ?? '') == 'exibir_vendidos'): ?>
                        <th>Data Venda</th>
                    <?php endif ?>
                    <th style="width: 100px;">Ações</th>
                </thead>
                <tbody>
                    <?php if(empty($brechoItens)): ?>
                        <tr>
                            <td colspan="5">Nenhum registro para exibir</td>
                        </tr>
                    <?php endif ?>
                    <?php foreach($brechoItens as $brechoItem): ?>
                        <tr>
                            <td><?= $brechoItem->cod_referencia ?></td>
                            <td><?= $brechoItem->tipo_embarcacao ?></td>
                            <td><?= $brechoItem->nome ?></td>
                            <td><?= $brechoItem->valor ?></td>
                            <?php if(($_GET['exibir_vendidos'] ?? '') == 'exibir_vendidos'): ?>
                                <td><?= $brechoItem->data_venda? date('d/m/Y', strtotime($brechoItem->data_venda)) : '' ?></td>
                            <?php endif ?>
                            <td>
                                <div class="dropdown dropleft">
                                    <a href="#" class="dropdown-toggle text-decoration-none" data-toggle="dropdown">
                                        Opções
                                    </a>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= $this->url('/brecho/show/' . $brechoItem->id) ?>">Visualizar</a>
                                        <a class="dropdown-item" href="<?= $this->url('/brecho/edit/' . $brechoItem->id) ?>">Editar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php
                if(!empty($brechoItens)):
                $currentPage = $_GET['page'] ?? 1;
                $previousPage = $currentPage - 1;
                $nextPage = $currentPage + 1;
                $lastPage = (int) ceil($count / ($_GET['limit'] ?? 10)); $lastPage = $lastPage < 1? 1 : $lastPage;

                $showPreviousPageButton = $currentPage > 1;
                $showNextPageButton = $lastPage != $currentPage;
                $showFirstPageButton = $currentPage != 1;
                $showLastPageButton = $lastPage != $currentPage;

                $firstPageParameters = http_build_query(array_merge($_GET, ['page' => 1]));
                $previousPageParameters = http_build_query(array_merge($_GET, ['page' => $previousPage]));
                $currentPageParameters = http_build_query(array_merge($_GET, ['page' => $currentPage]));
                $nextPageParameters = http_build_query(array_merge($_GET, ['page' => $nextPage]));
                $lastPageParameters = http_build_query(array_merge($_GET, ['page' => $lastPage]));
            ?>

            <ul class="pagination justify-content-center">
                <li class="page-item <?= (!$showFirstPageButton)? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $this->url("/brecho?$firstPageParameters") ?>" aria-label="Primeira">
                        Primeira
                    </a>
                </li>

                <li class="page-item <?= !$showPreviousPageButton? 'disabled' : '' ?>"><a class="page-link" href="<?= $this->url("/brecho?$previousPageParameters") ?>">Anterior</a></li>
                <li class="page-item active"><a class="page-link" href="<?= $this->url("/brecho?$currentPageParameters") ?>"><?= $currentPage; ?></a></li>
                <li class="page-item <?= !$showNextPageButton? 'disabled' : '' ?>"><a class="page-link" href="<?= $this->url("/brecho?$nextPageParameters") ?>">Próxima</a></li>
                <li class="page-item <?= (!$showLastPageButton)? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $this->url("/brecho?$lastPageParameters") ?>" aria-label="Next">
                        Última
                    </a>
                </li>
            </ul>

            <?php endif; // end if empty(brechoItens) ?>
        </div>
    </div>
</div>