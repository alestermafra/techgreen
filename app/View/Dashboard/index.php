<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://d3js.org/d3.v5.min.js"></script>

<style>
	.card {
		margin-bottom: 1.5rem;
	}
	
	.weather-N {
		transform: rotate(0deg);
	}
	
	.weather-NNW {
		transform: rotate(-22.5deg);
	}
	
	.weather-NW {
		transform: rotate(-45deg);
	}
	
	.weather-WNW {
		transform: rotate(-67.5deg);
	}
	
	.weather-W {
		transform: rotate(-90deg);
	}
	
	.weather-WSW {
		transform: rotate(-112.5deg);
	}
	
	.weather-SW {
		transform: rotate(-135deg);
	}
	
	.weather-SSW {
		transform: rotate(-157.5deg);
	}
	
	.weather-S {
		transform: rotate(-180deg);
	}
	
	.weather-SSE {
		transform: rotate(-202.5deg);
	}
	
	.weather-SE {
		transform: rotate(-225deg);
	}
	
	.weather-ESE {
		transform: rotate(-247.5deg);
	}
	
	.weather-E {
		transform: rotate(-270deg);
	}
	
	.weather-ENE {
		transform: rotate(-292.5deg);
	}
	
	.weather-NE {
		transform: rotate(-315deg);
	}
	
	.weather-NNE {
		transform: rotate(-337.5deg);
	}
</style>

<nav class="navbar navbar-light">
	<span class="navbar-brand">Dashboard</span>
</nav>

