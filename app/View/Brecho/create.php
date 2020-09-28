<nav class="navbar navbar-light">
	<span class="navbar-brand">Brechó - Novo Equipamento</span>
</nav>

<?php if(isset($error)): ?>
	<div class="container-fluid">
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?php echo $error ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
<?php endif ?>

<form action="<?php echo $this->url('/brecho/create') ?>" method="POST">	
	<div class="container-fluid">
		<div class="card">
			<div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label title="Código interno da Pera Náutica para o equipamento">Código de Referência</label>
                        <input type="text" name="cod_referencia" class="form-control" placeholder="Código de Referência" title="Código interno da Pera Náutica para o equipamento">
                    </div>
                    <div class="form-group col-md-9">
                        <label title="Tipo de embarcação para o qual este item é destinado">Tipo de Embarcação</label>
                        <select name="tipo_embarcacao_cprod" class="form-control" title="Tipo de embarcação para o qual este equipamento é destinado">
                            <option value="" selected hidden>Selecione</option>
                            <?php foreach($tipos_embarcacoes as $tipo_embarcacao): ?>
                                <option value="<?= $tipo_embarcacao['cprod'] ?>"><?= $tipo_embarcacao['nprod'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label title="Nome do equipamento">Equipamento</label>
                        <input type="text" name="nome" class="form-control" placeholder="Equipamento" title="Nome do equipamento">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label title="Marca do equipamento">Marca</label>
                        <input type="text" name="marca" class="form-control" placeholder="Marca" title="Marca do equipamento">
                    </div>

                    <div class="form-group col-md-4">
                        <label title="Modelo do equipamento">Modelo</label>
                        <input type="text" name="modelo" class="form-control" placeholder="Modelo" title="Modelo do equipamento">
                    </div>

                    <div class="form-group col-md-4">
                        <label title="Tamanho do equipamento">Tamanho</label>
                        <input type="text" name="tamanho" class="form-control" placeholder="Tamanho" title="Tamanho do equipamento">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label title="Cor do equipamento">Cor</label>
                        <input type="text" name="cor" class="form-control" placeholder="Cor" title="Cor do equipamento">
                    </div>

                    <div class="form-group col-md-6">
                        <label title="Estado de conservação do equipamento">Estado</label>
                        <select name="estado" class="form-control" title="Estado de conservação do equipamento">
                            <option value="" selected hidden>Selecione</option>
                            <option value="Ótimo">Ótimo</option>
                            <option value="Bom">Bom</option>
                            <option value="Ruim">Ruim</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label title="Valor do equipamento">Valor</label>
                        <input type="text" name="valor" class="form-control" placeholder="Valor" title="Valor do equipamento">
                    </div>

                    <div class="form-group col-md-6">
                        <label title="Data da venda do equipamento">Data da Venda</label>
                        <input type="date" name="data_venda" class="form-control" placeholder="Data da Venda" title="Data da venda do equipamento">
                    </div>
                </div>

                <div class="form-group">
                    <label>Observação</label>
                    <textarea name="observacao" class="form-control" placeholder="Observação"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Inserir</button>
                    <a href="<?= $this->url('/brecho') ?>" class="btn btn-light">Cancelar</a>
                </div>
		    </div>
		</div>
	</div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('[name=valor]').jQueryMask('000.000.000.000.000,00', {reverse: true});
    });
</script>