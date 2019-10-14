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
	<span class="navbar-brand">Cliente</span>
	<div>
		<a href="<?php echo $this->url('/painel/pj') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/painel/editar_pj/' . $clientepj['cps']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<table class="table table-sm table-borderless p-0 m-0">
                    	<tr>
							<td class="text-muted">Id</td>
							<td><?php echo $clientepj['cps'] ?></td>
						</tr>
						<tr>
							<td class="text-muted">Empresa</td>
							<td><?php echo $clientepj['nps'] ?></td>
						</tr>
						<tr>
							<td class="text-muted">Classificação</td>
							<td><?php echo $clientepj['nseg'] ?></td>
						</tr>
						<?php if(!empty($clientepj['cnpj'])): ?>
						<tr>
							<td class="text-muted">CNPJ</td>
							<td><input type="text" readonly class="form-control-plaintext p-0 m-0 cnpj-mask" value="<?php echo $clientepj['cnpj'] ?>" data-value="<?php echo $clientepj['cnpj'] ?>"></td>
						</tr>
						<?php endif; ?>
					</table>
					
					<div class="row">
						<div class="col text-right">
							<form action="<?php echo $this->url('/painel/editar_pj/' . $clientepj['cps']) ?>" method="POST">
								<div class="row">
									<div class="col"> 
										<?php if($clientepj['ativo'] == 1): ?>
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
							href="<?php echo $this->url("/endereco/inserir/{$clientepj['cps']}?redirect={$this->controller->request->url}") ?>"
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
					<?php if(!isset($clientepj['enderecos']) || isset($clientepj['enderecos']) && empty($clientepj['enderecos'])): ?>
						<small>Nenhum endereço cadastrado.</small>
					<?php else: ?>
						<table class="table table-sm table-borderless p-0 m-0">
							<?php foreach($clientepj['enderecos'] as $end): ?>
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
		</div>
		
		<div class="col-md-4">
		
			<div class="card">
				<div class="card-header bg-dark text-white">
					Contatos
					<div class="float-right">
						<a
							href="<?php echo $this->url('/contatos/inserir/' . $clientepj['cps']) ?>"
							class="btn btn-sm btn-primary"
							role="button"
							title="Adicionar novo endereço"
						>
							<i class="material-icons align-middle md-18">add</i>
							<span class="align-middle">Contato</span>
						</a>
					</div>
				</div>
				<div class="card-body">
					<?php if(empty($clientepj['contatos'])): ?>
						<small class="text-muted">Nenhum contato cadastrado.</small>
					<?php else: ?>
						<table class="table table-sm table-hover table-borderless p-0 m-0">
							<thead>
								<tr>
									<td class="text-muted">Nome</td>
									<td class="text-muted">Cargo</td>
								</tr>
							</thead>
							<?php foreach($clientepj['contatos'] as $contato):?>
								<tr data-toggle="modal" data-target="#contact-view-modal" style="cursor: pointer"
									data-cccon="<?php echo $contato['cccon'] ?>"
									data-nps="<?php echo $contato['nps'] ?>"
									data-profissao="<?php echo $contato['profissao'] ?>"
									data-email="<?php echo $contato['email'] ?>"
									data-fone="<?php echo $contato['fone'] ?>"
								>
									<td><?php echo $contato['nps'] ?></td>
									<td><?php echo $contato['profissao'] ?></td>
								</tr>
							<?php endforeach?>
						</table>
						
						<div class="modal fade" id="contact-view-modal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Dados do Contato</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
										  <span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label class="small text-muted">Nome do Contato</label>
											<input type="text" readonly class="form-control-plaintext p-0 m-0" id="modal-contact-nps"></input>
										</div>
										<div class="form-group">
											<label class="small text-muted">Cargo</label>
											<input type="text" readonly class="form-control-plaintext p-0 m-0" id="modal-contact-profissao"></input>
										</div>
										<div class="form-group">
											<label class="small text-muted">E-mail</label>
											<input type="text" readonly class="form-control-plaintext p-0 m-0" id="modal-contact-email"></input>
										</div>
										<div class="form-group">
											<label class="small text-muted">Telefone</label>
											<input type="text" readonly class="form-control-plaintext p-0 m-0 phone" id="modal-contact-fone"></input>
										</div>
										
										<div class="text-right">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
											<a href="#" data-href="<?php echo $this->url('/contatos/editar') ?>" class="btn btn-primary" id="modal-contact-edit-btn">Editar</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif ?>
				</div>
			</div>
			
			
			<div class="card">
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
				
					<form enctype="multipart/form-data" action="<?php echo $this->url('/painel/attachment_upload/' . $clientepj['cps']) ?>" method="POST">
						<input id="attachment-input" type="file" name="attachments[]" style="display: none;" onchange="this.form.submit()" accept="image/*" multiple></input>
					</form>
					
					<?php if(empty($clientepj['attachments'])): ?>
						<div class="text-left small text-muted">
							Nenhum anexo.
						</div>
					<?php else: ?>
						<div class="row">
							<?php foreach($clientepj['attachments'] as $image): ?>
								<div class="col-sm-12 col-md-6 col-lg-4 p-1 image-container">
									<div class="image-control">
										<form action="<?php echo $this->url('/painel/attachment_delete/' . $clientepj['cps']) ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir o anexo?');">
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
					href="<?php echo $this->url('/ocorrencia/inserir/pessoa/'.$clientepj['cps'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>"
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
		bindContactModalEvent();
		
		bindCNPJMask();
		bindPhoneMask();
	}
	
	function bindContactModalEvent() {
		$('#contact-view-modal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Botão que acionou o modal
			var cccon = button.data('cccon') // Extrai informação dos atributos data-*
			var nps = button.data('nps') // Extrai informação dos atributos data-*
			var profissao = button.data('profissao') // Extrai informação dos atributos data-*
			var email = button.data('email') // Extrai informação dos atributos data-*
			var fone = button.data('fone') // Extrai informação dos atributos data-*
			// Se necessário, você pode iniciar uma requisição AJAX aqui e, então, fazer a atualização em um callback.
			// Atualiza o conteúdo do modal. Nós vamos usar jQuery, aqui. No entanto, você poderia usar uma biblioteca de data binding ou outros métodos.
			//var modal = $(this);
			let edit_href = $("#modal-contact-edit-btn").data('href'); /* pega o atributo data-href */
			$("#modal-contact-nps").val(nps);
			$("#modal-contact-profissao").val(profissao);
			$("#modal-contact-email").val(email);
			$("#modal-contact-fone").val(fone);
			$("#modal-contact-edit-btn").prop('href', edit_href + '/' + cccon);
			
			bindPhoneMask();
		});
	}
	
	function bindCNPJMask() {
		$('.cnpj-mask').mask('00.000.000/0000-00');
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
})();
</script>