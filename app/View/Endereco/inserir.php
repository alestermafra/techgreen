<form method="POST">

<nav class="navbar navbar-light">
	<span class="navbar-brand">Inserir Endereço</span>
	<div>
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?= $this->url($redirect); ?>">Cancelar</a>
		<input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir"></input>
	</div>
</nav>

<?php if(isset($error)): ?>
	<div class="container-fluid">
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<?php echo $error ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
<?php endif ?>   
        
        
<div class="container-fluid">
	<div class="card">
		<div class="card-header bg-dark text-white">
			Endereço
        </div>
        
        <div class="card-body">
        	<div class="form-row">
            	<div class="form-group">
                	<input type="text" class="form-control-plaintext form-control-sm" value="<?php echo $pessoa['nps'] ?>" readonly />
                </div>
            </div>
            
			<div class="form-row">
				<div class="form-group col-md-3">
					<label><small>Tipo de Endereço</small></label>
					<select name="ctpsend" class="form-control form-control-sm" autofocus>
						<?php foreach($tipos_endereco as $t): ?>
							<option value="<?php echo $t['ctpsend'] ?>"><?php echo $t['ntpsend'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group col-md-7">
					<label><small>Cep</small></label>
					<input type="text" name="cep" class="form-control form-control-sm"></input>
					<span id="busca_cep_erro" style="display: none; color: red;"><small>Tente novamente ou insira manualmente.</small></span>
				</div>
                <div class="form-group col-md-2">
                	<div>&nbsp;</div>
                	<div class="align-bottom">
						<button type="button" id="btn_cep" class="btn btn-sm btn-link" disabled>Localizar CEP</button>
                    </div>
                </div>
			</div>
				
			<div class="form-row">
				<div class="form-group col-md-2">
					<label><small>UF</small></label>
					<select name="uf" class="form-control form-control-sm">
                        <?php foreach($uf as $uf): ?>
							<option value="<?= $uf['uf'] ?>"<?php echo $uf['uf'] == 'SP'? ' selected' : '' ?>><?php echo $uf['uf'] ?></option>
						<?php endforeach ?>
                    </select>
				</div>
				<div class="form-group col-md-5">
					<label><small>Cidade</small></label>
					<input type="text" name="cidade" class="form-control form-control-sm" placeholder="Cidade" />
				</div>
				<div class="form-group col-md-5">
					<label><small>Bairro</small></label>
					<input type="text" name="bai" class="form-control form-control-sm" placeholder="Bairro" />
				</div>
			</div>
				
			<div class="form-row">
				<div class="form-group col-md-10">
					<label><small>Endereço</small></label>
					<input type="text" name="endr" class="form-control form-control-sm" placeholder="Rua, avenida, travessa, etc." />
				</div>
				<div class="form-group col-md-2">
					<label><small>Número</small></label>
					<input type="text" name="no" class="form-control form-control-sm" placeholder="Nº" />
				</div>
			</div>
				
			<div class="form-group">
				<label><small>Complemento</small></label>
				<input type="text" name="endcmplt" class="form-control form-control-sm" placeholder="Casa, apartamento, bloco, etc." />
			</div>
		</div>
	</div>
		
		<br />
		
	<div class="form-group text-right">	
		<a class="btn btn-sm btn-light" role="button" style="width: 100px;" href="<?= $this->url($redirect); ?>">Cancelar</a>
        <input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Concluir" />
	</div>
</div>
</form>



<script type="text/javascript">
(function() {
	$(document).ready(function() {
		bindEvents();
	});

	
	function bindEvents() {
		/* mask */
		$('[name=cep]').mask('00000-000');
		$('[name=cep]').keyup(function() {
			var len = $(this).val().length;
			$("#btn_cep").prop('disabled', len < 9);
		});
		
		$("#btn_cep").click(pesquisar_cep);
	}
	
	function pesquisar_cep() {
		$("#btn_cep, [name=cep], [name=uf], [name=cidade], [name=bai], [name=endr]").prop({'disabled': true, 'readonly': true});
		$("#busca_cep_erro").hide();
		$.ajax({
			url: '<?php echo $this->url('/endereco/json_busca_cep') ?>' + '/' + $('[name=cep]').val(),
			dataType: 'json',
			success: preencher_endereco,
			error: function(e) {
				$("#busca_cep_erro").show();
			},
			complete: function() {
				$("#btn_cep, [name=cep], [name=uf], [name=cidade], [name=bai], [name=endr]").prop({'disabled': false, 'readonly': false});
			},
		});
	}
	
	function preencher_endereco(dados_cep) {
		if(Object.keys(dados_cep).length) {
			$('[name=endr]').val(dados_cep['endt'] + ' ' + dados_cep['endereco']);
			$('[name=uf]').val(dados_cep['uf']);
			$('[name=cidade]').val(dados_cep['cidade']);
			$('[name=bai]').val(dados_cep['bairro']);
		}
		else {
			$('[name=endr]').val('');
			//$('[name=uf]').val('');
			$('[name=cidade]').val('');
			$('[name=bai]').val('');
		}
	}
})();
</script>