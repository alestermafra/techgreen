<?php
	$months = [ 1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
?>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Guarderia</span>
	<div>
		<a href="<?php echo $this->url('/guardaria') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/guardaria/editar/' . $guardaria['cguardaria']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>


<?php if(isset($_GET['inserido'])): ?>
	<div class="container-fluid">
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			Guarderia inserida com sucesso.
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
							<label class="small text-muted">Proprietário</label>
						</div>
						<div class="col-md-8">
							<a href="<?php echo $this->url('/painel/overview_pf/' . $guardaria['cps']) ?>"><?php echo $guardaria['nps'] ?></a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Tipo</label>
						</div>
						<div class="col-md-8">
							<a href="<?php echo $this->url('/equipamentos/view/' . $guardaria['cequipe']) ?>"><?php echo $guardaria['nlinha'] ?></a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Modelo</label>
						</div>
						<div class="col-md-8">
						<a href="<?php echo $this->url('/equipamentos/view/' . $guardaria['cequipe']) ?>"><?php echo $guardaria['nprod'] ?></a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">Nome</label>
						</div>
						<div class="col-md-8">
							<a href="<?php echo $this->url('/equipamentos/view/' . $guardaria['cequipe']) ?>"><?php echo $guardaria['nome'] ?></a>
						</div>
					</div>
                    <div class="row form-group">
						<div class="col-md-4">
							<label class="small text-muted">À Venda?</label>
						</div>
						<div class="col-md-8">
							<?php 	
								if($guardaria['flg_venda'] == 1)
									echo 'Sim (' . money($guardaria['valor_venda']) . ')';
								else echo 'Não';
							?>
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
							<span class="text-muted">Plano</span>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['nplano'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<span class="text-muted">Vencimento</span>
						</div>
						<div class="col-md-8">
							<?= str_pad($guardaria['d_vencimento'], 2, '0', STR_PAD_LEFT) ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<span class="text-muted">Forma de Pagamento</span>
						</div>
						<div class="col-md-8">
							<?php echo $guardaria['npgt'] ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<span class="text-muted">Valor</span>
						</div>
						<div class="col-md-8">
							<?= money($guardaria['valor']); ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label class="text-muted">Observação</label>
						</div>
						<div class="col-md-8">
							<?php if($guardaria['descricao'] == ''): ?>
								<span class="text-muted">
									Nenhuma
								</span>
							<?php else: ?>
								<?= $guardaria['descricao'] ?>
							<?php endif ?>
						</div>
					</div>

					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
						Informar Pagamento
					</button>
				</div>
			</div>
			
			<div class="card" >
				<div class="card-header bg-dark text-white">
					Histórico de Pagamentos
				</div>
				<div class="card-body" style="max-height: 400px; overflow-y: scroll;">
					<?php if(empty($pagamentos)): ?>
						Nenhum pagamento informado
					<?php else: ?>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">Mês Referência</th>
									<th scope="col">Valor</th>
									<th scope="col">Data Pagamento</th>
									<th scope="col" class="text-center" style="width: 125px;">Opções</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($pagamentos as $pagamento): ?>
									<tr>
										<td class="align-middle" title="<?= $months[$pagamento['mes_ref']] ?>/<?= $pagamento['ano_ref'] ?>" nowrap><?= str_pad($pagamento['mes_ref'], 2, "0", STR_PAD_LEFT) . '/' . $pagamento['ano_ref'] ?></td>
										<td class="align-middle" nowrap><?= money($pagamento['valor']); ?></td>
										<td class="align-middle" nowrap><?= date('d/m/Y', strtotime($pagamento['data_pagamento'])) ?></td>
										<td class="align-middle">
											<div class="dropdown text-center">
												<a href="#" class="btn btn-link p-0 m-0" id="historico-dropdown-btn" data-toggle="dropdown">
													<span class="material-icons align-middle">more_vert</span>
												</a>

												<div class="dropdown-menu p-0" aria-labelledby="historico-dropdown-btn">
													<a href="<?= $this->url('/guardaria/remover_pagamento/' . $pagamento['id'] . '/' . $guardaria['cguardaria']) ?>" class="dropdown-item bg-danger text-white py-2">Remover</a>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>
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






<!-- Pagamento Modal -->
<form action="<?= $this->url('/guardaria/informar_pagamento/' . $guardaria['cguardaria']) ?>" method="POST">
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Informar Pagamento</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label>Data de referência</label>
					<div class="row">
						<div class="form-group col-md-6">
							<?php
								$time = time();
								$month = date('n', $time);
								$year = date('Y', $time);
							?>
							<select name="mes_ref" class="form-control" required>
								<?php for($m = 1; $m <= 12; $m++): ?>
									<option value="<?= $m ?>" <?= $month == $m? 'selected' : '' ?>><?= str_pad($m, 2, '0', STR_PAD_LEFT) ?> - <?= $months[$m] ?></option>
								<?php endfor ?>
							</select>
						</div>

						<div class="form-group col-md-6">
							<input name="ano_ref" type="text" class="form-control" placeholder="Ano" value="<?= $year ?>" required>
						</div>
					</div>

					<div class="form-group">
						<label>Valor</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">R$</div>
							</div>
							<input name="valor" type="text" class="form-control" value="<?= $guardaria['valor'] + $guardaria['valor_extra'] ?>">
						</div>
					</div>

					<div class="form-group">
						<label>Data do Pagamento</label>
						<input name="data_pagamento" type="date" class="form-control" value="">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</div>
		</div>
	</div>
</form>