<div class="row">
	<div class="form-group col-12 col-lg-3">
		<label>Unidade de Negócio</label>
		<div id="unidade_negocio-container"></div>
	</div>
	
	<div class="form-group col-12 col-lg-3">
		<label>Região</label>
		<div id="regiao-container"></div>
	</div>
	
	<div class="form-group col-12 col-lg-3">
		<label>Distrito</label>
		<div id="distrito-container"></div>
	</div>
	
	<div class="form-group col-12 col-lg-3">
		<label>Setor</label>
		<div id="setor-container"></div>
	</div>
</div>

<script type="text/javascript" src="<?php echo $this->url('/js/eventmanager.js') ?>"></script>
<script type="text/javascript">
(function() {
	var Hierarquia = function(container, url) {
		this.container = container;
		this.selector = container + ' select';
		this.url = url;
		
		EventManager.eventify(this);
		//this.load();
	};
	
	Hierarquia.prototype = {
		val: function() {
			return $(this.selector).val();
		},
		load: function(data = null) {
			var _this = this;
			ajax({
				url: this.url,
				url_params: data,
				container: this.container,
				change: function() {
					_this.onchange();
				},
				success: function(r) {
					_this.onchange();
				},
				show_loading: false
			});
		},
		onchange: function() {
			this.trigger('change', [this.val()]);
		},
	};
	
	window.Hierarquia = Hierarquia;
})();
	var UnidadeNegocio = new Hierarquia('#unidade_negocio-container', "<?php echo $this->url('/unidade_negocio/ajax_combo') ?>");
	var Regiao = new Hierarquia('#regiao-container', "<?php echo $this->url('/regiao/ajax_combo') ?>");
	var Distrito = new Hierarquia('#distrito-container', "<?php echo $this->url('/distrito/ajax_combo') ?>");
	var Setor = new Hierarquia('#setor-container', "<?php echo $this->url('/setor/ajax_combo') ?>");

(function() {
	bindEvents();
	UnidadeNegocio.load();
	
	function bindEvents() {
		UnidadeNegocio.on('change', function(id) {
			var data = [];
			if(id) {
				data = [id];
			}
			Regiao.load(data);
		});
		Regiao.on('change', function(id) {
			var data = [];
			if(id) {
				data = [id];
			}
			Distrito.load(data);
		});
		Distrito.on('change', function(id) {
			var data = [];
			if(id) {
				data = [id];
			}
			Setor.load(data);
		});
	};
})();

</script>