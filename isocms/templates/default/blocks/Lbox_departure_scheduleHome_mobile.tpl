{if $lstTourStartDate}
<div class="BoxDepartureSchedule bg_fff">
  	<div class="container">
  		<h2 class="title_box text-center text-upper mb10">{$core->get_Lang('Lich Khởi hành')}</h2>
	   <ul class="nav nav-tabs" role="tablist">
	    {section name=i loop=$lstTourGroup}
		<li class="list-group-tour title-group-tour {if $smarty.section.i.first}active{/if}" data-id="{$lstTourGroup[i].tour_group_id}" data-link="{$clsTourGroup->getLinkByGroup($lstTourGroup[i].tour_group_id)}" id="item_tour_group{$smarty.section.i.iteration}"><a href="javascript:void(0);">{$clsTourGroup->getTitle($lstTourGroup[i].tour_group_id)}</a></li>
		{/section}
		<li class="view_all bg_main"><span>{$core->get_Lang('Tên tour')}</span> <a href="{$clsTourGroup->getLinkByGroup($tour_group_first_id)}" title="{$core->get_Lang('View All')}">{$core->get_Lang('View All')} <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
	  </ul>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div id="tab-content">
			<div class="accordion" id="accordionStartDate">
				{section name=i loop=$lstTourStartDate}
				{assign var=tour_start_date_id value=$lstTourStartDate[i].tour_start_date_id}
				{assign var=tour_id value=$lstTourStartDate[i].tour_id}
				{assign var=start_date value=$clsTourStartDate->getStartDate($tour_start_date_id)}
				{assign var=checkmem value=$clsTour->getCheckMemSet($tour_id)}
				{assign var=checkTourLast value=$clsTour->checkTourLastHour2($tour_id,$now_day)}
				{assign var=countAvailable value=$clsTourStartDate->getSeatAvailable($tour_start_date_id)}
				{assign var=promotion value=$clsTourStartDate->getTripPriceOnePromotionStartDate($tour_start_date_id,$tour_id,$start_date)}
				{assign var=no_promotion value=$clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date)}
				{if @count|$countAvailable ne '0'}
				<div class="card">
					<div class="card-header" id="start_date_{$smarty.section.i.iteration}">
						<h3 class="title"> <a class="collapsed" data-toggle="collapse" data-target="#collapsestart_date_{$smarty.section.i.iteration}" aria-expanded="false" aria-controls="collapsestart_date_{$smarty.section.i.iteration}"> {$clsTour->getTitle($tour_id)} </a> </h3>
					</div>
					<div id="collapsestart_date_{$smarty.section.i.iteration}" class="collapse" aria-labelledby="start_date_{$smarty.section.i.iteration}" data-parent="#accordionStartDate">
						<div class="card-body">
							<p class="journeys"><span class="left">{$core->get_Lang('Journeys')}</span> <span class="right">{$clsTour->getTripDuration2020($tour_id)}</span></p>
							<p class="day"><span class="left">{$core->get_Lang('Departure day')}</span> <span class="right">{$clsTourStartDate->getStartDateTour($tour_start_date_id)}</span></p>
							{if $checkTourLast ne '' && @count|$countAvailable ne '0'}
							<p class="blank"><span class="left">{$core->get_Lang('Blank')}</span> <span class="right">{$clsTourStartDate->getSeatAvailable($tour_start_date_id)} {$core->get_Lang('chỗ')}</span></p>
							{else}
							  <p class="blank"><span class="left">{$core->get_Lang('Blank')}</span> <span class="right">{$core->get_Lang('Còn chỗ')}</span></p>
							{/if}
							<div class="tour_price"><span class="left">{$core->get_Lang('Tour Price')}</span>
								<div class="right"> {if $promotion ne ''}
									<p class="size18 color_fb1111 text-bold mb0"> <del class="size16 color_1c1c1c fw_400">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</del> <span>{$clsTourStartDate->getTripPriceOnePromotionStartDate($tour_start_date_id,$tour_id,$start_date)} {$clsISO->getShortRate()}</span></p>
									{elseif no_promotion ne '0'}
									<p class="size18 color_fb1111 text-bold mb0">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</p>
									{else}
									<p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
									{/if} </div>
							</div>
							<p class="view_tour"> <a class="detail_tour btn_main" href="{$clsTourStartDate->getLink($tour_start_date_id,$tour_id)}" title="{$core->get_Lang('Detail')}"> {$core->get_Lang('Detail')} </a> </p>
						</div>
					</div>
				</div>
				{/if}
				{/section}
			</div>
		  </div>
	  </div>
  	</div>
