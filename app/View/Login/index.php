<style>
body{
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 50px;
  padding-bottom: 50px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
  border:1px solid #ddd;
  background: #fdfdfd;
  box-shadow: -4px 6px 3px -4px rgba(201,197,201,1);
  text-align:center;
}

.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}

.form-signin .form-control:focus {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>

<form class="form-signin form-signin-sm" action="<?= $this->url('/login/login' . (isset($_GET['redirect'])? '?redirect=' . $_GET['redirect'] : '')) ?>" method="post">
	<img class="mb-4" src="<?=$this->url('/img/logo.png')?>" style="width:80px; height:80px;">
	<h1 class="h3 mb-3 font-weight-normal">Entre com seu acesso</h1>
	<div class="form-group">
		<input name="login" type="text" class="form-control" placeholder="Login" required autofocus>
		<input name="password" type="password" class="form-control" placeholder="Senha" required>
  	</div>
    <button type="submit" class="btn btn-lg btn-primary btn-block">Logar</button>
    <p class="mt-5 mb-3 text-muted">Powered by M.Gold®</p>
</form>