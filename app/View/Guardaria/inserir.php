<form action="<?php echo $this->url('/guardaria/inserir') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Guarderia</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/guardaria') ?>">Cancelar</a>
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
				Equipamento
			</div>
			<div class="card-body">
				<div class="form-group">
					<label for="cequipe-select" class="small text-muted">Embarcação</label> <a class="small" href="<?php echo $this->url('/equipamentos/inserir') ?>">+ Novo</a>
					<select name="cequipe" id="cequipe-select" class="form-control form-control-sm">
						<option value="0">Selecione</option>
						<?php foreach($equipamentos as $t): ?>
							<option
								value="<?php echo $t['cequipe'] ?>"
								<?php echo _isset($_POST['cequipe'], 0) == $t['cequipe']? ' selected' : '' ?>
								data-cprod="<?php echo $t['cprod'] ?>"
							>
								<?php echo $t['nome'].' ('.$t['nps'].')' ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-row">
					<div class="form-group col-sm-6">
						<label for="cprod-select" class="small text-muted">Tipo de Embarcação</label>
						<select name="cprod" id="cprod-select" class="form-control form-control-sm">
							<option value="0">Selecione</option>
							<?php foreach($produtos as $d): ?>
								<option value="<?php echo $d['cprod'] ?>"<?php echo _isset($_POST['cprod'], 0) == $d['cprod']? ' selected' : '' ?>><?php echo $d['nprod'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-sm-6">
						<label for="ctabela-select" class="small text-muted">Tabela</label>
						<select name="ctabela" id="ctabela-select" class="form-control form-control-sm">
							<?php foreach($tabelas as $t): ?>
								<option value="<?php echo $t['ctabela'] ?>"<?php echo _isset($_POST['ctabela'], 0) == $t['ctabela']? ' selected' : '' ?>><?php echo $t['ntabela'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
		  </div>
		</div>
		
		<br />
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Plano
			</div>
			<div class="card-body">
				<div id="planos"><small class="text-muted">Aguardando preenchimento dos dados.</small></div>
			</div>
		</div>
		
		<br />
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Financeiro
			</div>
			<div class="card-body">
				<div>
					R$ <span id="valor-span" style="font-size: 29px;">0</span>,00 <button type="button" class="btn btn-link" onclick="document.getElementById('valor-container').style.display = 'block'; this.style.display = 'none';">alterar</button>
				</div>
				<div id="valor-container" style="display: none;">
					<div class="form-row">
						<div class="form-group col-md-2">
							<label for="valor-input" class="small text-muted">Valor</label>
							<input type="text" name="valor" id="valor-input" class="form-control form-control-sm" placeholder="R$" value="<?php echo _isset($_POST['valor'], '') ?>"></input>
						</div>
						<div class="form-group col-md-2">
							<label for="valor_extra-input" class="small text-muted">Valor Extra</label>
							<input type="text" name="valor_extra" id="valor_extra-input" class="form-control form-control-sm" placeholder="R$" value="<?php echo _isset($_POST['valor_extra'], '') ?>"></input>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-4">
						<label for="cpgt-seect" class="small text-muted">Forma de Pagamento</label>
						<select name="cpgt" id="cpgt-select" class="form-control form-control-sm">
							<?php foreach($formas_pagamento as $t): ?>
								<option value="<?php echo $t['cpgt'] ?>"<?php echo _isset($_POST['cpgt'], 0) == $t['cpgt']? ' selected' : '' ?>><?php echo $t['npgt'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="cppgt-select" class="small text-muted">Parcelamento</label>
						<select name="cppgt" id="cppgt-select" class="form-control form-control-sm">
							<?php foreach($parcelas_pagamento as $ppgt): ?>
								<option value="<?php echo $ppgt['cppgt'] ?>"<?php echo _isset($_POST['cppgt'], 0) == $ppgt['cppgt']? ' selected' : '' ?>><?php echo $ppgt['nppgt'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="d_vencimento-select" class="small text-muted">Dia de Vencimento</label>
						<input type="number" value="1" min="1" max="31" name="d_vencimento" id="d_vencimento-select" class="form-control form-control-sm"/>
					</div>
				</div>
			</div>
		</div>
		
		<br />
		
		<div class="form-group">
			<label for="descricao-textarea" class="small text-muted">Descrição</label>
			<textarea name="descricao" id="descricao-textarea" class="form-control form-control-sm" rows="2" placeholder="(Opcional)"><?php echo _isset($_POST['descricao'], '') ?></textarea>
		</div>
		
		
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/guardaria') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
		</div>
	</div>
</form>

<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
		init();
	});
	
	function bindEvents() {
		/* Carregar os planos. */
		$("#cprod-select, #ctabela-select").change(load_planos);
		
		/* Desabilita o envio de formulario ao teclar enter. */
		$("#valor-input, #valor_extra-input").keydown(function(e) {
			if(e.key === 'Enter') {
				e.preventDefault();
				$(this).trigger('change');
			}
		});
		
		/* Atualizar o valor. */
		$("#valor-input, #valor_extra-input").change(updateValorSpan);
		
		/* Ao alterar o equipamento, preenche o select do cprod com o do equipamento selecionado. */
		$("#cequipe-select").change(function(e) {
			const cprod = $(this).find('option:selected').attr('data-cprod');
			if(cprod) {
				$("#cprod-select").val(cprod);
				$("#cprod-select").trigger('change');
			}
		});
	};
	
	function init() {
		if(<?php echo isset($_POST['cprod'])? 'true' : 'false' ?>) {
			load_planos();
		}
	}
	
	function load_planos() {
		var cprod = $("#cprod-select").val();
		var ctabela = $("#ctabela-select").val();
		if(cprod == 0 || ctabela == 0)
			return;
		ajax({
			url: <?php echo '\'' . $this->url('/guardaria/ajax_html_planos') . '\'' ?> + '/' + cprod + '/' + ctabela,
			container: '#planos'
		});
	};
	
	function updateValorSpan() {
		var valor = parseFloat($("#valor-input").val());
		var valor_extra = parseFloat($("#valor_extra-input").val());
		
		valor = Number.isNaN(valor)? 0 : valor;
		valor_extra = Number.isNaN(valor_extra)? 0 : valor_extra;
		
		var total = valor + valor_extra;
		$("#valor-span").html(total);
	}
})();
</script>