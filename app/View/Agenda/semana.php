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
            <a href="<?php echo $this->url('/agenda/semana') ?>" class="btn btn-sm btn-secondary active" title="Visão semanal">Semana</a>
            <a href="<?php echo $this->url('/agenda/dia/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano) ?>" class="btn btn-sm btn-secondary" title="Visão diária">Dia</a>
            <a href="<?php echo $this->url('/agenda/semana_quadro/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano) ?>" class="btn btn-sm btn-secondary" title="Visão de quadro semanal">Quadro</a>
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
							echo $this->url('/agenda/semana/'.$d_anterior);
						?>" role="button" title="Navegar para semana anterior">
                	<i class='material-icons md-18'>arrow_back_ios</i>
                </a>
            </th>
            
            <th colspan="3" class="text-center">
				<input class="form-control form-control-sm datinha" id="select_mes" type="date" onchange="reload()" value="<?=date("Y-m-d",strtotime($ano."-".$mes[0]['cmes']."-".$dia))?>"/>
            </th>
            
            <th colspan="2" class="text-right">
            	<a href="<?php 
							echo $this->url('/agenda/semana/'.$d_proximo) ;
						?>" role="button" title="Navegar para o próxima semana">
                	<i class='material-icons md-18'>arrow_forward_ios</i>
               	</a>
            </th>
          </tr>
          <tr class="table-bordered text-light bg-secondary text-center table-sm">
          <?php foreach($dias_semana as $d_s)
		  		echo '<td title="'.$d_s['ndsm'].'">'.$d_s['sdsm'].'</th>';
		  ?>
          </tr>
          
		  <?php
			
			echo "<tr class='table-bordered'>";
			
			foreach($dias as $dias){
				echo "<td style='height:6em'>";
				echo "<div class='text-right font-weight-light'>";
				echo "<a title='Novo evento para este dia' class='text-secondary' href='".$this->url('/agenda/inserir_agenda/'.$dias['cdia'].'/'.$dias['cmes'].'/'.$dias['can'])."'>";
				echo $dias['cdia'].'/'.$dias['cmes'];
				echo "</a>";
				echo "</div>";
				foreach($list as $ll){
					//para eventos que duram o mesmo dia (inicio e fim no mesmo dia)
					if($ll['cdia']==$dias['cdia'] && $ll['cmes']==$dias['cmes'] && $ll['can']==$dias['can'] && $ll['cdia']==$ll['cdia_fim'] && $ll['cmes']==$ll['cmes_fim'] && $ll['can']==$ll['can_fim']){
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'" ';
						if($ll['cor']){ echo ' style="background-color:#'.$ll['cor'].'; padding-left:0.5em"';}
						echo' >';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias['cdia'].'/'.$dias['cmes'].'/'.$dias['can'])."'>";
						if(!$ll['flg_dia_todo']) { 
							echo $ll['chora_ini'].'h'.$ll['cminuto_ini'].' - '.$ll['chora_fim'].'h'.$ll['cminuto_fim']; 
						}else{
							echo 'Dia todo';
						}
						if($ll['subtitulo']){ echo '<br>'.$ll['subtitulo'];}
						echo '<br>'.$ll['nacao'];
						foreach($pessoas as $pp){
							if($pp['cagenda']==$ll['cagenda'] && $pp['cps']){
								echo '<br>'.$pp['nps'];
								if($pp['cprod']){ echo ' ('.$pp['nprod'].')';}
							}
						}
						if($ll['OBS']){//mostra caso haja
							echo '<br>'.$ll['OBS'];
						}
						echo '</a>';
						echo '</div>';
					}
					//para eventos que duram mais de um dia (inicio do evento)
					if($ll['cdia']==$dias['cdia'] && $ll['cmes']==$dias['cmes'] && $ll['can']==$dias['can'] && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias['cdia'].'/'.$dias['cmes'].'/'.$dias['can'])."'>";
						echo $ll['chora_ini'].'h'.$ll['cminuto_ini'];
						echo '<br>'.$ll['nacao'].' <small>(Inicio de Evento - ';
						echo 'Termina as '.$ll['chora_fim'].'h'.$ll['cminuto_fim'].' em '.$ll['cdia_fim'].'/'.$ll['cmes_fim'].'/'.$ll['can_fim'];
						echo ')</small>';
						foreach($pessoas as $pp){
							if($pp['cagenda']==$ll['cagenda'] && $pp['cps']){
								echo '<br>'.$pp['nps'];
								if($pp['cprod']){ echo ' ('.$pp['nprod'].')';}
							}
						}
						if($ll['OBS']){//mostra caso haja
							echo '<br>'.$ll['OBS'];
						}
						echo '</a>';
						echo '</div>';
					}
					//para eventos que duram mais de um dia (meio do evento)
					if($ll['cdia']<$dias['cdia'] && $ll['cdia_fim']>$dias['cdia'] && $ll['cmes']<=$dias['cmes'] && $ll['can']<=$dias['can'] && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){	
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias['cdia'].'/'.$dias['cmes'].'/'.$dias['can'])."'>";
						echo $ll['nacao'].' <small>(Evento em andamento)</small>';
						foreach($pessoas as $pp){
							if($pp['cagenda']==$ll['cagenda'] && $pp['cps']){
								echo '<br>'.$pp['nps'];
								if($pp['cprod']){ echo ' ('.$pp['nprod'].')';}
							}
						}
						if($ll['OBS']){//mostra caso haja
							echo '<br>'.$ll['OBS'];
						}
						echo '</a>';
						echo '</div>';
					}
					//para eventos que duram mais de um dia (fim do evento)
					if($ll['cdia_fim']==$dias['cdia'] && $ll['cmes_fim']==$dias['cmes'] && $ll['can_fim']==$dias['can'] && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias['cdia'].'/'.$dias['cmes'].'/'.$dias['can'])."'>";
						echo $ll['chora_fim'].'h'.$ll['cminuto_fim'];
						echo '<br>'.$ll['nacao'].' <small>(Fim de Evento - ';
						echo 'Iniciou as '.$ll['chora_ini'].'h'.$ll['cminuto_ini'].' em '.$ll['cdia'].'/'.$ll['cmes'].'/'.$ll['can'];
						echo ')</small>';
						foreach($pessoas as $pp){
							if($pp['cagenda']==$ll['cagenda'] && $pp['cps']){
								echo '<br>'.$pp['nps'];
								if($pp['cprod']){ echo ' ('.$pp['nprod'].')';}
							}
						}
						if($ll['OBS']){//mostra caso haja
							echo '<br>'.$ll['OBS'];
						}
						echo '</a>';
						echo '</div>';
					}
				}
				echo "</td>";
			}
			
			echo "</tr>";
			
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
	window.location.href="<?= $this->url('/agenda/semana') ?>/"+dia+"/"+mes+"/"+ano;
}
</script>