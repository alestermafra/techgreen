<style>
/* Limpa o botão do input */
.datinha::-webkit-clear-button {
    display: none;
}

/* Remove a setinha (depende do navegador) */
.datinha::-webkit-inner-spin-button { 
    display: none;
}

/* Deixa com catinha*/
.datinha::-webkit-calendar-picker-indicator {
    color: #2c3e50;
}

.datinha {
    appearance: none;
    -webkit-appearance: none;
    /*color: #95a5a6;*/
    font-family: "Helvetica", arial, sans-serif;
    font-size: 18px;
    border:1px solid #ecf0f1;
    /*background:#ecf0f1;*/
    padding:5px;
    display: inline-block !important;
    visibility: visible !important;
	text-align:center;
}

.datinha, focus {
    color: #95a5a6;
    box-shadow: none;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
}

.agenda {
    table-layout: fixed;
    word-wrap: break-word;
}

.textinho {
	font-size: 12px;
	padding-bottom: 10px;
	cursor: default;
}
</style>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Calendário / Agenda</span>
    <div>
    	<div class="btn-group" role="group">
            <a href="<?php echo $this->url('/agenda/agenda/'.$mes[0]['cmes'].'/'.$ano) ?>" class="btn btn-sm btn-secondary" title="Visão mensal">Mês</a>
            <a href="<?php echo $this->url('/agenda/semana/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano) ?>" class="btn btn-sm btn-secondary" title="Visão semanal">Semana</a>
            <a href="<?php echo $this->url('/agenda/dia/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano) ?>" class="btn btn-sm btn-secondary" title="Visão diária">Dia</a>
            <a href="<?php echo $this->url('/agenda/semana_quadro/') ?>" class="btn btn-sm btn-secondary active" title="Visão de quadro semanal">Quadro</a>
            <a href="<?php echo $this->url('/agenda/tv') ?>" class="btn btn-sm btn-secondary" title="Visão de quadro semanal">TV</a>
		</div>
	</div>
</nav>

<div class="col-md-12 col-sm-12 well pull-right-lg">
    <div class="col-md-12 col-sm-12" style="padding:0px;">
        <table class="table agenda">
          <tr>
            <th colspan="2" class="text-left">
            <?php 
				//echo date('d/m/Y', strtotime($dia."-".$mes[0]['cmes']."-".$ano));//teste
				$d_anterior = date('d/m/Y', strtotime('-7 days', strtotime($dia."-".$mes[0]['cmes']."-".$ano)));
				$d_proximo = date('d/m/Y', strtotime('+7 days', strtotime($dia."-".$mes[0]['cmes']."-".$ano)));
			?>
            
            	<a href="<?php 
							echo $this->url('/agenda/semana_quadro/'.$d_anterior);
						?>" role="button" title="Navegar para semana anterior">
                	<i class='material-icons md-18'>arrow_back_ios</i>
                </a>
            </th>
            
            <th colspan="4" class="text-center">
				<input class="form-control form-control-sm datinha" id="select_mes" type="date" onchange="reload()" value="<?=date("Y-m-d",strtotime($ano."-".$mes[0]['cmes']."-".$dia))?>"/>
            </th>
            
            <th colspan="2" class="text-right">
            	<a href="<?php 
							echo $this->url('/agenda/semana_quadro/'.$d_proximo) ;
						?>" role="button" title="Navegar para o próxima semana">
                	<i class='material-icons md-18'>arrow_forward_ios</i>
               	</a>
            </th>
          </tr>
          	<tr>
				<td></td>
				<?php
					$nsemana = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'];
					$ssemana = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
				?>
				<?php for($i = 0; $i < 7; $i++): ?>
					<td class="table-bordered text-light bg-secondary text-center table-sm" title="<?= $nsemana[$i] ?>">
						<a title='Novo evento para este dia' class='text-light font-weight-light' href="<?= $this->url('/agenda/inserir_agenda/' . $dias[$i]['cdia'] . '/' . $dias[$i]['cmes'] . '/' . $dias[$i]['can']) ?>">
							<?= $ssemana[$i] ?> <?= $dias[$i]['cdia'] ?>/<?= $dias[$i]['cmes'] ?>
						</a>
					</td>
				<?php endfor; ?>
          </tr>
          
		  <?php
			
			echo $this->element(
				'semana_quadro',
				array(
					'acao' => 'Aula Wind',
					'dias' => $dias,
					'list' => $list_aula_wind,
					'pessoas' => $pessoas
				)
			);
			
			echo $this->element(
				'semana_quadro',
				array(
					'acao' => 'Aula Veleiro',
					'dias' => $dias,
					'list' => $list_aula_veleiro,
					'pessoas' => $pessoas
				)
			);
			
			echo $this->element(
				'semana_quadro',
				array(
					'acao' => 'Locação Veleiro',
					'dias' => $dias,
					'list' => $list_locacao_veleiro,
					'pessoas' => $pessoas
				)
			);
			
			echo $this->element(
				'semana_quadro',
				array(
					'acao' => 'Locação Caiaque',
					'dias' => $dias,
					'list' => $list_locacao_caiaque,
					'pessoas' => $pessoas
				)
			);
			
			echo $this->element(
				'semana_quadro',
				array(
					'acao' => 'Guarderia',
					'dias' => $dias,
					'list' => $guarderias,
					'pessoas' => $pessoas
				)
			);
			
			echo $this->element(
				'semana_quadro',
				array(
					'acao' => 'Outros',
					'dias' => $dias,
					'list' => $list,
					'pessoas' => $pessoas
				)
			);
			
		  ?>
        </table>

    </div>
</div>

<script type="text/javascript">
function reload(){
	var data = document.getElementById('select_mes').value;
	var ano = data.substring(0, 4);
	var mes = data.substring(5, 7);
	var dia = data.substring(8, 10);
	window.location.href="<?= $this->url('/agenda/semana_quadro') ?>/"+dia+"/"+mes+"/"+ano;
}
</script>