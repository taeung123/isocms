<div class="headPop"> 
	<a href="javascript:void(0);" class="closeEv close_pop"></a> 
	<h3>{$core->get_Lang('Thêm khách sạn')}</h3>
</div>
<div class="bodyPop">
	<form method="post" action="" class="form_add_hotel_combo" id="form_add_hotel_combo">
		<input type="hidden" value="{$table_id}" name="combo_id"/>
		<input type="hidden" value="{$tp}" name="tp"/>
		<div class="wrap">
			<div class="inpt_tour">
				<label for="title">{$core->get_Lang('Code or hotel name')} <span class="required_red">*</span></label>
				<div class="searchbox searchbox_new">
					<input {if $tp!='EDIT'}id="searchkey_hotel"{else}readonly{/if}  value="{$clsHotel->getTitle($hotel_id)}" placeholder="{$core->get_Lang('VD: Khách sạn ABC')}..." type="text" class="text" autocomplete="off" />
					<input type="hidden" name="hotel_id" id="hotel_id" value="{$hotel_id}"/>

					<div class="autosugget" id="autosugget">
						<ul class="HTML_sugget"></ul>
						<div class="clearfix"></div>
						<a class="close_Div">{$core->get_Lang('close')}</a>
					</div>
				</div>
			</div>
			<div class="inpt_tour">
				<label for="title">{$core->get_Lang('Ngày áp dụng')} <span class="required_red">*</span></label>
				{assign var=number_day value=$clsCombo->getOneField('number_day',$table_id)}

				<div class="list_check">
					<div class="item">
						<label><input id="check_all_day" {if $total_day_check==$number_day} checked{/if} type="checkbox" class="eld-checkbox">
						{$core->get_Lang('All')}</label>
					</div>
					
					{section name=day start=1 loop=$number_day+1 step=1}
					<div class="item">
					<label>
						<input type="checkbox" value="{$smarty.section.day.index}" {if in_array($smarty.section.day.index, $list_day_check)} checked{/if} class="chkitemday" name="listDay[]"> {$core->get_Lang('Days')} {$smarty.section.day.index}
					</label>
					</div>
					{/section}
				</div>
			</div>
			
			
		</div>
		<div class="btn_group">
			<a class="btn btn-cancel" id="cancel_hotel_combo">
				 <span>{$core->get_Lang('Hủy')}</span>
			</a>
			<a class="btn btn-add_new" data-tp="{$tp}" id="add_hotel_combo">
				 <span>{$core->get_Lang('Save')}</span>
			</a>
		</div>
	</form>
</div>

<script type="text/javascript">
var required_country = "{$core->get_Lang('You not selected country')}";
var required_city = "{$core->get_Lang('You not selected city')}";
var table_id = "{$table_id}";
</script>
{literal}
<script type="text/javascript">
var aj_search = '';
$("#searchkey_hotel").bind('keyup change', function() {
	var $_this = $(this);
	clearTimeout(aj_search);
	search_hotel_combo();
});
$(document).on('click', '.clickChooseHotel', function(ev) {
	var $_this = $(this);
	var title=$_this.data('title');
	var table_id=$_this.data('hotel_id');
	$('#searchkey_hotel').val(title);
	$('#hotel_id').val(table_id);
	search_hotel_combo('Hidden');
	return false;

});
$(document).on('click', '.clkDeleteTourStore', function(ev){
	if(confirm(confirm_delete)){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajDeleteTourStore',
			data: {'hotel_id': $_this.attr('_hotel_id')},
			dataType: "html",
			success: function(html){
				window.location.reload(true);
			}
		});
	}
});



$('#check_all_day').live('change',function(){
	var _this=$(this);
	var checked=_this.attr('checked');
	if(checked=='checked' || checked){
		$('input[class=chkitemday]').attr('checked',true);
	}else{
		$('input[class=chkitemday]').removeAttr('checked');
	}
});
function search_hotel_combo(check) {
	aj_search = setTimeout(function() {
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajGetHotelCombo',
			data: {
				"keyword": $("#searchkey_hotel").val(),
				"table_id": table_id,
				"check": check,
			},
			dataType: 'html',
			success: function(html) {
				if (html.indexOf('_EMPTY') >= 0) {
					$('#autosugget').hide();
				} else {
					$('#autosugget').stop(false, true).slideDown();
					$('#autosugget').find('.HTML_sugget').html(html);
				}
			}
		});
	}, 500);
}
</script>
{/literal}