<?php
	$user = Auth::user();
?>

<ul class="menu nav flex-column bg-dark">
	<?php if(in_array($user['sna'], array('ADM', 'AREANAU', 'INST'))): ?>
		<a href="<?= $this->url('/agenda/agenda') ?>" style="text-decoration: none;">
			<li class="item-menu nav-item text-light noselect">Agenda</li>
		</a>
	<?php endif ?>

	<?php if(in_array($user['sna'], array('ADM'))): ?>
		<a href="<?= $this->url('/painel/pf') ?>" style="text-decoration: none;">
			<li class="item-menu nav-item text-light noselect">Velejadores</li>
		</a>
	<?php endif ?>
	
	<?php if(in_array($user['sna'], array('ADM'))): ?>
		<a href="#" style="text-decoration: none;">
			<li class="item-menu nav-item text-light noselect">Brechó</li>
		</a>
	<?php endif ?>

	<?php if(in_array($user['sna'], array('ADM'))): ?>
		<li class="nav-item text-light noselect">
			<div class="item-menu noselect" data-toggle="collapse" data-target="#menu-administracao">Administração</div>
			<div class="collapse" id="menu-administracao">
				<ul class="menu nav flex-column bg-dark">
					<a href="<?= $this->url('/fornecedor') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Fornecedores</li>
					</a>
					<a href="<?= $this->url('/colaboradores') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Colaboradores</li>
					</a>
				</ul>
			</div>
		</li>
	<?php endif ?>

	<?php if(in_array($user['sna'], array('ADM', 'INST'))): ?>
		<li class="nav-item text-light noselect">
			<div class="item-menu noselect" data-toggle="collapse" data-target="#menu-servicos">Serviços</div>
			<div class="collapse" id="menu-servicos">
				<ul class="menu nav flex-column bg-dark">
					<?php if(in_array($user['sna'], array('ADM'))): ?>
						<a href="<?= $this->url('/guardaria') ?>" style="text-decoration: none;">
							<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Guarderia</li>
						</a>
					<?php endif ?>

					<?php if(in_array($user['sna'], array('ADM', 'INST'))): ?>
						<a href="<?= $this->url('/aula') ?>" style="text-decoration: none;">
							<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Aulas</li>
						</a>
					<?php endif ?>

					<?php if(in_array($user['sna'], array('ADM'))): ?>
						<a href="<?= $this->url('/locacao') ?>" style="text-decoration: none;">
							<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Locação</li>
						</a>
					<?php endif ?>

					<?php if(in_array($user['sna'], array('ADM'))): ?>
						<a href="<?= $this->url('/diariavelejador') ?>" style="text-decoration: none;">
							<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Diária/Pernoite</li>
						</a>
					<?php endif ?>
				</ul>
			</div>
		</li>
	<?php endif ?>

	<?php if(in_array($user['sna'], array('ADM'))): ?>
		<li class="nav-item text-light noselect">
			<div class="item-menu noselect" data-toggle="collapse" data-target="#menu-tabela-de-precos">Tabela de Preços</div>
			<div class="collapse" id="menu-tabela-de-precos">
				<ul class="menu nav flex-column bg-dark">
					<a href="<?= $this->url('/servicos/precos') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Serviços</li>
					</a>
				</ul>
			</div>
		</li>
	<?php endif ?>

	<?php if(in_array($user['sna'], array('ADM'))): ?>
		<li class="nav-item text-light noselect">
			<div class="item-menu noselect" data-toggle="collapse" data-target="#menu-relatorios">Relatórios</div>
			<div class="collapse" id="menu-relatorios">
				<ul class="menu nav flex-column bg-dark">
					<a href="<?= $this->url('/guardaria/relatorio') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Guarderia</li>
					</a>
					<a href="<?= $this->url('/aula/relatorio') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Aulas</li>
					</a>
					<a href="<?= $this->url('/locacao/relatorio') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Locação</li>
					</a>
					<a href="<?= $this->url('/diariavelejador/relatorio') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Diária/Pernoite</li>
					</a>
					<a href="<?= $this->url('/ocorrencia') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Ocorrências</li>
					</a>
					<a href="<?= $this->url('/painel/relatorio') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Velejadores</li>
					</a>
					<a href="<?= $this->url('/painel/relatorio_aniversariantes') ?>" style="text-decoration: none;">
						<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">Aniversariantes</li>
					</a>
				</ul>
			</div>
		</li>
	<?php endif ?>
	
	<?php if(Auth::user()['lg'] === 'gold'): ?>
		<a href="<?= $this->url('/usuario') ?>" style="text-decoration: none;">
			<li class="item-menu nav-item text-light noselect">Usuários</li>
		</a>
	<?php endif; ?>
	<li class="nav-item mt-5 mb-3 text-muted" style="padding-left: 10px;" title="M.Gold®">
		Powered by M.Gold®
	</li>
</ul>

<!--

	COMO ERA O MENU ANTERIOR : PEGANDO DO  BANCO

<ul class="menu nav flex-column bg-dark">
<?php foreach($menu as $m): ?>
	<li class="nav-item text-light">
		<div class="item-menu noselect" data-toggle="collapse" data-target=".collapse-menu-<?php echo $m['cmenu'] ?>"><?php echo $m['nmenu'] ?></div>
		<div class="collapse collapse-menu-<?php echo $m['cmenu'] ?>">
			<ul class="menu nav flex-column bg-dark">
			<?php foreach($m['sub'] as $sm): ?>
				<a href="<?php echo $this->url($sm['lnkmenu']) ?>" style="text-decoration: none;">
					<li class="item-menu nav-item text-light noselect" style="padding-left: 25px;">
						<?php echo $sm['nsmenu'] ?>
					</li>
				</a>
			<?php endforeach ?>
			</ul>
		</div>
	</li>
<?php endforeach ?>
</ul>

-->

<style>
	.noselect {
	  -webkit-touch-callout: none; /* iOS Safari */
		-webkit-user-select: none; /* Safari */
		 -khtml-user-select: none; /* Konqueror HTML */
		   -moz-user-select: none; /* Firefox */
			-ms-user-select: none; /* Internet Explorer/Edge */
				user-select: none; /* Non-prefixed version, currently
									  supported by Chrome and Opera */
	}
	
	.item-menu {
		padding: 10px;
	}
	
	.item-menu.active {
		background-color: #666;
	}
	
	.item-menu:hover {
		background-color: #666;
		cursor: pointer;
	}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('.nav-item .item-menu').click(function() {
			//$(this).find('.collapsed').removeClass('.collapsed').addClass('.collapse');
		});
	});
</script>