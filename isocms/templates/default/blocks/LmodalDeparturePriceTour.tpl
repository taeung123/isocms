<div class="modal fade in" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        	<div class="modal-header">
				<button type="button" class="close z_16 text-normal text-uppercase hidden-xs hidden-sm" data-dismiss="modal" aria-label="Close">Close <span aria-hidden="true" class="fa fa-times z_18"></span></button>
				<span class="inline-block m-for z_24 c2d">Price Calendar For </span>
				<h4 class="modal-title inline-block z_24 f_hn c2a text-bold" id="calendarModalLabel">{$clsTour->getTitle($tour_id)}</h4>
				<label class="rate-1"></label>
				{if $clsTour->getTripPrice($tour_id,$now_day) gt '0' and $clsTour->getLTripPriceOld($tour_id) gt '0'}
                <div class="price">
					<span class="block c2a">Starting at <b class="c5a">{$clsISO->getRate()} {$clsTour->getTripPrice($tour_id,$now_day)}</b> per person</span> including taxes and fees
				</div>
                
                {elseif $clsTour->getTripPrice($tour_id,$now_day) eq '0' and $clsTour->getLTripPriceOld($tour_id) gt '0'}
                <div class="price">
					<span class="block c2a">Starting at <b class="c5a">{$clsISO->getRate()} {$clsTour->getLTripPriceOld($tour_id)}</b> per person</span> including taxes and fees
				</div>
                {elseif $clsTour->getTripPrice($tour_id,$now_day) gt '0' and $clsTour->getLTripPriceOld($tour_id) eq '0'}
               <div class="price">
					<span class="block c2a">Starting at <b class="c5a">{$clsISO->getRate()} {$clsTour->getTripPrice($tour_id,$now_day)}</b> per person</span> including taxes and fees
				</div>
                {else}
                
                {/if}
			</div>
			<div class="modal-body">
				<!-- Tab panes -->
				<div class="tab-content bg-default">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div class="tab-ca-caption">
							<p style="margin-bottom:10px">
								<strong>{$clsISO->formatMonthYear($now)}</strong> <br>
								Click on a date below for pricing and booking details
							</p>
						</div>
						<div class="format-setting-content">
							<div class="row calendar-wrapper" data-tour_id="{$tour_id}">
								<div class="col-xs-4">
									<div class="calendar-form">
									</div>
								</div>
								<div class="col-xs-8">
									<div id="calendar" class="calendar-content">
									</div>
									<div class="overlay">
										<span class="spinner is-active"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>


{literal}
<style type="text/css">
/*******************************Calendar Top Navigation*********************************/
div#calendar{
  margin:0px auto;
  padding:0 20pxpx;
  width:100%;
}
 
div#calendar div.box{
    position:relative;
    top:0px;
    left:0px;
    width:100%;
    height:40px;
    background-color:   #787878 ;      
}
 
div#calendar div.header{
    line-height:40px;  
    vertical-align:middle;
    position:absolute;
    left:11px;
    top:0px;
    width:582px;
    height:40px;   
    text-align:center;
}
 
div#calendar div.header a.prev,div#calendar div.header a.next{ 
    position:absolute;
    top:0px;   
    height: 17px;
    display:block;
    cursor:pointer;
    text-decoration:none;
    color:#FFF;
}
 
div#calendar div.header span.title{
    color:#FFF;
    font-size:18px;
}
 
 
div#calendar div.header a.prev{
    left:0px;
}
 
div#calendar div.header a.next{
    right:0px;
}
 
 
 
 
/*******************************Calendar Content Cells*********************************/
div#calendar div.box-content{
    border:1px solid #787878 ;
    border-top:none;
}
 
 
 
div#calendar ul.label{
    float:left;
    margin: 0px;
    padding: 0px;
    margin-top:5px;
    margin-left: 5px;
}
 
div#calendar ul.label li{
    margin:0px;
    padding:0px;
    margin-right:5px;  
    float:left;
    list-style-type:none;
    width:80px;
    height:40px;
    line-height:40px;
    vertical-align:middle;
    text-align:center;
    color:#000;
    font-size: 15px;
    background-color: transparent;
}
 
 
div#calendar ul.dates{
    float:left;
    margin: 0px;
    padding: 0px;
    margin-left: 5px;
    margin-bottom: 5px;
}
 
/** overall width = width+padding-right**/
div#calendar ul.dates li{
    margin:0px;
    padding:0px;
    margin-right:5px;
    margin-top: 5px;
    line-height:80px;
    vertical-align:middle;
    float:left;
    list-style-type:none;
    width:80px;
    height:80px;
    font-size:25px;
    background-color: #DDD;
    color:#000;
    text-align:center; 
}
 
:focus{
    outline:none;
}
div.clear{
    clear:both;
}  
.fc-day-grid-event{background:none !important; border:none !important; color:#888 !important; text-align:right; font-size:11px}   
.fc-content .price{padding:10px 5px;}
.fc-content .price.background{background:#f16f30; color:#fff !important}
.fc-content .price:hover{background:#f16f30; color:#fff !important}
.priceOption{display:block; width:100%; font-size:20px;}
.fc-content .price.background .priceOption{color:#fff; font-weight:bold}
.fc-content .price:hover.background .priceOption{ color:#fff !important}
.fc-content a{text-decoration:underline; color:#888}
.fc-content .background a{color:#fff}
.fc-content .price:hover a{ color:#fff !important}
.fc-unthemed .fc-today {
    background: #fff !important;
}
.fc-ltr .fc-basic-view .fc-day-number{font-size:18px; font-weight:bold}
</style>
<script type="text/javascript">
var st_timezone = {"timezone_string":""};
var st_params = {"locale":"en","text_refresh":"Refresh"};
</script>
{/literal}
<link rel="stylesheet" type="text/css" href="{$URL_JS}/fullcalendar/fullcalendar.min.css" />
    
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment-timezone-with-data-2010-2020.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/date.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/custom.js"></script>