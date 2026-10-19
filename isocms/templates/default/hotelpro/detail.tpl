<link rel="stylesheet" type="text/css" href="{$URL_JS}/venobox/venobox.css?v={$upd_version}" />
<link href="{$URL_CSS}/hotelpro.css" rel="stylesheet" type="text/css">	
<link rel="stylesheet" type="text/css" href="{$URL_JS}/jqueryeasyui15/themes/icon.css">
<link rel="stylesheet" type="text/css" href="{$URL_JS}/jqueryeasyui15/demo.css">
<script defer type="text/javascript" src="{$URL_JS}/jqueryeasyui15/jquery.easyui.min.js"></script>
{$core->getBlock('hotelbooking')}
<div id="page">
	<div id="breadcrumb">
    	<div class="container">
        	<div class="breadcrumb"> 
                <ul> 
                    <li><a href="{$PCMS_URL}" title="Trang chủ">Trang chủ</a></li> 
                    <li> <i class="fa fa-chevron-right"></i> </li>
                    <li><a href="{$curl}" title="Khách sạn">Khách sạn</a></li> 
                    <li> <i class="fa fa-chevron-right"></i> </li> 
                    <li><a href="{$clsCity->getLink($city_id,'hotel')}" title="Khách sạn {$clsCity->getTitle($city_id)}">Khách sạn {$clsCity->getTitle($city_id)}</a></li>
					<li> <i class="fa fa-chevron-right"></i> </li> 
                    <li class="current"><a href="{$curl}" title="{$clsHotel->getTitle($hotel_id)}">{$clsHotel->getTitle($hotel_id)}</a></li>  
										
                 </ul> 
             </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div align="justify" class="col-lg-3 sildebar">
                <div id="find-vietnamhotels" class="mb20">
                    <h2>Tìm khách sạn</h2>
                    {$core->getBlock(find_hotel1)}
                </div>
                {if $Html}
                 <div class="attractionHotel boxx-hotels mt10 mb20">
                    <h2 class="title_0568a6">Danh lam & Thắng cảnh</h2>
                        {$Html}
                 </div>
                 {/if}
                {assign var=area_city_id value=$clsHotel->getOneField('area_city_id',$hotel_id)}
                {assign var=lstHotelCityArea value=$clsHotel->getAll("is_trash=0 and is_online=1 and hotel_id <> '$hotel_id' and area_city_id ='$area_city_id'")}
                {if $lstHotelCityArea}
                <div class="boxx-hotels">
                    <h2 class="title">Khách sạn cùng khu vực</h2>
                    <ul class="boxx-hotels-content">
                        {section name=i loop=$lstHotelCityArea}
                        <li>
                            <a href="{$clsHotel->getLink($lstHotelCityArea[i].hotel_id)}" title="{$clsHotel->getTitle($lstHotelCityArea[i].hotel_id)}" class="photo"><img src="{$clsHotel->getImage($lstHotelCityArea[i].hotel_id,70,70)}" width="100%" height="100%" alt="{$clsHotel->getTitle($lstHotelCityArea[i].hotel_id)}"/></a>
                            <div class="rbox">
                                <h3><a href="{$clsHotel->getLink($lstHotelCityArea[i].hotel_id)}" title="{$clsHotel->getTitle($lstHotelCityArea[i].hotel_id)}">{$clsHotel->getTitle($lstHotelCityArea[i].hotel_id)} <img align="absmiddle" style="vertical-align:-3px" src="{$clsHotel->getImageStar($lstHotelCityArea[i].star_id)}"></a></h3>
                                {assign var=hotel_room_id value=$clsISO->getHotelRoomId($lstHotelCityArea[i].hotel_id)}
                                {if $clsHotel->getPriceAvg($lstHotelCityArea[i].hotel_id) ne '0' and $hotel_room_id ne ''}
                                <div class="price">Giá từ <span>{$clsHotelRoom->getTripPricePlace($hotel_room_id)|strip_tags}</span></div>
                                {elseif $clsHotel->getPriceAvg($lstHotelCityArea[i].hotel_id) ne '0' and $hotel_room_id eq ''}
                                <div class="price">Giá từ <span>{$clsHotel->getPriceAvg2($lstHotelCityArea[i].hotel_id)|strip_tags}</span></div>
                                {else}
                                <div class="price" title="Giá rất tốt tại khách sạn này không được công bố trên website, vui lòng click và điền địa chỉ email để nhận báo giá"><a href="javascript:void(0);" rel="nofollow" data-toggle="modal" data-target="#quickBooking" >Liên hệ để lấy giá tốt</a>
                                </div>
                                {/if}
                            </div>
                        </li>
                        {/section}
                    </ul>								
                </div>
                {/if}
                {$core->getBlock(box_ads_1)}
                 {if $lstTourCity}
                <div class="boxx-tours mt20">
                    <h2 class="title">Tour ghép tại {$clsCity->getTitle($city_id)}</h2>
                    <ul class="boxx-tours-content">
                        {section name=i loop=$lstTourCity}
                        <li>
                            <a href="{$clsTour->getLink($lstTourCity[i].tour_id)}" title="{$clsTour->getTitle($lstTourCity[i].tour_id)}" class="hovermore photo" rel="{$lstTourCity[i].tour_id}"><img src="{$clsTour->getImage($lstTourCity[i].tour_id,70,70)}" width="100%" height="100%" alt="{$clsTour->getTitle($lstTourCity[i].tour_id)}"/>
                            </a>
                            <div class="rbox">
                                <h3><a href="{$clsTour->getLink($lstTourCity[i].tour_id)}" title="{$clsTour->getTitle($lstTourCity[i].tour_id)}" class="hovermore" rel="{$lstTourCity[i].tour_id}">{$clsTour->getTitle($lstTourCity[i].tour_id)}</a></h3>
                                <p class="duration">Thời gian: <span>{$clsTour->getTripDuration($lstTourCity[i].tour_id)}</span></p>
                                <p class="price">Giá: <span>{$clsTour->getTripPrice($lstTourCity[i].tour_id)}</span></p>
                            </div>
                            <div id="itemTour-{$lstTourCity[i].tour_id}" class="popupTourItem" style="display:none">
                            	<div class="photo">
                                    <a href="{$clsTour->getLink($lstTourCity[i].tour_id)}" title="{$clsTour->getTitle($lstTourCity[i].tour_id)}"><img src="{$clsTour->getImage($lstTourCity[i].tour_id,315,200)}" width="100%" height="100%" alt="{$clsTour->getTitle($lstTourCity[i].tour_id)}"/></a>
                                    <span class="priceTour">{$clsTour->getTripPrice($lstTourCity[i].tour_id)}</span>
                                </div>
                                <div class="body">
                                <h3><a href="{$clsTour->getLink($lstTourCity[i].tour_id)}" title="{$clsTour->getTitle($lstTourCity[i].tour_id)}">{$clsTour->getTitle($lstTourCity[i].tour_id)}</a></h3>
                                <p class="tripcode">Mã tour: <span>{$clsTour->getTripCode($lstTourCity[i].tour_id)}</span></p>
                                <p class="departure">Khởi hành: <span></span>&nbsp;&nbsp;&nbsp;&nbsp;Từ: <span class="cityName">{$clsCity->getTitle($city_id)}</span></p>
                                <p class="transport">Phương tiện:</p>
                                <p class="customer">KH: Hàng ngày. Áp dụng cho 5 khách hàng trở lên</p>
                                </div>
                            </div>
                        </li>
                        {/section}
                    </ul>								
                </div>
                {/if}
                {literal}
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function () {
                            $('.hovermore').hover(function(){
                                var _this = $(this);
                                var row_id = _this.attr('rel');
                                if($('#itemTour-'+row_id).is(':visible')){
                                    _this.removeClass('arrow_down').addClass('arrow_right');
                                    $('#itemTour-'+row_id).hide();
                                }else{
                                    _this.removeClass('arrow_right').addClass('arrow_down');
                                    $('#itemTour-'+row_id).show();
                                }
                                return false;
                            });
                        })
                    </script>
                {/literal}
                <div class="booking-room">
                    <i class="icon icon-room"></i>
                    <div class="formattest-booking">
                        <h4>Đặt phòng theo đoàn?</h4>
                        Vietnamhotel đảm bảo sẽ tìm kiếm deal tốt nhất cho bạn!
                        <div class="book-now-room">
                        <a href="javascript:void(0);" rel="nofollow" data-toggle="modal" data-target="#bookingGroup" class="book-now">Đặt ngay <i class="fa fa-chevron-right"></i></a> 
                        </div>
                    </div>
            	</div>
            </div>
            <div class="col-lg-9 hotel-details mt30">
                <div class="row">
                    <div class="header col-md-10">
                        <h1 class="title">{$clsHotel->getTitle($hotel_id)} &nbsp;<img src="{$clsHotel->getImageStar($lstHotelRelated[i].star_id)}"><span>({$clsHotelRoom->getNumberRoomHotel($hotel_id)} phòng)</span></h1>
                        <div class="destination fl">{$clsHotel->getAddress($hotel_id)}  
                            {if $show eq 'bando'}
                             <a href="javascript:void(0);" class="map clickShowMap h_icon_map"><i class="fa fa-map-marker"></i> Bản đồ<i class="fa fa-times" aria-hidden="true" style="display:inline-block"></i></a>	
                             {else}
                             <a href="javascript:void(0);" class="map clickShowMap"><i class="fa fa-map-marker"></i> Bản đồ<i class="fa fa-times" aria-hidden="true"></i></a>	
                            {/if}
                            {assign var=area_city_id value=$clsHotel->getOneField('area_city_id',$hotel_id)}
                             <p class="location">Khu vực: <a href="{$clsAreaCity->getLink($area_city_id)}">{$clsAreaCity->getTitle($area_city_id)}</a></p>												
                        </div>
                    </div>
                    {if $clsHotelReview->getCountReview($hotel_id)}
                    <div class="col-md-2 pdr0 pdl0">
                        <ul class="rate" style="height:70px">
                            <li class="number">{$clsHotelReview->getPointAvg($hotel_id)|number_format:"1":".":","}</li>
                            <li class="good">{$clsHotelReview->getTextRate($hotel_id)} <p>{$clsHotelReview->getCountReview($hotel_id)} đánh giá</p></li>
                        </ul>
                    </div>
                    {/if}
                </div>
                <div class="cleafix"></div>
                {if $show eq 'bando'}
                <div  id="HotelMap" class="mb20" style="display:block">
                    <div id="map_canvas" class="map_canvas">
                            <!-- HTML here -->
                    </div>
                </div>
                {else}
                 <div  id="HotelMap" class="mb20" style="display:none">
                    <div id="map_canvas" class="map_canvas">
                            <!-- HTML here -->
                    </div>
                </div>
                {/if}
                <div class="hotelsDetail-imges">
                    {literal}
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function () {
                            jssor_slider1_starter = function (containerId) {
                                var $_options = {
                                    $AutoPlay: true,
                                    $AutoPlaySteps: 1,
                                    $AutoPlayInterval: 3000,
                                    $SlideDuration: 800,
                                    $ThumbnailNavigatorOptions: {
                                    $Class: $JssorThumbnailNavigator$,
                                    $ChanceToShow: 2,
                                    $ActionMode: 1,
                                    $SpacingX: 7,
                                    $DisplayPieces: 8,
                                    $ParkingPosition: 0
                                },
                                $ArrowNavigatorOptions: {
                                $Class: $JssorArrowNavigator$,
                                $ChanceToShow: 2,
                                $Steps: 1 
                                }
                            };
                            var jssor_slider1 = new $JssorSlider$(containerId, $_options);
                            };
                        })
                    </script>
                    {/literal}
                    <div id="thumbnai_slider" style="position:relative;top:0px;left:0px;width:848px;height:610px; width:100%; background:none;overflow:hidden;">
                        <div u="loading" style="position:absolute;top:0px;left:0px;">
                            <div style="filter:alpha(opacity=70);opacity:0.7;position:absolute;display:block;top:0px;left:0px;width:100%;height:100%"></div>
                            <div style="position:absolute;display:block;top:0px;left:0px;width:100%;height:100%"></div>
                        </div>
                        <div u="slides" style="cursor:move;position:absolute;left:0px;top:0px;width:848px;height:530px; overflow:hidden;">
