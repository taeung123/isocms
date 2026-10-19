<div class=" filterbox" style="width:100%">
	<div class="wrap">
		<div class="searchbox">
			<select name="user_ctv_id" onchange="_reload()" class="slb mr5 fl" style="padding:5px;">
					<option value="0">{$core->get_Lang('Lựa chọn Cộng tác viên')}</option>
				   {section name=i loop=$listCTV}
				   <option {if $user_ctv_id eq $listCTV[i].user_id} selected="selected"{/if} value="{$listCTV[i].user_id}">{$listCTV[i].user_name}</option>
				   {/section}
				</select>
				<select {$is_approve_id} name="is_approve_id" onchange="_reload()" class="slb mr5 fl" style="padding:5px;">
					<option  selected="selected" value="0">{$core->get_Lang('Lựa chọn')}</option>
					
					<option {if $is_approve_id eq 1} selected="selected"{/if} value="1">{$core->get_Lang('Bài viết đã duyệt')}</option>
					<option {if $is_approve_id eq 2} selected="selected"{/if} value="2">{$core->get_Lang('Bài viết chưa duyệt')}</option>
				</select>
				<input name="from_date" autocomplete="off" maxlength="10" id="from_date" value="{$clsISO->formatTimeDate($from_date)}" size="15" class="text_32 border_aaa" placeholder="{$core->get_Lang('From Date')}">
				
				<input name="to_date" autocomplete="off" maxlength="10" id="to_date" value="{$clsISO->formatTimeDate($to_date)}" size="15" class="text_32 border_aaa" placeholder="{$core->get_Lang('To Date')}">
			<a class="btn btn-success" href="javascript:void();" id="searchbtn" style="padding:5px">
				<i class="icon-search icon-white"></i>
			</a>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
$('#from_date').datepicker({
	dateFormat: "mm/dd/yy", 
	maxDate: "+1Y",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true,
	onSelect: function(dateStr) { 
		var date = $(this).datepicker('getDate'); 
		if(date){ 
			date.setDate(date.getDate() + 30); 
		} 
		$('#to_date').datepicker('option').datepicker('setDate', date); 
	},
	onClose: function(dateText, inst) {
		$('#to_date').focus();
	}
});
$("#to_date").datepicker( { 
	dateFormat: "mm/dd/yy", 
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	showOtherMonths: true
});	
});
</script>
{/literal}