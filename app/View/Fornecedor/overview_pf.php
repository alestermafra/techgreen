<nav class="navbar navbar-light">
	<span class="navbar-brand">Fornecedor</span>
	<div>
		<a href="<?php echo $this->url('/fornecedor/fornecedores_pf') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/fornecedor/editar_pf/' . $fornecedor['cps']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<table class="table table-sm table-borderless p-0 m-0">
						<tr>
							<td class="text-muted">ID</td>
							<td><?php echo $fornecedor['cps'] ?></td>
						</tr>
                        <tr>
							<td class="text-muted">Nome</td>
							<td><?php echo $fornecedor['nps'] ?></td>
						</tr>
						<tr>
							<td class="text-muted">Tipo</td>
							<td><?= $fornecedor['ntfornec'] ?></td>
						</tr>
						<?php if(!empty($fornecedor['email'])): ?>
						<tr>
							<td class="text-muted">E-mail</td>
							<td><a href="mailto:<?php echo $fornecedor['email'] ?>"><?php echo $fornecedor['email'] ?></a></td>
						</tr>
						<?php endif; ?>
						<?php if(!empty($fornecedor['cpf'])): ?>
						<tr>
							<td class="text-muted">CPF</td>
							<td><input type="text" readonly class="form-control-plaintext p-0 m-0 cpf-mask" value="<?php echo $fornecedor['cpf'] ?>" data-value="<?php echo $fornecedor['cpf'] ?>"></td>
						</tr>
						<?php endif; ?>
						<?php if(!empty($fornecedor['rg'])): ?>
						<tr>
							<td class="text-muted">RG</td>
							<td><?php echo $fornecedor['rg'] ?></td>
						</tr>
						<?php endif; ?>
						<?php if(!empty($fornecedor['espec'])): ?>
						<tr>
							<td class="text-muted">Especialidade</td>
							<td><?php echo $fornecedor['espec'] ?></td>
						</tr>
						<?php endif; ?>
						<?php if(!empty($fornecedor['dados_bancarios'])): ?>
						<tr>
							<td class="text-muted">Dados Bancários</td>
							<td><?php echo nl2br($fornecedor['dados_bancarios']) ?></td>
						</tr>
						<?php endif; ?>
					</table>
					
					<div class="row">
						<div class="col text-right">
							<form action="<?php echo $this->url('/fornecedor/editar_pf/' . $fornecedor['cps']) ?>" method="POST">
								<div class="row">
									<div class="col"> 
                                    	<?php if(!$fornecedor['cliente']):?>
                                    	<a href="<?php echo $this->url('/fornecedor/tornar_cliente/' . $fornecedor['cps']) ?>" class="btn btn-sm btn-primary" role="button">Tornar velejador</a>
                                        <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled>Já é um velejador</button>
                                        <?php endif ?>
                                        
										<?php if($fornecedor['ativo'] == 1): ?>
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
							href="<?php echo $this->url("/endereco/inserir/{$fornecedor['cps']}?redirect={$this->controller->request->url}") ?>"
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
					<?php if(!isset($fornecedor['enderecos']) || empty($fornecedor['enderecos'])): ?>
						<small>Nenhum endereço cadastrado.</small>
					<?php else: ?>
						<table class="table table-sm table-borderless">
							<?php foreach($fornecedor['enderecos'] as $endereco): ?>
								<tr>
									<td class="text-muted"><?php echo $endereco['ntpsend'] ?></td>
									<td><?php echo endereco_short($endereco) ?></td>
									<td>
										<a href="<?php echo $this->url("/endereco/editar/{$endereco['cpsend']}?redirect={$this->controller->request->url}") ?>" class="btn btn-link btn-sm" title="Editar endereço">
											<i class='material-icons md-18'>edit</i>
										</a>
										<a href="<?php echo $this->url("/endereco/remover/{$endereco['cpsend']}?redirect={$this->controller->request->url}") ?>" class="btn btn-link btn-sm text-danger" title="Remover endereço">
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
					Telefones
				</div>
				<div class="card-body">
					<?php if(!isset($fornecedor['telefones']) || isset($fornecedor['telefones']) && empty($fornecedor['telefones'])): ?>
						<small>Nenhum telefone cadastrado.</small>
					<?php else: ?>
						<table class="table table-sm table-borderless">
							<?php foreach($fornecedor['telefones'] as $tel): ?>
								<tr>
									<td class="text-muted"><?= $tel['ntfone'] ?></td>
									<td><input type="text" readonly class="form-control-plaintext p-0 m-0 phone w-auto" value="<?php echo $tel['fone'] ?>" data-value="<?php echo $tel['fone'] ?>"></input></td>
								</tr>
							<?php endforeach ?>
						</table>
					<?php endif ?>
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
					href="<?php echo $this->url('/ocorrencia/inserir/pessoa/'.$fornecedor['cps'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>"
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
				<table class="table table-sm table-striped table-hover p-0 m-0">
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
		
		bindCPFMask();
		bindFoneMask();
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
			
			bindFoneMask();
		});
	}
	
	function bindCPFMask() {
		$('.cpf-mask').mask('000.000.000-00');
	};
	
	function bindFoneMask() {
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