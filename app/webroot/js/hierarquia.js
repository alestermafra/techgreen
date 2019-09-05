(function() {
	var Hierarquia = function(container) {
		this.$container = $(container);
		EventManager.eventify(this);
	};
	
	Hierarquia.prototype = {
		load: function(url) {
			var _this = this;
			var $container = this.$container;
			$.ajax({
				url: url,
				success: function(result) {
					var $result = $(result);
					$container.html($result);
					$result.change(() => _this.trigger('change'));
					_this.trigger('load_success');
				},
				error: function(err) {
					$container.empty();
					_this.trigger('load_error', [err]);
				}
			});
		}
	};
	
	window.Hierarquia = Hierarquia;
})();