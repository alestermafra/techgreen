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
				<select name="cps[0][cps]" class="form-control form-control-sm">
            		<option value="null">Ninguem selecionado</option>
					<?php foreach($pessoa as $p): ?>
						<option value="<?=$p['cps']?>">
							<?php echo $p['nps'].' (#'.$p['cps'].')'; ?>
						</option>
					<?php endforeach ?>
				</select>
			</div>
            
            
            <template id="cps-tmplt">
                <div class="card-body">
                    <select name="cps[{{index}}][cps]" class="form-control form-control-sm">
                    	<option value="null">Ninguem selecionado</option>
						<?php foreach($pessoa as $pp): ?>
                            <option value="<?php echo $pp['cps'] ?>"><?php echo $pp['nps'].' (#'.$pp['cps'].')';?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </template>
                                
            <div id="outros-cps-container"></div>
                    
            <div style="text-align: right">
                <button type="button" class="btn btn-sm btn-link add-cps-form">Adicionar Pessoa</button>
            </div>
            
		</div>
    
	</div>
    	
	<div class="form-group text-right">
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/agenda/agenda') ?>">Cancelar</a>
		<input type="button" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir" onclick="checa_coisas()">
	</div>
	
</form>

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