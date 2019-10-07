<nav class="navbar navbar-light">
	<span class="navbar-brand">Colaborador</span>
	<div>
		<a href="<?php echo $this->url('/colaboradores/colaboradores_pf') ?>" class="btn btn-sm btn-secondary">Ir para a lista</a>
		<a href="<?php echo $this->url('/colaboradores/editar_pf/' . $colaborador['cps']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<table class="table table-sm table-borderless p-0 m-0">
						<tr>
							<td class="text-muted">Nome</td>
							<td><?php echo $colaborador['nps'] ?></td>
						</tr>
						<?php if(!empty($colaborador['email'])): ?>
						<tr>
							<td class="text-muted">E-mail</td>
							<td><a href="mailto:<?php echo $colaborador['email'] ?>"><?php echo $colaborador['email'] ?></a></td>
						</tr>
						<?php endif; ?>
						<?php if(!empty($colaborador['cpf'])): ?>
						<tr>
							<td class="text-muted">CPF</td>
							<td><input type="text" readonly class="form-control-plaintext p-0 m-0 cpf-mask" value="<?php echo $colaborador['cpf'] ?>" data-value="<?php echo $colaborador['cpf'] ?>"></td>
						</tr>
						<?php endif; ?>
						<?php if(!empty($colaborador['rg'])): ?>
						<tr>
							<td class="text-muted">RG</td>
							<td><?php echo $colaborador['rg'] ?></td>
						</tr>
						<?php endif; ?>
					</table>
					
					<div class="row">
						<div class="col text-right">
							<form action="<?php echo $this->url('/colaboradores/editar_pf/' . $colaborador['cps']) ?>" method="POST">
								<div class="row">
									<div class="col"> 
										<?php if($colaborador['ativo'] == 1): ?>
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
							href="<?php echo $this->url("/endereco/inserir/{$colaborador['cps']}?redirect={$this->controller->request->url}") ?>"
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
					<?php if(!isset($colaborador['enderecos']) || empty($colaborador['enderecos'])): ?>
						<small>Nenhum endereço cadastrado.</small>
					<?php else: ?>
						<table class="table table-sm table-borderless">
							<?php foreach($colaborador['enderecos'] as $endereco): ?>
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
					<?php if(!isset($colaborador['telefones']) || isset($colaborador['telefones']) && empty($colaborador['telefones'])): ?>
						<small>Nenhum telefone cadastrado.</small>
					<?php else: ?>
						<table class="table table-sm table-borderless">
							<?php foreach($colaborador['telefones'] as $tel): ?>
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
					href="<?php echo $this->url('/ocorrencia/inserir/pessoa/'.$colaborador['cps'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>"
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
		bindCPFMask();
		bindFoneMask();
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