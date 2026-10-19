<main id="main" class="page_container">
 	<div class="BoxDepartureSchedule bg_fff">
		<div class="container">
			<h2 class="title_box text-center text-upper mb10">{$core->get_Lang('Lich Khởi hành')}</h2>
		   <ul class="nav nav-tabs" role="tablist">
			{section name=i loop=$lstTourGroup}
			<li class="list-group-tour title-group-tour {if $smarty.section.i.first}active{/if}"  data-id="{$lstTourGroup[i].tour_group_id}"><a href="javascript:void(0);">{$clsTourGroup->getTitle($lstTourGroup[i].tour_group_id)}</a></li>
			{/section}
		  </ul>
		  <div class="boxSearchTourStartDate">
		  		
		  </div>
		  <!-- Tab panes -->
		  <div class="tab-content">
			<table class="table table-striped">
				<thead>
				  <tr>
					<th>{$core->get_Lang('Tour name')}</th>
					<th style="width: 150px">{$core->get_Lang('Journeys')}</th>
					<th style="width: 150px">{$core->get_Lang('Departure day')}</th>
					<th style="width: 108px">{$core->get_Lang('Blank')}</th>
					<th style="width: 285px">{$core->get_Lang('Tour Price')}</th>
				  </tr>
				</thead>
				<tbody id="tab-content">
					{section name=i loop=$lstTourStartDate}
					{assign var=tour_start_date_id value=$lstTourStartDate[i].tour_start_date_id}
					{assign var=tour_id value=$lstTourStartDate[i].tour_id}
					{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
					{assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent)}
					{assign var=getPriceTourPromotionnomem value=$clsTour->getTripPriceNewPro2020($tour_id,$now_day,$is_agent,'nomem')}
				  <tr>
					<td>{$clsTour->getTitle($tour_id)}</td>
					<td>{$clsTour->getTripDuration2020($tour_id)}</td>
					<td>{$clsTourStartDate->getStartDateTour($tour_start_date_id)}</td>
					<td class="available">{$clsTourStartDate->getSeatAvailable($tour_start_date_id)} {$core->get_Lang('chỗ')}</td>
					<td class="price">
						<div class="p_price">
						{if $checkmem eq 1}
						{if $profile_id eq ''}{$getPriceTourPromotionnomem}{else}{$getPriceTourPromotion}{/if}
						{elseif $getPriceTourPromotion}
							{$getPriceTourPromotion}
						{else}
							<p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
						{/if}
						</div>
						<a class="detail_tour" href="{$clsTour->getLink($tour_id)}" title="{$core->get_Lang('Detail')}">
							{$core->get_Lang('Detail')}
						</a>
					</td>
				  </tr>
				  {/section}
				</tbody>
			</table>
		  </div>
		</div>
	</div>
</main>
{literal}
<style>
.BoxDepartureSchedule{padding: 60px 0}
.BoxDepartureSchedule .table{border-collapse: collapse; }
.BoxDepartureSchedule .nav-tabs{margin-bottom: 2px;border-bottom: 0}
.BoxDepartureSchedule .nav-tabs li.view_all{float: right}
.BoxDepartureSchedule .nav-tabs li.view_all a{font-size: 16px !important;background: none;border: 0;outline: none}
.text-upper{text-transform: uppercase}
.BoxDepartureSchedule .title_box{font-size: 28px;font-weight: 700}
.BoxDepartureSchedule .nav>li>a{font-size: 18px;color: #1c1c1c;background: none;border: 0}
.BoxDepartureSchedule .nav-tabs>li.active>a{padding: 10px 20px;font-size: 18px;background: var(--main-color);border: 0}
.BoxDepartureSchedule .table>thead>tr>th{
padding: 13px 20px;font-weight: 400;
background: var(--main-color) !important;border-bottom: 0;    border-right: 1px solid #c7c7c7;
}
.BoxDepartureSchedule .table>tbody>tr>td{border-top: 0;border-right: 1px solid #c7c7c7;    padding: 12px 20px;    vertical-align: inherit;
}
.BoxDepartureSchedule .table>tbody>tr>td:first-child{font-size: 17px;position: relative}
.BoxDepartureSchedule .table>tbody>tr>td:first-child:before{content: "";position: absolute;background: url('/isocms/templates/default/skin/images/icon/HOT_icon_tour.png') no-repeat;right: 15px;top: 15px;width: 48px;height: 23px}
.BoxDepartureSchedule .table>tbody>tr>td:nth-child(4){color: #1fb69a;}
.BoxDepartureSchedule .table>tbody>tr>td.price .p_price{
float: left;
line-height: 30px;
width: calc(100% - 91px);
}
.table tbody tr .price .detail_tour{
display: inline-block;
padding: 5px 21px;
float: right;
text-align: right;
background: var(--main-color);color: #1c1c1c;height: 30px
}
</style>
<script >
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			$(document).on('click', ".list-group-tour", function(ev) {
				$('#tab-content').html('');
				var $tour_group_id = $(this).data('id');
				$('.list-group-tour.active').removeClass('active');
				$(this).addClass('active');
				var $_this = $(this);
				$_this.find('.ajax-loader').show();
				$.ajax({  
					type:'POST',
					url:path_ajax_script+'/index.php?mod=home&act=ajload_list_tour_start_date&lang='+LANG_ID, 
					data:{
						"tour_group_id":$tour_group_id,
					},
					dataType:'html',
					success:function(html){
						var $htm = html.split('$$$');
						$_this.find('.ajax-loader').hide();
						$('#tab-content').append($htm[0]);
					}
				});	
			});
		});
	})
</script> 
{/literal}