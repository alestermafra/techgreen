<?php
			
echo "<tr class='table-bordered'>";
echo "<td class='font-weight-light text-secondary'>".$acao."</td>";
			
foreach($dias as $dias){
	echo "<td style='height:4em'>";
	foreach($list as $ll){
	//para eventos que duram o mesmo dia (inicio e fim no mesmo dia)
		if($ll['cdia']==$dias['cdia'] && $ll['cmes']==$dias['cmes'] && $ll['can']==$dias['can'] && $ll['cdia']==$ll['cdia_fim'] && $ll['cmes']==$ll['cmes_fim'] && $ll['can']==$ll['can_fim']){
			echo '<div class="font-light textinho" title="'.$ll['OBS'].'">';
			echo "<a class='text-secondary' href='".$this->url('/agenda/editar_agenda/'.$ll['cagenda'].'/'.$dias['cdia'].'/'.$dias['cmes'].'/'.$dias['can'])."'>";
			echo $ll['chora_ini'].'h'.$ll['cminuto_ini'].' - '.$ll['chora_fim'].'h'.$ll['cminuto_fim'];
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