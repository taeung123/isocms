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
          <li><a href="#" title="Trang chủ">Trang chủ</a></li>
          <li> <i class="fa fa-chevron-right"></i> </li>
          <li><a href="#" title="Khách sạn">Khách sạn</a></li>
          <li> <i class="fa fa-chevron-right"></i> </li>
            {if $show=='area'}
            <li><a href="{$clsCity->getLink($city_id,'hotel')}" title="Khách sạn {$clsCity->getTitle($city_id)}">Khách sạn {$clsCity->getTitle($city_id)}</a></li>
            <li> <i class="fa fa-chevron-right"></i> </li>
            <li class="current"><a href="{$curl}" title="{$oneArea.title}">{$oneArea.title}</a></li>
            {else}
  <li class="current"><a href="{$curl}" title="Khách sạn {$clsCity->getTitle($city_id)}">Khách sạn {$clsCity->getTitle($city_id)}</a></li>
            {/if}
        </ul>
      </div>
    </div>
  </div>
  <div class="cleafix"></div>
  <div class="container">
    <div class="row mt20">
      <div class="col-lg-3 mb40"> 
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
        <div class="benefits2 mt20">
          <div id="relatedBox" class="hotelBox">
            <div class="jcarousel-box owl-carousel" id="jcarousel-tours-slides"> {section name=i loop=$lstTestimonial max=5}
              <div class=" discover_Items">
                <div class="title">
                  <h4><a href="{$clsTestimonial->getLink($lstTestimonial[i].testimonial_id)}" title="{$clsTestimonial->getTitle($lstTestimonial[i].testimonial_id)}">{$clsTestimonial->getTitle($lstTestimonial[i].testimonial_id)}</a></h4>
                </div>
                <div class="intro"> "{$clsTestimonial->getIntro($lstTestimonial[i].testimonial_id)|truncate:150}" </div>
              </div>
              {/section} </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 list-hotles mb40">
      	{if $show eq 'area'}
        <h1 class="title">Khách sạn ở {$clsAreaCity->getTitle($area_city_id)}</h1>
        <div class="format-text"> {$clsAreaCity->getIntro($area_city_id,'Hotel')} </div>
        {else}
        <h1 class="title">Khách sạn ở {$clsCity->getTitle($city_id)}</h1>
        <div class="format-text"> {$clsCity->getIntro($city_id,'Hotel')} </div>
        {/if}
        <div class="control_sort-hotels">
          {if $show eq 'area'}
          <ul class="group_control">
            <li>Sắp xếp theo: &nbsp;&nbsp;<a href="{$clsAreaCity->getLink($area_city_id)}/a-z" title="Tên khách sạn A - Z" class="active"> Tên khách sạn A - Z </a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
            <li> <a href="{$clsAreaCity->getLink($area_city_id)}/rankaz" title="Tiêu chuẩn sao giảm dần" style="color:#2b2b2b">Tiêu chuẩn sao</a><a href="{$clsAreaCity->getLink($area_city_id)}/rankza" title="Tiêu chuẩn sao tăng dần"><i class="fa fa-long-arrow-up"></i></a>|&nbsp;&nbsp;</li>
            <li><a href="{$clsAreaCity->getLink($area_city_id)}/priceaz" title="Giá giảm dần"  style="color:#2b2b2b">Giá</a><a href="{$clsAreaCity->getLink($area_city_id)}/priceza" title="Giá tăng dần"><i class="fa fa-long-arrow-up"></i></a></li>
          </ul>
          {else}
          <ul class="group_control">
            <li>Sắp xếp theo: &nbsp;&nbsp;<a href="{$clsCity->getLink($city_id,'hotel')}/a-z" title="A-Z" class="active"> Tên khách sạn A - Z </a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
            <li> <a href="{$clsCity->getLink($city_id,'hotel')}/rankaz" title="Tiêu chuẩn sao giảm dần" style="color:#2b2b2b">Tiêu chuẩn sao</a><a href="{$clsCity->getLink($city_id,'hotel')}/rankza" title="Tiêu chuẩn sao tăng dần"><i class="fa fa-long-arrow-up"></i></a>|&nbsp;&nbsp;</li>
            <li><a href="{$clsCity->getLink($city_id,'hotel')}/priceaz" title="Giá giảm dần"  style="color:#2b2b2b">Giá</a><a href="{$clsCity->getLink($city_id,'hotel')}/priceza" title="Giá tăng dần"><i class="fa fa-long-arrow-up"></i></a></li>
          </ul>
          {/if}
        </div>
        {section name=i loop=$listHotelCity}
        {assign var=lstHotelFacility value = $clsHotel->getListHotelFacility($listHotelCity[i].hotel_id)}
        {if $smarty.section.i.iteration eq '4'}
        <div class="hotels-product mt20">
          <div class="images col-lg-3"> <img src="{$clsHotel->getImage($listHotelCity[i].hotel_id,179,134)}" alt="{$clsHotel->getTitle($listHotelCity[i].hotel_id)}" width="179" height="134" />
          {if $clsHotel->getDiscount($listHotelCity[i].hotel_id)}
            <div class="sale">{$clsHotel->getDiscount($listHotelCity[i].hotel_id)}</div>
          {/if}
          </div>
          <div class="col-lg-9 pr0">
            <div class="content {if $lstHotelFacility ne ''}borderBottom{/if}">
              <ul class="text-products col-lg-9 pl0">
                <li>
                  <h2 class="title"><a href="{$clsHotel->getLink($listHotelCity[i].hotel_id)}" title="{$clsHotel->getTitle($listHotelCity[i].hotel_id)}">{$clsHotel->getTitle($listHotelCity[i].hotel_id)}</a></h2>
                </li>
                <li>
                  <ul class="star">
                    <li><img src="{$clsHotel->getImageStar($listHotelCity[i].star_id)}" /></li>
                    {if $clsHotelReview->getCountReview($listHotelCity[i].hotel_id)}
                    <li class="good"><span>{$clsHotelReview->getPointAvg($listHotelCity[i].hotel_id)|number_format:"1":".":","}</span>{$clsHotelReview->getTextRate($listHotelCity[i].hotel_id)}</li>
                    <li>({$clsHotelReview->getCountReview($listHotelCity[i].hotel_id)} đánh giá)</li>
                    
                    {/if}
                  </ul>
                </li>
                <li class="destination">{$clsHotel->getAddress($listHotelCity[i].hotel_id)} <a href="{$clsHotel->getLinkMap($listHotelCity[i].hotel_id)}#HotelMap" title="Bản đồ" class="map"><i class="fa fa-map-marker"></i> Bản đồ</a> </li>
                {assign var=area_city_id value=$clsHotel->getOneField('area_city_id',$listHotelCity[i].hotel_id)}
                {if $clsAreaCity->getTitle($area_city_id) ne ''}
                <li class="location">Vị trí: <a href="{$clsAreaCity->getLink($area_city_id)}">{$clsAreaCity->getTitle($area_city_id)}</a></li>
                {/if}
              </ul>
              <ul class="text1-products col-lg-3">
              	{assign var=hotel_room_id value=$clsISO->getHotelRoomId($listHotelCity[i].hotel_id)}
              	{if $clsHotel->getPriceAvg($listHotelCity[i].hotel_id) ne '0' and $hotel_room_id ne ''}
                <li class="price-off">{$clsHotel->getPriceAvg1($listHotelCity[i].hotel_id)}</li>
                {if $clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$now_day_next) gt '0'}
                <li class="price">{$clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$now_day_next)}</li>
                {else}
                 <li class="price">{$clsHotelRoom->getTripPricePlace($hotel_room_id)}</li>
                {/if}
                {elseif $clsHotel->getPriceAvg($listHotelCity[i].hotel_id) ne '0' and $hotel_room_id eq ''}
                <li class="price">{$clsHotel->getPriceAvg2($listHotelCity[i].hotel_id)}</li>
                {else}
                <p class="text easyui-tooltip" title="Giá rất tốt tại khách sạn này không được công bố trên website, vui lòng click và điền địa chỉ email để nhận báo giá"><a href="javascript:void(0);" onclick="$('#hotel_id_rqprice').val({$listHotelCity[i].hotel_id});" rel="nofollow" data-toggle="modal" data-target="#quickBooking" >Liên hệ để lấy giá tốt</a>
                </p>
                {/if}
                 <li class="booking-rooms"><a href="{$clsHotel->getLink($listHotelCity[i].hotel_id)}">Chi tiết phòng</a></li>
              </ul>
            </div>
          </div>
          <div class="cleafix"></div>
          {if $lstHotelFacility}
          <ul class="tienich">
          	{assign var=totalHotelFacility value=$lstHotelFacility|@count}
            {section name=k loop=$lstHotelFacility}
            {if $clsProperty->getTitle($lstHotelFacility[k]) ne ''}
            <li class="col-md-3 {if $smarty.section.k.iteration gt '3'}hidElem{/if}" {if $smarty.section.k.iteration gt '3'}style="display:none"{/if}><i class="fa fa-check-square-o"></i> {$clsProperty->getTitle($lstHotelFacility[k])}</li>
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
          {/if} </div>

         <div class="qc1 mt20"><a title="{$clsAds->getTitle(2)}" href="{$clsAds->getLink(2)}" class="adsLink"><img src="{$clsAds->getImage(2,846,126)}" alt="{$clsAds->getTitle(2)}" width="100%" height="126" ></a></div>
        {elseif $smarty.section.i.iteration eq '8'}
        <div class="hotels-product mt20">
          <div class="images col-lg-3"> <img src="{$clsHotel->getImage($listHotelCity[i].hotel_id,179,134)}" alt="{$clsHotel->getTitle($listHotelCity[i].hotel_id)}" width="179" height="134" />
            {if $clsHotel->getDiscount($listHotelCity[i].hotel_id)}
            <div class="sale">{$clsHotel->getDiscount($listHotelCity[i].hotel_id)}</div>
          	{/if}
          </div>
          <div class="col-lg-9 pr0">
            <div class="content {if $lstHotelFacility ne ''}borderBottom{/if}">
              <ul class="text-products col-lg-9 pl0">
                <li>
                  <h2 class="title"><a href="{$clsHotel->getLink($listHotelCity[i].hotel_id)}" title="{$clsHotel->getTitle($listHotelCity[i].hotel_id)}">{$clsHotel->getTitle($listHotelCity[i].hotel_id)}</a></h2>
                </li>
                <li>
                  <ul class="star">
                    <li><img src="{$clsHotel->getImageStar($listHotelCity[i].star_id)}" /></li>
                    {if $clsHotelReview->getCountReview($listHotelCity[i].hotel_id)}
                    <li class="good"><span>{$clsHotelReview->getPointAvg($listHotelCity[i].hotel_id)|number_format:"1":".":","}</span>{$clsHotelReview->getTextRate($listHotelCity[i].hotel_id)}</li>
                    <li>({$clsHotelReview->getCountReview($listHotelCity[i].hotel_id)} đánh giá)</li>
                    
                    {/if}
                  </ul>
                </li>
                <li class="destination">{$clsHotel->getAddress($listHotelCity[i].hotel_id)} <a href="{$clsHotel->getLinkMap($listHotelCity[i].hotel_id)}#HotelMap" title="Bản đồ" class="map"><i class="fa fa-map-marker"></i> Bản đồ</a> </li>
                {assign var=area_city_id value=$clsHotel->getOneField('area_city_id',$listHotelCity[i].hotel_id)}
                {if $clsAreaCity->getTitle($area_city_id) ne ''}
                <li class="location">Vị trí: <a href="{$clsAreaCity->getLink($area_city_id)}">{$clsAreaCity->getTitle($area_city_id)}</a></li>
                {/if}
              </ul>
              <ul class="text1-products col-lg-3">
                {assign var=hotel_room_id value=$clsISO->getHotelRoomId($listHotelCity[i].hotel_id)}
              	{if $clsHotel->getPriceAvg($listHotelCity[i].hotel_id) ne '0' and $hotel_room_id ne ''}
                <li class="price-off">{$clsHotel->getPriceAvg1($listHotelCity[i].hotel_id)}</li>
                {if $clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$now_day_next) gt '0'}
                <li class="price">{$clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$now_day_next)}</li>
                {else}
                 <li class="price">{$clsHotelRoom->getTripPricePlace($hotel_room_id)}</li>
                {/if}
                {elseif $clsHotel->getPriceAvg($listHotelCity[i].hotel_id) ne '0' and $hotel_room_id eq ''}
                <li class="price">{$clsHotel->getPriceAvg2($listHotelCity[i].hotel_id)}</li>
                {else}
                <p class="text easyui-tooltip" title="Giá rất tốt tại khách sạn này không được công bố trên website, vui lòng click và điền địa chỉ email để nhận báo giá"><a href="javascript:void(0);" onclick="$('#hotel_id_rqprice').val({$listHotelCity[i].hotel_id});" rel="nofollow" data-toggle="modal" data-target="#quickBooking" >Liên hệ để lấy giá tốt</a>
                </p>
                {/if}
                 <li class="booking-rooms"><a href="{$clsHotel->getLink($listHotelCity[i].hotel_id)}">Chi tiết phòng</a></li>
              </ul>
            </div>
          </div>
          <div class="cleafix"></div>
          {if $lstHotelFacility}
          <ul class="tienich">
          	{assign var=totalHotelFacility value=$lstHotelFacility|@count}
            {section name=k loop=$lstHotelFacility}
            {if $clsProperty->getTitle($lstHotelFacility[k]) ne ''}
            <li class="col-md-3 {if $smarty.section.k.iteration gt '3'}hidElem{/if}" {if $smarty.section.k.iteration gt '3'}style="display:none"{/if}><i class="fa fa-check-square-o"></i> {$clsProperty->getTitle($lstHotelFacility[k])}</li>
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
          {/if} </div>
         <div class="qc1 mt20"><a title="{$clsAds->getTitle(3)}" href="{$clsAds->getLink(3)}" class="adsLink"><img src="{$clsAds->getImage(3,846,126)}" alt="{$clsAds->getTitle(3)}" width="100%" height="126" ></a></div>
        {else}
        <div class="hotels-product mt20">
          <div class="images col-lg-3"> <img src="{$clsHotel->getImage($listHotelCity[i].hotel_id,179,134)}" alt="{$clsHotel->getTitle($listHotelCity[i].hotel_id)}" width="179" height="134" />
            {if $clsHotel->getDiscount($listHotelCity[i].hotel_id)}
            <div class="sale">{$clsHotel->getDiscount($listHotelCity[i].hotel_id)}</div>
          	{/if}
          </div>
          <div class="col-lg-9 pr0">
            <div class="content {if $lstHotelFacility ne ''}borderBottom{/if}">
              <ul class="text-products col-lg-9 pl0">
                <li>
                  <h2 class="title"><a href="{$clsHotel->getLink($listHotelCity[i].hotel_id)}" title="{$clsHotel->getTitle($listHotelCity[i].hotel_id)}">{$clsHotel->getTitle($listHotelCity[i].hotel_id)}</a></h2>
                </li>
                <li>
                  <ul class="star">
                    <li><img src="{$clsHotel->getImageStar($listHotelCity[i].star_id)}" /></li>
                    {if $clsHotelReview->getCountReview($listHotelCity[i].hotel_id)}
                    <li class="good"><span>{$clsHotelReview->getPointAvg($listHotelCity[i].hotel_id)|number_format:"1":".":","}</span>{$clsHotelReview->getTextRate($listHotelCity[i].hotel_id)}</li>
                    <li>({$clsHotelReview->getCountReview($listHotelCity[i].hotel_id)} đánh giá)</li>
                    
                    {/if}
                  </ul>
                </li>
                <li class="destination">{$clsHotel->getAddress($listHotelCity[i].hotel_id)} <a href="{$clsHotel->getLinkMap($listHotelCity[i].hotel_id)}#HotelMap" title="Bản đồ" class="map"><i class="fa fa-map-marker"></i> Bản đồ</a> </li>
                {assign var=area_city_id value=$clsHotel->getOneField('area_city_id',$listHotelCity[i].hotel_id)}
                {if $clsAreaCity->getTitle($area_city_id) ne ''}
                <li class="location">Vị trí: <a href="{$clsAreaCity->getLink($area_city_id)}">{$clsAreaCity->getTitle($area_city_id)}</a></li>
                {/if}
              </ul>
              <ul class="text1-products col-lg-3">
                {assign var=hotel_room_id value=$clsISO->getHotelRoomId($listHotelCity[i].hotel_id)}
              	{if $clsHotel->getPriceAvg($listHotelCity[i].hotel_id) ne '0' and $hotel_room_id ne ''}
                <li class="price-off">{$clsHotel->getPriceAvg1($listHotelCity[i].hotel_id)}</li>
                {if $clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$now_day_next) gt '0'}
                <li class="price">{$clsAvailbility->getRoomPriceDatePlace($hotel_room_id,$now_day_next)}</li>
                {else}
                 <li class="price">{$clsHotelRoom->getTripPricePlace($hotel_room_id)}</li>
                {/if}
                {elseif $clsHotel->getPriceAvg($listHotelCity[i].hotel_id) ne '0' and $hotel_room_id eq ''}
                <li class="price">{$clsHotel->getPriceAvg2($listHotelCity[i].hotel_id)}</li>
                {else}
                <p class="text easyui-tooltip" title="Giá rất tốt tại khách sạn này không được công bố trên website, vui lòng click và điền địa chỉ email để nhận báo giá"><a href="javascript:void(0);" onclick="$('#hotel_id_rqprice').val({$listHotelCity[i].hotel_id});" rel="nofollow" data-toggle="modal" data-target="#quickBooking" >Liên hệ để lấy giá tốt</a>
                </p>
                {/if}
                <li class="booking-rooms"><a href="{$clsHotel->getLink($listHotelCity[i].hotel_id)}">Chi tiết phòng</a></li>
              </ul>
            </div>
          </div>
          <div class="cleafix"></div>
          {if $lstHotelFacility}
          <ul class="tienich">
          	{assign var=totalHotelFacility value=$lstHotelFacility|@count}
            {section name=k loop=$lstHotelFacility}
            {if $clsProperty->getTitle($lstHotelFacility[k]) ne ''}
            <li class="col-md-3 {if $smarty.section.k.iteration gt '3'}hidElem{/if}" {if $smarty.section.k.iteration gt '3'}style="display:none"{/if}><i class="fa fa-check-square-o"></i> {$clsProperty->getTitle($lstHotelFacility[k])}</li>
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
          {/if} </div>
        {/if}
        {/section}
        <div class="clearfix"></div>
        {if $totalPage gt 1}
        <center>
          <div class="pagination"> {$page_view} </div>
        </center>
        {/if} </div>
    </div>
    <div id="relates-hotel" class="mb20">
      <div class="hotels-good">
        <div class="header-hotel-goods">
          <h2 class="title"> Khách sạn tại các thành phố khác </h2>
        </div>
        {section name=i loop=$listTopCity max=4}
            <div class="col-ct-6 {if $smarty.section.i.index %2 eq '0'}pl0{else} pr0{/if} hotelCityItem">
              <div class="hotels-good-one">
                <div class="title-header">
                  <p class="left">{$clsCity->getTitle($listTopCity[i].city_id)}</p>
                  <p class="right">Khách sạn khác tại {$clsCity->getTitle($listTopCity[i].city_id)}</p>
                </div>
                <div class="images"> <a href="{$clsCity->getLink($listTopCity[i].city_id)}"><img src="{$clsCity->getImage($listTopCity[i].city_id,134,84)}" width="134" height="84"/></a> </div>
                {assign var=city_id value=$clsCity->getOneField('city_id',$listTopCity[i].city_id)}
                {assign var=lstHotelCity value=$clsHotel->getAll("is_trash=0 and is_online=1 and city_id='$city_id'")}
                <ul class="title-hotels">
                  {section name=j loop=$lstHotelCity max=3}
                  <li>
                      <a href="">{$clsHotel->getTitle($lstHotelCity[j].hotel_id)} <img src="{$clsHotel->getImageStar($lstHotelCity[j].star_id)}"/></a> 
                      {assign var=hotel_room_id value=$clsISO->getHotelRoomId($lstHotelCity[j].hotel_id)} <span class="price"> {$clsHotelRoom->getPrice($hotel_room_id)} {if $clsHotelRoom->getOneField('price',$hotel_room_id) gt 0} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}{/if} </span> 

                  </li>
                  {/section}
                </ul>
              </div>
            </div>
        {/section} 
        </div>
    </div>
  </div>
</div>

