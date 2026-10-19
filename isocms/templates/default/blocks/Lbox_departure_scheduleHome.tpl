{if $lstTourStartDate}
<div class="BoxDepartureSchedule bg_fff">
    <div class="container">
        <h2 class="title_box text-center text-upper mb10">{$core->get_Lang('Lich Khởi hành')}</h2>
        <ul class="nav nav-tabs" role="tablist">
            {section name=i loop=$lstTourGroup}
            <li class="list-group-tour title-group-tour {if $smarty.section.i.first}active{/if}" data-id="{$lstTourGroup[i].tour_group_id}" data-link="{$clsTourGroup->getLinkByGroup($lstTourGroup[i].tour_group_id)}" id="item_tour_group{$smarty.section.i.iteration}"><a href="javascript:void(0);">{$clsTourGroup->getTitle($lstTourGroup[i].tour_group_id)}</a></li>
            {/section}
            <li class="view_all"><a href="{$clsTourGroup->getLinkByGroup($tour_group_first_id)}" title="{$core->get_Lang('View All')}">{$core->get_Lang('View All')} <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content table-responsive">
            <table class="table table-striped table-bordered scroll">
                <thead>
                    <tr>
                        <th class="bg_main" style="width: 568px">{$core->get_Lang('Tour name')}</th>
                        <th class="bg_main" style="width: 140px">{$core->get_Lang('Journeys')}</th>
                        <th class="bg_main" style="width: 150px">{$core->get_Lang('Departure day')}</th>
                        <th class="bg_main" style="width: 100px">{$core->get_Lang('Blank')}</th>
                        <th class="bg_main" style="width: 325px">{$core->get_Lang('Tour Price')}</th>
                    </tr>
                </thead>
                <tbody id="tab-content">
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
                    <tr>
						<td style="width: 568px"><h3 class="title_tour limit_1line mb0">{$clsTour->getTitle($tour_id)}</<h3></td>
						<td style="width: 140px">{$clsTour->getTripDuration2020($tour_id)}</td>
						<td style="width: 150px">{$clsTourStartDate->getStartDateTour($tour_start_date_id)}</td>
						{if $checkTourLast ne '' && @count|$countAvailable ne '0'}
						<td style="width: 100px" class="available">{$clsTourStartDate->getSeatAvailable($tour_start_date_id)} {$core->get_Lang('chỗ')}</td>
						{else}
						<td style="width: 100px" class="available">{$core->get_Lang('Còn chỗ')}</td>
						{/if}
						<td style="width: 320px" class="price"><div class="p_price"> {if $promotion ne ''}
							<p class="size18 color_fb1111 text-bold mb0"> <del class="size16 color_1c1c1c fw_400">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</del> <span>{$clsTourStartDate->getTripPriceOnePromotionStartDate($tour_start_date_id,$tour_id,$start_date)} {$clsISO->getShortRate()}</span></p>
							{elseif no_promotion ne '0'}
							<p class="size18 color_fb1111 text-bold mb0">{$clsISO->formatPrice($clsTourStartDate->getTripPriceTourStartDateValue($tour_id,$start_date))} {$clsISO->getShortRate()}</p>
							{else}
							<p class="size18 color_fb1111 text-bold mb0">{$core->get_Lang('Contact')}</p>
							{/if} </div>
						<a class="detail_tour btn_main" href="{$clsTourStartDate->getLink($tour_start_date_id,$tour_id)}" title="{$core->get_Lang('Detail')}"> {$core->get_Lang('Detail')} </a></td>
					</tr>
                   	{/if}
                    {/section}
                </tbody>
                
            </table>
        </div>
    </div>
</div>
<script>
var view_all = "{$core->get_Lang('View All')}";
</script> 
{literal}
<style>
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #acacac; 
}
table.scroll {
    border-spacing: 0;
}

table.scroll tbody,
table.scroll thead tr { display: block; }

table.scroll tbody {
    max-height: 415px;
    overflow-y: scroll;
    overflow-x: hidden;
}

table.scroll tbody td,
table.scroll thead th {

    border-right: 1px solid black;
}

table.scroll thead th:last-child {

}

thead tr th { 
    height: 30px;
    line-height: 30px;
}

tbody td:last-child, thead th:last-child {
    border-right: none !important;
}
.fw_400{font-weight: 400}
.bg_f9f9f9{background: #f9f9f9 !important}
.mb35{margin-bottom: 35px !important}
#tab-content {
border-bottom: 2px solid var(--main-bg-color);
}
#tab-content h3.title_tour{font-size: 17px;}
.BoxDepartureSchedule{padding: 60px 0}
.BoxDepartureSchedule .table{border-collapse: collapse; height: 100px;overflow: auto}
.BoxDepartureSchedule .nav-tabs{margin-bottom: 2px;border-bottom: 0}
.BoxDepartureSchedule .nav-tabs li.view_all{float: right}
.BoxDepartureSchedule .nav-tabs li.view_all a{font-size: 16px !important;background: none;border: 0;outline: none}
.text-upper{text-transform: uppercase}
.BoxDepartureSchedule .title_box{font-size: 28px;font-weight: 700}
.BoxDepartureSchedule .nav>li>a{font-size: 18px;color: #1c1c1c;background: none;border: 0}
.BoxDepartureSchedule .nav-tabs>li.active>a{padding: 10px 20px;font-size: 18px;background: var(--main-color);border: 0}
.BoxDepartureSchedule .table>thead>tr>th{
padding: 13px 15px;font-weight: 400;border-bottom: 0;    border-right: 1px solid #c7c7c7;
}
.BoxDepartureSchedule .table>tbody>tr>td{border-top: 0;border-right: 1px solid #c7c7c7;    padding: 12px 12px;    vertical-align: inherit;border-bottom: 0;border-left: 0
}
.BoxDepartureSchedule .table>tbody>tr>td:first-child{font-size: 17px;position: relative;padding-right: 70px}
.BoxDepartureSchedule .table>tbody>tr>td:last-child{border-right: 0}
.BoxDepartureSchedule .table>thead>tr>th:last-child{border-right: 0}
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
text-align: right;color: #1c1c1c;height: 30px;border-radius: 3px
}
@media (max-width: 1200px){
.BoxDepartureSchedule .nav>li>a{font-size: 17px}
.BoxDepartureSchedule .nav>li>a{padding: 20px 15px}
.BoxDepartureSchedule .nav-tabs>li.active>a{font-size: 17px;padding: 20px 15px;}
.boxSearchTourStartDate .form_select{    width: 175px;}
.boxSearchTourStartDate .form_select.search_title{display: none}
}
</style>
<script >
	$(function(){
		$(document).on('click', ".list-group-tour", function(ev) {
			$('#tab-content').html('');
			var $tour_group_id = $(this).data('id'),
				link = $(this).data('link');
				$('.view_all').html('<a href="'+link+'" title="'+view_all+'">'+view_all+' <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>');
			
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
	$(document).ready(function () {
//$('#dtDynamicVerticalScrollExample').DataTable({
//"scrollY": "10vh",
//"scrollCollapse": true,
//});
$('.dataTables_length').addClass('bs-select');
});
</script> 
{/literal}
{/if}