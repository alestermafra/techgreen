<h2 style="padding: 20px; font-weight: lighter;">Dashboard Administrativo</h2>

<div style="padding: 0 20px">
<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Log</th>
      <th scope="col">Usuário</th>
      <th scope="col">Último Acesso</th>
      <th scope="col">Última Interação</th>
    </tr>
  </thead>
   <tbody>
   <?php 
	foreach($lista as $p){
		echo '<tr>';
		echo '<th scope="row">'.$p['cps'].'</th>';
		
		if($p['logado']==1){
			echo '<td><span class="badge badge-success" title="Usuário logado">ONLINE</span></td>';
		}else{
			echo '<td><span class="badge badge-secondary" title="Usuário deslogado">OFFLINE</span></td>';
		}
		
		echo '<td>'.$p['nps'].'</td>';
		echo '<td>'.date('d/m/Y H:i:s',strtotime($p['last_login'])).'</td>';
		echo '<td>'.date('d/m/Y H:i:s',strtotime($p['last_inter'])).'</td>';
		echo '</tr>';
	} 
   ?> 
   </tbody>
</table>
</div>
</div>

<script type="text/javascript">
    setTimeout(function () { 
      location.reload();
    }, 60 * 1000);
</script>
