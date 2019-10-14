<style>
	select[readonly] {
	  background: #eee; 
	  pointer-events: none;
	  touch-action: none;
	}
</style>

<form action="<?php echo $this->url('/ocorrencia/editar/'.$ocorrencia['cocorrencia'].'/'.$cod.'/'.str_replace('/','-',$onde)) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Editar Ocorrência</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url($onde) ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir">
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


<input type="hidden" name="cocorrencia" value="<?=$ocorrencia['cocorrencia']?>" />

<?php
	if($ocorrencia['ctocorrencia'] == 2){
		$target = "pessoa";
	}
	else if($ocorrencia['ctocorrencia'] == 1){
		$target = "equipamento";
	}
?>

<div class="container-fluid">
	<div class="card">
		<div class="card-header bg-dark text-white">
			Tipo de Ocorrência
        </div>

		  <div class="card-body">
		  
          	<div class="form-row">
				<div class="form-group col-sm-3">
					<label for="ctocorrencia-select"><small>Tipo</small></label>
					<select name="ctocorrencia" id="ctocorrencia-select" class="form-control form-control-sm" readonly>
							<option value="1" <?php if($target == "equipamento") { echo 'selected';}?>>Equipamento</option>
                            <option value="2" <?php if($target == "pessoa") { echo 'selected';}?>>Pessoa</option>
					</select>
				</div>
                
                <div class="form-group col-sm-9">
					<label for="codigo-select"><small>Referência</small></label>
					<select name="codigo" id="codigo-select" class="form-control form-control-sm">
						<?php 
                        	if($target == "pessoa"){ 
								foreach($lista_cod as $l){
									echo '<option value="'.$l['cps'].'" ';
									if($l['cps']==$cod){echo 'selected';}
									echo '>';
									echo $l['nps'].' (#'.$l['cps'].')';
									echo '</option>';
								}
                            }
                            
                            if($target == "equipamento"){ 
								foreach($lista_cod as $l){
									echo '<option value="'.$l['cequipe'].'" ';
									if($l['cequipe']==$cod){echo 'selected';}
									echo ' >';
									echo $l['nome'].' (#'.$l['cequipe'].') ('.$l['nps'].')';
									echo '</option>';
								}
							} 
						?>
					</select>
				</div>
			</div>
            	
		  </div>
	</div>
		
		<br />
        
    <div class="card">
		<div class="card-header bg-dark text-white">
			Dados de ocorrência / registro / atividade
		</div>
		<div class="card-body">
			<div class="form-group">
				<label for="assunto-input"><small>Assunto</small></label>
				<input name="assunto" id="assunto-input" type="text" class="form-control form-control-sm" placeholder="Assunto resumido" autocomplete="off" value="<?php echo _isset($_POST['assunto'], $ocorrencia['assunto']) ?>" />
			</div>
                
			<div class="form-group">
				<label for="descricao-textarea"><small>Descrição</small></label>
				<textarea name="descricao" id="descricao-textarea" class="form-control form-control-sm" rows="2" placeholder="Observações e descrição geral"><?php echo _isset($_POST['descricao'], $ocorrencia['descricao']) ?></textarea>
			</div>
                
            <div class="form-group">
				<label for="data-input"><small>Data</small></label>
				<input type="date" name="data" id="data-input" class="form-control form-control-sm" value="<?=date("Y-m-d");?>" readonly>
			</div>
		</div>
	</div>
    
    <br />
    
    <div class="form-group text-right">	
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url($onde) ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
	</div>
</div>
</form>