<!--                        	-->
                            {section name=i loop=$listImage}
                            <div>
                                <img u="image" src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,848,530)}" />
                                <img u="thumb" src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,100,70)}" />
                            </div>
                            {/section}								                            
                        </div>
                        <div u="thumbnavigator" class="thumb_navigator" style="position:absolute;width:848px; height:70px;left:0px;bottom:0;">
                            <div u="slides" style="cursor:move; width:848px;top:12px">
                                <div u="prototype" class="p" style="POSITION:absolute;WIDTH:100px;HEIGHT:70px;TOP:0;LEFT:0;">
                                    <ThumbnailTemplate class="i" style="position:absolute;"></ThumbnailTemplate>
                                    <div class="o"></div>
                                </div>
                            </div>
                        </div>
                        <span u="arrowleft" class="jssora05l"></span>
                        <span u="arrowright" class="jssora05r"></span>
                        {literal}
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function () {
                                var timeClick = '';
                                jssor_slider1_starter('thumbnai_slider');
                                clearTimeout(timeClick);
                                timeClick = setTimeout(function(){
                                    $('div[u=prototype]:first').trigger('click');
                                    console.log('xx');
                                },100);
                            })
                        </script>
                        {/literal}
                    </div> 
                    {if $clsHotel->getUrlVideo($hotel_id)}
                    <div class="video mt20" id="VideoYoutubePlayer">
                    	<div class="htdt-ywrap">
                            <img src="//img.youtube.com/vi/xXzbhHlmHoU/default.jpg" alt="">
                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                        </div>
                        <h3 style="display:inline-block; margin-left:15px;">Video về khách sạn {$clsHotel->getTitle($hotel_id)}</h3>
                    </div> 
                    {/if}
                </div> 
                <div class="mt20" id="videoPlay" style="display:none">
                <iframe u="image" width="100%" height="530px" src="{$clsHotel->getUrlVideo($hotel_id)}" frameborder="0" allowfullscreen></iframe>
                </div>        
                <div id="find-vietnamhotels" class="mb20 mt20 search-details">
					<div class=" wow fadeInDown find_roomHotel" data-wow-delay="0.5s"> 
						<div class="select-active-border">
							<div class="select-active-content"> 
								<form method="post" action="" class="form-inline">
                                  <div class="msgRoomBooking" style="display:none; margin-bottom:10px; color:#f00">Chọn xem giá phòng theo ngày để nhận nhiều ưu đãi</div>
                                  <div class="form-group">
                                        <label>Ngày nhận phòng</label>
                                         <input name="departure_in" autocomplete="off" maxlength="10" id="departure_inn" value="{if $departure_in ne ''}{$clsISO->formatTimeDateEn($departure_in)}{else}{$checkin_to}{/if}" size="15" class="departureInFocus form-control dateTxt required hasIconPicker" placeholder="mm/dd/yyyy" />
                                    </div>
                                    <div class="form-group">
                                        <label>Ngày trả phòng</label>
                                        <input name="departure_out" autocomplete="off" maxlength="10" id="departure_outt" value="{if $departure_out ne ''}{$clsISO->formatTimeDateEn($departure_out)}{else}{$checkout_to}{/if}" size="15" class="form-control dateTxt required hasIconPicker" placeholder="mm/dd/yyyy" />
                                    </div>

									<button type="submit" class="btn hotels-button" id="CheckPriceRoomDate">Xem giá phòng theo ngày</button>
									<input type="hidden" name="Hid_CheckDate" value="Hid_CheckDate">
								</form>
							</div>
						</div>
					</div>
                </div>
                <div class="nopadding" data-instant-booking="1" data-url-roomprice="" data-url-pay="" data-map-room="0">
					{if $show eq 'Detail'}
                    {if $lstHotelRoom}
                    <table class="table table-bordered table-responsive tableRoomResult" id="tableRoomResultDefault" style="display: table;">
                        <thead>
							<tr>
                                <th class="tb-header"><strong>{$core->get_Lang('Loại phòng')}</strong></th>
                                <th class="tb-header"><strong>{$core->get_Lang('Tối đa')}</strong></th>
                                <th class="tb-header" style="width:33%"><strong>{$core->get_Lang('Giá phòng/đêm')}</strong></th>
                                <th class="tb-header" style="width:10%"><strong>{$core->get_Lang('Số phòng')}</strong></th>
                                <th class="tb-header"><strong>{$core->get_Lang('Đặt phòng')}</strong></th> 
                            </tr>
                        </thead>
                        <tbody id="show_data_hotel_recheck">
                            {section name=i loop=$lstHotelRoom}
                            <form method="post" action="" class="form-inline">
                            <input type="hidden" name="hotel_room_id" value="{$lstHotelRoom[i].hotel_room_id}">
                            <tr class="{if $smarty.section.i.iteration%2 eq '0'}row2 {else}row1{/if}">
                                <td class="col-room-type">
                                    <div class="pull-right">
                                     {if $clsHotelRoom->getOneField('is_breakfast',$lstHotelRoom[i].hotel_room_id) eq '1'}
                                     
                                    <span class="easyui-tooltip" title="Phòng bao gồm ăn sáng"><img class="icon-breakfast" src="{$URL_IMAGES}/breakfast.png" alt="Promotion"></span>
                                    {/if}
                                     {if $clsHotelRoom->getOneField('discount_rate',$lstHotelRoom[i].hotel_room_id) gt '0'}
                                    <span class="easyui-tooltip" title="Phòng có khuyến mãi {$clsHotelRoom->getOneField('discount_rate',$lstHotelRoom[i].hotel_room_id)} %"><img class="icon-gif" src="{$URL_IMAGES}/gift.png" alt="Promotion"></span>
                                    {/if}
                                    </div>
                                    <br class="cleafix"/>
                                    <h3 class="roomTitle">{$clsHotelRoom->getTitle($lstHotelRoom[i].hotel_room_id)}</h3>
                                    {if $clsHotelRoom->getImage($lstHotelRoom[i].hotel_room_id,120,80)}
                                    <div class="photoRoom">
                                        <img class="photo cleafix mb10" width="169" height="110" src="{$clsHotelRoom->getImage($lstHotelRoom[i].hotel_room_id,169,110)}" alt=""/>	
                                        {section name=j loop=$listImage}
                                        <a class="photo venobox" data-gall="myGallery" href="{$listImage[j].image}" title="" style="display:none">
                                        <img src="{$clsHotelImage->getImage($listImage[j].hotel_image_id,400,300)}" alt="" width="100%" style="display:none"/>
                                        </a>
                                        {/section}	 
                                    </div>
                                    {/if}	
                                    {literal}
									<script type="text/javascript">
                                        document.addEventListener("DOMContentLoaded", function () {
                                            $(function(){
                                                $('.venobox').venobox({
                                                    framewidth:800,
                                                    numeratio: true
                                                });
                                            });
                                        })
                                    </script>
                                    {/literal}	
                                    <br class="cleafix"/>
                                    <a class="clickmore arrow_right" rel="{$lstHotelRoom[i].hotel_room_id}" title="{$core->get_Lang('Thông tin phòng')}">{$core->get_Lang('Thông tin phòng')}</a> <span> &nbsp; | &nbsp; </span> <a class="clickmore2 arrow_right" rel="{$lstHotelRoom[i].hotel_room_id}" title="{$core->get_Lang('Điều kiện hủy phòng')}">{$core->get_Lang('Điều kiện hủy phòng')}</a>
                                </td>
                                <td align="center" style="text-align:center" class="col-max">
                                    {if $clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id) ne 0}
                                    <span class="easyui-tooltip people" title="Số lượng tối đa: {$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)} Người lớn{if $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) ne '0'}, {$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)} Trẻ em{/if}"><i class="glyphicon glyphicon-question-sign"></i></span>
                                    {if $clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id) gt '4' or $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) gt '2'}
                                    {$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)} Người lớn, {$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)} Trẻ em
                                    {else}
                                    <img class="mhs" style="vertical-align:-1px" src="{$URL_IMAGES}/people/icon_child_{$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)}{if $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) ne '0'}{$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)}{/if}.png" height="15px" width="auto" alt="" />
                                    {/if}
                                    {/if}
                                </td>
                                <td align="center" style="text-align:center" class="col-price">
                                    {if $clsAvailbility->getRoomPriceNoDate($lstHotelRoom[i].hotel_room_id,$departure_in) gt '0' and $lstHotelRoom[i].is_booking eq '1'}
                                    <span class="priceOld">
                                    {$clsHotelRoom->getPrice2($lstHotelRoom[i].hotel_room_id)}{if $clsHotelRoom->getOneField('price',$lstHotelRoom[i].hotel_room_id) ne '0'} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}{/if}
                                    </span>
                                    {$clsAvailbility->getRoomPriceNoDate($lstHotelRoom[i].hotel_room_id,$departure_in)}
                                	{$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}
                                    {elseif $lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_sendrequest eq '1'}
                                    {$clsHotelRoom->getPrice2($lstHotelRoom[i].hotel_room_id)}{if $clsHotelRoom->getOneField('price',$lstHotelRoom[i].hotel_room_id) ne '0'} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}{/if}
                                    {else}
                                    
                                    {/if}
                                    <div class="normal">{$clsHotelRoom->getIntro($lstHotelRoom[i].hotel_room_id)|html_entity_decode} </div>
                                </td>
                                <td align="center" style="text-align:center" class="col-room-number">
                                    {if $clsHotelRoom->getNumberRoom($lstHotelRoom[i].hotel_room_id) ne 0}
                                    <input type="number" class="form-control input-sm" name="numbertotalroom" id="numbertotalroom{$lstHotelRoom[i].hotel_room_id}" maxlength="2" min="1" value="1" max="{$clsHotelRoom->getNumberRoom($lstHotelRoom[i].hotel_room_id)}" style="border: 1px solid red;">
                                    {/if} 
                                     <input type="hidden" name="departure_in" value="{if $departure_in ne ''}{$clsISO->formatTimeDateEn($departure_in)}{else}{$checkout_to}{/if}">
                                     <input type="hidden" name="departure_out" value="{if $departure_out ne ''}{$clsISO->formatTimeDateEn($departure_out)}{else}{$checkout_to}{/if}">
                                </td>
                                <td align="center" style="text-align:center" class="col-book-now" rowspan="3">

                                    {if $lstHotelRoom[i].price gt '0' and $lstHotelRoom[i].is_booking eq '1'}
                                    {if $departure_in ne ''}
                                     <button type="submit" class="booking btn hotels-button" id="bookingRoom{$lstHotelRoom[i].hotel_room_id}">{$core->get_Lang('Đặt phòng')}</button>
                                    {else}
                                     <button type="button" class="booking btn hotels-button buttonBookingClick" id="bookingRoom{$lstHotelRoom[i].hotel_room_id}">{$core->get_Lang('Đặt phòng')}</button>
                                     {/if}
									<input type="hidden" name="BookingRoom" value="BookingRoom">
                                     {elseif  $lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_sendrequest eq '1'}
                                      <a href="javascript:void(0);" rel="nofollow" onclick="$('#hotel_room_id_rqprice').val({$lstHotelRoom[i].hotel_room_id});" data-toggle="modal" data-target="#quickBooking" class="booking">{$core->get_Lang('Yêu cầu giá')}</a>
                                      <p style="color:#0568a6; margin-top:6px">Trả lời trong vòng 60 phút</p>
                                     {elseif  $lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_getprice eq '1'}
                                     <a href="javascript:void(0);" rel="nofollow" onclick="$('#hotel_room_id_reqprice').val({$lstHotelRoom[i].hotel_room_id});" data-toggle="modal" data-target="#quickRequestPrice" class="booking">{$core->get_Lang('Click để lấy giá')}</a>
                                	{else}
                                    <a href="javascript:void(0);" rel="nofollow" onclick="$('#hotel_room_id_reqprice').val({$lstHotelRoom[i].hotel_room_id});" data-toggle="modal" data-target="#quickRequestPrice" class="booking">{$core->get_Lang('Click để lấy giá')}</a>
                                	{/if}
                                </td>
                            </tr>
                            <tr>
                                <td id="row-{$lstHotelRoom[i].hotel_room_id}" style="display:none" colspan="4">
                                <div class="formatTextStandard" style="text-align:left !important; padding:10px 0; font-size:13px !important; display:inline-block">
                                    {assign var=room_type_id value=$clsHotelRoom->getOneField('room_stype_id',$lstHotelRoom[i].hotel_room_id)}
                                    {if $room_type_id ne ''}
                                    <p><strong>{$core->get_Lang('Loại phòng')}:</strong> {$clsProperty->getTitle($room_type_id)}</p>
                                    {/if}
                                    <p><strong>{$core->get_Lang('Room Size')}:</strong> {$clsHotelRoom->getRoomSize($lstHotelRoom[i].hotel_room_id)} m2</p>
                                    <p><strong>{$core->get_Lang('Beds')}:</strong> {$clsHotelRoom->getRoomBed($lstHotelRoom[i].hotel_room_id)}</p>
                                    {if $clsHotelRoom->getOneField('price_extra',$lstHotelRoom[i].hotel_room_id) ne '0'}
                                    <p><strong>{$core->get_Lang('Giường phụ')}:</strong>  {$clsHotelRoom->getPriceExtra($lstHotelRoom[i].hotel_room_id)} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}</p>
                                    {/if}
                                    {assign var=hotel_room_id value=$lstHotelRoom[i].hotel_room_id}
                                    {assign var=lstHotelRoomCustomField value=$clsHotelCustomField->getAll("hotel_id='$hotel_id' and hotel_room_id='$hotel_room_id' and fieldtype='ADDFACILITY' order by order_no ASC")}
                                    {if $lstHotelRoomCustomField}
                        			{section name=j loop=$lstHotelRoomCustomField}
                                    <p><strong>{$lstHotelRoomCustomField[j].fieldname}:</strong> {$lstHotelRoomCustomField[j].fieldvalue|html_entity_decode}</p>
                                    {/section}
                                    {/if}
                                    {assign var=lstRoomServices value = $clsHotelRoom->getListRoomServices($lstHotelRoom[i].hotel_room_id)}
                                    <p><strong>{$core->get_Lang('Room Services')}:</strong>  {if $lstRoomServices[0] ne ''}
                                    {section name=k loop=$lstRoomServices}
                                    {if $clsProperty->getTitle($lstRoomServices[k])}
                                    <span>{$clsProperty->getTitle($lstRoomServices[k])}</span><span>{if $smarty.section.k.last}.{else},{/if}</span>
                                    {/if}
                                    {/section}
                                    {/if}
                                    </p>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td id="row2-{$lstHotelRoom[i].hotel_room_id}" style="display:none" colspan="4">
                                <div class="formatTextStandard" style="text-align:left !important; padding:10px 0; font-size:13px !important; display:inline-block">
                                    <p>
                                    Yêu cầu hủy phòng nhận được từ ngày <strong>{$clsISO->formatTimeDate($now)}</strong> đến ngày nhận phòng <strong>{$clsISO->formatTimeDate($now)}</strong> sẽ bị tính phí cho cho mỗi đêm là: {if $lstHotelRoom[i].price gt '0' and $lstHotelRoom[i].is_booking eq '1' or ($lstHotelRoom[i].price gt '0' and $lstHotelRoom[i].is_sendrequest eq '1')}<strong> {$clsHotelRoom->getPrice($lstHotelRoom[i].hotel_room_id)} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}</strong>
                                    {else}
                                    <a href="{$clsISO->getLink('feedback')}" rel="nofollow" class="linkfeedback">Liên hệ</a> để biết thêm thông tin
                                    {/if}
                                    </p>
                                </div>
                                </td>
                            </tr>
                            </form>
                            {/section}
                    	</tbody>
                    </table>
                    {literal}
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function () {
                            $('.clickmore').click(function(){
                                var _this = $(this);
                                var row_id = _this.attr('rel');
                                if($('#row-'+row_id).is(':visible')){
                                    _this.removeClass('arrow_down').addClass('arrow_right');
                                    $('#row-'+row_id).hide();
                                }else{
                                    _this.removeClass('arrow_right').addClass('arrow_down');
                                    $('#row-'+row_id).show();
                                }
                                return false;
                            });
                            $('.clickmore2').click(function(){
                                var _this = $(this);
                                var row_id = _this.attr('rel');
                                if($('#row2-'+row_id).is(':visible')){
                                    _this.removeClass('arrow_down').addClass('arrow_right');
                                    $('#row2-'+row_id).hide();
                                }else{
                                    _this.removeClass('arrow_right').addClass('arrow_down');
                                    $('#row2-'+row_id).show();
                                }
                                return false;
                            });
                        })
                    </script>
                    {/literal}
                    {else}
                    
                    Không có dữ liệu
                    {/if}
                    {else}
                   	{if $lstHotelRoom}
                    <table class="table table-bordered table-responsive tableRoomResult" id="tableRoomResultDefault" style="display: table;">
                        <thead>
							<tr>
                                <th class="tb-header"><strong>{$core->get_Lang('Loại phòng')}</strong></th>
                                <th class="tb-header"><strong>{$core->get_Lang('Tối đa')}</strong></th>
                                <th class="tb-header" style="width:33%"><strong>{$core->get_Lang('Giá phòng/đêm')}</strong></th>
                                <th class="tb-header" style="width:10%"><strong>{$core->get_Lang('Số phòng')}</strong></th>
                                <th class="tb-header"><strong>{$core->get_Lang('Đặt phòng')}</strong></th> 
                            </tr>
                        </thead>
                        <tbody id="show_data_hotel_recheck">
                            {section name=i loop=$lstHotelRoom}
                            <form method="post" action="" class="form-inline">
                            <input type="hidden" name="hotel_room_id" value="{$lstHotelRoom[i].hotel_room_id}">
                            <tr class="{if $smarty.section.i.iteration%2 eq '0'}row2 {else}row1{/if}">
                                <td class="col-room-type">
                                    <div class="pull-right">
                                     {if $clsHotelRoom->getOneField('is_breakfast',$lstHotelRoom[i].hotel_room_id) eq '1'}
                                    <span class="easyui-tooltip" title="Phòng bao gồm ăn sáng"><img class="icon-breakfast" src="{$URL_IMAGES}/breakfast.png" alt="Promotion"></span>
                                    {/if}
                                     {if $clsHotelRoom->getOneField('discount_rate',$lstHotelRoom[i].hotel_room_id) gt '0'}
                                    <span class="easyui-tooltip" title="Phòng có khuyến mãi {$clsHotelRoom->getOneField('discount_rate',$lstHotelRoom[i].hotel_room_id)} %"><img class="icon-gif" src="{$URL_IMAGES}/gift.png" alt="Promotion"></span>
                                    {/if}
                                    </div>
                                    <br class="cleafix"/>
                                    <h3 class="roomTitle">{$clsHotelRoom->getTitle($lstHotelRoom[i].hotel_room_id)}</h3>
                                    {if $clsHotelRoom->getImage($lstHotelRoom[i].hotel_room_id,120,80)}
                                    <img class="photo cleafix mb10" width="169" height="110" src="{$clsHotelRoom->getImage($lstHotelRoom[i].hotel_room_id,169,110)}" alt=""/>
                                    {/if}
                                    <br class="cleafix"/>
                                    <a class="clickmore arrow_right" rel="{$lstHotelRoom[i].hotel_room_id}" title="{$core->get_Lang('Thông tin phòng')}">{$core->get_Lang('Thông tin phòng')}</a> <span> &nbsp; | &nbsp; </span> <a class="clickmore2 arrow_right" rel="{$lstHotelRoom[i].hotel_room_id}" title="{$core->get_Lang('Điều kiện hủy phòng')}">{$core->get_Lang('Điều kiện hủy phòng')}</a>
                                </td>
                                <td align="center" style="text-align:center" class="col-max">
                                    {if $clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id) ne '0' and $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) ne '0'}
                                    <span class="easyui-tooltip people" title="Số lượng tối đa: {$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)} Người lớn{if $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) ne '0'}, {$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)} Trẻ em{/if}"><i class="glyphicon glyphicon-question-sign"></i></span>
                                    {if $clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id) gt '4' and $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) gt '1'}
                                    {$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)} Người lớn, {$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)} Trẻ em
                                    {else}
                                    <img class="mhs" style="vertical-align:-1px" src="{$URL_IMAGES}/people/icon_child_{$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)}{if $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) ne '0'}{$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)}{/if}.png" height="15px" width="auto" alt="" />
                                    {/if}
                                    {/if}
                                </td>
                                <td align="center" style="text-align:center" class="col-price">
                                 	{if $clsAvailbility->getRoomPriceNoDate($lstHotelRoom[i].hotel_room_id,$departure_in) gt '0' and $lstHotelRoom[i].is_booking eq '1' or ($lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_sendrequest eq '1')}
                                    <span class="priceOld">
                                    {$clsHotelRoom->getPrice2($lstHotelRoom[i].hotel_room_id)}{if $clsHotelRoom->getOneField('price',$lstHotelRoom[i].hotel_room_id) ne '0'} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}{/if}
                                    </span>
                                    {$clsAvailbility->getRoomPriceNoDate($lstHotelRoom[i].hotel_room_id,$departure_in)}
                                	{$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}
                                    {elseif $lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_sendrequest eq '1'}
                                    {$clsAvailbility->getRoomPriceDate($lstHotelRoom[i].hotel_room_id,$departure_in)}
                                	{$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}
                                    {else}
                                    {/if}
                                    <div class="normal">{$clsHotelRoom->getIntro($lstHotelRoom[i].hotel_room_id)|html_entity_decode} </div>
                                </td>
                                <td align="center" style="text-align:center" class="col-room-number">
                                    {if $clsHotelRoom->getNumberRoom($lstHotelRoom[i].hotel_room_id) ne 0}
                                    <input type="number" class="form-control input-sm" name="numbertotalroom" id="numbertotalroom{$lstHotelRoom[i].hotel_room_id}" maxlength="2" min="1" value="1" max="{$clsHotelRoom->getNumberRoom($lstHotelRoom[i].hotel_room_id)}" style="border: 1px solid red;">
                                    {/if} 
                                     <input type="hidden" name="departure_in" value="{if $departure_in ne ''}{$clsISO->formatTimeDateEn($departure_in)}{else}{$checkout_to}{/if}">
                                     <input type="hidden" name="departure_out" value="{if $departure_out ne ''}{$clsISO->formatTimeDateEn($departure_out)}{else}{$checkout_to}{/if}">
                                </td>
                                <td align="center" style="text-align:center" class="col-book-now" rowspan="3">
                                    {if $lstHotelRoom[i].price gt '0' and $lstHotelRoom[i].is_booking eq '1'}
                                     <button type="submit" class="booking btn hotels-button" id="bookingRoom{$lstHotelRoom[i].hotel_room_id}">{$core->get_Lang('Đặt phòng')}</button>
									<input type="hidden" name="BookingRoom" value="BookingRoom">
                                     {elseif  $lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_sendrequest eq '1'}
                                       <a href="javascript:void(0);" rel="nofollow" onclick="$('#hotel_room_id_rqprice').val({$lstHotelRoom[i].hotel_room_id});" data-toggle="modal" data-target="#quickBooking" class="booking">{$core->get_Lang('Yêu cầu giá')}</a>
                                       <p style="color:#0568a6; margin-top:6px">Trả lời trong vòng 60 phút</p>
                                     {elseif  $lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_getprice eq '1'}
                                      <a href="javascript:void(0);" rel="nofollow" onclick="$('#hotel_room_id_reqprice').val({$lstHotelRoom[i].hotel_room_id});" data-toggle="modal" data-target="#quickRequestPrice" class="booking">{$core->get_Lang('Click để lấy giá')}</a>
                                	{else}
                                    	<a href="javascript:void(0);" rel="nofollow" onclick="$('#hotel_room_id_reqprice').val({$lstHotelRoom[i].hotel_room_id});" data-toggle="modal" data-target="#quickRequestPrice" class="booking">{$core->get_Lang('Click để lấy giá')}</a>
                                	{/if}
                                </td>
                            </tr>
                            <tr>
                                <td id="row0-{$lstHotelRoom[i].hotel_room_id}" style="display:none" colspan="4">
                                <div class="formatTextStandard" style="text-align:left !important; padding:10px 0; font-size:13px !important; display:inline-block">
                                    {assign var=room_type_id value=$clsHotelRoom->getOneField('room_stype_id',$lstHotelRoom[i].hotel_room_id)}
                                    {if $room_type_id ne ''}
                                    <p><strong>{$core->get_Lang('Loại phòng')}:</strong> {$clsProperty->getTitle($room_type_id)}</p>
                                    {/if}
                                    <p><strong>{$core->get_Lang('Room Size')}:</strong> {$clsHotelRoom->getRoomSize($lstHotelRoom[i].hotel_room_id)} m2</p>
                                    <p><strong>{$core->get_Lang('Beds')}:</strong> {$clsHotelRoom->getRoomBed($lstHotelRoom[i].hotel_room_id)}</p>
                                    {if $clsHotelRoom->getOneField('price_extra',$lstHotelRoom[i].hotel_room_id) ne '0'}
                                    <p><strong>{$core->get_Lang('Giường phụ')}:</strong>  {$clsHotelRoom->getPriceExtra($lstHotelRoom[i].hotel_room_id)} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}</p>
                                    {/if}
                                    {assign var=hotel_room_id value=$lstHotelRoom[i].hotel_room_id}
                                    {assign var=lstHotelRoomCustomField value=$clsHotelCustomField->getAll("hotel_id='$hotel_id' and hotel_room_id='$hotel_room_id' and fieldtype='ADDFACILITY' order by order_no ASC")}
                                    {if $lstHotelRoomCustomField}
                        			{section name=j loop=$lstHotelRoomCustomField}
                                    <p><strong>{$lstHotelRoomCustomField[j].fieldname}:</strong> {$lstHotelRoomCustomField[j].fieldvalue|html_entity_decode}</p>
                                    {/section}
                                    {/if}
                                    {assign var=lstRoomServices value = $clsHotelRoom->getListRoomServices($lstHotelRoom[i].hotel_room_id)}
                                    <p><strong>{$core->get_Lang('Room Services')}:</strong>  {if $lstRoomServices[0] ne ''}
                                    {section name=k loop=$lstRoomServices}
                                    {if $clsProperty->getTitle($lstRoomServices[k])}
                                    <span>{$clsProperty->getTitle($lstRoomServices[k])}</span><span>{if $smarty.section.k.last}.{else},{/if}</span>
                                    {/if}
                                    {/section}
                                    {/if}
                                    </p>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td id="row02-{$lstHotelRoom[i].hotel_room_id}" style="display:none" colspan="4">
                                <div class="formatTextStandard" style="text-align:left !important; padding:10px 0; font-size:13px !important; display:inline-block">
                                    <p>Yêu cầu hủy phòng nhận được từ ngày <strong>{$clsISO->formatTimeDate($now)}</strong> đến ngày nhận phòng <strong>{$clsISO->formatTimeDate($departure_in)}</strong> sẽ bị tính phí cho cho mỗi đêm là:  {if $clsAvailbility->getRoomPriceDate($lstHotelRoom[i].hotel_room_id,$departure_in) ne '0' and $lstHotelRoom[i].is_booking eq '1' or ($lstHotelRoom[i].price ne '' and $lstHotelRoom[i].is_sendrequest eq '1') }
                                    <strong>{$clsAvailbility->getRoomPriceDate($lstHotelRoom[i].hotel_room_id,$departure_in)}
                                	{$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}</strong>
                                    {else}
                                      <a href="{$clsISO->getLink('feedback')}" rel="nofollow" class="linkfeedback">Liên hệ</a> để biết thêm thông tin
                                    {/if}</p>
                                </div>
                                </td>
                            </tr>
                            </form>
                            {/section}
                    	</tbody>
                    </table>
                    {literal}
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function () {
                            $('.clickmore').click(function(){
                                var _this = $(this);
                                var row_id = _this.attr('rel');
                                if($('#row0-'+row_id).is(':visible')){
                                    _this.removeClass('arrow_down').addClass('arrow_right');
                                    $('#row0-'+row_id).hide();
                                }else{
                                    _this.removeClass('arrow_right').addClass('arrow_down');
                                    $('#row0-'+row_id).show();
                                }
                                return false;
                            });
                            $('.clickmore2').click(function(){
                                var _this = $(this);
                                var row_id = _this.attr('rel');
                                if($('#row02-'+row_id).is(':visible')){
                                    _this.removeClass('arrow_down').addClass('arrow_right');
                                    $('#row02-'+row_id).hide();
                                }else{
                                    _this.removeClass('arrow_right').addClass('arrow_down');
                                    $('#row02-'+row_id).show();
                                }
                                return false;
                            });
                        })
                    </script>
                    {/literal}
                    {else}
                    Không có dữ liệu
                    {/if}
                    {literal}
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function () {
                            $(function(){
                                $('.ClickMore').click(function(){
                                    var $_this = $(this);
                                    if($_this.closest('ul').find('.hidElem:first').is(':visible')){
                                        $_this.closest('ul').find('.hidElem').hide();
                                        $_this.html('Xem thêm  <i class="fa fa-caret-down"></i>');
                                    }else{
                                        $_this.closest('ul').find('.hidElem').show();
                                        $_this.html('Rút gọn <i class="fa fa-caret-up"></i>');
                                    }
                                    return false;
                                });
                            });
                        })
                    </script>
                    {/literal}
                    <div class="note-text center">
                            <p>Xin lưu ý, mức giá trên đây có thể thay đổi đôi chút vào các dịp lễ, tết, thời gian cao điểm. </p>
                            <p>Quý khách vui lòng liên hệ với Vietnamhotel qua số 1900 0000 00 / 08 0000 1000 để được tư vấn thêm.</p>
                    </div>
                    {/if}
                    <div class="imformation-details">
                        <h2 class="title_0568a6">Thông tin {$clsHotel->getTitle($hotel_id)}</h2>
                        {if $clsHotel->getIntro($hotel_id) ne ''}
                        <div class="format-text intro" id="box_1" style="display: block;">
                            {$clsHotel->getIntro($hotel_id)|strip_tags|truncate:600}
                            <div class="read-more__handler"></div> 
                            <a href="javascript:void(0);" class="moreH viewmore ex right">{$core->get_Lang('Xem thêm')} <i class="fa fa-chevron-down"></i> </a> 
                        </div> 
                        <div class="format-text intro" id="box_2" style="display: none;">
                            {$clsHotel->getIntro($hotel_id)}
                            <a href="javascript:void(0);" class="moreH less col mt30 right">{$core->get_Lang('Rút gọn')} <i class="fa fa-chevron-up"></i></a> 
                        </div> 
                        
                        {literal}
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function () {
                                $('.moreH').click(function(){
                                    if($(this).hasClass('ex')){
                                        $('#box_1').hide();
                                        $('#box_2').show();
                                    }else{
                                        $('#box_1').show();
                                        $('#box_2').hide();
                                    }
                                });
                            })
                        </script>	
                        {/literal}
                        {/if}									
                     </div>
                    {if $clsHotel->getIntroArea($hotel_id) ne ''}
                        <div class="loaction">
                            <h2 class="title_0568a6">Vị trí</h2>
                            <div class="format-text">
                            {$clsHotel->getIntroArea($hotel_id)}
                            <!--<p><a href="" class="map"><i class="fa fa-map-marker"></i> Bản đồ</a></p>-->
                            </div>
                        </div>
                    {/if}
                    {if $lstFacility}
                    <div class="Facilities-services">
                    	<h2 class="title_0568a6">Tiện nghi, dịch vụ</h2>
                        <ul class="facility_UL">
                            {assign var=totalHotlelFacility value=$lstFacility|@count}
                            {section name=i loop=$lstFacility}
                            <li class="col-md-4 col-lg-4">{$clsProperty->getTitle($lstFacility[i])}</li>
                            {/section}                     
                        </ul>  
                    </div>
                    {/if}
                    <div class="quydinh mt20">
                    	<h2 class="title_0568a6">Quy định khách sạn</h2> 
                        <dl class="accordion-box">
                            <dt class="accordion_Items hotel">Giờ nhận - trả phòng
                            <a class="arrow_icr" href="javascript:void(0);" rel="nofollow"></a> </dt>
                            <dd class="info pbm" style="display:block">
                            <p>Giờ nhận phòng: {$oneItem.check_in_time}</p>
                            <p>Giờ trả phòng: {$oneItem.check_out_time}</p>
                            </dd>
                        </dl>
                        {if $listCustomField}
                        {section name=i loop=$listCustomField}
                        <dl class="accordion-box">
                            <dt class="accordion_Items hotel {if $smarty.section.i.last}show-icr{/if}">{$listCustomField[i].fieldname}
                            <a class="arrow_icr" href="javascript:void(0);" rel="nofollow"></a> </dt>
                            <dd class="info pbm" {if $smarty.section.i.last}style="display:none"{else}style="display:none"{/if}>
                            {$listCustomField[i].fieldvalue|html_entity_decode}
                            </dd>
                        </dl>
                        {/section}    
                        {/if}     
                    </div>
					{if $lstHotelReview}
                    <div class="danhgia mt10">
                    	<h2 class="title_0568a6">Đánh giá khách sạn {$clsHotel->getTitle($hotel_id)}</h2>
                        <ul class="mt20">
                            {foreach from=$lstHotelReview item=item name=item}
                            <li>
                                <div class="col-md-2">
                                    {if $clsHotelReview->getImage($item.hotel_review_id,60,60)}
                                        <img src="{$clsHotelReview->getImage($item.hotel_review_id,60,60)}" alt="{$item.name}">
                                    {else}
                                        <img src="{$URL_IMAGES}/people.png">
                                    {/if}
                                        <h3>{$item.name}</h3>
                                        <p class="date">{$clsISO->formatDateDMY($item.reg_date)}</p>
                                </div>
                                <div class="col-md-10 text1">
                                        <p class="beautiful"><span>{$item.point}</span> {$clsHotelReview->getTextRateByPoint($item.point)}</p>
                                        <h4 class="title">{$item.title}</h4>
                                        <div class="text">{$item.intro|html_entity_decode}</div>	
                                </div>
							</li>
                            {/foreach}
                        </ul>
                    </div>{/if}
                </div>
             </div>					
        </div>		
    </div>	
