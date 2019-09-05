<form action="<?php echo $this->url('/estoque/inserir_estoque') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Inserir Produto em Estoque</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/movimentacao') ?>">Cancelar</a>
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

	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Detalhes
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Produto</label> 
					<select name="cprod" class="form-control form-control-sm" autofocus>
						<?php foreach($produtos as $prod): ?>
							<option value="<?php echo $prod['cprod'] ?>">
								<?php echo $prod['nlinha'] .' > '. $prod['nprod'] ?>
							</option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group form-row">
					<div class="col-6">
						<label class="small text-muted">Estoque</label> 
						<input name="qtd" type="number" class="form-control form-control-sm" placeholder="Quantidade em estoque" autocomplete="off" required />
					</div>
					<div class="col-6">
						<label class="small text-muted">Quantidade Máxima</label> 
						<input name="qtd_max" type="number" class="form-control form-control-sm" placeholder="Quantidade/capacitade máxima de estoque" autocomplete="off" required />
					</div>
				</div>
		  </div>
		</div>
		
		<br>
		
		<div class="form-group text-right">
			<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?php echo $this->url('/estoque/movimentacao') ?>">Cancelar</a>
			<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"/>
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
		$("[name='qtd']").mask('00000');
		$("[name='qtd_max']").mask('00000');
	};

})();
</script>