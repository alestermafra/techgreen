<nav class="navbar navbar-light">
	<span class="navbar-brand">Guardaria</span>
	<div>
		<a href="<?php echo $this->url('/guardaria') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/guardaria/editar/' . $guardaria['cguardaria']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>


<?php if(isset($_GET['inserido'])): ?>
	<div class="container-fluid">
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			Guardaria inserida com sucesso.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
<?php endif ?>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-dark text-white">
					Detalhes
                    <div class="float-right">
                    	<a role="button" class="btn btn-sm btn-primary" target="_blank" href="<?php echo $this->url('/guardaria/gerar_contrato/' . $guardaria['cguardaria']) ?>">Ver Contrato</a>
                    </div>
				</div>
				<div class="card-body">
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Embarcação</label>
						</div>
						<div class="col-md-8">
							<a href="<?php echo $this->url('/equipamentos/view/' . $guardaria['cequipe']) ?>"><?php echo $guardaria['nome'] ?></a>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Equipamento em venda?</label>
						</div>
						<div class="col-md-8">
							<?php 	
								if($guardaria['flg_venda'] ==1) {echo 'Sim';} else {echo 'Não';}
								if($guardaria['flg_venda'] ==1) {echo ' ('.$guardaria['valor_venda'].')';} else {echo '';} 
							?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Pessoa</label>
						</div>
						<div class="col-md-8">
							<a href="<?php echo $this->url('/painel/overview_pf/' . $guardaria['cps']) ?>"><?php echo $guardaria['nps'] ?></a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Modelo da Guardaria</label>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['nprod'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Descrição</label>
						</div>
						<div class="col-md-8">
							<?php if($guardaria['descricao'] === ''): ?>
								<span class="small text-muted">
									Nenhuma. <small>Clique em <a href="<?php echo $this->url('/guardaria/editar/' . $guardaria['cguardaria']) ?>">editar</a> para adicionar uma descrição.</small>
								</span>
							<?php else: ?>
								<?php echo $guardaria['descricao'] ?>
							<?php endif ?>
						</div>
					</div>
					
					<div class="float-right">
						<?php if($guardaria['ativo'] == 1): ?>
							<form action="<?php echo $this->url('/guardaria/cancelar_contrato/' . $guardaria['cguardaria']) ?>" method="POST">
								<input type="submit" class="btn btn-sm btn-danger" value="Cancelar Contrato"></input>
							</form>
						<?php endif ?>
						<?php if($guardaria['ativo'] == 0): ?>
							<form action="<?php echo $this->url('/guardaria/ativar_contrato/' . $guardaria['cguardaria']) ?>" method="POST">
								<input type="submit" class="btn btn-sm btn-success" value="Reativar Contrato"></input>
							</form>
						<?php endif ?>
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
							<?php echo $guardaria['valor'] + $guardaria['valor_extra'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Plano</label>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['nplano'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Valor do Plano</label>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['valor'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Valor Extra</label>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['valor_extra'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Forma de Pagamento</label>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['npgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Parcelas</label>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['nppgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Dia de Vencimento</label>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['d_vencimento'] ?>
						</div>
					</div>
					<div class="text-right">
						<a href="<?php echo $this->url('/agenda/agendar_cobranca_guardaria/'.$guardaria['cguardaria']) ?>" class="btn btn-sm btn-primary">Agendar cobranças</a>
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
					href="<?php echo $this->url('/ocorrencia/inserir/equipamento/'.$guardaria['cequipe'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>"
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