</div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGBM_QUAg8Oi-dI_Bopn6JVe4jrgVUcWw&libraries=places"></script>
<script type="text/javascript">
	var map_la = '{$clsHotel->getOneField("map_la",$hotel_id)}';
	var map_lo = '{$clsHotel->getOneField("map_lo",$hotel_id)}';
	var content_map = '{$clsHotel->getTitle($hotel_id)}';
	var hotel_id = '{$hotel_id}';
	var $_show = '{$show}';
</script>
{literal}
<style>
.map_canvas{ width:100%; height:460px;}
.htdt-ywrap {
    display: inline-block;
    position: relative;
}
.htdt-ywrap img {
    width: 120px;
    height: 90px;
}
.htdt-ywrap .fa-youtube-play{
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -15px;
    margin-left: -21px;
	font-size:34px;
	color:#f00;
	cursor:pointer;
}
</style>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        $(document).ready(function(){
            $('#departure_inn').datepicker({
                closeText: "Đóng",
                prevText: "Trước",
                nextText: "Sau",
                currentText: "Hôm nay",
                monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                monthNamesShort:["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
                dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                weekHeader: "Tuần",
                dateFormat: "mm/dd/yy", 
                minDate: "+0D", maxDate: "+1Y",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                showOtherMonths: true,
                onSelect: function(dateStr) { 
                    var date = $(this).datepicker('getDate'); 
                    if(date){ 
                        date.setDate(date.getDate() + 1); 
                    } 
                    $('#departure_outt').datepicker('option', {minDate: date}).datepicker('setDate', date); 
                },
                onClose: function(dateText, inst) {
                    $('#departure_outt').focus();
                }
            });
            $("#departure_outt").datepicker( { 
                closeText: "Đóng",
                prevText: "Trước",
                nextText: "Sau",
                currentText: "Hôm nay",
                monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                monthNamesShort:["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
                dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
                dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                weekHeader: "Tuần",
                dateFormat: "mm/dd/yy", 
                minDate: new Date(), maxDate: "+1Y",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                showOtherMonths: true
            });	
            
            $('.buttonBookingClick').click(function() {
                $('.departureInFocus').focus();
                $('.msgRoomBooking').show();
                $('#CheckPriceRoomDate').css({'background':'#0568a6'});	
            });
            $('.upNum').click(function() {
                var val = parseInt($('.isoNumber').val());
                var max_number = parseInt($('.isoNumber').attr('max-number'));
                val = val + 1;
                if (val > max_number){
                    val = max_number;
                }
                $('.isoNumber').val(val);
                return false;
            });
            $('.unNum').click(function() {
                var val = parseInt($('.isoNumber').val());
                var min_number = parseInt($('.isoNumber').attr('min-number'));
                val = val - 1;
                if (val < min_number) {
                    val = min_number;
                }
                $('.isoNumber').val(val);
                return false;
            });
            $(document).on('click', '#VideoYoutubePlayer', function(){
                if($('#videoPlay').is(':visible')){
                    $('#videoPlay').hide();
                }else{
                    $('#videoPlay').show();
                }
                return false;
            });
        });
        $(function(){
            initialize();
        });
        function initialize(){
            var mapOptions = {
                center: new google.maps.LatLng(map_la,map_lo),
                zoom: 11,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }; 
            map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
            var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(map_la,map_lo),
            });
            var infowindow = new google.maps.InfoWindow({
                map: map,
                position: new google.maps.LatLng(map_la,map_lo),
                content: content_map
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
        }
    })
</script>
{/literal}
<script defer type="text/javascript" src="{$URL_JS}/venobox/venobox.min.js?v={$upd_version}"></script>
