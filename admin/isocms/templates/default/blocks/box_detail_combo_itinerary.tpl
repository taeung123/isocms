<h3 class="title_box mb05">{$core->get_Lang('Combo Itinerary')}</h3>
<p class="intro_box mb40">{$core->get_Lang('introcomboitinerary')}</p>
<div class="inpt_tour">
	<div class="hastable">
		<div class="contingency_table" style="display: none;">
			<p class="title_contingency_table">{$core->get_Lang('Contingency table')}</p> <a style="vertical-align:middle" href="javascript:void(0);" id="clickToAddItinerary_contingency" class="iso-button-primary fl"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Add Contingency')}</a>
			<table class="full-width tbl-grid" cellspacing="0">
				<thead>
					<tr>
						<th class="gridheader" style="width:60px"><strong>{$core->get_Lang('day')}</strong></th>
						<th class="gridheader name_responsive name_responsive2" style="text-align:left"><strong>{$core->get_Lang('Title')}</strong></th>
						<th class="gridheader hiden_responsive" style="text-align:left; width: 290px;"><strong>{$core->get_Lang('Meals')}</strong></th>
						<th class="gridheader hiden_responsive" style="width: 50px"></th>
					</tr>
				</thead>
				<tbody id="tblComboItinerary_contingency"></tbody>
			</table>
		</div>
		<table class="full-width tbl-grid table_responsive" cellspacing="0">
			<thead>
			<tr>
				<th class="gridheader" style="width:60px"><strong>{$core->get_Lang('day')}</strong></th>
				<th class="gridheader hiden_responsive" style="width: 40px"></th>
				<th class="gridheader name_responsive name_responsive2" style="text-align:left"><strong>{$core->get_Lang('Title')}</strong></th>
				<th class="gridheader hiden_responsive" style="text-align:left; width: 290px;"><strong>{$core->get_Lang('Meals')}</strong></th>
				<th class="gridheader hiden_responsive" style="width: 50px"></th>
			</tr>
			</thead>
			<tbody id="tblComboItinerary"></tbody>
		</table>
	</div>
	<a href="javascript:void(0);" id="clickToAddItinerary" class="btn_additinerary" title="{$core->get_Lang('additinerary')}">+ {$core->get_Lang('additinerary')}</a>