<div class="container-fluid">
	<div class="row">
		<div class="col-xl-3">
			<div class="card" style="border-left: 5px solid grey;">
				<div style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;">
					<canvas id="clients_ytd_chart" style="width: 100%; height: 100%;"></canvas>
				</div>
				<div class="card-body">
					<h3 class="py-0"><?php echo $cliente_ytd_month[date('n') - 1]['quantidade'] ?></h3>
					<span class="text-muted">Novos Velejadores</span>
				</div>
			</div>
		</div>
		<div class="col-xl-3">
			<div class="card" style="border-left: 5px solid grey;">
				<div style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;">
					<canvas id="aulas_ytd_chart" style="width: 100%; height: 100%;"></canvas>
				</div>
				<div class="card-body">
					<h3 class="py-0"><?php echo $aulas_ytd_month[date('n') - 1]['quantidade'] ?></h3>
					<span class="text-muted">Aulas agendadas</span>
				</div>
			</div>
		</div>
		<div class="col-xl-3">
			<div class="card" style="border-left: 5px solid grey;">
				<div style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;">
					<canvas id="locacoes_ytd_chart" style="width: 100%; height: 100%;"></canvas>
				</div>
				<div class="card-body">
					<h3 class="py-0"><?php echo $locacoes_ytd_month[date('n') - 1]['quantidade'] ?></h3>
					<span class="text-muted">Locações</span>
				</div>
			</div>
		</div>
		<div class="col-xl-3">
			<div class="card" style="border-left: 5px solid grey;">
				<div style="position: absolute; left: 0; top: 0; right: 0; bottom: 0;">
					<canvas id="diarias_ytd_chart" style="width: 100%; height: 100%;"></canvas>
				</div>
				<div class="card-body">
					<h3 class="py-0"><?php echo $diarias_ytd_month[date('n') - 1]['quantidade'] ?></h3>
					<span class="text-muted">Diárias</span>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xl-8">
			<?php
				$estoque_color = 'green';
				foreach($estoque_acabando as $estoque) {
					if($estoque['qtd'] / $estoque['qtd_max'] < .1) {
						$estoque_color = 'red';
						break;
					}
					else if($estoque['qtd'] / $estoque['qtd_max'] < .2) {
						$estoque_color = 'orange';
					}
				}
			?>
			<div class="card" style="border-left: 5px solid <?php echo $estoque_color ?>;">
				<div class="card-body pt-0 pb-3">
					<div class="py-3">
						<h5 class="py-0 text-muted">Situação do Estoque</h5>
					</div>
					<?php if(empty($estoque_acabando)): ?>
						<p class="text-success">O estoque está OK!</p>
					<?php else: ?>
						
							<?php foreach($estoque_acabando as $estoque): ?>
								<div class="row">
									<div class="col-6 text-right">
										<?php echo $estoque['nprod'] ?>
									</div>
									<div class="col-6" data-toggle="tooltip" data-placement="top" title="<?php echo $estoque['qtd'] ?>/<?php echo $estoque['qtd_max'] ?>">
										<div class="h-100 w-100 bg-light">
											<div class="h-100 bg-<?php echo (($estoque['qtd'] / $estoque['qtd_max']) < 0.1? 'danger' : 'warning') ?>" style="width: <?php echo (int) ($estoque['qtd'] / $estoque['qtd_max'] * 100) ?>%">
											</div>
										</div>
									</div>
								</div>
							<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xl-4 bg-light">
					<a href="<?php echo $this->url('/painel/pf') ?>" class="text-decoration-none">
						<div class="card" style="background-color: #26a69a">
							<div class="card-body text-white">
								<h3 class="py-0"><?php echo $clientes_quantidade ?></h3>
								Velejadores cadastrados
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-4">
					<a href="<?php echo $this->url('/guardaria') ?>" class="text-decoration-none">
						<div class="card" style="background-color: #ec407a">
							<div class="card-body text-white">
								<h3 class="py-0"><?php echo $guardaria_quantidade ?></h3>
								Equipamentos na guardaria
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-4">
					<a href="<?php echo $this->url('/equipamentos') ?>" class="text-decoration-none">
						<div class="card" style="background-color: #29b6f6">
							<div class="card-body text-white">
								<h3 class="py-0"><?php echo $equipamentos_quantidade ?></h3>
								Equipamentos cadastrados
							</div>
						</div>
					</a>
				</div>
			</div>
			
			<div class="card d-none">
				<div class="card-body pt-0 pb-3">
					<div class="py-3">
						<h5 class="py-0 text-muted">Situação do Estoque</h5>
					</div>
						<canvas id="grafico2"></canvas>
				</div>
			</div>
			
			<div class="card d-none">
				<div class="card-body pt-0 pb-3">
					<div class="py-3">
						<h5 class="py-0 text-muted">Alguma coisa</h5>
					</div>
					<canvas id="grafico3"></canvas>
				</div>
			</div>
			
			<div class="card">
				<div class="card-body pt-0 pb-3">
					<div class="py-3">
						<h5 class="py-0 text-muted">Aniversariantes da semana</h5>
					</div>
					<?php if(empty($aniversariantes)): ?>
						<div class="small text-muted">Nenhum registro para exibir.</div>
					<?php else: ?>
						<div class="table-responsive" style="max-height: 300px; overflow-y: scroll;">
							<table class="table">
								<?php foreach($aniversariantes as $aniv): ?>
									<tr>
										<td><small><a href="<?= $this->url("/painel/overview_pf/{$aniv["cps"]}") ?>"><?php echo $aniv['nps'] ?></a></small></td>
										<td><small><?php echo $aniv['d_nasc'].'/'.$aniv['m_nasc'].'/'.$aniv['a_nasc'] ?></small></td>
									</tr>
								<?php endforeach ?>
							</table>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
		
		<div class="col-xl-4">
			<div class="card" style="background-color: #6495ED">
				<div class="card-body text-white">
					<div class="text-center" data-id="weather-loading">
						<div class="spinner-border" role="status">
						  <span class="sr-only">Loading...</span>
						</div>
					</div>
					
					<div class="d-none" data-id="weather-container">
						<h5 class="py-0">São Paulo</h5>
						<h1 class="py-2" style="font-weight: lighter; font-size: 49px;"><span data-id="weather-temperature">0</span>º</h1>
						<div>Direção do vento: <i class="material-icons align-middle px-2" data-id="weather-wind-direction-arrow">navigation</i>(<span data-id="weather-wind-direction"></span>)</div>
						<div>Velocidade do vento: <span data-id="weather-wind-velocity"></span>km/h</div>
						<div class="small pt-2 float-right">Fonte: <a href="https://www.climatempo.com.br" class="text-white" target="_blank">Climatempo</a></div>
					</div>
					
					<div class="d-none small text-center" data-id="weather-error">
						<p class="text-center">Não foi possível obter os dados meteorológicos.</p>
						<button type="button" class="btn btn-sm btn-primary" data-id="weather-refresh" style="border-radius: 40px;">
							<i class="material-icons align-middle">refresh</i>
							<span class="align-middle">Recarregar</span>
						</button>
					</div>
				</div>
			</div>
			
			<div class="card">
				<div class="card-body pt-0 pb-3">
					<div class="py-3">
						<h5 class="py-0 text-muted">Eventos de hoje</h5>
					</div>
					<?php if(empty($tarefas_dia)): ?>
						<div class="small text-muted">Nenhum evento para hoje.</div>
					<?php endif ?>
					<?php 
						$dia = date("d"); $mes = date("m"); $ano = date("Y");
						foreach($tarefas_dia as $td): 
					?>
                        <?php //para eventos que duram o mesmo dia (inicio e fim no mesmo dia)
							if($td['cdia']==$dia && $td['cmes']==$mes && $td['can']==$ano && $td['cdia']==$td['cdia_fim'] && $td['cmes']==$td['cmes_fim'] && $td['can']==$td['can_fim']):
						?>
                          <div class="card-body">
						  <div><?=$td['nacao'] .' / ' ?> 
						  <?php if($td['flg_dia_todo']==0) {
						  	echo $td['chora_ini'].'h'.$td['cminuto_ini'].'-'.$td['chora_fim'].'h'.$td['cminuto_fim'] ;
						  }else {
							echo 'Dia todo';
						  }
						  ?>
                          </div>
						  <?php 
						  	foreach($pessoas_ag as $pp){
								if($td['cagenda']==$pp['cagenda'] && $pp['cps']){
									echo '<div> > '.$pp['nps'].'</div>';
								}
							}
							
							if($td['OBS']){//mostra caso haja
								echo '<div>'.$td['OBS'].'</div>';
							}
						  ?> 
                          </div>
                        <?php endif; ?>
                        
                        <?php //para eventos que duram mais de um dia (inicio do evento)
							if($td['cdia']==$dia && $td['cmes']==$mes && $td['can']==$ano && $td['cdia']<$td['cdia_fim'] && $td['cmes']<=$td['cmes_fim'] && $td['can']<=$td['can_fim']):
						?>
                          <div class="card-body">
                          <div><?=$td['nacao'] .' / Termina em '. $td['cdia_fim'].'/'.$td['cmes_fim'].'/'.$td['can_fim']?></div>
						  <?php 
						  	foreach($pessoas_ag as $pp){
								if($td['cagenda']==$td['cagenda'] && $pp['cps']){
									echo '<div> > '.$pp['nps'].'</div>';
								}
							}
							if($td['OBS']){//mostra caso haja
								echo '<div>'.$td['OBS'].'</div>';
							}
						  ?> 
                          </div>
                        <?php endif; ?>
                        
                        <?php //para eventos que duram mais de um dia (meio do evento)
							if($td['cdia']<$dia && $td['cdia_fim']>$dia && $td['cmes']<=$mes && $td['can']<=$ano && $td['cdia']<$td['cdia_fim'] && $td['cmes']<=$td['cmes_fim'] && $td['can']<=$td['can_fim']):
						?>
                          <div class="card-body">
                          <div><?=$td['nacao'] .' / Durante '.$td['cdia'].'/'.$td['cmes'].'/'.$td['can'].' até '.$td['cdia_fim'].'/'.$td['cmes_fim'].'/'.$td['can_fim']?></div>
						  <?php 
						  	foreach($pessoas_ag as $pp){
								if($td['cagenda']==$td['cagenda'] && $pp['cps']){
									echo '<div> > '.$pp['nps'].'</div>';
								}
							}
							
							if($td['OBS']){//mostra caso haja
								echo '<div>'.$td['OBS'].'</div>';
							}
						  ?>
                          </div> 
                        <?php endif; ?>
                        
                        <?php //para eventos que duram mais de um dia (fim do evento)
							if($td['cdia_fim']==$dia && $td['cmes_fim']==$mes && $td['can_fim']==$ano && $td['cdia']<$td['cdia_fim'] && $td['cmes']<=$td['cmes_fim'] && $td['can']<=$td['can_fim']):
						?>
                          <div class="card-body">
                          <div><?=$td['nacao'] .' / Termina hoje as '.$td['chora_fim'].'h'.$td['cminuto_fim']?></div>
						  <?php 
						  	foreach($pessoas_ag as $pp){
								if($td['cagenda']==$td['cagenda'] && $pp['cps']){
									echo '<div> > '.$pp['nps'].'</div>';
								}
							}
							
							if($td['OBS']){//mostra caso haja
								echo '<div>'.$td['OBS'].'</div>';
							}
						  ?> 
                          </div>
                        <?php endif; ?>
                        
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class="card">
				<div class="card-body pt-0 pb-3">
					<div class="py-3">
						<h5 class="py-0 text-muted">Próximos eventos</h5>
					</div>
					<?php if(empty($tarefas_dp)): ?>
						<div class="small text-muted">Nenhum evento para exibir.</div>
					<?php endif ?>
					<?php foreach($tarefas_dp as $tdp): ?>
							<div class="card-body py-2">
                              <div><?=$tdp['nacao']?></div>
							  <div>
                                  <?=$tdp['cdia'].'/'.$tdp['cmes'].'/'.$tdp['can']?> | 
								  <?php if($tdp['flg_dia_todo']==0) {
                                    echo $tdp['chora_ini'].'h'.$tdp['cminuto_ini'] ;
                                  } else {
								  	echo 'Dia todo';
								  }
                                  ?>
                              </div>
							  <?php 
								foreach($pessoas_dp as $pdp){
									if($tdp['cagenda']==$pdp['cagenda'] && $pdp['cps']){
										echo '<div> > '.$pdp['nps'].'</div>';
									}
								}
								if($tdp['OBS']){//mostra caso haja
									echo '<div>'.$tdp['OBS'].'</div>';
								}
							  ?> 
							</div>
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class="card">
				<div class="card-header bg-transparent border-0">
					<h5 class="py-0 text-muted">Novos Velejadores</h5>
				</div>
				<div class="card-body p-0">
					<?php if(empty($last_clients)): ?>
						<div class="small text-muted">Nenhum registro para exibir.</div>
					<?php else: ?>
						<div class="table-responsive">
							<table class="table">
								<?php foreach($last_clients as $client): ?>
									<tr>
										<td><?php echo $client['nps'] ?></td>
										<td><?php echo $client['cpsf']? 'PF' : 'PJ' ?></td>
									</tr>
								<?php endforeach ?>
							</table>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
