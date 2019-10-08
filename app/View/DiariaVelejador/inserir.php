<form action="<?php echo $this->url('/DiariaVelejador/inserir') ?>" method="POST">	

<nav class="navbar navbar-light">
	<span class="navbar-brand">Inserir dados para diária de velejador</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/DiariaVelejador') ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
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

<?php 
	//para valor
	foreach($val_prod as $vp){
		echo "<input type='hidden' name='val_".$vp['cprod']."_".$vp['ctabela']."' value='".$vp['valor']."' />";
	}
			
	//para plano
	foreach($planos as $plano){
		echo "<input type='hidden' name='cplano' value='".$plano['cplano']."' />";
	}
?>

	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Diária
			</div>
			<div class="card-body">
            	<div class="form-group">
					<input type="hidden" id="cps" name="cps"></input>
					<label for="cps-autocomplete" class="small text-muted">Cliente</label>
					<input type="text" id="cps-autocomplete" class="form-control form-control-sm" placeholder="Procurar cliente"></input>
				</div>
				<div id="cps-autocomplete-details" style="display: none;">
					<span id="cps-autocomplete-nps">cli</span> <span style="color: #CCC">(#<span id="cps-autocomplete-cps">id</span>)</span>
				</div>
                <div class="form-group">
					<label class="small text-muted">Data</label> 
					<input type="date" value="<?=date("Y-m-d")?>" name="datinha" id="datinha-select" class="form-control form-control-sm"/>
				</div>
				<div class="form-group form-row">
					<div class="col-9">
						<label class="small text-muted">Tipo de Equipamento</label> 
						<select name="cprod" id="cprod-select" class="form-control form-control-sm">
							<option value="0">Selecione</option>
							<?php foreach($produtos as $d): ?>
								<option value="<?php echo $d['cprod'] ?>"<?php echo _isset($_POST['cprod'], 0) == $d['cprod']? ' selected' : '' ?>>
									<?php echo $d['nprod']; ?>
								</option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-3">
						<label class="small text-muted">Plano</label> 
						<select name="ctabela" id="ctabela-select" class="form-control form-control-sm">
							<?php foreach($tabela as $tab): ?>
								<option value="<?php echo $tab['ctabela'] ?>">
									<?php echo $tab['ntabela']; ?>
								</option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
		  </div>
		</div>
		
		<br />
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Financeiro
			</div>
			<div class="card-body">
            	<div class="form-group">
					<label class="small text-muted">Valor R$</label>
					<input type="text" name="valor" id="valor-input" class="form-control form-control-sm"  placeholder="R$" value="<?php echo _isset($_POST['valor'], '') ?>"/>
				</div>
				
				<div class="form-group">
					<label class="small text-muted">Forma de Pagamento</label> 
					<select name="cpgt" id="cpgt-select" class="form-control form-control-sm">
						<?php foreach($formas_pagamento as $t): ?>
							<option value="<?php echo $t['cpgt'] ?>"<?php echo _isset($_POST['cpgt'], 0) == $t['cpgt']? ' selected' : '' ?>><?php echo $t['npgt'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				
				<div class="form-group">
					<label class="small text-muted">Parcelas</label> 
					<select name="cppgt" id="cppgt-select" class="form-control form-control-sm">
						<?php foreach($parcelas_pagamento as $ppgt): ?>
							<option value="<?php echo $ppgt['cppgt'] ?>"<?php echo _isset($_POST['cppgt'], 0) == $ppgt['cppgt']? ' selected' : '' ?>><?php echo $ppgt['nppgt'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				
				<div class="form-group">
					<label class="small text-muted">Data</label> 
					<input type="date" value="<?=date("Y-m-d")?>" name="datinha_pgt" id="datinha-select" class="form-control form-control-sm"/>
				</div>
			</div>
		</div>
		
		<br />
		
		<div class="form-group">
			<label for="descricao-textarea" class="small text-muted">Descrição</label>
			<textarea name="descricao" id="descricao-textarea" class="form-control form-control-sm" rows="2" placeholder="(Opcional)"><?php echo _isset($_POST['descricao'], '') ?></textarea>
		</div>
		
		
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/DiariaVelejador') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
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
		$("#cprod-select").change(load_valor);
		$("#ctabela-select").change(load_valor);
	};
	
	function init() {
		if(<?php echo isset($_POST['cprod'])? 'true' : 'false' ?>) {
			load_valor();
		}
	}
	
	function load_valor() {
		var cprod = $("#cprod-select").val();
		var ctabela = $("#ctabela-select").val();
		var valor = $("input[name=val_"+cprod+"_"+ctabela+"]").val();
		
		if(cprod == 0) {
			$("#valor-input").val(0);
			return;
		}else{
			$("#valor-input").val(valor);
		}
	};
})();
</script>