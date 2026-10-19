{assign var=title_hotel value=$clsHotel->getTitle($hotel_id)}
{assign var=hotel__id value=$hotel_id}
{assign var=intro_hotel value=$clsHotel->getIntro($hotel_id)}
{assign var=content_hotel value=$clsHotel->getContent($hotel_id)}
<div class="page_container pdb50">
    <nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$clsCountryEx->getLink($country_id,'Hotel')}" title="{$core->get_Lang('Hotels')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                  <a itemprop="item" href="{$curl}" title="{$title_hotel}">
					  <span itemprop="name" class="reb">{$title_hotel}</span></a>
				   <meta itemprop="position" content="3" />
               </li>
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="content hotelPageDetail pd40_0">
        <div class="hotelDetail">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <article class="hotels">
                            <img u="image" class="cover img100" src="{$clsHotel->getImage($hotel_id,954,405)}" alt="{$title_hotel}" />
                            <span style="cursor:pointer" class="{if $profile_id eq ''}exitLogin{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" clsTable="Hotel" data="{$hotel_id}" id="addwishlistHotel{$hotel_id}">{$clsHotel->getOneField('wishlist_num',$hotel_id)}</span>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="body">
										<h1 class="pane-title pane-title-fixed text-left mb10 mt0">{$title_hotel} <img src="{$clsHotel->getImageStar($oneItem.star_id)}" alt="{$title_hotel}"/></h1>
                                        <div class="address"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($hotel_id)}</div>
                                        <div class="stripbox intro" id="box_1">
                                            {$intro_hotel|strip_tags|truncate:150}
                                            <a href="javascript:void(0);" class="moreH readmore ex">{$core->get_Lang('More')} <i class="fa fa-caret-down"></i></a>
                                        </div>
                                        <div class="fullbox intro" id="box_2" style="display:none">
                                            {$intro_hotel}
                                            <a href="javascript:void(0);" class="moreH readmore col" >{$core->get_Lang('Less')} <i class="fa fa-caret-up"></i></a>
                                        </div> 
                                        <p class="price">{$core->get_Lang('Price from')}:<span class="price-Inc"> {$clsHotel->getPrice($hotel_id)}</span></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="needhelp">
                                        <h4>{$core->get_Lang('Need help? Call us at')}</h4>
                                        <p class="phone"><i class="fa fa-phone"></i><a class="color_body" href="tel:{$clsConfiguration->getValue('CompanyHotline')}" title="{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a></p>
                                        <p class="small">{$core->get_Lang('or call your favorite travel agent')}</p>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="wrap">
                            <ul id="tabsk" class="clienttabs mtm">
                                <li class="first"><a href="javascript:void(0);" class="current">{$core->get_Lang('Overview')}</a></li> 
                                {if $lstHotelRoom}
                                <li><a href="javascript:void(0);">{$core->get_Lang('Hotel Rooms')}</a></li>
                                {/if}
                                {if $listImage}
                                <li><a href="javascript:void(0);" rel="nofollow">{$core->get_Lang('Photos gallery')}</a></li>
                                {/if}
                            </ul>
                            <ul class="tabs_content pl0" id="lstTabs" style="border:0 !important">
                                <li class="contentTab">
                                    {if $content_hotel ne ''}
									<div class="H_Box">
										<div class="formatTextStandard mb10">
											{$content_hotel}
										</div>
									</div>
                                    {/if}
									{assign var=bookingPlicy_hotel value=$clsHotel->getHotelBookingPolicy($hotel_id)}
                                    {if $bookingPlicy_hotel ne ''}
									<div class="H_Box">
										<div class="formatTextStandard mb10">
											<h3 class="h3bold">{$core->get_Lang('Hotel booking policy')}</h3>
											{$bookingPlicy_hotel}
										</div>
									</div>
                                    {/if}
									{if $listCustomField}
                                    {section name=i loop=$listCustomField}
                                        {if $listCustomField[i].fieldvalue ne ''}
										<div class="H_Box">
											<h3 class="h3bold">{$listCustomField[i].fieldname}</h3>
											<div class="formatTextStandard listItem">{$listCustomField[i].fieldvalue|html_entity_decode}</div>
										</div>
                                        {/if}
                                    {/section}
									{/if}
                                    {if $lstHotelFacility}
                                    <h3 class="h3bold">{$core->get_Lang('Hotel Facilities')} </h3>
                                    <div class="row">
                                        <ul class="facility_UL">
                                            {section name=i loop=$lstHotelFacility}
                                            <li class="col-xs-6 col-sm-6 col-md-4 col-lg-4 visible">{$clsProperty->getTitle($lstHotelFacility[i])}</li>
                                            {/section}                                   
                                        </ul>
                                    </div>
                                    {/if}
                                </li>
                                {if $lstHotelRoom}
                                <li class="contentTab TabHotel" style="display:none">
									{assign var=note_hotel value=$clsHotel->getNote($hotel_id)}
                                    {if $note_hotel}
                                    <h3 class="h3bold">{$core->get_Lang('Hotel Note Price Tables')}</h3>
                                    <div class="formatTextStandard">{$note_hotel}</div>
                                    {/if}
                                    <table class="tbl-grid width100 table0" style="min-width:600px; overflow:auto">
                                        <tr>
                                            <td class="tb-header"><strong>{$core->get_Lang('Room Types')}</strong></td>
											<td class="tb-header" style="text-align:center">{$core->get_Lang('Max People')}</td>
                                            <td class="tb-header text-center" style="width: 60px">
                                                <strong>{$core->get_Lang('Price')}({$clsISO->getRate()})</strong>
                                            </td>
                                        </tr>
                                        {section name=i loop=$lstHotelRoom}
                                        <tr class="{if $smarty.section.i.iteration%2 eq '0'}row2 {else}row1{/if}">
                                            <td style="width: 45%">
                                                {if $clsHotelRoom->getUrlImage($lstHotelRoom[i].hotel_room_id)}
                                                <img class="photo" width="120" height="80" src="{$clsHotelRoom->getImage($lstHotelRoom[i].hotel_room_id,120,80)}"/>
                                                {/if}
                                                <div class="r" {if !$clsHotelRoom->getUrlImage($lstHotelRoom[i].hotel_room_id)}style="margin:0px"{/if}>
                                                    <h2>
                                                        {$clsHotelRoom->getTitle($lstHotelRoom[i].hotel_room_id)}
                                                    </h2>
                                                    {if $clsHotelRoom->getNumberRoom($lstHotelRoom[i].hotel_room_id) ne 0}
                                                        <strong>{$core->get_Lang('numroom')}</strong>: 
                                                        {$clsHotelRoom->getNumberRoom($lstHotelRoom[i].hotel_room_id)}
                                                        <br/>
                                                    {/if} 
                                                    <a class="clickmore arrow_right" href="javascript:void(0);" rel="{$lstHotelRoom[i].hotel_room_id}"><i class="fa fa-caret-right"></i> {$core->get_Lang('roominfo')}</a>
                                                </div>
                                            </td>
                                            <td style="text-align:center;width: 100%">
                                            {if $clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id) ne 0}
                                            {if $clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id) gt '4' or $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) gt '2'}
                                            {$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)} {$core->get_Lang('Adults')}, {$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)} {$core->get_Lang('Children')}
                                            {else}
                                            <img class="mhs" style="vertical-align:-1px" src="{$URL_IMAGES}/people/icon_child_{$clsHotelRoom->getNumberAdult($lstHotelRoom[i].hotel_room_id)}{if $clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id) ne '0'}{$clsHotelRoom->getNumberChild($lstHotelRoom[i].hotel_room_id)}{/if}.png" height="15px" width="auto" alt="" />
                                            {/if}
                                            {/if}
                                        	</td>
                                            <td style="text-align:center">
                                           <span class="price_Inc"> {$clsHotelRoom->getPrice($lstHotelRoom[i].hotel_room_id)} </span>
                                        	</td>
                                        </tr>
                                        <tr id="row-{$lstHotelRoom[i].hotel_room_id}" style="display:none">
                                            <td colspan="3">
                                            <div class="formatTextStandard" style="text-align:left !important; padding:10px 0; font-size:15px !important; display:inline-block; width:100%">
                                                <h3 class="h3bold">{$core->get_Lang('Room Description')}</h3>
                                                {$clsHotelRoom->getIntro($lstHotelRoom[i].hotel_room_id)|html_entity_decode}
                                                <p>{$core->get_Lang('No. beds')}: {$clsHotelRoom->getOneField('number_bed',$lstHotelRoom[i].hotel_room_id)}</p>
                                                <p>{$core->get_Lang('Room size')}: {$clsHotelRoom->getOneField('footage',$lstHotelRoom[i].hotel_room_id)} {$core->get_Lang('m2')}</p>
                                                <p>{$core->get_Lang('Room type')}: {$clsProperty->getTitle($lstHotelRoom[i].room_stype_id)}</p>
                                                {assign var=lstFacility value = $clsHotelRoom->getListRoomFacility($lstHotelRoom[i].hotel_room_id)}
                                                {if $lstFacility[0] ne ''}
                                                 <hr class="lineF" />
                                                <h3 class="h3bold">{$core->get_Lang('Room Facilities')}</h3>
                                                <ul class="lst-ext-facilities inline-block full-width">
                                                    {section name=k loop=$lstFacility}
                                                    {if $clsProperty->getTitle($lstFacility[k])}
                                                    <li class="col-md-4 col-sm-6 visible">{$clsProperty->getTitle($lstFacility[k])}</li>
                                                    {/if}
                                                    {/section}
                                                </ul>
                                                {/if}
                                            </div>
                                            </td>
                                        </tr>
                                        {/section}
                                    </table>
                                    {literal}
                                    <script >
                                        document.addEventListener("DOMContentLoaded", function () {
                                            $('.clickmore').click(function(){
                                                var _this = $(this);
                                                var row_id = _this.attr('rel');
                                                if($('#row-'+row_id).is(':visible')){ _this.removeClass('arrow_down').addClass('arrow_right');
                                                    $('#row-'+row_id).hide();
                                                }else{
                                                    _this.removeClass('arrow_right').addClass('arrow_down');
                                                    $('#row-'+row_id).show();
                                                }
                                                return false;
                                            });
                                        })
                                    </script>
                                    {/literal}
                                </li>
                                {/if}
                                {if $listImage}
                                <li class="contentTab" style="display:none;">
                                    <div class="row">
                                        <ul class="lst-ext-image gallery">
                                            {section name=i loop=$listImage}
											{assign var=title_hotel_image value=$clsHotel->getNote($hotel_id)}
                                            <li class="col-xs-6 col-sm-4 col-md-4">
                                                <a class="photo venobox" data-gall="myGallery" href="{$listImage[i].image}" title="{$title_hotel_image}"><img class="width100 heightAuto" src="{$clsHotelImage->getImage($listImage[i].hotel_image_id,463,308)}" alt="{$title_hotel_image}" /></a>
                                                <h3>{$title_hotel_image}</h3>
                                            </li>
                                            {/section}
                                        </ul>
                                        {literal}
                                        <script >
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
                                    </div>
                                </li>
                                {/if}
                            </ul>
                            <div class="clearfix"></div>
                            <div class="books_or_made mgt15">
                                <a class="booknow btn_main fl" href="{$clsHotel->getLinkBook($hotel_id)}">
                                    {$core->get_Lang('Book this hotel now')} 
                                </a>
                                {assign var=country_id value=$clsHotel->getOneField('country_id',$hotel_id)}
                                <a href="{$clsCountryEx->getLink($country_id,Hotel)}" title="{$core->get_Lang('Back to previous page')} " class="back_to_list fr">
                                     {$core->get_Lang('Back to previous page')} 
                                </a> 
                                <div class="clearfix"></div>
                            </div>
                        </article>
                        {if $lstHotelRelated}
                        <section id="relatedBox" class="hotelBox mt40">
                            <div class="headBox">
                                <h2 class="pane-title text-left mt0 mb20">{$core->get_Lang('Related hotels')}</h2>
                                <div class="control_js fr">
                                    <a href="javascript:void(0);" class="prev" id="prev_1"></a>
                                    <a href="javascript:void(0);" class="next" id="next_1"></a>
                                </div>
                            </div>
                            <div class="jcarousel-box owl-carousel" id="jcarousel-related-slides">
                                {section name=i loop=$lstHotelRelated}
                                {assign var=hotel_id value = $lstHotelRelated[i].hotel_id}
                                {assign var=arrHotel value = $lstHotelRelated[i]}
                                <article class="hotelItem">
                                  	{$clsISO->getBlock('hotelbox',["hotel_id"=>$hotel_id,"arrHotel"=>$arrHotel])}
                                </article>
                                {/section}
                            </div>
                        </section>
                        {/if}
                    </div> 
                    <aside class="col-md-3">
                        <div class="box_right">  
                            <div class="mapsBox hidden">
                                <h3 class="SegoeUILight mb10">{$core->get_Lang('Map Hotel')}</h3>
                                <div id="map_canvas" class="map_canvas">
                                    <!-- HTML here -->
                                </div>
								<div class="cleafix mt20"></div>
                            </div>
							<div class="testimonials">
								
                            	{$core->getBlock('testimonials')}
							</div>
                            <div class="whyUs">
								<div class="cleafix mt20"></div>
                            	{$core->getBlock('Lwhybox')}   
							</div>              
                        </div>
                    </aside>     
                </div>
                <script >
                    var map_la = '{$clsHotel->getOneField("map_la",$hotel__id)}';
                    var map_lo = '{$clsHotel->getOneField("map_lo",$hotel__id)}';
                    var content_map = '{$title_hotel}';
                    var hotel_id = '{$hotel__id}';
                    var $_show = '{$show}';
                </script>
                {literal}
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        $(function(){
                            initialize();
                        });
                        function initialize(){
                            var mapOptions = {
                                center: new google.maps.LatLng(map_la,map_lo),
                                zoom: 6,
                                scrollwheel: false,
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
                            google.maps.event.addListener(marker, 'click',function() {
                                infowindow.open(map, marker);
                            });
                            setTimeout(function() {infowindow.close(); },1000);
                        }
                    })
                </script>
                {/literal}
            </div>
        </div>
    </div>
</div>