<style>
	.lista-participantes .participante-container {
		margin-top: 1rem;
	}
	
	.lista-participantes .participante-container:first-child {
		margin-top: 0;
	}
</style>


<nav class="navbar navbar-light">
	<span class="navbar-brand">Aula / Curso</span>
	<div>
		<a href="<?php echo $this->url('/aula') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/aula/editar/' . $aula['caula']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>

<?php if(isset($error)): ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<?php echo $error ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif ?>


<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-header bg-dark text-white">
					Detalhes
				</div>
				<div class="card-body">
					<div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Tipo</label>
						</div>
						<div class="col-md-10">
							<?php echo $aula['nlinha'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Instrutor</label>
						</div>
						<div class="col-md-10">
							<?php echo $aula['instrutor'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Subtitulo</label>
						</div>
						<div class="col-md-10">
							<?php echo $aula['subtitulo'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Data</label>
						</div>
						<div class="col-md-10">
							<?php echo $aula['cdia'].'/'.$aula['cmes'].'/'.$aula['can'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Horário</label>
						</div>
						<div class="col-md-10">
							<?php echo $aula['chora'].'h'.$aula['cminuto'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Plano / Carga Horária</label>
						</div>
						<div class="col-md-10">
							<?php echo $aula['nplano'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Valor</label>
						</div>
						<div class="col-md-10">
							<?php echo $aula['valor'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Descrição</label>
						</div>
						<div class="col-md-10">
							<?php if($aula['descricao'] === ''): ?>
								<span class="small text-muted">
									Nenhuma. <small>Clique em <a href="<?php echo $this->url('/aula/editar/' . $aula['caula']) ?>">editar</a> para adicionar uma descrição.</small>
								</span>
							<?php else: ?>
								<?php echo $aula['descricao'] ?>
							<?php endif ?>
						</div>
					</div>
                    <div class="text-right">
                    	<a title="Remove aula e seus participantes (caso haja)" href="<?php echo $this->url('/aula/remover/'.$aula['caula']) ?>" class="btn btn-sm btn-danger">Remover aula</a>
						<a href="<?php echo $this->url('/agenda/agendar_aula/'.$aula['caula']) ?>" class="btn btn-sm btn-success">Agendar aula</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header bg-dark text-white">
					Participantes e Aula
					<div class="float-right">
                        <a href="<?php echo $this->url('/aula/participantes/'.$aula['caula']) ?>" class="btn btn-sm btn-primary" role="link" title="Novo participante">
                            <i class="material-icons align-middle md-18">add</i>
                            <span class="align-middle">Participante</span>
                        </a>
                    </div>
				</div>
				<div class="card-body lista-participantes">
					<?php if(!$participantes){ echo '<div>Sem participantes para essa aula/curso</div>';} ?>
					<?php foreach($participantes as $i => $pct):?>
						<div class="participante-container">
							<div>
								<a href="<?= $this->url("/overview_pf/{$pct["cps"]}") ?>"><?= $pct["nps"] ?></a>
								<span style="font-weight: bold">(<?= $pct["nprod"] ?>)</span>
							</div>
							<div class="row">
								<div class="col">
									<textarea data-id="<?= $pct["czaula"] ?>" type="text" class="form-control descricao-participante-textarea" style="height: 60px;"><?= $pct["descricao_participante"] ?></textarea>
									<small class="invisible">status</small>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
(function() {
	$(document).ready(function() {
		$(".descricao-participante-textarea").keyup(function() {
			var $textarea = $(this);
			var $status = $textarea.next();
			clearTimeout($textarea.data("timeout"));
			$textarea.data("timeout", setTimeout(function(){ save_descricao($textarea, $status); }, 1000));
			$status.text("Salvando...");
			$status.removeClass("invisible");
		});
	});
	
	function save_descricao($el, $status) {
		let czaula = $el.data("id");
		let descricao = $el.val();
		
		$.ajax({
			url: "<?= $this->url('/aula/ajax_set_descricao_participante') ?>",
			method: "POST",
			data: {
				"czaula": czaula,
				"descricao": descricao
			},
			success: function(result) {
				if(result === "success") {
					$status.text("Salvo!");
				}
				else {
					$status.text("Erro ao salvar. Tente novamente.");
				}
			},
			error: function(err) {
				$status.text("Erro ao salvar. Tente novamente. err");
			}
		});
	};
})();
</script>