</div>
<script>
var view_all = "{$core->get_Lang('View All')}";
var title_tour = "{$core->get_Lang('Tên tour')}";
</script>
{literal}
<style>
@media (max-width: 1024px){
.BoxDepartureSchedule {padding: 50px 0}
.BoxDepartureSchedule .nav>li>a{padding: 10px 20px}
.formSearchDeparture{display: inline-block;width: 100%}
.BoxDepartureSchedule .nav-tabs{max-width: 100%}
.boxSearchTourStartDate{width: 100%	}
.boxSearchTourStartDate .form_select.search_title{display: none}
.boxSearchTourStartDate .form_select{
width: calc(50% - 10px);
margin-left: 10px;
margin-right: 10px;
}
.boxSearchTourStartDate .form_select:nth-child(2), .boxSearchTourStartDate .form_select:nth-child(4){margin-left: 0}
.boxSearchTourStartDate .form_select:nth-child(3), .boxSearchTourStartDate .form_select:nth-child(5){margin-right: 0}
.BoxDepartureSchedule .nav>li>a {
font-size: 17px;
color: #1c1c1c;
background: none;
border: 0;
}
.BoxDepartureSchedule .nav-tabs>li.active>a {
padding: 10px 20px;
font-size: 17px;
background: var(--main-color);
border: 0;
}
.BoxDepartureSchedule ul li.view_all{
width: 100%;
padding: 13px 10px;
margin-top: 2px;
}
.BoxDepartureSchedule ul li.view_all span{float: left}
.BoxDepartureSchedule ul li.view_all a{float: right;padding: 0;font-size: 16px;}
#accordionStartDate .card:nth-child(odd){
background: #f1f1f1;
}
#accordionStartDate .card:nth-child(even){
background: #fff;
}
#accordionStartDate .card .card-header{padding: 12px 10px}
#accordionStartDate .card h3{font-size: 17px;line-height: 20px;position: relative;padding-right: 55px;cursor: pointer}
#accordionStartDate .card h3:before{
content: "";position: absolute;background: url('/isocms/templates/default/skin/images/icon/HOT_icon_tour.png') no-repeat;right: 0;top: calc(50% - 12px);width: 48px;height: 23px
}
#accordionStartDate .card .card-body .tour_price{display: inline-block;width: 100%;margin-bottom: 5px}
#accordionStartDate .card .card-body .tour_price .right{float: right}
#accordionStartDate .card h3 a{color: #1c1c1c;display: inline-block;width: 100%;cursor: pointer}
#accordionStartDate .card .card-body {padding: 0px 10px 15px;}
#accordionStartDate .card .card-body p{font-size: 17px;margin-bottom: 5px}
#accordionStartDate .card .card-body p.blank{color: #1fb69a}
#accordionStartDate .card .card-body p span.right{font-size: 16px;float: right}
#accordionStartDate .card .card-body p.view_tour{text-align: right}
#accordionStartDate .card .card-body p.view_tour a{
display: inline-block;
background: var(--main-bg-color);
padding: 4px 21px;
font-size: 16px;
color: #1c1c1c;
border-radius: 2px;
}
}
@media (max-width:600px){
.boxSearchTourStartDate .form_select{
width: 100% !important;
margin: 0 !important;
}
}
</style>
<script >
	$(function(){
		$(document).on('click', ".list-group-tour", function(ev) {
			$('#tab-content').html('');
			var $tour_group_id = $(this).data('id'),
				link = $(this).data('link');
				$('.view_all').html('<span>'+title_tour+'</span> <a href="'+link+'" title="'+view_all+'">'+view_all+' <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>');
			
			$('.list-group-tour.active').removeClass('active');
			$(this).addClass('active');
			var $_this = $(this);
			$_this.find('.ajax-loader').show();
			$.ajax({  
				type:'POST',
				url:path_ajax_script+'/index.php?mod=home&act=ajload_list_tour_start_date_mobile&lang='+LANG_ID, 
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
</script> 
{/literal}
{/if}