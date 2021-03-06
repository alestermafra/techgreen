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
	<span class="navbar-brand">Embarcação</span>
	<div>
		<a href="<?php echo $this->url('/equipamentos/editar/' . $equipamento['cequipe']) ?>" class="btn btn-sm btn-primary" role="button">Editar</a>
	</div>
</nav>

<?php if(isset($_GET['inserido'])): ?>
	<div class="container-fluid">
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			Equipamento inserido.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
<?php endif ?>


<div class="container-fluid">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="detalhes-tab" data-toggle="tab" href="#detalhes-content" role="tab" aria-controls="detalhes-content" aria-selected="true">Detalhes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="equipamentos-tab" data-toggle="tab" href="#equipamentos-content" role="tab" aria-controls="equipamentos-content" aria-selected="false">Equipamentos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="galeria-tab" data-toggle="tab" href="#galeria-content" role="tab" aria-controls="galeria-content" aria-selected="false">Galeria</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="detalhes-content" role="tabpanel" aria-labelledby="detalhes-tab">
            <div class="card mt-2">
                <div class="card-header bg-dark text-white">
                    Detalhes
                    
                    <div class="float-right">
                        <a role="button" class="btn btn-sm btn-primary" target="_blank" href="<?php echo $this->url('/equipamentos/gerar_relacao/' . $equipamento['cequipe']) ?>">Vistoria</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="small text-muted">Proprietário</label>
                        </div>
                        <div class="col-md-8">
                            <a href="<?= $this->url('/painel/overview_pf/' . $equipamento['cps']) ?>"><?php echo $equipamento['nps'] ?></a>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="small text-muted">Tipo</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $equipamento['nlinha'] ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="small text-muted">Modelo</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $equipamento['nprod'] ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="small text-muted">Nome da Embarcação</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $equipamento['nome'] ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="small text-muted">À Venda?</label>
                        </div>
                        <div class="col-md-8">
                            <?php if($equipamento['flg_venda'] == 1) {echo 'Sim';} else {echo 'Não';}  ?>
                        </div>
                    </div>
                    <?php if($equipamento['flg_venda'] == 1): ?>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="small text-muted">Valor de venda</label>
                            </div>
                            <div class="col-md-8">
                                R$ <?php echo $equipamento['valor_venda'] ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($equipamento['marca'])): ?>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="small text-muted">Marca</label>
                            </div>
                            <div class="col-md-8">
                                <?php echo $equipamento['marca'] ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($equipamento['tamanho'])): ?>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="small text-muted">Tamanho</label>
                        </div>
                        <div class="col-md-8">
                            <?php echo $equipamento['tamanho'] ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($equipamento['cor'])): ?>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="small text-muted">Cor</label>
                            </div>
                            <div class="col-md-8">
                                <?php echo $equipamento['cor'] ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($equipamento['ano'])): ?>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="small text-muted">Ano</label>
                            </div>
                            <div class="col-md-8">
                                <?php echo $equipamento['ano'] ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty($equipamento['estado_geral'])): ?>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="small text-muted">Estado geral</label>
                            </div>
                            <div class="col-md-8">
                                <?php echo $equipamento['estado_geral'] ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-remover-embarcacao">Deletar Embarcação</button>

<div class="modal" id="modal-remover-embarcacao">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        Tem certeza que deseja deletar esta embarcação? Todas as informações da embarcação serão perdidas. Esta ação não pode ser desfeita.
      </div>
      <div class="modal-footer">
        <a href="<?= $this->url('/equipamentos/deletar/' . $equipamento['cequipe']) ?>" class="btn btn-danger">Deletar Embarcação</a>
        <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="equipamentos-content" role="tabpanel" aria-labelledby="equipamentos-tab">
            <div class="card mt-2">
                <div class="card-header bg-dark text-white">
                    Equipamentos
                    <div class="float-right">
                        <a href="<?php echo $this->url('/pertences/inserir/' . $equipamento['cequipe']) ?>" class="btn btn-sm btn-primary" role="link" title="Nova ocorrência">
                            <i class="material-icons align-middle md-18">add</i>
                            <span class="align-middle">Equipamento</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(!isset($equipamento['pertences']) || empty($equipamento['pertences'])): ?>
                        <div class="small text-muted">Nenhum equipamento cadastrado.</div>
                    <?php else: ?>
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="small">Nome</th>
                                    <th scope="col" class="small">Marca</th>
                                    <th scope="col" class="small">Modelo</th>
                                    <th scope="col" class="small">Tamanho</th>
                                    <th scope="col" class="small">Cor</th>
                                    <th scope="col" class="small">Ano</th>
                                    <th scope="col" class="small">Estado Geral</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($equipamento['pertences'] as $p): ?>
                                    <tr style="cursor: pointer" onclick="window.location = '<?php echo $this->url('/pertences/editar/' . $p['cpertence']) ?>'">
                                        <td><?php echo $p['npertence'] ?></td>
                                        <td><?php echo $p['marca'] ?></td>
                                        <td><?php echo $p['modelo'] ?></td>
                                        <td><?php echo $p['tamanho'] ?></td>
                                        <td><?php echo $p['cor'] ?></td>
                                        <td><?php echo $p['ano'] ?></td>
                                        <td><?php echo $p['estado_geral'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                        </tbody>
                        </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="galeria-content" role="tabpanel" aria-labelledby="galeria-tab">
            <form enctype="multipart/form-data" action="<?php echo $this->url('/equipamentos/image_upload/' . $equipamento['cequipe']) ?>" method="POST">
                <input id="attachment-input" type="file" name="attachments[]" style="display: none;" onchange="this.form.submit()" accept="image/*" multiple></input>
            </form>
                
            <div class="card mt-2">
                <div class="card-header bg-dark text-white">
                    Galeria
                    <div class="float-right">
                        <label for="attachment-input" class="btn btn-sm btn-primary m-0">
                            <i class="material-icons align-middle md-18">cloud_upload</i>
                            <span class="align-middle">Enviar Imagem</span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if(empty($equipamento['attachments'])): ?>
                            <div class="col text-left small text-muted">
                                Nenhuma imagem anexada.
                            </div>
                        <?php endif ?>
                        <?php foreach($equipamento['attachments'] as $image): ?>
                            <div class="col-12 col-sm-6 col-md-3 col-lg-2 p-1 image-container">
                                <div class="image-control">
                                    <form action="<?php echo $this->url('/equipamentos/image_delete/' . $equipamento['cequipe']) ?>" method="POST">
                                        <input type="hidden" name="image_name" value="<?php echo $image['name'] ?>"></input>
                                        <input type="submit" class="btn btn-sm btn-danger" value="Deletar"></input>
                                    </form>
                                </div>
                                <div class="image">
                                    <a href="<?php echo $this->url($image['url']) ?>" data-fancybox="gallery" style="width: 100%;">
                                        <img src="<?php echo $this->url($image['url']) ?>" style="width: 150px; height: 150px;" />
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
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
				<a href="<?php echo $this->url('/ocorrencia/inserir/equipamento/' . $equipamento['cequipe'] . '/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>" class="btn btn-sm btn-primary" role="button" title="Nova ocorrência">
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

<script type="text/javascript">
(function() {
	$(document).ready(function() {
		clean_url();
	});
	
	function clean_url() {
		const url = window.location.href.replace('?inserido', '');
		window.history.pushState({path: url}, '', url);
	}
})();
</script>