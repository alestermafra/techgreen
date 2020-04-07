<style>
	.image-container {
		position: relative;
	}
	
	.image-control {
		position: absolute;
		display: none;
	}
	
	.image-container:hover .image-control {
		display: block;
	}
</style>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Velejador</span>
	<div>
		<a href="<?php echo $this->url('/painel/pf') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/painel/editar_pf/' . $clientepf['cps']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>


<div class="container-fluid">
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="dados-pessoais-tab" data-toggle="tab" href="#dados-pessoais-content" role="tab" aria-controls="dados-pessoais-content" aria-selected="true">Dados Pessoais</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="embarcacoes-tab" data-toggle="tab" href="#embarcacoes-content" role="tab" aria-controls="embarcacoes-content" aria-selected="false">Embarcações</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="anexos-tab" data-toggle="tab" href="#anexos-content" role="tab" aria-controls="anexos-content" aria-selected="false">Anexos</a>
		</li>
	</ul>

	<div class="tab-content">
		<!-- Dados pessoais tab -->
		<div class="tab-pane fade show active" id="dados-pessoais-content" role="tabpanel" aria-labelledby="dados-pessoais-tab">
			<div class="row mt-2">
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<table class="table table-sm table-borderless p-0 m-0">
								<tr>
									<td class="text-muted">Id</td>
									<td><?= $clientepf['cps'] ?></td>
								</tr>
								<tr>
									<td class="text-muted">Velejador</td>
									<td><?= $clientepf['nps'] ?></td>
								</tr>
								<tr>
									<td class="text-muted">Classificação</td>
									<td><?= $clientepf['nseg'] ?></td>
								</tr>
								<?php if(!empty($clientepf['email'])): ?>
								<tr>
									<td class="text-muted"><label class="text-muted">E-mail</label></td>
									<td><a href="mailto:<?= $clientepf['email'] ?>"><?= $clientepf['email'] ?></a></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['rg'])): ?>
								<tr>
									<td class="text-muted">RG</td>
									<td><?php echo $clientepf['rg'] ?></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['cpf'])): ?>
								<tr>
									<td class="text-muted">CPF</td>
									<td><input type="text" readonly class="form-control-plaintext p-0 m-0 cpf-mask" value="<?php echo $clientepf['cpf'] ?>" data-value="<?php echo $clientepf['cpf'] ?>"></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['d_nasc']) && !empty($clientepf['m_nasc']) && !empty($clientepf['a_nasc'])): ?>
								<tr>
									<td class="text-muted">Data de Nascimento</td>
									<td><?php echo $clientepf['d_nasc'] . '/' . $clientepf['m_nasc'] . '/' . $clientepf['a_nasc'] ?></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['peso'])): ?>
								<tr>
									<td class="text-muted">Peso</td>
									<td><?php echo $clientepf['peso'] ?></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['profissao'])): ?>
								<tr>
									<td class="text-muted">Profissão</td>
									<td><?php echo $clientepf['profissao'] ?></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['equipe'])): ?>
								<tr>
									<td class="text-muted">Equipe</td>
									<td><?php echo $clientepf['equipe'] ?></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['dependente1']) || !empty($clientepf['dependente2']) || !empty($clientepf['dependente3']) || !empty($clientepf['dependente4']) || !empty($clientepf['dependente5'])): ?> 
								<tr>
									<td class="text-muted">Dependente(s)</td>
									<td>
										<?php if(!empty($clientepf['dependente1'])): ?>
											<div><span class="text-muted">1.</span> <?php echo $clientepf['dependente1'] ?></div>
										<?php endif; ?>
										<?php if(!empty($clientepf['dependente2'])): ?>
											<div><span class="text-muted">2.</span> <?php echo $clientepf['dependente2'] ?></div>
										<?php endif; ?>
										<?php if(!empty($clientepf['dependente3'])): ?>
											<div><span class="text-muted">3.</span> <?php echo $clientepf['dependente3'] ?></div>
										<?php endif; ?>
										<?php if(!empty($clientepf['dependente4'])): ?>
											<div><span class="text-muted">4.</span> <?php echo $clientepf['dependente4'] ?></div>
										<?php endif; ?>
										<?php if(!empty($clientepf['dependente5'])): ?>
											<div><span class="text-muted">5.</span> <?php echo $clientepf['dependente5'] ?></div>
										<?php endif; ?>
									</td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['d_contato']) && !empty($clientepf['m_contato']) && !empty($clientepf['a_contato'])): ?>
								<tr>
									<td class="text-muted">Primeiro contato</td>
									<td><?php echo $clientepf['d_contato'] . '/' . $clientepf['m_contato'] . '/' . $clientepf['a_contato'] ?></td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['interesses'])): ?>
								<tr>
									<td class="text-muted">Interesse(s)</td>
									<td>
										<?php foreach($clientepf['interesses'] as $i => $interesse): ?>
											<div><span class="text-muted"><?php echo ($i + 1) ?>. </span> <?php echo $interesse['ntinteresse'] ?></div>
										<?php endforeach ?>
									</td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['canais'])): ?>
								<tr>
									<td class="text-muted">Canais de Conhecimento</td>
									<td>
										<?php foreach($clientepf['canais'] as $i => $canal): ?>
											<div><span class="text-muted"><?php echo ($i + 1) ?>. </span> <?php echo $canal['ncanal'] . ' ' . $canal['OBS'] ?></div>
										<?php endforeach ?>
									</td>
								</tr>
								<?php endif; ?>
								<?php if(!empty($clientepf['canais_contato'])): ?>
								<tr>
									<td class="text-muted">Canais de Contato</td>
									<td>
										<?php foreach($clientepf['canais_contato'] as $i => $canal_contato): ?>
											<div><span class="text-muted"><?php echo ($i + 1) ?>. </span> <?php echo $canal_contato['ncanalcontato'] . ' ' . $canal_contato['OBS'] ?></div>
										<?php endforeach ?>
									</td>
								</tr>
								<?php endif; ?>
							</table>
							
							<div class="row">
								<div class="col text-right">
									<form action="<?php echo $this->url('/painel/editar_pf/' . $clientepf['cps']) ?>" method="POST">
										<div class="row">
											<div class="col"> 
												<?php if($clientepf['ativo'] == 1): ?>
													<input name="ativo" type="hidden" value="0"></input>
													<input type="submit" class="btn btn-sm btn-danger" value="Inativar" style="width: 100px;"></input>
												<?php else: ?>
													<input name="ativo" type="hidden" value="1"></input>
													<input type="submit" class="btn btn-sm btn-success" value="Ativar" style="width: 100px;"></input>
												<?php endif ?>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
					<div class="card">
						<div class="card-header bg-dark text-white">
							Endereços
							<div class="float-right">
								<a
									href="<?php echo $this->url("/endereco/inserir/{$clientepf['cps']}?redirect={$this->controller->request->url}") ?>"
									class="btn btn-sm btn-primary"
									role="button"
									title="Adicionar novo endereço"
								>
									<i class="material-icons align-middle md-18">add</i>
									<span class="align-middle">Endereço</span>
								</a>
							</div>
						</div>
						<div class="card-body">
							<?php if(!isset($clientepf['enderecos']) || isset($clientepf['enderecos']) && empty($clientepf['enderecos'])): ?>
								<small>Nenhum endereço cadastrado.</small>
							<?php else: ?>
								<table class="table table-sm table-borderless p-0 m-0">
									<?php foreach($clientepf['enderecos'] as $end): ?>
										<tr>
											<td class="text-muted"><?php echo $end['ntpsend'] ?></td>
											<td><?php echo endereco_short($end) ?></td>
											<td>
												<a href="<?php echo $this->url("/endereco/editar/{$end['cpsend']}?redirect={$this->controller->request->url}") ?>" class="btn btn-link btn-sm" title="Editar endereço">
													<i class='material-icons md-18'>edit</i>
												</a>
												<a href="<?php echo $this->url("/endereco/remover/{$end['cpsend']}?redirect={$this->controller->request->url}") ?>" class="btn btn-link btn-sm text-danger" title="Remover endereço">
													<i class='material-icons md-18'>clear</i>
												</a>
											</td>
										</tr>
									<?php endforeach ?>
								</table>

							<?php endif ?>
						</div>
					</div>
					
					<div class="card">
						<div class="card-header bg-dark text-white">
							Aulas
						</div>
						<div class="card-body">
							<?php if(empty($clientepf['aulas'])): ?>
								<small>Não participou de nenhuma aula.</small>
							<?php else: ?>
								<ul class="list-group list-group-flush">
									<?php foreach($clientepf['aulas'] as $aula): ?>
										<li class="list-group-item">
											<div class="d-flex w-100 justify-content-between">
											<h6>
												<a title="Ver detalhes da aula" href="<?php echo $this->url('/aula/view/' . $aula['caula']) ?>">
													<?= $aula['nlinha'] ?> <small>(<?= $aula['subtitulo']; ?>)</small>
												</a>
											</h6>
											<small><?= $aula['cdia']; ?>/<?= $aula['cmes']; ?>/<?= $aula['can']; ?></small>
											</div>
											<?php if($aula['descricao']) { echo '<p>Descrição aula:'.$aula['descricao'].'</p>';} ?>
											<?php if($aula['descricao_participante']) { echo '<p>'.$aula['descricao_participante'].'</p>';}?>
											<small>Instrutor <?= $aula['instrutor']; ?></small>
										</li>
									<?php endforeach ?>
								</ul>
							<?php endif ?>
						</div>
					</div>
				</div>
			
				
				<div class="col-md-4">
					<div class="card">
						<div class="card-header bg-dark text-white">
							Telefones
						</div>
						<div class="card-body">
							<?php if(!isset($clientepf['telefones']) || isset($clientepf['telefones']) && empty($clientepf['telefones'])): ?>
								<small>Nenhum telefone cadastrado.</small>
							<?php else: ?>
								<table class="table table-sm table-borderless p-0 m-0">
									<?php foreach($clientepf['telefones'] as $tel): ?>
										<tr>
											<td class="text-muted"><?= $tel['ntfone'] ?></td>
											<td><input type="text" readonly class="form-control-plaintext p-0 m-0 phone w-auto" value="<?php echo $tel['fone'] ?>"data-value="<?php echo $tel['fone'] ?>"></input></td>
										</tr>
									<?php endforeach ?>
								</table>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Embarcações tab -->
		<div class="tab-pane fade" id="embarcacoes-content" role="tabpanel" aria-labelledby="embarcacoes-tab">
			<div class="card mt-2">
				<div class="card-header bg-dark text-white">
					Embarcações
					<div class="float-right">
						<a
							href="<?php echo $this->url("/equipamentos/inserir/{$clientepf['cps']}") ?>"
							class="btn btn-sm btn-primary"
							role="button"
							title="Adicionar novo endereço"
						>
							<i class="material-icons align-middle md-18">add</i>
							<span class="align-middle">Embarcação</span>
						</a>
					</div>
				</div>
				<div class="card-body">
					<?php if(empty($clientepf['equipamentos'])): ?>
						<small>Nenhuma embarcação.</small>
					<?php else: ?>
						<table class="table table-sm table-hover table-borderless p-0 m-0">
								<thead>
									<tr>
										<th>Tipo</th>
										<th>Modelo</th>
										<th>Nome</th>
										<th class="text-center">Ações</th>
									</tr>
								</thead>
							<?php foreach($clientepf['equipamentos'] as $embarcacao): ?>
								<tr>
									<td><?= $embarcacao['nlinha'] ?></td>
									<td><?= $embarcacao['nprod'] ?></td>
									<td><?= $embarcacao['nome'] ?></td>
									<td class="text-center"><a href="<?= $this->url("/equipamentos/view/{$embarcacao['cequipe']}") ?>">Visualizar</a></td>
								</tr>
							<?php endforeach ?>
						</table>
					<?php endif ?>
				</div>
			</div>
		</div>

		<div class="tab-pane fade" id="anexos-content" role="tabpanel" aria-labelledby="anexos-tab">
			<div class="card mt-2">
				<div class="card-header bg-dark text-white">
					Anexos
					<div class="float-right">
						<label for="attachment-input" class="btn btn-sm btn-primary m-0">
							<i class="material-icons align-middle md-18">cloud_upload</i>
							<span class="align-middle">Enviar Imagem</span>
						</label>
					</div>
				</div>
				<div class="card-body">
				
					<form enctype="multipart/form-data" action="<?php echo $this->url('/painel/attachment_upload/' . $clientepf['cps']) ?>" method="POST">
						<input id="attachment-input" type="file" name="attachments[]" style="display: none;" onchange="this.form.submit()" accept="image/*" multiple></input>
					</form>
					
					<?php if(empty($clientepf['attachments'])): ?>
						<div class="text-left small text-muted">
							Nenhum anexo.
						</div>
					<?php else: ?>
						<div class="row">
							<?php foreach($clientepf['attachments'] as $image): ?>
								<div class="col-sm-12 col-md-6 col-lg-4 p-1 image-container">
									<div class="image-control">
										<form action="<?php echo $this->url('/painel/attachment_delete/' . $clientepf['cps']) ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir o anexo?');">
											<input type="hidden" name="image_name" value="<?php echo $image['name'] ?>"></input>
											<input type="submit" class="btn btn-sm btn-danger" value="Deletar"></input>
										</form>
									</div>
									<div class="image">
										<a href="<?php echo $this->url($image['url']) ?>" data-fancybox="gallery" style="width: 100%;">
											<img src="<?php echo $this->url($image['url']) ?>" style="width: 120px; height 120px;" />
										</a>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
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
					href="<?php echo $this->url('/ocorrencia/inserir/pessoa/'.$clientepf['cps'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>"
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
	
	
<?php
	function endereco_short(array $endr) {
		$str = '';
		if(isset($endr['endr'])) {
			$str .= $endr['endr'];
		}
		if(isset($endr['no']) && strlen($endr['no'])) {
			$str .= ', ' . $endr['no'];
		}
		if(isset($endr['bai']) && strlen($endr['bai'])) {
			$str .= ' - ' . $endr['bai'];
		}
		if(isset($endr['uf']) && strlen($endr['uf'])) {
			$str .= ' - ' . $endr['uf'];
		}
		if(isset($endr['cep']) && strlen($endr['cep'])) {
			$str .= ' - ' . $endr['cep'];
		}
		
		return $str;
	}
?>

<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
	});
	
	function bindEvents() {
		bindPhoneMask();
		bindCPFMask();
	};
	
	function bindPhoneMask() {
		let fone_mask = (val) => {
			val = val.replace(/[^0-9]/g, '');
			
			if(val.length <= 8) {
				return '0000-0000';
			}
			if(val.length <= 9) {
				return '00000-0000';
			}
			if(val.length <= 10) {
				return '(00) 0000-0000'; 
			}
			if(val.length <= 11) {
				return '(00) 00000-0000';
			}
			if(val.length <= 12) {
				return '+00 (00) 0000-0000';
			}
			if(val.length <= 13) {
				return '+00 (00) 00000-0000';
			}
		};
		$('.phone').mask(fone_mask);
	};
	
	function bindCPFMask() {
		$('.cpf-mask').mask('000.000.000-00');
	};
})();
</script>