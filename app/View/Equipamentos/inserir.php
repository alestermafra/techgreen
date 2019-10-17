<form action="<?php echo $this->url('/equipamentos/inserir') ?>" method="POST">

	<nav class="navbar navbar-light">
		<span class="navbar-brand">Embarcação</span>
		<div>
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/equipamentos') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
		</div>
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

	
	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Embarcação
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="nome-input" class="small text-muted">Nome da Embarcação</label>
					<input name="nome" id="nome-input" type="text" class="form-control form-control-sm" placeholder="Nome do equipamento" autocomplete="off" value="<?php echo _isset($_POST['nome'], '') ?>"></input>
				</div>
				<div class="form-group">
					<label for="cprod-select" class="small text-muted">Modelo</label>
					<select name="cprod" id="cprod-select" class="form-control form-control-sm">
						<option value="0">Selecione</option>
						<?php foreach($categorias as $c): ?>
							<option value="<?php echo $c['cprod'] ?>"<?php echo _isset($_POST['cprod'], 0) == $c['cprod']? ' selected' : '' ?>><?php echo $c['nprod'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<input type="hidden" id="cps" name="cps"></input>
					<label for="cps-autocomplete" class="small text-muted">Responsável</label>
					<input type="text" id="cps-autocomplete" class="form-control form-control-sm" placeholder="Procurar velejador"></input>
				</div>
				<div id="cps-autocomplete-details" style="display: none;">
					<span id="cps-autocomplete-nps">cli</span> <span style="color: #CCC">(#<span id="cps-autocomplete-cps">id</span>)</span>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Detalhes
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="marca-input" class="small text-muted">Marca</label>
					<input name="marca" id="marca-input" type="text" class="form-control form-control-sm" placeholder="Marca do equipamento" autocomplete="off" value="<?php echo _isset($_POST['marca'], '') ?>"></input>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-6 col-md-4">
						<label for="ano-input" class="small text-muted">Ano</label>
						<input name="ano" id="ano-input" type="text" class="form-control form-control-sm" placeholder="Ano do equipamento" autocomplete="off" value="<?php echo _isset($_POST['ano'], '') ?>"></input>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label for="tamanho-input" class="small text-muted">Tamanho</label>
						<input name="tamanho" id="tamanho-input" type="text" class="form-control form-control-sm" placeholder="Tamanho do equipamento" autocomplete="off" value="<?php echo _isset($_POST['tamanho'], '') ?>"></input>
					</div>
					<div class="form-group col-sm-6 col-md-4">
						<label for="cor-input" class="small text-muted">Cor</label>
						<input name="cor" id="cor-input" type="text" class="form-control form-control-sm" placeholder="Cor do equipamento" autocomplete="off" value="<?php echo _isset($_POST['cor'], '') ?>"></input>
					</div>
				</div>
				
				<div class="form-group col-sm-2">
					<label for="estado_geral-select" class="small text-muted">Estado</label>
					<select name="estado_geral" id="estado_geral-select" class="form-control form-control-sm">
                    	<option value="Excelente"<?php echo _isset($_POST['estado_geral'], 0) == 'Excelente'? ' selected' : '' ?>>Excelente</option>
						<option value="Bom"<?php echo _isset($_POST['estado_geral'], 0) == 'Bom'? ' selected' : '' ?>>Bom</option>
						<option value="Médio"<?php echo _isset($_POST['estado_geral'], 0) == 'Médio'? ' selected' : '' ?>>Médio</option>
						<option value="Ruim"<?php echo _isset($_POST['estado_geral'], 0) == 'Ruim'? ' selected' : '' ?>>Ruim</option>
					</select>
				</div>
			</div>
		</div>
        
        <br />
        
        <div class="card">
			<div class="card-header bg-dark text-white">
				Venda
			</div>
			<div class="card-body">
            	<div class="form-row">
                    <div class="form-group form-check form-check-inline col-sm-6 col-md-6">
                        <input name="flg_venda" id="flg_venda-input" type="checkbox" class="form-check-input"/>
                        <label class="form-check-label"><span class="small text-muted">Em Venda?</span></label>
                    </div>
                    <div class="form-group col-sm-6 col-md-6">
                        <label for="valor_venda-input" class="small text-muted">Valor</label>
                        <input name="valor_venda" id="valor_venda-input" type="text" class="form-control form-control-sm" placeholder="Valor de venda do equipamento" autocomplete="off" value="<?php echo _isset($_POST['valor_venda'], '') ?>"/>
                    </div>
                </div>
			</div>
		</div>
		
		<br />
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/equipamentos') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
		</div>
	</div>
</form>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<style>
	.ui-autocomplete {
		max-height: 200px;
		overflow-y: scroll;
		overflow-x: hidden;
	}
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#cps-autocomplete").autocomplete({
		source: '<?= $this->url("/painel/search") ?>',
		select: function(event, ui) {
			$("#cps-autocomplete-details").hide();
			$("#cps-autocomplete-nps").text(ui.item.nps);
			$("#cps-autocomplete-cps").text(ui.item.cps);
			$("#cps").val(ui.item.cps);
			$("#cps-autocomplete-details").fadeIn();
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div style='font-size: 19px;'>" + item.nps + " <span style='color: #ccc;'>(#" + item.cps + ")</span></div>")
			.appendTo(ul);
	};
});
</script>