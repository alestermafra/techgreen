<form action="<?php echo $this->url('/locacao/vale_locacao/' . $vale['cps'] . '/'. $clocacao) ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Gerenciar Horas Vale Locação</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/locacao/view/' . $clocacao) ?>">Cancelar</a>
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
			Pessoa
        </div>
		
		<div class="card-body">
			<div class="form-group">
				<label><?=$vale['nps']?></label>
			</div>
		</div>
	</div>

        <input type="hidden" value="<?=$clocacao?>" name="clocacao" />
        <input type="hidden" value="<?=$vale['cps']?>" name="cps" />
        <input type="hidden" value="<?=$vale['choraslocacao']?>" name="choraslocacao" />
	<br />
    
    <div class="card">
		<div class="card-header bg-dark text-white">
			Saldo de horas
        </div>   
        
		<div class="card-body">
			<div class="form-group form-row">
				<div class="col-6">
					<label for="horinhas-input"><small>Horas atuais</small></label>
					<input type="text" readonly name="horinhas" class="form-control form-control-sm" value="<?php echo $vale['horas'] ?>"/>
				</div>
				
				<div class="col-6">
					<label for="horas-input"><small>Horas</small></label>
					<input type="number" name="horas" id="horas-input" min="0" class="form-control form-control-sm" value="<?php echo _isset($_POST['horas'], $vale['horas']) ?>"/>
				</div>
			</div>		
		</div>
	</div>
		
	<br />
	
	<div class="form-group text-right">	
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/locacao/view/' . $clocacao) ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
	</div>
</div>
</form>

<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
	});
	
	function bindEvents() {
		/* mask */
		$("[name='horas']").mask('0000');
	};
	
})();
</script>