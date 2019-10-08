<form action="<?php echo $this->url('/locacao/editar/' . $locacao['clocacao']) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Gerenciar locação</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/locacao/view/' . $locacao['clocacao']) ?>">Cancelar</a>
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

	<input type="hidden" value="<?php $locacao['clocacao'] ?>" name="clocacao"/>

	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Locação
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="hidden" id="cps" name="cps" value="<?=$locacao['cps']?>"></input>
					<label for="cps-autocomplete" class="small text-muted">Cliente</label>
					<input type="text" id="cps-autocomplete" class="form-control form-control-sm" placeholder="Procurar cliente"></input>
				</div>
				<div class="form-group" id="cps-autocomplete-details">
					<span id="cps-autocomplete-nps"><?=$locacao['nps']?></span> <span style="color: #CCC">(#<span id="cps-autocomplete-cps"><?=$locacao['cps']?></span>)</span>
				</div>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label class="small text-muted">Data para locação</label> 
                        <input type="date" value="<?=date("Y-m-d", strtotime($locacao['can']."-".$locacao['cmes']."-".$locacao['cdia']))?>" name="datinha" id="datinha-select" class="form-control form-control-sm"/>
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label class="small text-muted">Horário</label>
                        <div class="row">
                        <div class="col"> <input title="Hora inicial" name="chora" type="number" class="form-control form-control-sm" value="<?=$locacao['chora']?>" min="0" max="23" /> </div>
                        <div class="col"> <input title="Minuto inicial" name="cminuto" type="number" class="form-control form-control-sm" value="<?=$locacao['cminuto']?>" min="0" max="59" /> </div>
                         </div>	
                    </div>
                </div>
				<div class="form-group form-row">
					<div class="col-6">
						<label class="small text-muted">Tipo de Equipamento</label> 
						<select name="cprod" id="cprod-select" class="form-control form-control-sm">
							<option value="0">Selecione</option>
							<?php foreach($produtos as $d): ?>
								<option value="<?php echo $d['cprod'] ?>"<?php echo _isset($_POST['cprod'], $locacao['cprod']) == $d['cprod']? ' selected' : '' ?>>
									<?php echo $d['nlinha'].' > '.$d['nprod']; ?>
								</option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-6">
						<label class="small text-muted">Tabela</label>
						<select name="ctabela" id="ctabela-select" class="form-control form-control-sm">
							<?php foreach($tabela as $t): ?>
								<option value="<?php echo $t['ctabela'] ?>"<?php echo _isset($_POST['ctabela'], $locacao['ctabela']) == $t['ctabela']? ' selected' : '' ?>><?php echo $t['ntabela'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
		  </div>
		</div>
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Plano
			</div>
			<div class="card-body">
				<div id="planos"><small class="text-muted">Aguardando preenchimento dos dados.</small></div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Financeiro
			</div>
			<div class="card-body">
            	<div class="form-group">
					<label class="small text-muted">Valor R$</label>
					<input type="text" name="valor" id="valor-input" class="form-control form-control-sm"  placeholder="R$" value="<?php echo _isset($_POST['valor'], $locacao['valor']) ?>"/>
				</div>
				
				<div class="form-group">
					<label class="small text-muted">Forma de Pagamento</label> 
					<select name="cpgt" id="cpgt-select" class="form-control form-control-sm">
						<option value="0">Selecione</option>
						<?php foreach($formas_pagamento as $t): ?>
							<option value="<?php echo $t['cpgt'] ?>"<?php echo _isset($_POST['cpgt'], $locacao['cpgt']) == $t['cpgt']? ' selected' : '' ?>><?php echo $t['npgt'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				
				<div class="form-group">
					<label class="small text-muted">Parcelas</label> 
					<select name="cppgt" id="cppgt-select" class="form-control form-control-sm">
						<?php foreach($parcelas_pagamento as $ppgt): ?>
							<option value="<?php echo $ppgt['cppgt'] ?>"<?php echo _isset($_POST['cppgt'], $locacao['cppgt']) == $ppgt['cppgt']? ' selected' : '' ?>><?php echo $ppgt['nppgt'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				
				<div class="form-group">
					<label class="small text-muted">Data</label> 
					<input type="date" value="<?=date("Y-m-d", strtotime($locacao['can_pgt']."-".$locacao['cmes_pgt']."-".$locacao['cdia_pgt']))?>" name="datinha_pgt" id="datinha-select" class="form-control form-control-sm"/>
				</div>
			</div>
		</div>
		
		
		<div class="form-group">
			<label for="descricao-textarea" class="small text-muted">Descrição</label>
			<textarea name="descricao" id="descricao-textarea" class="form-control form-control-sm" rows="2" placeholder="(Opcional)"><?php echo _isset($_POST['descricao'], $locacao['descricao']) ?></textarea>
		</div>
		
		
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/locacao/view/' . $locacao['clocacao']) ?>">Cancelar</a>
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
(function() {
	$(document).ready(function() {
		bindEvents();
		init();
		
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
	
	function bindEvents() {
		/* Carregar os planos. */
		$("#cprod-select, #ctabela-select").change(load_planos);
		
		/* Atualizar o valor. */
		$("#valor-input").change(updateValorSpan);
	};
	
	function init() {
		if(<?php echo isset($_POST['cprod']) || isset($locacao['cprod'])? 'true' : 'false' ?>) {
			load_planos();
		}
	}
	
	function load_planos() {
		var cprod = $("#cprod-select").val();
		var ctabela = $("#ctabela-select").val();
		if(cprod == 0 || ctabela == 0)
			return;
		ajax({
			url: <?php echo '\'' . $this->url('/locacao/ajax_html_planos') . '\'' ?> + '/' + cprod + '/' + ctabela,
			container: '#planos'
		});
	};
	
	function updateValorSpan() {
		var valor = parseFloat($("#valor-input").val());
		
		valor = Number.isNaN(valor)? 0 : valor;
		
	}
})();
</script>