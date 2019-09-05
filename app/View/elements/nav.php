<nav class="navbar fixed-top navbar-dark bg-dark">
	<button class="navbar-toggler d-lg-none" type="button">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<a class="navbar-brand" href="<?php echo $this->url('/') ?>">
		<img class="align-top" src="<?=$this->url('/img/logo_h.png')?>" width="100" />
	</a>
	
	<span class="nav-item dropdown">
		<a class="nav-link dropdown-toggle text-light" title="Opções" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"></a>
		<div class="dropdown-menu">
			<a class="dropdown-item" title="Alterar sua senha de acesso" href='<?= $this->url('/usuario/alterar_senha') ?>'>
				<i class="large material-icons">account_box</i>
			</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" title="Sair" href='<?= $this->url('/login/logout') ?>'>
				<i class="large material-icons">exit_to_app</i>
			</a>
		</div>
	</span>
</nav>
<style>
    /* para compensar o navbar estar fixo */
	body {
		padding-top: 56px;
	}
</style>