<nav class="navbar navbar-light">
	<span class="navbar-brand">Brechó - Visualizar Equipamento</span>
</nav>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <a href="<?= $this->url('/brecho') ?>" class="btn btn-secondary">Voltar para a lista</a>
            </div>

            <?php if(isset($error)): ?>
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

            <?php if($brechoItem->vendido()): ?>
                <div class="alert alert-primary" role="alert">
                    Este equipamento foi marcado como vendido no dia <b><?= date('d/m/Y', strtotime($brechoItem->data_venda)) ?></b>.
                </div>
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Código de Referência</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->cod_referencia ?>" disabled>
                </div>
                <div class="form-group col-md-9">
                    <label>Tipo de Embarcação</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->nprod ?>" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Equipamento</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->nome ?>" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Marca</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->marca ?>" disabled>
                </div>

                <div class="form-group col-md-4">
                    <label>Modelo</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->modelo ?>" disabled>
                </div>

                <div class="form-group col-md-4">
                    <label>Tamanho</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->tamanho ?>" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label title="Cor do equipamento">Cor</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->cor ?>" disabled>
                </div>

                <div class="form-group col-md-6">
                    <label>Estado</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->estado ?>" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Valor</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->valor ?>" disabled>
                </div>

                <div class="form-group col-md-6">
                    <label>Data da Venda</label>
                    <input type="text" class="form-control" value="<?= $brechoItem->data_venda? date('d/m/Y', strtotime($brechoItem->data_venda)) : '' ?>" disabled>
                </div>
            </div>

            <div class="form-group">
                <label>Observação</label>
                <textarea class="form-control" disabled><?= $brechoItem->observacao ?></textarea>
            </div>

            <div class="form-group">
                <a href="<?= $this->url('/brecho/edit/' . $brechoItem->id) ?>" class="btn btn-primary">Editar</a>
                <?php if(!$brechoItem->vendido()): ?>
                    <a href="<?= $this->url('/brecho/baixa/' . $brechoItem->id) ?>" class="btn btn-warning">Dar Baixa</a>
                <?php endif; ?>
                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#destroyBrechoItemModal">Deletar</a>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="destroyBrechoItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Remoção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja deletar este produto do brechó?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <a href="<?= $this->url('/brecho/destroy/' . $brechoItem->id) ?>" class="btn btn-danger">Deletar</a>
            </div>
        </div>
    </div>
</div>