(function() {
	const COLORS = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(75, 192, 192)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(201, 203, 207)',
		transparent: 'rgba(0, 0, 0, 0)',
	};
	
	const MONTHS = ['', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];


	//var clients_ytd_chart;
	//var aulas_ytd_chart;
	//var locacoes_ytd_chart;
	//var diarias_ytd_chart;


	$(document).ready(function() {
		bindEvents();
		init();
	});
	
	function bindEvents() {
		$("[data-id='weather-refresh']").click(get_weather_data);
	};
	
	function init() {
		/* inicia os tooltips. */
		$('[data-toggle="tooltip"]').tooltip();
		
		draw_charts();
		get_weather_data();
		setInterval(get_weather_data, 300000);
	};
	
	function draw_charts() {
		var clients_ytd_chart = draw_clients_ytd_chart();
		var aulas_ytd_chart = draw_aulas_ytd_chart();
		var locacoes_ytd_chart = draw_locacoes_ytd_chart();
		var diarias_ytd_chart = draw_diarias_ytd_chart();
	};
	
	
	
	
	/* charts */
	function draw_clients_ytd_chart() {
		let YTD_month = <?php echo json_encode($cliente_ytd_month) ?>;
		let ctx = document.getElementById('clients_ytd_chart').getContext('2d');
		let chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',

			// The data for our dataset
			data: {
				labels: YTD_month.map((d) => MONTHS[d.cmes]),
				datasets: [{
					backgroundColor: COLORS.transparent, /* cor do preenchimento do grafico. */
					borderColor: 'rgba(0, 0, 0, .2)', /* cor da linha. */
					lineTension: 0, /* curvatura da linha nos pontos. 0 fica tudo reto. */
					pointRadius: 1, /* tamanho dos pontos. */
					data: YTD_month.filter((d) => d.cmes <= <?php echo date('n') ?>).map((d) => d.quantidade),
					borderWidth: 1, /* grossura da linha, do ponto, bordas em geral. */
				}],
			},

			// Configuration options go here

			options: {
				tooltips: {
					mode: 'index', /* mostra o tooltip da posicao que o mouse estiver. */
					intersect: false, /* mostrar o tooltip só de colocar o mouse em cima do grafico. */
					displayColors: false, /* nao mostrar os quadradinhos com a cor no tooltip (popup que abre quando coloca o mouse em cima). */
				},
				legend: {
					display: false /* não mostrar legenda (que fica na parte de cima). */
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false, /* nao mostrar o valor da escala vertical. */
						}
					}],
					xAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false /* nao mostrar o valor da escala vertical. */
						}
					}]
				}
			}
		});
		
		return chart;
	}
	
	function draw_aulas_ytd_chart() {
		let YTD_month = <?php echo json_encode($aulas_ytd_month) ?>;
		
		let ctx = document.getElementById('aulas_ytd_chart').getContext('2d');
		
		let chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',

			// The data for our dataset
			data: {
				labels: YTD_month.map((d) => MONTHS[d.cmes]),
				datasets: [{
					backgroundColor: COLORS.transparent, /* cor do preenchimento do grafico. */
					borderColor: 'rgba(0, 0, 0, .2)', /* cor da linha. */
					lineTension: 0, /* curvatura da linha nos pontos. 0 fica tudo reto. */
					pointRadius: 1, /* tamanho dos pontos. */
					data: YTD_month.filter((d) => d.cmes <= <?php echo date('n') ?>).map((d) => d.quantidade),
					borderWidth: 1, /* grossura da linha, do ponto, bordas em geral. */
				}],
			},

			// Configuration options go here
			options: {
				tooltips: {
					mode: 'index', /* mostra o tooltip da posicao que o mouse estiver. */
					intersect: false, /* mostrar o tooltip só de colocar o mouse em cima do grafico. */
					displayColors: false, /* nao mostrar os quadradinhos com a cor no tooltip (popup que abre quando coloca o mouse em cima). */
				},
				legend: {
					display: false /* não mostrar legenda (que fica na parte de cima). */
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false, /* nao mostrar o valor da escala vertical. */
						}
					}],
					xAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false /* nao mostrar o valor da escala vertical. */
						}
					}]
				}
			}
		});
		
		return chart;
	}
	
	function draw_locacoes_ytd_chart() {
		let YTD_month = <?php echo json_encode($locacoes_ytd_month) ?>;
		
		let ctx = document.getElementById('locacoes_ytd_chart').getContext('2d');
		
		let chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',

			// The data for our dataset
			data: {
				labels: YTD_month.map((d) => MONTHS[d.cmes]),
				datasets: [{
					backgroundColor: COLORS.transparent, /* cor do preenchimento do grafico. */
					borderColor: 'rgba(0, 0, 0, .2)', /* cor da linha. */
					lineTension: 0, /* curvatura da linha nos pontos. 0 fica tudo reto. */
					pointRadius: 1, /* tamanho dos pontos. */
					data: YTD_month.filter((d) => d.cmes <= <?php echo date('n') ?>).map((d) => d.quantidade),
					borderWidth: 1, /* grossura da linha, do ponto, bordas em geral. */
				}],
			},

			// Configuration options go here
			options: {
				tooltips: {
					mode: 'index', /* mostra o tooltip da posicao que o mouse estiver. */
					intersect: false, /* mostrar o tooltip só de colocar o mouse em cima do grafico. */
					displayColors: false, /* nao mostrar os quadradinhos com a cor no tooltip (popup que abre quando coloca o mouse em cima). */
				},
				legend: {
					display: false /* não mostrar legenda (que fica na parte de cima). */
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false, /* nao mostrar o valor da escala vertical. */
						}
					}],
					xAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false /* nao mostrar o valor da escala vertical. */
						}
					}]
				}
			}
		});
		
		return chart;
	}
	
	function draw_diarias_ytd_chart() {
		let YTD_month = <?php echo json_encode($diarias_ytd_month) ?>;
		
		let ctx = document.getElementById('diarias_ytd_chart').getContext('2d');
		
		let chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',

			// The data for our dataset
			data: {
				labels: YTD_month.map((d) => MONTHS[d.cmes]),
				datasets: [{
					backgroundColor: COLORS.transparent, /* cor do preenchimento do grafico. */
					borderColor: 'rgba(0, 0, 0, .2)', /* cor da linha. */
					lineTension: 0, /* curvatura da linha nos pontos. 0 fica tudo reto. */
					pointRadius: 1, /* tamanho dos pontos. */
					data: YTD_month.filter((d) => d.cmes <= <?php echo date('n') ?>).map((d) => d.quantidade),
					borderWidth: 1, /* grossura da linha, do ponto, bordas em geral. */
				}],
			},

			// Configuration options go here
			options: {
				tooltips: {
					mode: 'index', /* mostra o tooltip da posicao que o mouse estiver. */
					intersect: false, /* mostrar o tooltip só de colocar o mouse em cima do grafico. */
					displayColors: false, /* nao mostrar os quadradinhos com a cor no tooltip (popup que abre quando coloca o mouse em cima). */
				},
				legend: {
					display: false /* não mostrar legenda (que fica na parte de cima). */
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false, /* nao mostrar o valor da escala vertical. */
						}
					}],
					xAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false /* nao mostrar o valor da escala vertical. */
						}
					}]
				}
			}
		});
		
		return chart;
	}
	
	
	
	function grafico1() {
		var ctx = document.getElementById('grafico1').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',

			// The data for our dataset
			data: {
				labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
				datasets: [{
					backgroundColor: 'rgba(0, 0, 0, 0)', /* cor do preenchimento do grafico. */
					borderColor: 'rgba(0, 0, 0, .2)', /* cor da linha. */
					lineTension: 0, /* curvatura da linha nos pontos. 0 fica tudo reto. */
					pointRadius: 1, /* tamanho dos pontos. */
					data: Array.from({length: 12}, () => Math.floor(Math.random() * 100)),
					borderWidth: 1, /* grossura da linha, do ponto, bordas em geral. */
				}],
			},

			// Configuration options go here
			options: {
				tooltips: {
					mode: 'index', /* mostra o tooltip da posicao que o mouse estiver. */
					intersect: false, /* mostrar o tooltip só de colocar o mouse em cima do grafico. */
					displayColors: false, /* nao mostrar os quadradinhos com a cor no tooltip (popup que abre quando coloca o mouse em cima). */
				},
				legend: {
					display: false /* não mostrar legenda (que fica na parte de cima). */
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false, /* nao mostrar o valor da escala vertical. */
						}
					}],
					xAxes: [{
						gridLines: {
							display: false, /* nao mostrar a linha do grid vertical. */
							drawBorder: false, /* nao mostrar a borda da esquerda. */
						},
						ticks: {
							display: false /* nao mostrar o valor da escala vertical. */
						}
					}]
				}
			}
		});
	}
	
	
	function grafico2() {
		var ctx = document.getElementById('grafico2').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'line',

			// The data for our dataset
			data: {
				labels: Array.from({length: 12}, () => 'label'),
				datasets: [{
					backgroundColor: 'rgba(0, 0, 0, 0)', /* cor do preenchimento do grafico. */
					borderColor: 'rgba(0, 0, 0, .2)', /* cor da linha. */
					lineTension: 0, /* curvatura da linha nos pontos. 0 fica tudo reto. */
					//pointRadius: 2, /* tamanho dos pontos. */
					data: Array.from({length: 12}, () => Math.floor(Math.random() * 100)),
					//borderWidth: 1, /* grossura da linha, do ponto, bordas em geral. */
				}],
			},

			// Configuration options go here
			options: {
				tooltips: {
					mode: 'index', /* mostra o tooltip da posicao que o mouse estiver. */
					intersect: false, /* mostrar o tooltip só de colocar o mouse em cima do grafico. */
					displayColors: false, /* nao mostrar os quadradinhos com a cor no tooltip (popup que abre quando coloca o mouse em cima). */
				},
				legend: {
					display: false /* não mostrar legenda (que fica na parte de cima). */
				},
			}
		});
	}
	
	function grafico3() {
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
						window.chartColors.blue,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Red',
					'Orange',
					'Yellow',
					'Green',
					'Blue'
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Chart.js Doughnut Chart'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};
		
		var ctx = document.getElementById('grafico3').getContext('2d');
		var chart = new Chart(ctx, config);
	}
	
	
	/* WEATHER */
	function get_weather_data() {
		$("[data-id='weather-error']").addClass("d-none");
		$("[data-id='weather-container']").addClass("d-none");
		$("[data-id='weather-loading']").removeClass("d-none");
		
		let get_from_cookies = function() {
			console.log("getting weather from cookies.");
			let weather = {
				temperature: getCookie('weather-temperature'),
				wind_direction: getCookie('weather-wind_direction'),
				wind_velocity: getCookie('weather-wind_velocity')
			};
			$("[data-id='weather-loading']").addClass("d-none");
			set_weather(weather);
		};
		
		let get_from_api = function() {
			console.log("getting weather from api.");
			$.get("http://apiadvisor.climatempo.com.br/api/v1/weather/locale/3477/current?token=f57930f341a1e09946919a9531b9dd14")
				.done(function(weather) {
					setCookie('weather-time', new Date().getTime());
					setCookie('weather-temperature', weather.data.temperature);
					setCookie('weather-wind_direction', weather.data.wind_direction);
					setCookie('weather-wind_velocity', weather.data.wind_velocity);
					set_weather(weather.data);
				})

				.fail(function(e) {
					$("[data-id='weather-error']").removeClass("d-none");
				})
				.always(function() {
					$("[data-id='weather-loading']").addClass("d-none");
				});
		};
		
		function set_weather(weather) {
			$("[data-id='weather-temperature']").text(weather.temperature);
			$("[data-id='weather-wind-direction']").text(weather.wind_direction);
			$("[data-id='weather-wind-direction-arrow']")
				.removeClass("weather-N weather-NNW weather-NW weather-WNW weather-W weather-WSW weather-SW weather-SSW weather-S weather-SSE weather-SE weather-ESE weather-E weather-ENE weather-NE weather-NNE")
				.addClass("weather-" + weather.wind_direction);
			$("[data-id='weather-wind-velocity']").text(weather.wind_velocity);
			$("[data-id='weather-container']").removeClass("d-none");
		};
		
		let weather_time = getCookie('weather-time');
		console.log(weather_time);
		if(weather_time && (new Date().getTime() - weather_time) < 1000 * 60 * 10) { /* 10 minutos */
			get_from_cookies();
		}
		else {
			get_from_api();
		}
	};

	
	function setCookie(cname, cvalue, exdays = 1) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
})();
</script>