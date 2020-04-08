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
            <a href="<?php echo $this->url('/agenda/agenda') ?>" class="btn btn-sm btn-secondary active" title="Visão mensal">Mês</a>
            <a href="<?php echo $this->url('/agenda/semana') ?>" class="btn btn-sm btn-secondary" title="Visão semanal">Semana</a>
            <a href="<?php echo $this->url('/agenda/dia') ?>" class="btn btn-sm btn-secondary" title="Visão diária">Dia</a>
            <a href="<?php echo $this->url('/agenda/semana_quadro/') ?>" class="btn btn-sm btn-secondary" title="Visão de quadro semanal">Quadro</a>
		</div>
	</div>
</nav>

<?php 
	$anterior = date("m/Y", strtotime("-1 month", strtotime($dia."-".$mes[0]['cmes']."-".$ano)));
	$proximo = date("m/Y", strtotime("+1 month", strtotime($dia."-".$mes[0]['cmes']."-".$ano)));
?>


<div class="col-md-12 col-sm-12 well pull-right-lg">
    <div class="col-md-12 col-sm-12" style="padding:0px;">
        <table class="table agenda">
          <tr>
            <th colspan="2" class="text-left">
            	<a href="<?php echo $this->url('/agenda/agenda/'.$anterior);?>" role="button" title="Navegar para mês anterior">
                	<i class='material-icons md-18'>arrow_back_ios</i>
                </a>
            </th>
            
            <th colspan="3" class="text-center">
                <input class="form-control form-control-sm datinha"  id="select_mes" type="month" onchange="reload()" value="<?=date("Y-m",strtotime($ano."-".$mes[0]['cmes']))?>"/>
            </th>
            
            <th colspan="2" class="text-right">
            	<a href="<?php echo $this->url('/agenda/agenda/'.$proximo) ;?>" role="button" title="Navegar para o próximo mês">
                	<i class='material-icons md-18'>arrow_forward_ios</i>
               	</a>
            </th>
          </tr>
          <tr class="table-bordered text-light bg-secondary text-center table-sm">
		  	<td title="Segunda-feira">Seg</td>
		  	<td title="Terça-feira">Ter</td>
		  	<td title="Quarta-feira">Qua</td>
		  	<td title="Quinta-feira">Qui</td>
		  	<td title="Sexta-feira">Sex</td>
		  	<td title="Sábado">Sáb</td>
		  	<td title="Domingo">Dom</td>
          </tr>
          
		  <?php
			$cont = 0;
			
			for($linha = 0; $linha < 6; $linha++){
				echo "<tr class='table-bordered'>";
				for($coluna = 0; $coluna < 7; $coluna++){
					$pos2 = $cont - $pos;
			 
					if(empty($dias[$pos2]))echo "<td class='table-active'></td>"; //dias de outros meses
					else{
						if($dias[$pos2] == $dia && $mes[0]['cmes'] == date("m")){ // dia vigente
							echo "<td class='bg-info text-light' style='height:6em'>";
							echo "<div class='text-right font-weight-light'>";
							echo "<a title='Novo evento para este dia' class='text-light' href='".$this->url('/agenda/inserir_agenda/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
							echo $dias[$pos2];
							echo "</a>";
							echo "</div>";
								foreach($list as $l){//lista de eventos
									//para eventos que duram o mesmo dia (inicio e fim no mesmo dia)
									if($l['cdia']==$dias[$pos2] && $l['cmes']==$mes[0]['cmes'] && $l['can']==$ano && $l['cdia']==$l['cdia_fim'] && $l['cmes']==$l['cmes_fim'] && $l['can']==$l['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$l['OBS'].'" ';
										if($l['cor']){ echo ' style="background-color:#'.$l['cor'].'; padding-left:0.5em;"';}
										echo '>';
										echo "<a";
										if($l['cor']){ echo " class='text-dark'";} else {echo " class='text-light'";}
										echo " href='".$this->url('/agenda/editar_agenda/'.$l['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										if(!$l['flg_dia_todo']) { 
											echo $l['chora_ini'].'h'.$l['cminuto_ini'].' - '.$l['chora_fim'].'h'.$l['cminuto_fim']; 
										}else{
											echo 'Dia todo';
										}
										if($l['subtitulo']){ echo '<br>'.$l['subtitulo'];}
										echo '<br>'.$l['nacao'];
										foreach($pessoas as $p){
											if($p['cagenda']==$l['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
									//para eventos que duram mais de um dia (inicio do evento)
									if($l['cdia']==$dias[$pos2] && $l['cmes']==$mes[0]['cmes'] && $l['can']==$ano && $l['cdia']<$l['cdia_fim'] && $l['cmes']<=$l['cmes_fim'] && $l['can']<=$l['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$l['OBS'].'">';
										echo "<a class='text-light' href='".$this->url('/agenda/editar_agenda/'.$l['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										echo $l['chora_ini'].'h'.$l['cminuto_ini'];
										echo '<br>'.$l['nacao'].' <small>(Inicio de evento)</small>';
										foreach($pessoas as $p){
											if($p['cagenda']==$l['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
									//para eventos que duram mais de um dia (meio do evento)
									if($l['cdia']<$dias[$pos2] && $l['cdia_fim']>$dias[$pos2] && $l['cmes']<=$mes[0]['cmes'] && $l['can']<=$ano && $l['cdia']<$l['cdia_fim'] && $l['cmes']<=$l['cmes_fim'] && $l['can']<=$l['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$l['OBS'].'">';
										echo "<a class='text-light' href='".$this->url('/agenda/editar_agenda/'.$l['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										echo $l['nacao'].' <small>(Evento em andamento)</small>';
										foreach($pessoas as $p){
											if($p['cagenda']==$l['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
									//para eventos que duram mais de um dia (fim do evento)
									if($l['cdia_fim']==$dias[$pos2] && $l['cmes_fim']==$mes[0]['cmes'] && $l['can_fim']==$ano && $l['cdia']<$l['cdia_fim'] && $l['cmes']<=$l['cmes_fim'] && $l['can']<=$l['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$l['OBS'].'">';
										echo "<a class='text-light' href='".$this->url('/agenda/editar_agenda/'.$l['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										echo $l['chora_fim'].'h'.$l['cminuto_fim'];
										echo '<br>'.$l['nacao'].' <small>(Fim de evento)</small>';
										foreach($pessoas as $p){
											if($p['cagenda']==$l['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
								}
							echo "</td>";
						}else { // demais dias
							echo "<td style='height:6em'>";
							echo "<div class='text-right font-weight-light'>";
							echo "<a title='Novo evento para este dia' class='text-secondary' href='".$this->url('/agenda/inserir_agenda/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
							echo $dias[$pos2];
							echo "</a>";
							echo "</div>";
								foreach($list as $ll){
									//para eventos que duram o mesmo dia (inicio e fim no mesmo dia)
									if($ll['cdia']==$dias[$pos2] && $ll['cmes']==$mes[0]['cmes'] && $ll['can']==$ano && $ll['cdia']==$ll['cdia_fim'] && $ll['cmes']==$ll['cmes_fim'] && $ll['can']==$ll['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$ll['OBS'].'" ';
										if($ll['cor']){ echo ' style="background-color:#'.$ll['cor'].'; padding-left:0.5em;"';}
										echo '>';
										echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										if(!$ll['flg_dia_todo']) { 
											echo $ll['chora_ini'].'h'.$ll['cminuto_ini'].' - '.$ll['chora_fim'].'h'.$ll['cminuto_fim']; 
										}else{
											echo 'Dia todo';
										}
										if($ll['subtitulo']){ echo '<br>'.$ll['subtitulo'];}
										echo '<br>'.$ll['nacao'];
										foreach($pessoas as $p){
											if($p['cagenda']==$ll['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
									//para eventos que duram mais de um dia (inicio do evento)
									if($ll['cdia']==$dias[$pos2] && $ll['cmes']==$mes[0]['cmes'] && $ll['can']==$ano && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$ll['OBS'].'">';
										echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										echo $ll['chora_ini'].'h'.$ll['cminuto_ini'];
										echo '<br>'.$ll['nacao'].' <small>(Inicio de evento)</small>';
										foreach($pessoas as $p){
											if($p['cagenda']==$ll['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
									//para eventos que duram mais de um dia (meio do evento)
									if($ll['cdia']<$dias[$pos2] && $ll['cdia_fim']>$dias[$pos2] && $ll['cmes']<=$mes[0]['cmes'] && $ll['can']<=$ano && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$ll['OBS'].'">';
										echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										echo $ll['nacao'].' <small>(Evento em andamento)</small>';
										foreach($pessoas as $p){
											if($p['cagenda']==$ll['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
									//para eventos que duram mais de um dia (fim do evento)
									if($ll['cdia_fim']==$dias[$pos2] && $ll['cmes_fim']==$mes[0]['cmes'] && $ll['can_fim']==$ano && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
										echo '<div class="font-light text-truncate textinho" title="'.$ll['OBS'].'">';
										echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias[$pos2].'/'.$mes[0]['cmes'].'/'.$ano)."'>";
										echo $ll['chora_fim'].'h'.$ll['cminuto_fim'];
										echo '<br>'.$ll['nacao'].' <small>(Fim do evento)</small>';
										foreach($pessoas as $p){
											if($p['cagenda']==$ll['cagenda'] && $p['cps']){
												echo '<br>'.$p['nps'];
												if($p['cprod']){ echo ' ('.$p['nprod'].')';}
											}
										}
										echo '</a>';
										echo '</div>';
									}
								}
							echo "</td>";
						}
					}
			 
					$cont++;
				}
				echo "</tr>";
			}
		  ?>
        </table>

    </div>
</div>

<script type="text/javascript">
function reload(){
	var data = document.getElementById('select_mes').value;
	var ano = data.substring(0, 4);
	var mes = data.substring(5, 7);
	window.location.href="<?= $this->url('/agenda/agenda') ?>/"+mes+"/"+ano;
}
</script>