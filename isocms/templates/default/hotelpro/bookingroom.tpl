<link href="{$URL_CSS}/hotelbooking.css" rel="stylesheet" type="text/css">	
<div class="page_container mb80">
    <div id="content">
        <div class="container">
            <div id="breadcrumb" class="mb30">
                <div class="breadcrumb">
                    <ul itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="name"><a href="{$PCMS_URL}" title="{$core->get_Lang('home')}" itemprop="url">{$core->get_Lang('Home')}</a></li>
                        <li><span>›</span></li>
                        <li itemprop="name"><a href="{$clsHotel->getLink($hotel_id)}" title="{$clsHotel->getTitle($hotel_id)}" itemprop="url">{$clsHotel->getTitle($hotel_id)}</a></li>
                        <li><span>›</span></li>
                         <li itemprop="name"><a href="{$curl}" title="{$clsHotelRoom->getTitle($hotel_room_id)}" itemprop="url">{$clsHotelRoom->getTitle($hotel_room_id)}</a></li>
                        <li><span>›</span></li>
                        <li itemprop="name"><a href="{$curl}" title="{$core->get_Lang('Booking Room')}" itemprop="url">{$core->get_Lang('Booking Room')}</a></li>
                    </ul>
                </div>
            </div>
            <div class="hotel-decrition intro14_5">
            	 <section id="booking" class="rowbox primary">
                 	<form action="" method="post" class="formBookingRoom">
                    	{if $err_msg ne ''}
                        <div class="message_box corner-3px mtmm">{$err_msg}</div>
                        {/if}
                        <div class="row" id="setp_1">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="bookingPayment">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="bookingInfo">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paymentPanel">
                                                    <br>
                                                    <div id="hotelDetail" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing">
                                                        <div class="title-hotel vspacingbottom10">
                                                            <h2>{$clsHotel->getTitle($hotel_id)} &nbsp;<img class="middle" src="{$clsHotel->getImageStar($hotel_id.star_id)}">
                                                            <input type="hidden" value="{$hotel_id}" name="hotel_id" id="hotel_id" />
                                                            </h2>
                                                        </div>
                                                        <div class="address-hotel">
                                                            <i class="glyphicon glyphicon-map-marker"></i>
                                                            <span>{$clsHotel->getAddress($hotel_id)} </span>
                                                        </div>
                                                        <br>
                                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 vremoveSpacing hotelImageDiv">
                                                            <img src="{$clsHotel->getImage($hotel_id,87,65)}" class="img-responsive img-rounded" width="87" height="65" alt="{$clsHotel->getTitle($hotel_id)}">
                                                        </div>
                                                        <div class="clearfix visible-xs-block"><br></div>
                                                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" id="checInDateRange">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing vspacingbottom10">
                                                                <div class="col-xs-6 col-sm-4 col-md-5 col-lg-6 vremoveSpacing">Ngày nhận phòng</div>
                                                                <div class="col-xs-6 col-sm-8 col-md-7 col-lg-6 vremoveSpacing"><span class="hightLight">{$departure_in}</span></div>
                                                                 <input type="hidden" value="{$departure_in}" name="departure_in" id="departure_in" />
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing vspacingbottom10">
                                                                <div class="col-xs-6 col-sm-4 col-md-6 col-lg-6 vremoveSpacing">Ngày trả phòng</div>
                                                                <div class="col-xs-6 col-sm-8 col-md-6 col-lg-6 vremoveSpacing"><span class="hightLight">{$departure_out}</span></div>
                                                                 <input type="hidden" value="{$departure_out}" name="departure_out" id="departure_out" />
                                                            </div>
                                                            <input type="hidden" value="{$numbertotalroom}" name="number_bookingroom" id="number_bookingroom" />
                                                        </div>
                                                    </div>
                                                    <div id="roomDetail" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing vspacingbottom30">
                                                        <hr class="horizontalLine">
                                                        <div class="title-hotel vspacingbottom10">
                                                            <h2>{$clsHotelRoom->getTitle($hotel_room_id)}</h2>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vspacingbottom10">
                                                                {assign var=totalPriceRoom value=$clsAvailbility->getRoomPriceMath($hotel_room_id,$departure_in_price)*$numbertotalroom*$totalnumberDay}
                                                                {assign var=totalPriceExtra value=$clsHotelRoom->getPriceExtraMath($hotel_room_id)*$numbertotalroom*$totalnumberDay}
                                                                {assign var=totalPrice value=$totalPriceRoom+$totalPriceExtra}
                                                                
                                                                <p>Số phòng: {$numbertotalroom}</p>
                                                                <p>Giá phòng {$totalnumberDay} đêm: <span class="color_0568a6">{$clsISO->formatPrice($totalPriceRoom,3)} {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}</span></p>
                                                                <input type="hidden" name="price_totalbookingRoom" value="{$totalPriceRoom}" id="price_totalbookingRoom">
                                                                {if $clsHotelRoom->getPriceExtra($hotel_room_id) gt '0'}
                                                                <p>Giá giường phụ {$totalnumberDay} đêm: <span class="color_0568a6">  {$clsISO->formatPrice($clsHotelRoom->getPriceExtraMath($hotel_room_id),3)} 
                                                                {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))} x 
                                                                <input type="number" value="0" name="number_extraroom" id="number_extraroom"/>
                                                                <input type="hidden" name="price_extraroom" value="{$clsHotelRoom->getPriceExtraMath($hotel_room_id)}" id="price_extraroom">
                                                                <input type="hidden" name="price_room" value="{$clsAvailbility->getRoomPriceDate($hotel_room_id,$departure_in_price)}" id="price_room">
                                                                </span></p>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vspacingtop15 paymentPanel">
                                                    <br>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing vspacingbottom15">
                                                        <div class="title-hotel vspacingbottom10">
                                                            <h2 class="pull-left">Thanh toán </h2>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vspacingbottom5">
                                                                <div class="col-xs-5 col-sm-5 col-md-4 col-lg-4 vremoveSpacing">
                                                                    <span>Tổng tiền</span>
                                                                </div>
                                                                <div class="col-xs-7 col-sm-7 col-md-8 col-lg-8 vremoveSpacing">
                                                                    <span class="totalPrice color_0568a6" id="totalpriceroom">0</span>
                                                                    <input type="hidden" value="0" name="totalPrice" id="totalPrice"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <span class="taxIncluded">Giá đã bao gồm 10% phí VAT và 5% phí dịch vụ.</span>
                                                            </div>
                                                        </div>
                            
                                                    </div>
                                                </div>
                                                <input type="hidden" id="tourselectcttc">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 " id="bookerInfo">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing">
                                                    <div id="bookerInfoProfile" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paymentPanel">
                                                        <br>
                                                        <div class="title-hotel vspacingbottom10">
                                                            <h2>Thông tin người đặt <br><span>(Vui lòng điền đầy đủ thông tin)</span></h2>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="row vspacingbottom10">
                                                                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Danh Xưng</span></div>
                                                                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing input-name-people">
                                                                    <div class="col-sm-1 col-xs-1 col-md-1 col-lg-1 vremoveSpacing"><input value="Anh" type="radio" name="ctitle"></div>
                                                                    <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3 vremoveSpacing"><span>Anh</span></div>
                                                                    <div class="col-sm-1 col-xs-1 col-md-1 col-lg-1 vremoveSpacing"><input value="Chị" type="radio" name="ctitle"></div>
                                                                    <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3 vremoveSpacing"><span>Chị</span></div>
                                                                </div>
                                                            </div>
                                                            <div class="row vspacingbottom10">
                                                                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Họ tên:</span></div>
                                                                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                    <input type="text" class="form-control input-sm" name="customername" id="customername">
                                                                </div>
                                                            </div>
                                                            <div class="row vspacingbottom10">
                                                                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Số di động:</span></div>
                                                                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                    <input type="text" class="form-control input-sm" name="customerphone" id="phone">
                                                                </div>
                                                            </div>
                                                            <div class="row vspacingbottom10">
                                                                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Email:</span></div>
                                                                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing input-name-people">
                                                                    <input type="text" class="form-control input-sm" name="customeremail" id="email">
                                                                </div>
                                                            </div>
                                                            <div class="row vspacingbottom10">
                                                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel hidden-xs"><span></span></div>
                                                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 vremoveSpacing">
                                                                    <input id="registercustomerorther" type="checkbox" class="customizedCheckbox">
                                                                    <label for="registercustomerorther" class="labelRegisterAnotherCustomer">Tôi đặt phòng cho người khác</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="display-none" id="registercustomerortherform">
                                                            <div class="title-hotel vspacingbottom10">
                                                                <h2>Thông tin khách nhận phòng</h2>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                <div class="row vspacingbottom10">
                                                                    <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Danh Xưng</span></div>
                                                                    <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing input-name-people">
                                                                        <div class="col-sm-1 col-xs-1 col-md-1 col-lg-1 vremoveSpacing"><input checked="checked" type="radio" value="Anh" name="leadingtitle"></div>
                                                                        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3 vremoveSpacing"><span>Anh</span></div>
                                                                        <div class="col-sm-1 col-xs-1 col-md-1 col-lg-1 vremoveSpacing"><input type="radio" value="Chị" name="leadingtitle"></div>
                                                                        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3 vremoveSpacing"><span>Chị</span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row vspacingbottom10">
                                                                    <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Họ tên:</span></div>
                                                                    <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                        <input type="text" class="form-control input-sm" name="leadingname" id="leadingname">
                                                                    </div>
                                                                </div>
                                                                <div class="row vspacingbottom10">
                                                                    <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Số di động:</span></div>
                                                                    <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                        <input type="text" class="form-control input-sm" name="leadingphone" id="leadingphone">
                                                                    </div>
                                                                </div>
                                                                <div class="row vspacingbottom10">
                                                                    <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Email:</span></div>
                                                                    <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing input-name-people">
                                                                        <input type="text" class="form-control input-sm" name="leadingemail" id="leadingemail">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <br>
                                                        </div>
                                                        <div class="title-hotel vspacingbottom10">
                                                            <h2>Danh sách khách</h2>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="row vspacingbottom10">
                                                                <div class="vremoveSpacing col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <span>Theo quy định của khách sạn, mời quý khách để lại thông  tin của những người nhận phòng (mỗi phòng một người, gõ tên đúng như trên giấy tờ cá nhân).</span>
                                                                </div>
                                                            </div>
                                                            <div id="listdatanhanphong">
                                                                {section name=i loop=$numbertotalroom}
                                                                <div class="row vspacingbottom10 ">
                                                                    <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Phòng {$smarty.section.i.iteration}:</span></div>
                                                                        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing">
                                                                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 vremoveSpacing">
                                                                                    <select {if $smarty.section.i.first}disabled="disabled"{/if} class="form-control input-sm vspacingbottom10" id="danhxung_1_{$smarty.section.i.iteration}" name="danhxung_1_{$smarty.section.i.iteration}">
                                                                                        <option value="Anh">Anh</option>
                                                                                        <option value="Chị">Chị</option>
                                                                                    </select>
                                                                                </div>
                                                                                
                                                                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9 vremoveSpacing vspacingbottom10">
                                                                                    <input type="text" {if $smarty.section.i.first}disabled="disabled"{/if} maxlength="400" class="form-control input-sm" lang="adust_1_{$smarty.section.i.iteration}" name="room_popele_adust_1_{$smarty.section.i.iteration}" id="room_popele_adust_1_{$smarty.section.i.iteration}" placeholder="Họ tên người thứ {$smarty.section.i.iteration}">    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {/section}
                                                                </div>
                                                                <div class="row vspacingbottom10">
                                                                    <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span></span></div>
                                                                    <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing">
                                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 vremoveSpacing">
                                                                            <input type="checkbox" id="registercustomerortherorder" class="customizedCheckbox">
                                                                            <label for="registercustomerortherorder" class="labelRegisterAnotherCustomer">Xuất hóa đơn</label>
                                                                        </div>
                                
                                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 vremoveSpacing">
                                                                            <input type="checkbox" id="registercustomerortherhhh" class="customizedCheckbox">
                                                                            <label for="registercustomerortherhhh" class="labelRegisterAnotherCustomer">Yêu cầu khác</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="registercustomerortherformhodon" class="display-none" style="display:none">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <br>
                                                                </div>
                                                                <div class="title-hotel vspacingbottom10">
                                                                    <h2>Thông tin xuất hóa đơn</h2>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="row vspacingbottom10">
                                                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Tên công ty:</span></div>
                                                                        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                            <input type="text" class="form-control input-sm" name="companyname" id="companyname">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row vspacingbottom10">
                                                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Địa chỉ:</span></div>
                                                                        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                            <input type="text" class="form-control input-sm" name="companyaddress" id="companyaddress">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row vspacingbottom10">
                                                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Mã số thuế:</span></div>
                                                                        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing input-name-people">
                                                                            <input type="text" size="13" maxlength="13" name="companytax" class="form-control input-sm" id="companytax">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row vspacingbottom10">
                                                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing"><span>Địa chỉ nhận hóa đơn:</span></div>
                                                                        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing input-name-people">
                                                                            <input type="text" class="form-control input-sm"  name="coompanyaddresshaodon" id="coompanyaddresshaodon">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="registercustomerortherformhodonhhhh" class="display-none" style="display:none">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <br>
                                                                </div>
                                                                <div class="title-hotel vspacingbottom10">
                                                                    <h2>Thông tin yêu cầu khác</h2>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <div class="row vspacingbottom15">
                                                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing">
                                                                            <div class="vspacingright15"><span>Thời gian nhận phòng dự kiến:</span></div>
                                                                        </div>
                                                                        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                            <input type="text" class="form-control input-sm" name="hoursddd" id="hoursddd">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row vspacingbottom15">
                                                                        <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3 vremoveSpacing spanLabel"><span>Yêu cầu khác:</span></div>
                                                                        <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9 vremoveSpacing ">
                                                                            <textarea class="form-control  input-sm" name="recdudud" id="recdudud"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 agreeDiv">
                                                                    <!--<div class="row continue-step">-->
                                                                    <div class="clearfix col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing" style="text-align: right;">
                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 vremoveSpacing vspacingtop10 vspacingbottom10">
                                                                            <button id="btn_continue" class="btn btn-warning next-button btn-block">Đặt ngay <i class="glyphicon glyphicon-chevron-right"></i></button>
                                                                            <input type="hidden" name="bookingRoom" value="bookingRoom">
                                                                            
                                                                            
                                                                            
                                                                            
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
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="divSpacing"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
           	</div>      
        </div>
    </div>
