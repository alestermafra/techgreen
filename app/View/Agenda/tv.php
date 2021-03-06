<style>
@page {
	size: auto;
}
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
	padding-bottom: 10px;
	cursor: default;
}

table.agenda {
	font-size: 24px;
}
</style>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Agenda</span>
</nav>

<div class="col-md-12 col-sm-12 well pull-right-lg">
    <div class="col-md-12 col-sm-12" style="padding:0px;">
        <table class="table agenda">
          <tr>
            <th colspan="1" class="text-left">
            </th>
            
            <th colspan="2" class="text-center">
				<input class="form-control form-control-sm datinha" id="select_mes" type="date" onchange="reload()" value="<?=date("Y-m-d",strtotime($ano."-".$mes[0]['cmes']."-".$dia))?>"/>
            </th>
            
            <th colspan="1" class="text-right">
            </th>
          </tr>
          <tr class="table-bordered text-light bg-secondary text-center table-sm">
          	<th colspan="4">
            </th>
          </tr>
          
		  <?php
			
			foreach($list as $ll){
			echo "<tr class='table-bordered'";
			if($ll['cor']){ echo ' style="background-color:#'.$ll['cor'].'"';}
			echo ">";
				echo "<td colspan='4'>";
					//para eventos que duram o mesmo dia (inicio e fim no mesmo dia)
					if($ll['cdia']==$dia && $ll['cmes']==$mes[0]['cmes'] && $ll['can']==$ano && $ll['cdia']==$ll['cdia_fim'] && $ll['cmes']==$ll['cmes_fim'] && $ll['can']==$ll['can_fim']){
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano)."'>";
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
					if($ll['cdia']==$dia && $ll['cmes']==$mes[0]['cmes'] && $ll['can']==$ano && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano)."'>";
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
					if($ll['cdia']<$dia && $ll['cdia_fim']>$dia && $ll['cmes']<=$mes[0]['cmes'] && $ll['can']<=$ano && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano)."'>";
						echo $ll['nacao'].' <small>(Evento em andamento - ';
						echo 'Iniciou as '.$ll['chora_ini'].'h'.$ll['cminuto_ini'].' em '.$ll['cdia'].'/'.$ll['cmes'].'/'.$ll['can'];
						echo ' | Termina as '.$ll['chora_fim'].'h'.$ll['cminuto_fim'].' em '.$ll['cdia_fim'].'/'.$ll['cmes_fim'].'/'.$ll['can_fim'];
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
					//para eventos que duram mais de um dia (fim do evento)
					if($ll['cdia_fim']==$dia && $ll['cmes_fim']==$mes[0]['cmes'] && $ll['can_fim']==$ano && $ll['cdia']<$ll['cdia_fim'] && $ll['cmes']<=$ll['cmes_fim'] && $ll['can']<=$ll['can_fim']){
						echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
						echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dia.'/'.$mes[0]['cmes'].'/'.$ano)."'>";
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
				echo "</td>";
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
	var dia = data.substring(8, 10);
	window.location.href="<?= $this->url('/agenda/tv') ?>/"+dia+"/"+mes+"/"+ano;
}
</script>