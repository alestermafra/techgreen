<nav class="navbar navbar-light">
	<span class="navbar-brand">Locação</span>
	<div>
		<a href="<?php echo $this->url('/locacao') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/locacao/editar/' . $locacao['clocacao']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
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
							<?php echo $locacao['nps'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Tipo de equipamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['nlinha'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Equipamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['nprod'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Tipo / Tabela de preços</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['ntabela'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Plano / Horas</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['nplano'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Data</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['cdia'].'/'.$locacao['cmes'].'/'.$locacao['can'] ?>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Horário</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['chora'].'h'.$locacao['cminuto'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Descrição</label>
						</div>
						<div class="col-md-8">
							<?php if($locacao['descricao'] === ''): ?>
								<span class="small text-muted">
									Nenhuma. <small>Clique em <a href="<?php echo $this->url('/aula/editar/' . $locacao['caula']) ?>">editar</a> para adicionar uma descrição.</small>
								</span>
							<?php else: ?>
								<?php echo $locacao['descricao'] ?>
							<?php endif ?>
						</div>
					</div>
					<div class="text-right">
						<a href="<?php echo $this->url('/agenda/agendar_locacao/'.$locacao['clocacao']) ?>" class="btn btn-sm btn-success">Agendar aluguel</a>
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
							<?php echo $locacao['valor'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Forma de Pagamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['npgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Parcelas de Pagamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['nppgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Data</label>
						</div>
						<div class="col-md-8">
							<?php echo $locacao['cdia_pgt'].'/'.$locacao['cmes_pgt'].'/'.$locacao['can_pgt'] ?>
						</div>
					</div>
				</div>
			</div>
			<br />
		</div>
	</div>
</div>	

<div class="container-fluid">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header bg-dark text-white">
					Saldo de horas
					<?php  if($vale_locacao){ ?>
					<div class="float-right">
                        <a title="Gerenciar saldo de horas" href="<?php echo $this->url('/locacao/vale_locacao/'.$locacao['cps'].'/'.$locacao['clocacao']) ?>" class="btn btn-sm btn-primary">
                            <i class="material-icons align-middle md-18">alarm</i>
                            <span class="align-middle">Gerenciar</span>
                        </a>
                    </div>
					<?php }?>
				</div>
				<div class="card-body">
					<?php  if(!$vale_locacao){ echo '<div>Sem saldo de horas para essa locação</div>';} ?>
					<?php foreach($vale_locacao as $vl):?>
					<div class="row form-group">
						<div class="col-md-2">
							<label class="small text-muted">Nome: </label>
						</div>
						<div class="col-md-10">
							<?php echo $vl['nps'] ?>
						</div>
						<div class="col-md-2">
							<label class="small text-muted">Horas: </label>
						</div>
						<div class="col-md-10">
							<?php echo $vl['horas'] ?>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>

<br />

<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			Ocorrências
			<div class="float-right">
				<a
					href="<?php echo $this->url('/ocorrencia/inserir/pessoa/'.$locacao['cps'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>"
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
							<tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/ocorrencia/editar/'.$ocorr['cocorrencia'].'/'.$ocorr['codigo'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>'">
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