<nav>
	<ul class="pagination pagination-sm justify-content-center">
		<li class="page-item <?php echo $page == 1? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url($link . '/1') ?>">Primeira</a></li>
		<li class="page-item <?php echo $page == 1? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url($link . '/' . ($page - 1)) ?>">Anterior</a></li>
		<li class="page-item active"><a class="page-link" href="<?php echo $this->url($link . '/' . $page) ?>"><?php echo $page ?></a></li>
		<li class="page-item <?php echo $page == $paginas? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url($link . '/' . ($page + 1)) ?>">Próxima</a></li>
		<li class="page-item <?php echo $page == $paginas? 'disabled':'' ?>"><a class="page-link" href="<?php echo $this->url($link . '/' . $paginas) ?>">Última</a></li>
	</ul>
</nav>