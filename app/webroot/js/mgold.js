function ajax(options) {
	var url = options['url'] || null;
	var url_params = options['url_params'] || null;
	var method = options['method'] || 'GET';
	var data = options['data'] || {};
	var success = options['success'] || null;
	var error = options['error'] || null;
	var container = options['container'] || null;
	var show_loading = options['show_loading'] === false? false : true;
	var loading_html = options['loading_html'] || '<div class="text-center"><small class="text-muted">loading</small></div>';
	var change = options['change'] || null;
	var attempts = options['attempts'] === 0? 0 : options['attempts'] || 3;
	
	if(!url) {
		console.log('Error: url not defined.');
		return;
	}
	
	if(url_params && Array.isArray(url_params)) {
		url_params.forEach(function(d) {
			url += '/' + d;
		});
	}
	
	if(container) {
		$(container).empty();
		if(show_loading) {
			$(container).html('<div class="text-center"><small class="text-muted">loading</small></div>');
		}
	}
	
	if(typeof AJAX_COLA !== 'undefined' && AJAX_COLA === true) {
		console.log(method + ': ' + url);
	}
	
	$.ajax({
		url: url,
		method: method,
		data: data,
		success: function(result) {
			$result = $(result);
			if(container) {
				$(container).empty();
				$(container).html($result);
				if(change) {
					$result.change(change);
				}
			}
			if(success) {
				success(result, $result);
			}
		},
		error: function(e) {
			attempts = attempts - 1;
			if(attempts > 0) {
				options['attempts'] = attempts;
				ajax(options);
			}
			else if(error) {
				error(e);
			}
		}
	});
}


/* mask functions */
function apply_mask(mask, val) {
	if(mask instanceof Function) {
		mask = mask(val);
	}
	
	var v_index = 0;
	var new_val = '';
	
	var mask_type = {
		NUMERO: '0',
		LETRA: 'L',
		NUMERO_OU_LETRA: 'A',
		QUALQUER_COISA: 'X'
	};
	
	for(var m_index = 0; m_index < mask.length && val[v_index]; m_index++) {
		if(mask[m_index] === mask_type['NUMERO'] && !val[v_index].match(/\d/)
			|| mask[m_index] === mask_type['LETRA'] && !val[v_index].match(/[a-zA-Z]/)
			|| mask[m_index] === mask_type['NUMERO_OU_LETRA'] && !val[v_index].match(/\d/) && !val[v_index].match(/[a-zA-Z]/)
		) {
			m_index--;
			v_index++;
			continue;
		}
		
		if(mask[m_index] !== mask_type['NUMERO'] && mask[m_index] !== mask_type['LETRA'] && mask[m_index] !== mask_type['NUMERO_OU_LETRA'] && mask[m_index] !== mask_type['QUALQUER_COISA'] && mask[m_index] !== val[v_index]) {
			new_val += mask[m_index];
		}
		else {
			new_val += val[v_index++];
		}
	}
	
	return new_val;
};

(function($) {
	$.fn.mask = function(mask) {
		$(this).each(function() {
			$(this).off('keyup');
			$(this).val(apply_mask(mask, $(this).val()));
			$(this).keyup(() => $(this).val(apply_mask(mask, $(this).val())));
		});
		
		return this;
	};
})(jQuery);