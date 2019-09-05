(function() {
	if(typeof window.EventManager !== 'undefined') {
		console.log('Warning: EventManager is already defined.');
		return;
	}
	
	var EventManager = function() {
		this.events = {};
	};
	EventManager.prototype = {
		on : function(e, fn) {
			this.events[e] = this.events[e] || [];
			this.events[e].push(fn);
			return this;
		},
		trigger: function(e, args) {
			args = args || [];
			var _event = this.events[e];
			if(_event instanceof Array) {
				_event.forEach((fn) => fn.apply(fn, args));
			}
		}
	};
	
	EventManager.eventify = function(obj) {
		var manager = new EventManager();
		obj.on = function() {
			manager.on.apply(manager, arguments);
		};
		obj.trigger = function() {
			manager.trigger.apply(manager, arguments);
		};
	};
	
	window.EventManager = EventManager;
})();