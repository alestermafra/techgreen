<nav class="navbar navbar-light">
	<span class="navbar-brand">Alteração de sua Senha de Acesso</span>
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


<form action="<?php echo $this->url('/usuario/alterar_senha') ?>" method="POST">	

	<input type="hidden" name="cusu" value="<?=$usu['cusu'];?>" />
	
	<div class="container-fluid">
		<div class="card">
			<div class="card-header bg-dark text-white">
				<i class="material-icons" onclick="mostra_esconde()" id="visivel" style="cursor:pointer" title="Mudar visibilidade">visibility</i>
			</div>
			<div class="card-body">
				<div class="form-group">
					<label class="small text-muted">Nova Senha</label> 
					<input name="pwd1" id="pwd1" type="password" class="form-control form-control-sm" placeholder="Digite sua nova senha" required autofocus maxlength="20">
				</div>
				<div class="form-group">
					<label class="small text-muted">Confirmar Senha</label> 
					<input name="pwd2" id="pwd2" type="password" class="form-control form-control-sm" placeholder="Confirme sua nova senha" required maxlength="20">
				</div>
		  </div>
		</div>
		
		<br>
		
		<div class="form-group text-right">
			<button type="submit" class="btn btn-success btn-sm">Confirmar</button>
		</div>
	</div>
</form>

<br />


<script type="text/javascript">
	//document.getElementById('formulario').onsubmit=function()
//	{
//		if(this.pwd1.value != this.pwd2.value)
//	 {
//			document.getElementById('alerta').style.display = 'block';
//			return false
//		}
//		return true
//	}
//
//	function some(){
//		document.getElementById('alerta').style.display = 'none';
//	}
	
	function mostra_esconde() {
	  var x = document.getElementById('pwd1');
	  var y = document.getElementById('pwd2');
	  var v = document.getElementById('visivel');
	  if (x.type === "password") {
		x.type = "text";
		y.type = "text";
		v.innerHTML = "visibility_off";		
	  } else {
		x.type = "password";
		y.type = "password";
		v.innerHTML = "visibility";	
	  }
	}
</script>