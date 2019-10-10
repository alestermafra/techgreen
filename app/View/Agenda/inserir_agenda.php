<form action="<?php echo $this->url('/agenda/inserir_agenda') ?>" method="POST" id="form">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Novo Evento em Calendário / Agenda</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/agenda/agenda') ?>">Cancelar</a>
		<input type="button" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir" onclick="checa_coisas()">
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

<?php //resgata a data selecionada, caso haja
   	if($dia && $mes && $ano){
		$datinha = date("Y-m-d", strtotime($ano."-".$mes."-".$dia));
		$datinha_fim = date("Y-m-d", strtotime($ano."-".$mes."-".$dia));
	}else{
		$datinha = date("Y-m-d");
		$datinha_fim = date("Y-m-d");
	}		
?>
	
	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Data e horário
			</div>
			<div class="card-body">
            	<div class="form-row">
                	<div class="form-group col-sm-6">
                    	<input type="checkbox" name="flg_dia_todo" value="0" onchange="duracao_dia()" />
						<label class="form-check-label">Duração para o dia inteiro</label>
                    </div>
                    <div class="form-group col-sm-6">
                    	<label class="small text-muted">Cor de tarja</label>
                        <select class="form-control form-control-sm" name="cor">
                        	<option value="">Sem tarja</option>
                            <option value="87CEFA" style="background-color:#87CEFA">Ciano</option>
                            <option value="FFD700" style="background-color:#FFD700">Dourado</option>
                            <option value="CC99FF" style="background-color:#CC99FF">Malva</option>
                        </select>
                    </div>
                </div>
            	<div class="form-row">
                    <div class="form-group col-sm-6">
                        <label class="small text-muted">Data de inicio</label>
                        <input title="Data do evento" name="datinha" type="date" class="form-control form-control-sm" value="<?=$datinha?>" required />
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="small text-muted">Data de fim <small>(caso dure mais dias)</small></label>
                        <input title="Data de fim do evento" name="datinha_fim" type="date" class="form-control form-control-sm" value="<?=$datinha_fim?>" required />
                    </div>
                </div>
				<div class="form-row">
					<div class="form-group col-sm-6">
						<label class="small text-muted">Inicio</label>
                            <div class="row">
                            <div class="col"> <input title="Hora inicial" name="chora_ini" type="number" class="form-control form-control-sm" value="<?=date("G")?>" min="0" max="23" /> </div>
                            <div class="col"> <input title="Minuto inicial" name="cminuto_ini" type="number" class="form-control form-control-sm" value="<?=date("i")?>" min="0" max="59" /> </div>
                            </div>	
					</div>
					<div class="form-group col-sm-6">
						<label class="small text-muted">Fim</label>
                        <div class="row">
                            <div class="col"> <input title="Hora de término" name="chora_fim" type="number" class="form-control form-control-sm" value="<?=date("G", strtotime("+1 hour"))?>" min="0" max="23" /> </div>
                            <div class="col"> <input title="Minuto de término" name="cminuto_fim" type="number" class="form-control form-control-sm" value="<?=date("i")?>" min="0" max="59" /> </div>
						</div>
					</div>
				</div>
		  </div>
		</div>
		
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Evento
			</div>
			<div class="card-body">
				<div class="form-group">
					<select name="cacao" class="form-control form-control-sm">
						<?php foreach($acao as $acao): ?>
							<option value="<?php echo $acao['cacao'] ?>">
								<?php echo $acao['nacao'] ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
				
				<div class="form-group">
					<textarea name="OBS" class="form-control form-control-sm" rows="3" placeholder="Observações"></textarea>
				</div>
			</div>
		</div>
        
        <div class="card">
			<div class="card-header bg-dark text-white">
				Pessoa
			</div>
			<div class="card-body">
				<div class="form-group">
					<input type="text" id="cps-autocomplete" class="form-control form-control-sm" placeholder="Procurar cliente (opcional)"></input>
				</div>
				
				<div id="outros-cps-container"></div>
			</div>
            
            
            <template id="cps-tmplt">
				<div id="cps-{{index}}-container">
					<input type="hidden" id="cps-{{index}}-input" name="cps[{{index}}][cps]" value="{{cps}}"></input>
					<div><span>{{nps}}</span> <button type="button" class="btn btn-link" onclick="$('#cps-{{index}}-input').val(0); $('#cps-{{index}}-container').hide();">remover</button></div>
				</div>
            </template>
		</div>
    
	</div>
    	
	<div class="form-group text-right">
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/agenda/agenda') ?>">Cancelar</a>
		<input type="button" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir" onclick="checa_coisas()">
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
	let cps_index = 1;
	$("#cps-autocomplete").autocomplete({
		source: '<?= $this->url("/agenda/search_pessoa") ?>',
		select: function(event, ui) {
			let index = cps_index++;
			
			let tmplt = $("#cps-tmplt").html();
			tmplt = tmplt.replace(/{{index}}/g, index);
			tmplt = tmplt.replace(/{{cps}}/g, ui.item.cps);
			tmplt = tmplt.replace(/{{nps}}/g, ui.item.nps);
			
			$("#outros-cps-container").append(tmplt);
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div style='font-size: 19px;'>" + item.nps + " <span style='color: #ccc;'>(#" + item.cps + ") - " + (item.cpsf? "PF" : "PJ") + "</span></div>")
			.appendTo(ul);
	};
});
</script>

<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
	});
	
	function bindEvents() {
		$(".add-cps-form").click(add_cps_form);
	};
	
	function add_cps_form() {
		var index = $("[name$='\\[cps\\]']").length;
		
		var tmplt = $("#cps-tmplt").html();
		var html = tmplt.replace(/{{index}}/g, index);
		
		$("#outros-cps-container").append(html);
	};
})();

	function duracao_dia(){ // checa para habilitar e desabilitar o horário
		if($("[name='flg_dia_todo']"). prop("checked") == true){
			$("[name='flg_dia_todo']").val(1);
			$("[name='datinha_fim']").prop( "disabled", true );
			$("[name='chora_ini']").prop( "disabled", true );
			$("[name='chora_fim']").prop( "disabled", true );
			$("[name='cminuto_ini']").prop( "disabled", true );
			$("[name='cminuto_fim']").prop( "disabled", true );
		} else {
			$("[name='flg_dia_todo']").val(0);
			$("[name='datinha_fim']").prop( "disabled", false );
			$("[name='chora_ini']").prop( "disabled", false );
			$("[name='chora_fim']").prop( "disabled", false );
			$("[name='cminuto_ini']").prop( "disabled", false );
			$("[name='cminuto_fim']").prop( "disabled", false );
		}
	}
	
	function checa_coisas(){
		var data_ini = $("[name='datinha']").val();
		var data_fim = $("[name='datinha_fim']").val();
		var hora_ini = $("[name='chora_ini']").val();
		var hora_fim = $("[name='chora_fim']").val();
		var minut_ini = $("[name='cminuto_ini']").val();
		var minut_fim = $("[name='cminuto_fim']").val();
		
		if(data_ini > data_fim){ //data inicial maior que a data final
			alert('Data inicial do evento não pode ser maior que a data final');
			$("[name='datinha_fim']").focus();
			return;
		}
		
		if(data_ini == data_fim){ //outras verificações
			if(hora_ini > hora_fim){ //hora inicial maior que a hora final
				alert('Horário inicial do evento não pode ser maior que o horário final');
				$("[name='chora_fim']").focus();
				return;
			}else{ //outras verificações
				if((hora_ini == hora_fim) && (minut_ini > minut_fim)){ //minuto inicial maior que minuto final quando a hora for igual
					alert('Horário inicial do evento não pode ser maior que o horário final');
					$("[name='cminuto_fim']").focus();
					return;
				}
			}
		}
		
		document.getElementById("form").submit();
	};
</script>