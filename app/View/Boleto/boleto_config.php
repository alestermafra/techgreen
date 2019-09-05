<h2 style="padding: 10px; font-weight: lighter;">Gerar Boleto</h2>

<form action="<?php echo $this->url('/boleto/boleto_config/'.$guardaria['cguardaria'].'/'.$equipamento['cequipe']) ?>" method="POST">
	<div style="padding: 10px; max-width: 720px;">
	
	
	
		<?php if(isset($error)): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php echo $error ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif ?>
       
        
        <?php //para valor do boleto
			if($guardaria['qtd_parcela'] > 0){
        		$valor_boleto = ($guardaria['valor']+$guardaria['valor_extra']) / $guardaria['qtd_parcela'];
			} else {
				$valor_boleto = ($guardaria['valor']+$guardaria['valor_extra']);
			}
			
			//para data de vencimento
			if(date("j")<$guardaria['d_vencimento']){
				$datinha = date("Y-m-d", strtotime(date("Y")."-".date("n")."-".$guardaria['d_vencimento']));
			}else{
				$datinha = date("Y-m-d", strtotime(date("Y")."-".date("n", strtotime("+1 month"))."-".$guardaria['d_vencimento']));
			}	
		?>
        
        <div class="form-group">
			<input name="nps" type="text" class="form-control-plaintext form-control-sm" value="<?=$equipamento['nps'] ?>" readonly />
		</div>
        
        
        <input type="hidden" name="cps" value="<?=$equipamento['cps']?>" />
        <input type="hidden" name="cprod" value="<?=$guardaria['cprod']?>" />
        <input type="hidden" name="pedido" value="<?=$guardaria['cguardaria']?>" />
        
		<div class="form-group form-row">
            <div class="col-sm-6">
                <label for="nome-input"><small>Equipamento em guardaria</small></label>
                <input type="text" name="nome" class="form-control form-control-sm"  value="<?=$equipamento['nome']?>" readonly />
            </div>
            <div class="col-sm-6">
                <label for="valor_cobrado-input"><small>Valor deste boleto</small></label>
                <input type="text" name="valor_cobrado" class="form-control form-control-sm" title="R$"  value="<?=$valor_boleto?>" readonly />
            </div>
        </div>
		
        
		<div class="form-group form-row">
        	<div class="col-sm-4">
                <label><small>Data de vencimento</small></label>
                <input type="date" value="<?=$datinha?>" name="datinha" class="form-control form-control-sm" readonly/>
            </div>
            <div class="col-sm-4">
                <label for="dias-input"><small>Dias para prazo de pagamento</small></label>
                <input type="number" name="dias_prazo_pagamento" class="form-control form-control-sm" min="0" max="30" title="Isso prorroga a data de vencimento (data de vencimento + dias para prazo de pagamento = novo prazo de pagamento)" />
            </div>
            
            <div class="col-sm-2">
                <label for="taxa-input"><small>Taxa</small></label>
                <input type="text" name="taxa" title="Taxa bancária" class="form-control form-control-sm" placeholder="Ex: 02.5" />
            </div>
            
            <div class="col-sm-2">
                <label for="taxa-input"><small>Multa</small></label>
                <input type="text" name="taxa" title="Multa após vencimento" class="form-control form-control-sm" placeholder="Ex: 02.5" />
            </div>
		</div>	
        
        <div class="form-group">
            <label for="endereco-select"><small>Endereço</small></label>
            <select name="cpsend" class="form-control form-control-sm" title="Este endereço será usado na geração do boleto">
            <?php
                foreach($endereco as $ed){
                	echo '<option value="'.$ed['cpsend'].'">('.$ed['ntpsend'].') '.$ed['endr'].','.$ed['no'].' - '.$ed['cidade'].'</option>';
                }
            ?>
            </select>
        </div>
		
        
		<div style="padding-top: 20px;">
			<a class="btn btn-sm btn-secondary" role="button" style="width: 100px;" href="<?php echo $this->url('/guardaria/view/'.$guardaria['cguardaria']) ?>">Cancelar</a>
            <input type="submit" class="btn btn-sm btn-success" style="width: 100px;" value="Gerar Boleto" />
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
		$("[name='dias_prazo_pagamento']").mask('00');
		$("[name='taxa']").mask('00.00');
	};
	
})();
</script>