</div>
<script type="text/javascript">
	var hotel_id="{$hotel_id}";
</script>
{literal}
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        $(document).ready(function(){
            $('#checkin').datepicker({
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
                    $('#checkout').datepicker('option', {minDate: date}).datepicker('setDate', date); 
                },
                onClose: function(dateText, inst) {
                    $('#checkout').focus();
                }
            });
            $("#checkout").datepicker( { 
                dateFormat: "mm/dd/yy", 
                minDate: new Date(), maxDate: "+1Y",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                showOtherMonths: true
            });	
            $('#BookingHotel').validate();
            
            D=function(){$("#datatchchhcch").click(function(){$("#showwdatacancelpolixy").toggle()}),$("#registercustomerortherhhh").click(function(){$("#registercustomerortherhhh").is(":checked")?$("#registercustomerortherformhodonhhhh").show():$("#registercustomerortherformhodonhhhh").hide()})},w=function(){$("#registercustomerortherorder").change(function(){$("#registercustomerortherorder").is(":checked")?$("#registercustomerortherformhodon").show():$("#registercustomerortherformhodon").hide()})}
        });

        $(document).ready(function() {
            $('#registercustomerorther').live('change',function(){
                var $_this = $(this);
                if($_this.is(':checked')==1){
                $('#registercustomerortherform').show();
                }else{
                    $('#registercustomerortherform').hide();
                }
            });
            $('#registercustomerortherhhh').live('change',function(){
                var $_this = $(this);
                if($_this.is(':checked')==1){
                $('#registercustomerortherformhodonhhhh').show();
                }else{
                    $('#registercustomerortherformhodonhhhh').hide();
                }
            });
            $('#registercustomerortherorder').live('change',function(){
                var $_this = $(this);
                if($_this.is(':checked')==1){
                $('#registercustomerortherformhodon').show();
                }else{
                    $('#registercustomerortherformhodon').hide();
                }
            });
        });
    })
</script>
{/literal}
<script defer type="text/javascript" src="{$URL_JS}/bookinghotel.js"></script>