<main id="main" class="page_container">
    <nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_f9f9f9">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 pd10_0" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"> <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$PCMS_URL}"> <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"> <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="javascript:void(0);" title="{$core->get_Lang('Lich Khởi hành')}"> <span itemprop="name" class="reb">{$core->get_Lang('Lich Khởi hành')}</span> </a>
                    <meta itemprop="position" content="4" />
                </li>
            </ol>
        </div>
    </nav>
    <div class="BoxDepartureSchedule bg_fff">
        <div class="container">
            <h2 class="title_box text-center text-upper mb30">{$core->get_Lang('Lich Khởi hành')}</h2>
            <form method="post" class="formSearchDeparture" action="">
                <ul class="nav nav-tabs">
                    {section name=i loop=$lstTourGroup}
                    <li class="list-group-tour title-group-tour {if $tour_group_id eq $lstTourGroup[i].tour_group_id}active{/if}"  data-id="{$lstTourGroup[i].tour_group_id}"><a href="{$clsTourGroup->getLinkByGroup($lstTourGroup[i].tour_group_id)}">{$clsTourGroup->getTitle($lstTourGroup[i].tour_group_id)}</a></li>
                    {/section}
                </ul>
                <div class="boxSearchTourStartDate">
                    <p class="form_select search_title">{$core->get_Lang('Tìm kiếm')}</p>
                    <div class="form_select form_select_destination">
                        <select class="form-control slb" name="departure_point_ID" id="departure_point_ID">
                            <option value="0">{$core->get_Lang('Departure point')}</option>
							{section name=i loop=$lstDeparturePoint}
                            <option value="{$lstDeparturePoint[i].city_id}" title="{$clsCity->getTitle($lstDeparturePoint[i].city_id)}">{$clsCity->getTitle($lstDeparturePoint[i].city_id)}</option>
							{/section}
                        </select>
                    </div>
                    <div class="form_select form_select_city">
                        <select class="form-control" name="destination_ID" id="destination_ID">
							{$CITY_HTML}
                        </select>
                    </div>
                    <div class="form_select form_select_duration">
                        <select class="form-control" name="duration_ID" id="duration_ID">
							{$DURATION_HTML}
                        </select>
                    </div>
                    <div class="form_select form_select_date">
                        <select class="form-control" id="start_date" name="start_date">
							{$AVAILABLE_HTML}
                        </select>
                    </div>
                </div>
            </form>
            <!-- Tab panes --> 
            {if $clsISO->getBrowser() eq 'computer'}
            <div class="tab-content">
                <table class="table table-striped scroll">
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
						<td style="width: 568px"><p class="limit_1line mb0">{$clsTour->getTitle($tour_id)}</p></td>
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
            {else}
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
                        {/section} </div>
                </div>
            </div>
            {/if} </div>
    </div>
