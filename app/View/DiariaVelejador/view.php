<nav class="navbar navbar-light">
	<span class="navbar-brand">Diária de Velejador</span>
	<div>
		<a href="<?php echo $this->url('/DiariaVelejador') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/DiariaVelejador/editar/' . $diaria['cdiaria']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
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
							<label class="small text-muted">Nome</label>
						</div>
						<div class="col-md-8">
							<?php echo $diaria['nps'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Equipamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $diaria['nprod'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Plano </label>
						</div>
						<div class="col-md-8">
							<?php echo $diaria['ntabela'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Data</label>
						</div>
						<div class="col-md-8">
							<?php echo $diaria['cdia'].'/'.$diaria['cmes'].'/'.$diaria['can'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Descrição</label>
						</div>
						<div class="col-md-8">
							<?php if($diaria['descricao'] === ''): ?>
								<span class="small text-muted">
									Nenhuma. <small>Clique em <a href="<?php echo $this->url('/aula/editar/' . $diaria['caula']) ?>">editar</a> para adicionar uma descrição.</small>
								</span>
							<?php else: ?>
								<?php echo $diaria['descricao'] ?>
							<?php endif ?>
						</div>
					</div>
					<div class="text-right">
						<a href="<?php echo $this->url('/agenda/agendar_diaria/'.$diaria['cdiaria']) ?>" class="btn btn-sm btn-success">Agendar a diária</a>
					</div>
				</div>
			</div>
			<br />
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
							<?php echo $diaria['valor'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Forma de Pagamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $diaria['npgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Parcelas de Pagamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $diaria['nppgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Data</label>
						</div>
						<div class="col-md-8">
							<?php echo $diaria['cdia_pgt'].'/'.$diaria['cmes_pgt'].'/'.$diaria['can_pgt'] ?>
						</div>
					</div>
				</div>
			</div>
			<br />
		</div>
	</div>
</div>	


<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			Ocorrências
			<div class="float-right">
				<a
					href="<?php echo $this->url('/ocorrencia/inserir/pessoa/'.$diaria['cps'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>"
					class="btn btn-sm btn-primary"
					role="button"
					title="Nova ocorrência"
				>
					<i class="material-icons align-middle md-18">add</i>
					<span class="align-middle">Ocorrência</span>
				</a>
			</div>
		</div>
		<div class="card-body">
			<?php if(empty($ocorrencia)): ?>
				<div class="small text-muted">Sem ocorrências por enquanto.</div>
			<?php else: ?>
				<table class="table table-sm table-striped table-hover">
					<thead>
						<tr>
							<td><label class="small">id</label></td>
							<td><label class="small">Assunto</label></td>
							<td><label class="small">Descrição</label></td>
							<td><label class="small">Data</label></td>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach($ocorrencia as $ocorr):?>
							<tr>
								<td><?php echo $ocorr['cocorrencia'] ?></td>
								<td><?php echo $ocorr['assunto'] ?></td>
								<td><?php echo $ocorr['descricao'] ?></td>
								<td><?php echo $ocorr['data'] ?></td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
	</div>
</div>

<br />