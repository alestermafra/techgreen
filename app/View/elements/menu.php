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
	<li class="nav-item mt-5 mb-3 text-muted" style="padding-left: 10px;" title="M.Gold®">
		Powered by M.Gold®
	</li>
</ul>

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