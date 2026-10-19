<link href="{$URL_CSS}/hotelpro.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{$URL_JS}/jqueryeasyui15/themes/icon.css">
<link rel="stylesheet" type="text/css" href="{$URL_JS}/jqueryeasyui15/demo.css">
<script defer type="text/javascript" src="{$URL_JS}/jqueryeasyui15/jquery.easyui.min.js"></script>
{$core->getBlock('hotelbooking')}
<div class="page_container mb60">   
        <div id="breadcrumb">
    	<div class="container">
        	<div class="breadcrumb"> 
                <ul> 
                    <li><a href="#" title="Trang chủ">Trang chủ</a></li> 
                    <li> <i class="fa fa-chevron-right"></i> </li>
                    <li><a href="#" title="Khách sạn">Khách sạn</a></li> 
                    <li> <i class="fa fa-chevron-right"></i> </li> 
                    <li class="current"><a href="{$curl}" title="{$core->get_Lang('Result Search')}">{$core->get_Lang('Result Search')}</a></li> 
                 </ul> 
             </div>
        </div>
    </div>      
 	<div class="rowbox primary">
    <div class="container">
    	<div class="row">
            <div class="col-md-3 site-right-page">
                <div class="sticky_box">
                    <div class="clearfix mbl"></div>
                    {$core->getBlock('find_hotel1')}
                    {$core->getBlock(right_hotel)}
                    {$core->getBlock(box_ads_1)}
                    <div class="booking-room"> <i class="icon icon-room"></i>
                      <div class="formattest-booking">
                        <h4>Đặt phòng theo đoàn?</h4>
                        Vietnamhotel đảm bảo sẽ tìm kiếm deal tốt nhất cho bạn!
                        <div class="book-now-room"> <a href="" class="book-now">Đặt ngay <i class="fa fa-chevron-right"></i></a> </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 site-left-page">
            	{if $area_city_id>0}
                 <h1 class="title">Khách sạn ở {$clsAreaCity->getTitle($area_city_id)} <span class="totalSearch">({$totalRecord} {$core->get_Lang('hotels')})</span></h1>
                <div class="format-text"> {$clsAreaCity->getIntro($area_city_id,'Hotel')} </div>
                {elseif $city_id >0}
                <h1 class="title">Khách sạn ở {$clsCity->getTitle($city_id)} <span class="totalSearch">({$totalRecord} {$core->get_Lang('hotels')})</span></h1>
                <div class="format-text"> {$clsCity->getIntro($city_id,'Hotel')} </div>
                {else}
                <h1 class="title">Khách sạn ở {$clsCountry->getTitle($country_id)} <span class="totalSearch">({$totalRecord} {$core->get_Lang('hotels')})</span></h1>
                <div class="format-text"> {$clsCountry->getIntro($country_id,'Hotel')} </div>
                {/if}
                <div class="control_sort-hotels">
                  <ul class="group_control">
                    <li>Sắp xếp theo: &nbsp;&nbsp;<a href="{$curl}/a-z" title="Tên khách sạn A - Z" class="active"> Tên khách sạn A - Z </a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
                    <li> <a href="{$curl}/rankaz" title="Tiêu chuẩn sao giảm dần" style="color:#2b2b2b">Tiêu chuẩn sao</a><a href="{$curl}/rankza" title="Tiêu chuẩn sao tăng dần"><i class="fa fa-long-arrow-up"></i></a>|&nbsp;&nbsp;</li>
                    <li><a href="{$curl}/priceaz" title="Giá giảm dần"  style="color:#2b2b2b">Giá</a><a href="{$curl}/priceza" title="Giá tăng dần"><i class="fa fa-long-arrow-up"></i></a></li>
                  </ul>
                </div>
                <!--<h1 class="headPage mbmm">{$core->get_Lang('Result Search')} <span class="totalSearch">({$totalRecord} {$core->get_Lang('results')})</span></h1>-->
                    {if $listHotelSearch}
                    <div class="boxHotels row" id="listHolderView">
                        {assign var=totalHotels value=$listHotelSearch|@count}
                        {section name=i loop=$listHotelSearch}
                        {assign var=lstHotelFacility value = $clsHotel->getListHotelFacility($listHotelSearch[i].hotel_id)}
                        {assign var=hotel_id value=$listHotelSearch[i].hotel_id}
                        <div class="hotels-product mt20 box" {if $smarty.section.i.iteration gt '6'} style="display:none;"{/if}>
                        <div class="images col-lg-3">
                             <img src="{$clsHotel->getImage($listHotelSearch[i].hotel_id,179,134)}" alt="{$clsHotel->getTitle($listHotelSearch[i].hotel_id)}" width="179" height="134" />
                             {if $clsHotel->getDiscount($listHotelSearch[i].hotel_id)}
                             <div class="sale">{$clsHotel->getDiscount($listHotelSearch[i].hotel_id)}</div>
                             {/if}
                        </div>
                        <div class="col-lg-9 pr0">
                            <div class="content {if $lstHotelFacility ne ''}borderBottom{/if}">
                                <ul class="text-products col-lg-9 pl0">
                                    <li><h2 class="title"><a href="{$clsHotel->getLink($listHotelSearch[i].hotel_id)}" title="{$clsHotel->getTitle($listHotelSearch[i].hotel_id)}">{$clsHotel->getTitle($listHotelSearch[i].hotel_id)}</a></h2></li>
                                    <li>
                                        <ul class="star">
                                            <li><img src="{$clsHotel->getImageStar($listHotelSearch[i].star_id)}" /></li>
                                            {if $clsHotelReview->getCountReview($listHotelSearch[i].hotel_id)}
                                            <li class="good"><span>{$clsHotelReview->getPointAvg($listHotelSearch[i].hotel_id)|number_format:"1":".":","}</span>{$clsHotelReview->getTextRate($listHotelSearch[i].hotel_id)}</li>
                                            <li>({$clsHotelReview->getCountReview($listHotelSearch[i].hotel_id)} đánh giá)</li>
                                            {/if}
                                        </ul>
                                    </li>
                                    <li class="destination">{$clsHotel->getAddress($listHotelSearch[i].hotel_id)}
                                        <a href="{$clsHotel->getLinkMap($listHotelSearch[i].hotel_id)}#HotelMap" class="map"><i class="fa fa-map-marker"></i> Bản đồ</a>													
                                    </li>
                                    {assign var=area_city_id value=$clsHotel->getOneField('area_city_id',$listHotelSearch[i].hotel_id)}
                                    {if $clsAreaCity->getTitle($area_city_id) ne ''}
                                    <li class="location">Vị trí: <a href="{$clsAreaCity->getLink($area_city_id)}">{$clsAreaCity->getTitle($area_city_id)}</a></li>								 												{/if}
                                </ul>
                                <ul class="text1-products col-lg-3">
                                    {assign var=hotel_room_id value=$clsISO->getHotelRoomId($listHotelSearch[i].hotel_id)}
                                    {if $clsHotel->getPriceAvg($listHotelSearch[i].hotel_id) ne '0' and $hotel_room_id ne ''}
                                    <li class="price-off">{$clsHotel->getPriceAvg1($listHotelSearch[i].hotel_id)}</li>
                                    {if $clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$departure_in_price) gt '0'}
                                    <li class="price">{$clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$departure_in_price)}</li>
                                    {else}
                                     <li class="price">{$clsHotelRoom->getTripPricePlace($hotel_room_id)}</li>
                                    {/if}
                                    {elseif $clsHotel->getPriceAvg($listHotelSearch[i].hotel_id) ne '0' and $hotel_room_id eq ''}
                                    <li class="price">{$clsHotel->getPriceAvg2($listHotelSearch[i].hotel_id)}</li>
                                    {else}
                                    <p class="text easyui-tooltip" title="Giá rất tốt tại khách sạn này không được công bố trên website, vui lòng click và điền địa chỉ email để nhận báo giá"><a href="javascript:void(0);" onclick="$('#hotel_id_rqprice').val({$listHotelSearch[i].hotel_id});" rel="nofollow" data-toggle="modal" data-target="#quickBooking" >Liên hệ để lấy giá tốt</a>
                                    </p>
                                    {/if}
                                    <li class="booking-rooms"><a href="{$clsHotel->getLink($listHotelSearch[i].hotel_id)}">Chi tiết phòng</a></li>
                                </ul>
                            </div>
                        </div>
                        {assign var=lstHotelFacility value = $clsHotel->getlistHotelFacility($listHotelSearch[i].hotel_id)}
                        {if $lstHotelFacility}
                        <div class="cleafix"></div>
                        <ul class="tienich">
                            {assign var=totalHotelFacility value=$lstHotelFacility|@count}
                            {section name=k loop=$lstHotelFacility}
                            {if $clsProperty->getTitle($lstHotelFacility[k])}
                            <li class="col-md-3 {if $smarty.section.k.iteration gt '3'}hidElem{/if}" {if $smarty.section.k.iteration gt '3'}style="display:none"{/if}><i class="fa fa-check-square-o"></i>  {$clsProperty->getTitle($lstHotelFacility[k])}</li>
                            {/if}
                            {/section}
                            {if $totalHotelFacility gt '3'}
                            <li class="col-md-3 more">
                                <a class="ClickMore" href="javasctipt:void(0);" rel="nofollow" title="{$core->get_Lang('Xem thêm')}">
                                    {$core->get_Lang('Xem thêm')} <i class="fa fa-caret-down"></i>
                                </a> 
                           </li>
                           {/if}
                        </ul>
                        {/if}
                        </div>
                        {/section}
                        {if $totalHotels gt '6'}
                        <div class="wrap text-center mt40">
                            <a href="javascript:void(0);" rel="nofollow" page="1" class="show-more" id="show-more">Xem thêm<img src="{$URL_IMAGES}/load0.png" class="load" alt="load" width="16px" height="16px"/></a>
                        </div>
                        {/if}
                    </div>
                    {else}
                    <div class="med" style="font-size:18px">  
                        <p style="padding-top:.33em"> 
                        	{$core->get_Lang('Your search')} - <em>{$keyword}</em> - {$core->get_Lang('did not match any hotels')}.  
                        </p> 
                        <p style="margin:1em 0">{$core->get_Lang('Suggestions')}:</p> 
                        <ul style="margin-left:1.3em;margin-bottom:2em; list-style:disc">
                            <li>{$core->get_Lang('Make sure that all words are spelled correctly')}.</li>
                            <li>{$core->get_Lang('Try different keywords')}.</li>
                            <li>{$core->get_Lang('Try more general keywords')}.</li>
                        </ul> 
                    </div>
                {/if}
            </div>
    	</div>
    </div>
</div>
</div>
{literal}
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        $(function(){	
            var $number_per_page =6;	
            var $page =1;	
            var timer = '';
            $('#show-more').click(function(){
                var $_this = $(this);	
                clearTimeout(timer);	
                $page = $page+1;	
                $_this.find('img.load').show();	
                timer = setTimeout(function(){	
                    var $start = ($page-1)*$number_per_page;	
                    var $end = $start + $number_per_page;	
                    for(var i = $start; i < $end; i++){	
                        $('.box').eq(i).show();	
                    }	
                    $_this.find('img.load').hide();	
                },500);
                /* Hide load more */	
                setInterval(function(){	
                    loadPageFix();	
                },100);	
            });	
        }); 
    })
</script>
{/literal}
