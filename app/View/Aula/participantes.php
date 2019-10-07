<form action="<?php echo $this->url('/aula/participantes') ?>" method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Gerenciar Participantes</span>
	<div>
		<a class="btn btn-sm btn-secondary" role="button" style="width: 100px;" href="<?php echo $this->url('/aula/view/' . $caula) ?>">Voltar</a>
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
			<div class="card-body">
				<div>
					<input type="text" id="participantes-autocomplete" class="form-control" placeholder="Procurar cliente"></input>
				</div>
				<div id="participante-detalhes" style="display: none; padding-top: 10px;">
					<div class="form-group">
						<label class="text-muted">ID</label>
						<div class="participante-cps">8235</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							<label class="text-muted">Nome</label>
							<div class="participante-nps">Abilio de Souza</div>
						</div>
						<div class="col-md-6 form-group">
							<label class="text-muted">Classificação</label>
							<div class="participante-nseg">None</div>
						</div>
					</div>
					<div>
						<form action="<?php echo $this->url('/aula/participantes') ?>" method="POST">
							<input type="hidden" class="participante-cps" name="cps" required></input>
							
							<div class="form-group">
								<select name="cprod" class="form-control">
									<?php foreach($produtos as $pdd): ?>
										<option value="<?php echo $pdd['cprod'] ?>"><?php echo $pdd['nprod'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
							
							<input type="submit" class="btn btn-success" value="Inserir Participante"></input>
						</form>
					</div>
				</div>
				<div id="participante-detalhes-loading" style="text-align: center; display: none;">
					<div class="spinner-border text-dark">
					  <span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
		
		<h4>Participantes</h4>
		<div class="card">
			<div class="card-body">
				<?php if(empty($participantes)): ?>
					Nenhum participante para essa aula
				<?php else: ?>
					<?php foreach($participantes as $ptc): ?>
						<div>
							<span>
								<a href="<?= $this->url("/painel/overview_pf/{$ptc["cps"]}") ?>"><?= $ptc["nps"] ?></a>
							</span>
							<span style="color: #ccc;">
								(#<?= $ptc["cps"] ?>)
							</span> - <?= $ptc["nprod"] ?>
							<a href="<?php echo $this->url('/aula/remover_participante/' . $ptc['cps'] .'/'.$caula) ?>" class="btn btn-link btn-sm text-danger" title="Remover participante">
								<i class='material-icons md-18'>clear</i>
							</a>
						</div>
					<?php endforeach ?>
				<?php endif; ?>
		  </div>
		</div>
	</div>

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
	$("#participantes-autocomplete").autocomplete({
		source: '<?= $this->url("/painel/search") ?>',
		select: function(event, ui) {
			$("#participante-detalhes").hide();
			$("#participante-detalhes-loading").show();
			setTimeout(function() {
				$(".participante-cps").text(ui.item.cps);
				$(".participante-cps").val(ui.item.cps);
				$(".participante-nps").text(ui.item.nps);
				$(".participante-nseg").text(ui.item.nseg);
				$("#participante-detalhes-loading").hide();
				$("#participante-detalhes").fadeIn();
			}, 500);
			return false;
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div style='font-size: 19px;'>" + item.nps + " <span style='color: #ccc;'>(#" + item.cps + ")</span></div>")
			.appendTo(ul);
	};
});
</script>