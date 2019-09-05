<form action="<?php echo $this->url('/aula/participantes') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Gerenciar Participantes</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/aula/view/' . $caula) ?>">Voltar</a>
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


	<input type="hidden" name="caula" value="<?=$caula?>"/>
	
	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Participantes Existentes
			</div>
			<div class="card-body">
				<div class="form-group">
					<?php  if(!$participantes){ echo '<div> Sem participantes para essa aula / curso </div>';} ?>
					<?php foreach($participantes as $ptc): ?>
						<div> <?php echo $ptc['nps']. ' ('.$ptc['nprod'].')' ?> 
							<a href="<?php echo $this->url('/aula/remover_participante/' . $ptc['cps'] .'/'.$caula) ?>" class="btn btn-link btn-sm text-danger" title="Remover participante">
								<i class='material-icons md-18'>clear</i>
							</a>
						</div>
					<?php endforeach ?>
				</div>
		  </div>
		</div>
		
		<div class="card">
			<div class="card-header bg-dark text-white">
				Vincular Participante e aula
			</div>
			<div class="card-body">
            	<div class="row">
                    <div class="form-group col-sm-6">
                        <select name="cps" class="form-control form-control-sm">
                            <?php foreach($pessoas as $pss): ?>
                                <option value="<?php echo $pss['cps'] ?>"><?php echo $pss['nps'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <select name="cprod" class="form-control form-control-sm">
                            <?php foreach($produtos as $pdd): ?>
                                <option value="<?php echo $pdd['cprod'] ?>"><?php echo $pdd['nprod'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
			</div>
		</div>
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/aula/view/' . $caula) ?>">Voltar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir">
		</div>
	</div>
</form>
