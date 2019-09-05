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
		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-dark text-white">
					Detalhes
				</div>
				<div class="card-body">
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Tipo</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['nlinha'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Instrutor</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['instrutor'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Subtitulo</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['subtitulo'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Data</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['cdia'].'/'.$aula['cmes'].'/'.$aula['can'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Horário</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['chora'].'h'.$aula['cminuto'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Plano / Carga Horária</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['nplano'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Descrição</label>
						</div>
						<div class="col-md-8">
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
						<a href="<?php echo $this->url('/agenda/agendar_aula/'.$aula['caula']) ?>" class="btn btn-sm btn-success">Agendar aula</a>
					</div>
				</div>
			</div>
		</div>
	
		
		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-dark text-white">
					Financeiro
				</div>
				<div class="card-body">
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Valor Total</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['valor'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Forma de Pagamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['npgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Parcelas de Pagamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['nppgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Data</label>
						</div>
						<div class="col-md-8">
							<?php echo $aula['cdia_pgt'].'/'.$aula['cmes_pgt'].'/'.$aula['can_pgt'] ?>
						</div>
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
				<div class="card-body">
					<?php  if(!$participantes){ echo '<div> Sem participantes para essa aula / curso </div>';} ?>
					<?php foreach($participantes as $pct):?>
                        <div class="row form-group">
                            <div class="col-md-12"><?php echo $pct['nps'].' <b>('.$pct['nprod'].')</b>' ?></div>
                        </div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>