$.extend($.fn.combogrid.defaults.keyHandler, {
	query: function (q, e) {
		var target = this;
		var state = $.data(target, 'combogrid');
		var opts = state.options;
		var grid = state.grid;
		state.remainText = true;
		if (opts.multiple && !q) {
			$(target).combogrid('setValues', []);
		} else {
			$(target).combogrid('setValues', [q]);
		}
		if (opts.mode == 'remote') {
			var _options = { q: q };
			if ($('.filter_item_search').length) {
				$('.filter_item_search').each(function (_i, _elem) {
					var column = $(_elem).attr('column');
					_options[column] = $(_elem).val();
				});
			}
			grid.datagrid('clearSelections');
			grid.datagrid('load', $.extend({}, opts.queryParams, _options));
		} else {
			if (!q) return;
			grid.datagrid('clearSelections');
			var rows = grid.datagrid('getRows');
			var qq = q.split(opts.separator);
			for (var j = 0; j < qq.length; j++) {
				var q = qq[j];
				if (!q) { continue; }
				for (var i = 0; i < rows.length; i++) {
					if (opts.filter.call(target, q, rows[i])) {
						grid.datagrid('selectRow', i);
					}
				}
			}
		}
	}
});
function generateCode() {
	//console.log('generateCode called');
	var code = $Core.util.randomString(5);
	$('.ipn__discount_code').val(code.toUpperCase());
	return false;
}
function open_discount(_this) {
	var discount_id = $(_this).attr('discount_id');
	vietiso_loading(1);
	$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=open_discount", {
		'discount_id': discount_id,
		dataType: "html",
	}, function (html) {
		vietiso_loading(0);
		makepopup(
			"991px",
			"auto",
			html,
			"pop_AddDiscount",
			"frmPop2"
		);
		//$Core.popup.open('auto','auto',html,'open_discount_'+discount_id);
		$('select[name=product_group]').trigger('change');
	}, 'html');
}
function get_select_city(_this) {
	var _country_id = $(_this).val(),
		_form = $(_this).closest('.modal');
	vietiso_loading(1);
	$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=get_select_city", {
		'country_id': _country_id
	}, function (html) {
		vietiso_loading(0);
		$('.slb_City_Id').html(html);
	});
}
function handler_filter_objects(_this) {
	var discount_id = $(_this).attr('discount_id'),
		product_type = $(_this).val();
	$('.holder_filters').html('<div class="loading text-center">Loading...</div>');
	$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=handler_filter_objects", {
		'discount_id': discount_id,
		'product_type': product_type,
	}, function (respJson) {
		load_products_discount(discount_id, {});
		$('.holder_filters').html(respJson.html);
		$('#' + 'cboProduct').combogrid({
			onSelect: function (index, row) {
				return false;
			}
		});
		if (respJson.callback) {
			eval(respJson.callback);
		}
	}, 'json');
}
function handler_discount_change(_this) {
	var _value_type = $(_this).val(),
		_suffix = $(_this).attr('suffix');
	$('.discount-suffix').text(_suffix);
	if (_value_type == 1) {
		$('input[name=discount_value]')
			.val(0)
			.priceFormat({
				centsLimit: 0,
				thousandsSeparator: '.'
			});
	} else {
		$('input[name=discount_value]')
			.val(0)
			.unpriceFormat();
	}
}
function add_product(_this) {
	var type = $(_this).attr('_type'),
		item_id = $(_this).attr('item_id'),
		clsTable = $(_this).attr('clsTable'),
		discount_id = $(_this).attr('discount_id');
	var $_adata = { 'discount_id': discount_id, 'type': type, 'item_id': item_id, 'clsTable': clsTable, 'action': '_save' };
	vietiso_loading(1);
	$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=add_product", $_adata, function (html) {
		vietiso_loading(0);
		if (html.indexOf('_error') >= 0) {
			$Core.alert.alert(__['Message'], 'Bạn phải chọn ít nhất một sản phẩm [OR] danh mục');
		} else {
			var $_options = { '_reload': true };
			if ($('.filter_item_search').length) {
				$('.filter_item_search').each(function (_i, _elem) {
					var column = $(_elem).attr('column');
					$_options[column] = $(_elem).val();
				});
			}
			$('#' + 'cboProduct').combogrid('grid').datagrid('load', $_options);
			load_products_discount(discount_id, {});
		}
	});
	return false;
}
function delete_product(_this) {
	var type = $(_this).attr('_type'),
		discount_id = $(_this).attr('discount_id'),
		discount_item_id = $(_this).attr('discount_item_id');
	vietiso_loading(1);
	$Core.alert.confirm(__['Message'], __['confirm_delete'], function () {
		$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=delete_product", {
			'discount_id': discount_id,
			'discount_item_id': discount_item_id
		}, function (html) {
			vietiso_loading(0);
			load_products_discount(discount_id, { 'type': type });
		});
	});
	return false;
}
function load_products_discount(discount_id, options) {
	var $_adata = options || {};
	$_adata['discount_id'] = discount_id;
	vietiso_loading(0);
	$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=load_products_discount&lang=" + LANG_ID, $_adata, function (respJson) {
		vietiso_loading(0);
		$('#' + 'total_items').text(respJson.total_items);
		$('#' + 'holder_products_discount').html(respJson.html);
	}, 'json');
}
function pop_save_discount(_this, ev) {
	ev.preventDefault();
	var discount_id = $(_this).attr('discount_id'),
		_form = $('#promoForm');

	var _validated = 0;
	if ($('input.required, select.required', _form).length) {
		$('input.required, select.required', _form).each(function (_i, _elem) {
			if ($Core.util.isEmpty($(_elem).val())) {
				_validated++;
				$(_elem).focus();
				return false;
			}
		});
	}
	//console.log('Validation errors:', _validated);
	if (_validated == 0) {
		vietiso_loading(1);

		_form.ajaxSubmit({
			type: 'POST',
			url: path_ajax_script + "/index.php?mod=" + mod + "&act=pop_save_discount&lang=" + LANG_ID,
			data: {
				'discount_id': discount_id
			},
			success: function (html) {
				vietiso_loading(0);

				Swal.fire({
					icon: 'success',
					title: 'Success',
					text: 'Promotion has been saved successfully!',
					timer: 1000,
					timerProgressBar: true,
					showConfirmButton: true,
					confirmButtonText: 'OK',
					allowOutsideClick: false,
					allowEscapeKey: false
				}).then(function () {
					window.location.reload(true);
				});
			},
			error: function () {
				vietiso_loading(0);

				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Something went wrong. Please try again.',
					showConfirmButton: true,
					confirmButtonText: 'OK',
					allowOutsideClick: false
				});
			}
		});
	}
	return false;
}
function stop_discount(_this) {
	var discount_id = $(_this).attr('discount_id'),
		$_adata = { 'discount_id': discount_id };
	$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=get_discount_info", $_adata, function (respJson) {
		$Core.alert.confirm(respJson.title, respJson.msg, function () {
			$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=stop_discount", $_adata, function (respJson) {
				window.location.reload(true);
			});
		});
	}, 'json');
}
function continue_discount(_this) {
	var discount_id = $(_this).attr('discount_id'),
		$_adata = { 'discount_id': discount_id, 'holderG': 'continue' };
	$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=get_discount_info", $_adata, function (respJson) {
		$Core.alert.confirm(respJson.title, respJson.msg, function () {
			$.post(path_ajax_script + "/index.php?mod=" + mod + "&act=continue_discount", $_adata, function (respJson) {
				window.location.reload(true);
			});
		});
	}, 'json');
}
function html_entity_decode(str) {
	var ta = document.createElement("textarea");
	ta.innerHTML = str.replace(/</g, "&lt;").replace(/>/g, ">");
	toReturn = ta.value;
	ta = null;
	return toReturn;
}
function ltrimZero(str) {
	return str.replace(/^0/, "");
}
function rtrimZero(str) {
	return str.replace(/0$/, "");
}
$(function () {
	$_document.on("keyup", 'input[name="discount_value"]', function () {
		$(this).val(ltrimZero($(this).val()));
	});
	$_document.on('change', '.filter_item_search', function () {
		var _this = $(this),
			_modal = _this.closest('.modal');

		var $_options = { '_reload': true };
		if ($('.filter_item_search', _modal).length) {
			$('.filter_item_search', _modal).each(function (_i, _elem) {
				var column = $(_elem).attr('column');
				$_options[column] = $(_elem).val();
			});
		}
		console.log($_options);
		$('#' + 'cboProduct').combogrid('grid').datagrid('load', $_options);
	});
	$_document.on('change', 'input[type=checkbox][name=allow_usage_limit]', function () {
		var _this = $(this);
		if (_this.is(':checked')) {
			$('#' + 'usage_limit').removeClass('hidden');
			$('input[name=usage_limit]').focus();
		} else {
			$('#' + 'usage_limit').addClass('hidden');
		}
	});
	$_document.on('change', 'input[type=radio][name=product_type]', function () {
		var _this = $(this),
			_discount_id = _this.attr('discount_id'),
			_val = $('input[type=radio][name=product_type]:checked').val();
		if (_val == 'all') {
			$('.' + 'holder_product_group').addClass('hidden');
		} else {
			$('.' + 'holder_product_group').removeClass('hidden');
			$('select[name=product_group]').trigger('change');
		}
	});
	$_document.on('change', 'input[type=checkbox][name=is_alldays]', function () {
		var _this = $(this), _form = _this.closest('form');
		if (_this.is(':checked')) {
			$('.weekday[type=checkbox]', _form).attr('checked', true);
		} else {
			$('.weekday[type=checkbox]', _form).attr('checked', false);
		}
	});
	$_document.on('change', 'input[type=checkbox][class=weekday]', function () {
		var _this = $(this), _form = _this.closest('form');
		if ($(".weekday:checked").length == 7) {
			$('input[type=checkbox][name=is_alldays]', _form).attr('checked', true);
		} else {
			$('input[type=checkbox][name=is_alldays]', _form).attr('checked', false);
		}
	});
});