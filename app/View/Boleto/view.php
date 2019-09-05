<nav class="navbar navbar-light">
	<span class="navbar-brand">Boletos</span>
</nav>


<div> 
	<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <td><label><small>id</small></label></td>
            <td><label><small>Sacado</small></label></td>
            <td><label><small>Vencimento</small></label></td>
            <td><label><small>Taxa</small></label></td>
            <td><label><small>Dias prazo</small></label></td>
            <td><label><small>Visualizar</small></label></td>
        </tr>
	</thead>
    
    <tbody>
    <?php if(!$boleto){ echo '<tr><td colspan="4">Sem histórico de boletos</td></tr>';}?>
	<?php foreach($boleto as $boleto):?>
	<tr>
        <td><?php echo $boleto['cboleto'] ?></td>
        <td><?php echo $boleto['nps'] ?></td>
        <td><?php echo date("d/m/Y" , strtotime($boleto['data_venc'])); ?></td>
        <td><?php echo $boleto['taxa'] ?></td>
        <td><?php echo $boleto['dias_prazo_pagamento'] ?></td>
        <td>
        	<a class="btn btn-sm" target="_blank" role="button" href="<?php echo $this->url('/boleto/visualizar_boleto/'.$boleto['cboleto']) ?>">
        		<i class='material-icons md-24'>pageview</i>
            </a>
        </td>
	</tr>    	
    <?php endforeach?>
    </tbody>
    </table>
</div>

<div style="padding-top:10px"> <!------ ocorrencia-------->
	<table class="table table-sm table-striped table-hover">
    <thead>
    	<tr>
        	<td colspan="3">Ocorrências</td>
            <td class="text-right"><a href="<?php echo $this->url('/ocorrencia/inserir/pessoa/'.$boleto['cps'].'/'.str_replace('/','-',$_SERVER["REQUEST_URI"])) ?>" class="btn btn-primary btn-sm" role="button" title="Nova ocorrência">+</a></td>
        </tr>
        <tr>
            <td><label><small>id</small></label></td>
            <td><label><small>Assunto</small></label></td>
            <td><label><small>Descrição</small></label></td>
            <td><label><small>Data</small></label></td>
        </tr>
	</thead>
    
    <tbody>
    <?php if(!$ocorrencia){ echo '<tr><td colspan="4">Sem histórico de ocorrências</td></tr>';}?>
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
</div>
