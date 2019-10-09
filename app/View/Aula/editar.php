<form action="<?php echo $this->url('/aula/editar/' . $aula['caula']) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Gerenciar Aula / Curso</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/aula/view/' . $aula['caula']) ?>">Cancelar</a>
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

<?php 
	//para valor
	foreach($val_prod as $vp){
		echo "<input type='hidden' name='cprod_".$vp['clinha']."' value='".$vp['valor']."' />";
	}
	//para plano/carga horária (nome)
	foreach($val_prod as $pdd){
		echo "<input type='hidden' name='plano_".$pdd['clinha']."' value='".$pdd['nplano']."' />";
	}
	//para plano/carga horária (valor)
	foreach($val_prod as $ppdd){
		echo "<input type='hidden' name='plano-val_".$ppdd['clinha']."' value='".$ppdd['cplano']."' />";
	}
?>
	
	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Aula / Curso
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Tipo de Aula / Curso</label> 
					<select name="clinha" id="clinha-select" class="form-control form-control-sm">
						<option value="0">Selecione</option>
						<?php foreach($linha as $d): ?>
							<option value="<?php echo $d['clinha'] ?>"<?php echo _isset($_POST['clinha'], $aula['clinha']) == $d['clinha']? ' selected' : '' ?>>
								<?php echo $d['nlinha']; ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
                <div class="form-group form-row">
					<div class="form-group col-sm-6">
						<label class="small text-muted">Valor R$</label>
						<input type="text" name="valor" id="valor-input" class="form-control form-control-sm"  placeholder="R$" value="<?php echo _isset($_POST['valor'], $aula['valor']) ?>">
					</div>
					<div class="form-group col-sm-6">
						<label class="small text-muted">Plano / Carga horária</label>
						<input type="text" name="plano" id="plano-input" class="form-control form-control-sm" readonly value="<?php echo $aula['nplano'] ?>" />
						<input type="hidden" name="cplano" id="cplano-input" value="<?php echo $aula['cplano'] ?>" />
					</div>
				</div>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label class="small text-muted">Data de aula/curso</label> 
                        <input type="date" value="<?=date("Y-m-d", strtotime($aula['can']."-".$aula['cmes']."-".$aula['cdia']))?>" name="datinha" id="datinha-select" class="form-control form-control-sm"/>
                    </div>
                    
                    <div class="form-group col-sm-6">
                        <label class="small text-muted">Inicio</label>
                        <div class="row">
                        <div class="col"> <input title="Hora inicial" name="chora" type="number" class="form-control form-control-sm" value="<?=$aula['chora']?>" min="0" max="23" /> </div>
                        <div class="col"> <input title="Minuto inicial" name="cminuto" type="number" class="form-control form-control-sm" value="<?=$aula['cminuto']?>" min="0" max="59" /> </div>
                         </div>	
                    </div>
                </div>
                
                <div class="form-group">
					<label class="small text-muted">Instrutor</label> 
					<input type="text" value="<?=$aula['instrutor']?>" name="instrutor" id="instrutor-input" class="form-control form-control-sm" placeholder="Nome do instrutor"/>
				</div>
                
                <div class="form-group">
					<label class="small text-muted">Subtitulo</label> 
					<input type="text" value="<?=$aula['subtitulo']?>" name="subtitulo" id="subtitulo-input" class="form-control form-control-sm" placeholder="Ex: 5º Aula, 2º Aula de Veleiro, etc" maxlength="100"/>
				</div>
		  </div>
		</div>
        
		<div class="form-group">
			<label for="descricao-textarea" class="small text-muted">Descrição</label>
			<textarea name="descricao" id="descricao-textarea" class="form-control form-control-sm" rows="2" placeholder="(Opcional)"><?php echo _isset($_POST['descricao'], $aula['descricao']) ?></textarea>
		</div>
		
		
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/aula/view/' . $aula['caula']) ?>">Cancelar</a>
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
		$("#clinha-select").change(load_valor);
	};
	
	function init() {
		if(<?php echo isset($_POST['cprod'])? 'true' : 'false' ?>) {
			load_valor();
		}
	}
	
	function load_valor() {
		var cprod = $("#clinha-select").val();
		var valor = $("input[name=cprod_"+cprod+"]").val();
		var plano_n = $("input[name=plano_"+cprod+"]").val();
		var plano_v = $("input[name=plano-val_"+cprod+"]").val();
		
		if(cprod == 0) {
			$("#valor-input").val(0);
			$("#plano-input").val(0);
			$("#cplano-input").val(0);
			return;
		}else{
			$("#valor-input").val(valor);
			$("#plano-input").val(plano_n);
			$("#cplano-input").val(plano_v);
		}
	};
})();
</script>