</main>
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
    max-height: 720px;
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
.formSearchDeparture{display: flex}
.BoxDepartureSchedule{padding: 55px 0 110px}
.BoxDepartureSchedule .table{border-collapse: collapse; }
.BoxDepartureSchedule .nav-tabs{margin-bottom: 5px;border-bottom: 0;    width: 100%;
max-width: 370px;
float: left;}
.BoxDepartureSchedule .nav-tabs li.view_all{float: right}
.BoxDepartureSchedule .nav-tabs li.view_all a{font-size: 16px !important;background: none;border: 0;outline: none}
.text-upper{text-transform: uppercase}
.BoxDepartureSchedule .title_box{font-size: 28px;font-weight: 700}
.BoxDepartureSchedule .nav>li>a{font-size: 18px;color: #1c1c1c;background: none;border: 0;padding: 20px}
.BoxDepartureSchedule .nav-tabs>li.active>a{padding: 20px;font-size: 18px;background: var(--main-color);border: 0}
.BoxDepartureSchedule .table>thead>tr>th{
padding: 13px 15px;font-weight: 400;border-bottom: 0;    border-right: 1px solid #c7c7c7;
}
.BoxDepartureSchedule .table>thead>tr>th:last-child{border-right: 0}
.BoxDepartureSchedule .table>tbody>tr>td{border-top: 0;border-right: 1px solid #c7c7c7;padding: 12px 12px;    vertical-align: inherit;border-left: 1px solid #c7c7c7
}
.BoxDepartureSchedule .table>tbody>tr>td:first-child{font-size: 17px;position: relative;padding-right: 70px}
.BoxDepartureSchedule .table>tbody>tr>td:last-child{border-right: 0}
.BoxDepartureSchedule .table>tbody>tr>td:first-child:before{content: "";position: absolute;background: url('/isocms/templates/default/skin/images/icon/HOT_icon_tour.png') no-repeat;right: 15px;top: 15px;width: 48px;height: 23px}
.BoxDepartureSchedule .table>tbody>tr>td:nth-child(4){color: #1fb69a;}
.BoxDepartureSchedule .table>tbody>tr>td.price .p_price{
float: left;
line-height: 30px;
width: calc(100% - 91px);
}
.boxSearchTourStartDate{
width: calc(100% - 370px);
float: right;
}
#tab-content{border-bottom: 2px solid var(--main-bg-color);}
.boxSearchTourStartDate .form_select{width: 192px;float: left;margin-left: 15px;padding: 8px 0}
.boxSearchTourStartDate .form_select .form-control{height: 50px;font-size: 16px;color: #999}

.boxSearchTourStartDate	.form_select.search_title{
width: auto;
padding: 22px 0;
margin-bottom: 0;position: relative;
}
.boxSearchTourStartDate	.form_select.search_title:before{content: "";position: absolute;width: 1px ;height: 16px;background: #1c1c1c;top: 24px;left: -15px}
.table tbody tr .price .detail_tour{
display: inline-block;
padding: 5px 21px;
float: right;
text-align: right;height: 30px;border-radius: 3px
}
@media (max-width: 1200px){
.BoxDepartureSchedule .nav>li>a{font-size: 17px}
.BoxDepartureSchedule .nav>li>a{padding: 20px 15px}
.BoxDepartureSchedule .nav-tabs>li.active>a{font-size: 17px;padding: 20px 15px;}
.BoxDepartureSchedule .nav-tabs{max-width: 340px}
.boxSearchTourStartDate {    width: calc(100% - 340px);}
.boxSearchTourStartDate .form_select{    width: 175px;}
.boxSearchTourStartDate .form_select.search_title{display: none}
}
@media (max-width: 1024px){
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
background: var(--main-bg-color);
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
{/literal} 
<script>
	var cat_id= '{$cat_id}';
	var tour_group_id= '{$tour_group_id}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
	var Loading = '{$core->get_Lang("Loading")}';
</script> 
{literal} 
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			$('select[name=departure_point_ID]').change(function(){
				var $_this = $(this);
				var $departure_point_ID = $_this.val();
				makeSelectDestination($_this.val(),0,tour_group_id);
				makeSelectboxDuration($departure_point_ID,0,0,0,tour_group_id);
				makeSelectboxStartDate($departure_point_ID,0,0,tour_group_id);
				ajLoadTourStartDate($departure_point_ID,0,0,0,tour_group_id);
			});
			$(document).on('change', 'select[name=destination_ID]', function(ev){
				var $_this = $(this);
				var $destination_ID = $_this.val();
				var $departure_point_ID = $('select[name=departure_point_ID]').val();
				makeSelectboxDuration($departure_point_ID,$destination_ID,0,0,tour_group_id);
				makeSelectboxStartDate($departure_point_ID,$destination_ID,0,tour_group_id);
				ajLoadTourStartDate($departure_point_ID,$destination_ID,0,0,tour_group_id);
			});
			$(document).on('change', 'select[name=duration_ID]', function(ev){
				var $_this = $(this);
				var $duration_ID = $_this.val();
				var $destination_ID = $('select[name=destination_ID]').val();
				var $departure_point_ID = $('select[name=departure_point_ID]').val();
				makeSelectboxStartDate($departure_point_ID,$destination_ID,$duration_ID,tour_group_id);
				ajLoadTourStartDate($departure_point_ID,$destination_ID,$duration_ID,0,tour_group_id);
			});
			$(document).on('change', 'select[name=start_date]', function(ev){
				var $_this = $(this);
				var $start_date = $_this.val();
				var $duration_ID = $('select[name=duration_ID]').val();
				var $destination_ID = $('select[name=destination_ID]').val();
				var $departure_point_ID = $('select[name=departure_point_ID]').val();
				ajLoadTourStartDate($departure_point_ID,$destination_ID,$duration_ID,$start_date,tour_group_id);
			});
			$(document).on('change', 'select[name=cat_ID]', function(ev){
				var $_this = $(this);
				var $departure_point_ID = $('select[name=departure_point_ID]').val();
				var $destination_ID = $('select[name=destination_ID]').val();
				var $cat_ID = $_this.val();
				makeSelectboxDuration($departure_point_ID,$destination_ID,$cat_ID,0);
			});
			if($('.findBox').length > 0){
				var _hh = $(window).height();
				var _hc = $('#sliderHomePage').outerHeight(false);
				var _hd = _hc-_hh;
				$('.findBox').css('bottom',_hd+10);
			}
		});
		function makeSelectDestination($departure_point_ID, $city_id,$tour_group_id){
			$('select[name=destination_ID]').html('<option value="">'+Loading+'...</option>');
			var $_adata = {
				'departure_point_ID' : $departure_point_ID,
				'city_id' : $city_id,
				'tour_group_id' : $tour_group_id,
			};
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDestinationDeparture&lang='+LANG_ID,
				data :$_adata,
				dataType:'html',
				success: function(html){
					$('select[name=destination_ID]').html(html);
				}
			});
		}
		function makeSelectCategory($departure_point_ID, $city_id, $cat_id){
			$('select[name=cat_ID]').html('<option value="0">'+Loading+'...</option>');
			var $_adata = {
				'departure_point_ID': $departure_point_ID,
				'city_id': $city_id,
				'cat_id': $cat_id
			};
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectCategory&lang='+LANG_ID,
				data :$_adata,
				dataType:'html',
				success: function(html){
					$('select[name=cat_ID]').html(html);
				}
			});
		}
		function makeSelectboxDuration($departure_point_ID,$city_id,$cat_ID,$duration_ID,$tour_group_id){
			$('select[name=duration_ID]').html('<option value="0">'+Loading+'...</option>');
			var adata = {
				'departure_point_id'    : $departure_point_ID,
				'city_id'    : $city_id,
				'duration_id'    : $duration_ID,
				'tour_group_id'    : $tour_group_id
			};
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectDurationDeparture&lang='+LANG_ID,
				data :adata,
				dataType:'html',
				success: function(html){
					$('select[name=duration_ID]').html(html);
				}
			});
		}
		function makeSelectboxStartDate($departure_point_ID,$city_id,$duration_ID,$tour_group_id){
			$('select[name=start_date]').html('<option value="0">'+Loading+'...</option>');
			var adata = {
				'departure_point_id'    : $departure_point_ID,
				'duration_id'    : $duration_ID,
				'tour_group_id'    : $tour_group_id,
				'city_id'    : $city_id,
				
			};
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=ajax&act=ajLoadSelectStartDateDeparture&lang='+LANG_ID,
				data :adata,
				dataType:'html',
				success: function(html){
					$('select[name=start_date]').html(html);
				}
			});
		}
		function ajLoadTourStartDate($departure_point_ID,$city_id,$duration_ID,$start_date,$tour_group_id){
			$('#tab-content').html('');
			var adata = {
				'departure_point_id'    : $departure_point_ID,
				'duration_id'    : $duration_ID,
				'tour_group_id'    : $tour_group_id,
				'city_id'    : $city_id,
				'start_date'    : $start_date,
			};
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=tour&act=ajload_list_tour_start_date&lang='+LANG_ID,
				data :adata,
				dataType:'html',
				success: function(html){
					$('#tab-content').html(html);
				}
			});
		}
	})
</script> 
{/literal}