{if $type=='DAY'}
<div class="text-center begin_date_text">
	<span class="prev_week span_control" data-date="{$begin_date_prev}" data-type="DAY"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
	<span class="span_text">{$begin_date_text}</span>
	<span class="next_week span_control" data-date="{$begin_date_next}" data-type="DAY"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
</div>
<table cellspacing="0" id="table_start_date" class="tbl-grid table_responsive" width="100%">
	<thead>
		<tr>
			<th class="gridheader hiden767" style="width:70px"><strong>ID</strong></th>
			<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('nameoftrips')}</strong></th>
			<th class="gridheader hiden_responsive" style="text-align:center; width: 150px;"><strong>{$core->get_Lang('Đã xác nhận')}</strong></th>

			<th class="gridheader hiden_responsive" style="text-align:center; width:150px"><strong>{$core->get_Lang('Đợi xác nhận')}</strong></th>
			<th class="gridheader hiden_responsive" style="text-align:center; width: 160px"><strong>{$core->get_Lang('Còn lại/Số chỗ')}</strong></th>
			<th class="gridheader hiden_responsive" style="text-align:right; width: 150px;"><strong>{$core->get_Lang('Giá từ')}</strong></th>
			<th class="gridheader hiden_responsive" style="text-align:center; width: 160px;"></th>

			<th class="gridheader hiden_responsive" style="text-align:center; width:40px"></th>
		</tr>
	</thead>
	<tbody id="SortAble">
		{section name=i loop=5}
		<tr class="{cycle values="row1,row2"}">
			<td class="index hiden767" data-title="ID"><span>#12345</span></td>
			<td class="text-left name_service">
				Du lịch thắng cảnh tại nhà trong mùa dịch Covid
			</td>
			<td class="block_responsive comfirm text-center" data-title="{$core->get_Lang('Đã xác nhận')}">
				<span class="title">2</span>
			</td>
			<td class="block_responsive uncomfirm text-center" data-title="{$core->get_Lang('Đợi xác nhận')}">
				<span class="title">2</span>
			</td>
			<td class="block_responsive seat text-center" data-title="{$core->get_Lang('Còn lại/Số chỗ')}">
				10/14
			</td>
			<td class="block_responsive price text-right" data-title="{$core->get_Lang('Giá từ')}">
				195 000 <u>đ</u>
			</td>
			<td class="block_responsive btn_booking text-center">
				<div class="btn_create_booking btn-main"><a href="" title="Tạo booking">Tạo booking</a></div>
			</td>
			

			<td class="block_responsive" align="center" style="vertical-align: middle; text-align:center;white-space: nowrap;" data-title="{$core->get_Lang('func')}">

				<div class="btn-group">
					<button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
					<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
					</button>
					<ul class="dropdown-menu">
						<li><a title="{$core->get_Lang('edit')}" href=""><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
						<li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href=""><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
					</ul>
				</div>
			</td>
		</tr>
		{/section}
	</tbody>
</table>
{else}
<div class="text-center begin_date_text">
	<span class="prev_week span_control" data-date="{$begin_date_prev}" data-type="MONTH"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
	<span class="span_text">{$list_date[0].Day_Month} - {$list_date[6].Full_Date_2}</span>
	<span class="next_week span_control" data-date="{$begin_date_next}" data-type="MONTH"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
</div>
<table id="table_start_date">
	<thead>
		<tr>
			{foreach from=$list_date item=item name=item}
			<th class="text-center">
				<span class="day_text">{$item.Day_Text}, {$item.Day_Month}</span>
			</th>
			{/foreach}
		</tr>
	</thead>
	<tbody>
		<tr>
			{foreach from=$list_date item=item name=item}
			<td class="{$item.Day_Class}">
				<div class="tour_item">
					<a href="" title="Hà Nội - Mộc Châu - Lên Núi">
					Hà Nội - Mộc Châu - Lên Núi
					</a>
					<p>2/10</p>
				</div>
			</td>
			{/foreach}
		</tr>
	</tbody>
</table>
{/if}
{literal}
<script>
$(function(){
$('.span_control').click(function() {
	var begin_date = $(this).data('date');
	var type = $(this).data('type');
	loadListStartDate(begin_date,type);
})
});
</script>
{/literal}