</div>
{literal}
<script>
$( document ).ready(function() {
loadComboItinerary(table_id);
loadComboItineraryContingency(table_id);
$(document).on('click', '#clickToAddItinerary', function(ev) {
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItinerary',
		data: {
			'table_id': table_id,
			'tp': 'F'
		},
		dataType: "html",
		success: function(html) {
			makepopupnotresize('90%', 'auto', html, 'SiteFrmComboItinerary');
			$('#SiteFrmComboItinerary').css('top', '20px');
			var $editorID = $('.textarea_itinerary_content_editor').attr('id');
			$('#' + $editorID).isoTextAreaFull();
			vietiso_loading(0);
		}
	});
	return false;
});
$(document).on('click', '#clickToAddItinerary_contingency', function(ev) {
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItineraryContingency',
		data: {
			'table_id': table_id,
			'tp': 'F'
		},
		dataType: "html",
		success: function(html) {
			makepopupnotresize('90%', 'auto', html, 'SiteFrmComboItinerary');
			$('#SiteFrmComboItinerary').css('top', '20px');
			var $editorID = $('.textarea_itinerary_content_editor').attr('id');
			$('#' + $editorID).isoTextAreaFix();
			vietiso_loading(0);
		}
	});
	return false;
});
$(document).on('click', '.clickEditItinerary', function(ev) {
	var $_this = $(this);
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItinerary',
		data: {
			'tour_itinerary_id': $_this.attr('data'),
			'table_id': table_id,
			'tp': 'F'
		},
		dataType: "html",
		success: function(html) {
			makepopupnotresize('90%', 'auto', html, 'SiteFrmComboItinerary');
			$('#SiteFrmComboItinerary').css('top', '20px');
			var $editorID = $('.textarea_itinerary_content_editor').attr('id');
			$('#' + $editorID).isoTextAreaFull();
			if ($SiteHasHotel_Tours == 1) {
				loadListHotelItinerary(table_id, $_this.attr('data'), '');
			}
			vietiso_loading(0);
		}
	});
	return false;
});
$(document).on('click', '.clickEditItineraryContingency', function(ev) {
	var $_this = $(this);
	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItineraryContingency',
		data: {
			'tour_itinerary_id': $_this.attr('data'),
			'table_id': table_id,
			'tp': 'F'
		},
		dataType: "html",
		success: function(html) {
			makepopupnotresize('90%', 'auto', html, 'SiteFrmComboItinerary');
			$('#SiteFrmComboItinerary').css('top', '20px');
			var $editorID = $('.textarea_itinerary_content_editor').attr('id');
			$('#' + $editorID).isoTextAreaFix();
			if ($SiteHasHotel_Tours == 1) {
				loadListHotelItinerary(table_id, $_this.attr('data'), '');
			}
			vietiso_loading(0);
		}
	});
	return false;
});
$(document).on('click', '.btnSaveComboItinerary', function(ev) {
	var $_this = $(this);
	var $_form = $_this.closest('.frmPop');
	var $day = $_form.find('input[name=day]');
	var $day2 = $_form.find('input[name=day2]');

	var $meals = getCheckBoxValueByClass('chk_Meal');
	var $transport = getCheckBoxValueByClass('chk_Transport');
	var $editorID = $('.textarea_itinerary_content_editor').attr('id');
	var $content = tinyMCE.get($editorID).getContent();
	var $image = $_form.find('input[name=isoman_url_image]');
	var $tour_itinerary_id = $_this.attr('tour_itinerary_id');
	var $is_show_image = $('input[name=is_show_image]:checked').val();

	if ($day.val() == '') {
		$day.focus().addClass('error');
		alertify.error(field_is_required);
		return false;
	}
	/**/
	var adata = {};
	adata['day'] = $.trim($day.val());
	adata['day2'] = $.trim($day2.val());
	adata['meals'] = $meals;
	adata['transport'] = $transport;
	adata['content'] = $content;
	adata['image'] = $image.val();
	adata['tour_itinerary_id'] = $tour_itinerary_id;
	adata['is_show_image'] = $is_show_image;
	adata['table_id'] = table_id;
	adata['tp'] = 'S';

	vietiso_loading(1);
	$('#frmItinerary').ajaxSubmit({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItinerary',
		data: adata,
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_INSERT_SUCCESS') >= 0) {
				loadComboItinerary(table_id);
				loadComboItineraryContingency(table_id);
				$_this.closest('.frmPop').find('.close_pop').trigger('click');
				window.location.reload(true);
			}
			if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
				loadComboItinerary(table_id);
				loadComboItineraryContingency(table_id);
				$_this.closest('.frmPop').find('.close_pop').trigger('click');
				window.location.reload(true);
			}
			if (html.indexOf('_ERROR') >= 0) {
				alertify.error(insert_error);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
			if (html.indexOf('day_invalid') >= 0) {
				$day.focus();
				alertify.error('Error !');
			}
			
		}
	});
	return false;
});
$(document).on('click', '.btnSaveComboItineraryContingency', function(ev) {
	var $_this = $(this);
	var $_form = $_this.closest('.frmPop');
	var $title_contingency = $_form.find('input[name=title_contingency]');

	var $meals = getCheckBoxValueByClass('chk_Meal');
	var $transport = getCheckBoxValueByClass('chk_Transport');
	var $editorID = $('.textarea_itinerary_content_editor').attr('id');
	var $content = tinyMCE.get($editorID).getContent();
	var $image = $_form.find('input[name=isoman_url_image]');
	var $tour_itinerary_id = $_this.attr('tour_itinerary_id');
	var $is_show_image = $('input[name=is_show_image]:checked').val();

	/**/
	var adata = {};

	adata['title_contingency'] = $title_contingency.val();
	adata['meals'] = $meals;
	adata['transport'] = $transport;
	adata['content'] = $content;
	adata['image'] = $image.val();
	adata['tour_itinerary_id'] = $tour_itinerary_id;
	adata['is_show_image'] = $is_show_image;
	adata['table_id'] = table_id;
	adata['tp'] = 'S';

	vietiso_loading(1);
	$('#frmItinerary').ajaxSubmit({
		type: "POST",
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItineraryContingency',
		data: adata,
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_INSERT_SUCCESS') >= 0) {
				loadComboItinerary(table_id);
				loadComboItineraryContingency(table_id);
				$_this.closest('.frmPop').find('.close_pop').trigger('click');
			}
			if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
				loadComboItinerary(table_id);
				loadComboItineraryContingency(table_id);
				$_this.closest('.frmPop').find('.close_pop').trigger('click');
			}
			if (html.indexOf('_ERROR') >= 0) {
				alertify.error(insert_error);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
			if (html.indexOf('day_invalid') >= 0) {
				$day.focus();
				alertify.error('Error !');
			}
		}
	});
	return false;
});
$(document).on('click', '.moveComboItinerary', function(ev) {
	var _this = $(this);
	/**/
	var adata = {};
	adata['tour_itinerary_id'] = _this.attr('data');
	adata['table_id'] = table_id;
	adata['direct'] = _this.attr('direct');
	adata['tp'] = 'M';

	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItinerary',
		data: adata,
		dataType: 'html',
		success: function(html) {
			loadComboItinerary(table_id);
			loadComboItineraryContingency(table_id);
			vietiso_loading(0);
		}
	});
});
$(document).on('click', '.clickDeleteItinerary', function(ev) {
	var _this = $(this);
	if (confirm(confirm_delete)) {
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItinerary',
			data: adata = {
				'table_id': table_id,
				'tour_itinerary_id': _this.attr('data'),
				'tp': 'D'
			},
			dataType: 'html',
			success: function(html) {
				loadComboItinerary(table_id);
				loadComboItineraryContingency(table_id);
				alertify.success(delete_success);
				vietiso_loading(0);
				window.location.reload(true);
			}
		});
	}
	return false;
});
$(document).on('click', '.clickDeleteItineraryContingency', function(ev) {
	var _this = $(this);
	if (confirm(confirm_delete)) {
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=SiteFrmComboItineraryContingency',
			data: adata = {
				'table_id': table_id,
				'tour_itinerary_id': _this.attr('data'),
				'tp': 'D'
			},
			dataType: 'html',
			success: function(html) {
				loadComboItinerary(table_id);
				loadComboItineraryContingency(table_id);
				alertify.success(delete_success);
				vietiso_loading(0);
			}
		});
	}
	return false;
});
});
</script>
{/literal}
