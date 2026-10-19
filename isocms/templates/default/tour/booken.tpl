<script defer type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>
<div class="tour_page" id="tour_page_container">
        <div class="container row_no_marging_padding hidden-xs">
        <div class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more pdt20">
        <div class="container">
            <ol class="breadcrumb hidden-xs" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsCountryEx->getLink($country_id,'Tour')}" title="{$clsCountryEx->getTitle($country_id)}">
						<span itemprop="name" class="reb">{$clsCountryEx->getTitle($country_id)} {$core->get_Lang('Tours')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsTour->getLink($tour_id)}" title="{$clsTour->getTitle($tour_id)}">
						<span itemprop="name" class="reb">{$clsTour->getTitle($tour_id)}</span></a>
					<meta itemprop="position" content="3" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<span itemprop="name" class="reb">{$core->get_Lang('Booking Tours')}</span>
					<meta itemprop="position" content="4" />
				</li>
            </ol>
        </div>
    </div>
    </div>
    <section id="booking" class="variantdatabg mb10">
      <div class="container">
        <div class="row">
            <div id="page-maincontent" class="col-md-12">
              <form action="" method="post" id="frmRateCruise" class="formBookingTour" novalidate="novalidate">
                <input type="hidden" id="name_tour" name="name_tour" value="{$clsTour->getTitle($tour_id)}">
                <input type="hidden" id="code_tour" name="code_tour" value="{$clsTour->getTripCode($tour_id)}">
                <input type="hidden" id="id" name="id" value="{$tour_id}">
                <div class="rightsidedata mb30">
                	<div class="row">
                    	<div class="col-md-2 col-sm-4 col-xs-12 photo">
                        	<img src="{$clsTour->getImage($tour_id,452,264)}" width="100%" at="{$clsTour->getTitle($tour_id)}"/>
                        </div>
                        <div class="titleandpackagedetails col-md-10 co-sm-8 col-xs-12">
                          <h1 class="pagemaintitle">{$clsTour->getTitle($tour_id)}</h1>
                          <div class="ratingsandotherdetails"><label class="rate-1">{$clsTour->getStarNew($tour_id)}</label>
                          <span class="spanncontentt">{$clsReviews->getToTalReview($tour_id,tour)} {$core->get_Lang('reviews')}</span>
                          <span class="inline-block">{$clsTour->getLTripDuration($tour_id,booking)}</span>
                          <span class="inline-block"> <span class="icon">l</span><span class="spanncontentt">{$clsTour->getLCityAround($tour_id)}</span></span>
                          </div>
                        </div>
                	</div>
                </div>
                <div class="infoBooking">
                    <div class="boderBooking ">
                     <div class="row">
                        <div class="col-md-5">
                       		{if $show eq 'Departure'}
                            <div class="infoTour">
                                <div class="row" style="margin:5px 0px;">
                                  <div class="has-feedback">
                                  	<h3>{$core->get_Lang('Booking Information')}</h3>
                                    <p>{$core->get_Lang('Start Date')}: <span>{$check_in_date}</span></p>
                                    <input type="hidden" name="departure_date"  value="{$departure_date}" />
                                    <p>{$core->get_Lang('End Date')}: <span>{$check_out_date}</span></p>
                                    <input type="hidden" name="end_date"  value="{$end_date}" />
                                  </div>
                                </div>
                                <div style="padding:5px;">
                                	<span class="head-book">{$core->get_Lang('Basic price')}</span>
                                    <span style="float:right">({$clsISO->getRate()})</span>
                               </div>
                               <table class="table table-bordered " width="100%">
                                  <tr>
                                    <th style="text-align:left;">{$core->get_Lang('Visitor Type')}</th>
                                    <th style="text-align:center;">{$core->get_Lang('Price')}</th>
                                    <th style="text-align:center;">{$core->get_Lang('Quality')}</th>
                                    </tr>
                                  {section name=i loop=$lstVisitorType}
                                  <tr>
                                    <td>{$lstVisitorType[i].title}</td>
									{assign var=price value=$clsTourPriceVal->getPriceBooking($lstVisitorType[i].tour_property_id,0,$departure_date_booking,$tour_id)}
									{assign var=price2 value=$clsTourPriceVal->getPriceBooking2($lstVisitorType[i].tour_property_id,0,$departure_date_booking,$tour_id)}
                                    {assign var=tripprice value=$clsTourPriceVal->getTripPriceOptionBooking($lstVisitorType[i].tour_property_id,0,$departure_date_booking,$tour_id)}
									{assign var=tripprice2 value=$clsTourPriceVal->getTripPriceOptionBooking2($lstVisitorType[i].tour_property_id,0,$departure_date_booking,$tour_id)}
                                    <td>{if $smarty.section.i.first}{$price2}{else}{$price}{/if}</td>
                                    <td>
                                      <input type="number" name="national_visitor{$lstVisitorType[i].tour_property_id}" id="national_visitor{$lstVisitorType[i].tour_property_id}" {if $smarty.section.i.first}value="{$adult}"{elseif $smarty.section.i.iteration eq 2}value="{$child}" {else}value="{$infant}"{/if} style="width: 50px;float: right;">
									  {if $smarty.section.i.first}
                                      <input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{if $tripprice2}{$tripprice2}{else}0{/if}" id="people_price{$lstVisitorType[i].tour_property_id}">
									  {else}
									  <input type="hidden" name="people_price{$lstVisitorType[i].tour_property_id}" value="{if $tripprice}{$tripprice}{else}0{/if}" id="people_price{$lstVisitorType[i].tour_property_id}">
									  {/if}
									  </td>
                                    </tr>
                                  {/section}
                                  <tr>
                                    <td colspan="2">{$core->get_Lang('Total amount')}</td>
                                    <td style="text-align:right">{$clsISO->getRate()} <span id="national_total">0</span></td>
                                  </tr>
                                  <tr>
                                  	<td colspan="2">
                                    <div class="special_select">
                                        <select class="pay_deposit" id="pay_deposit" name="pay_deposit">
                                            {assign var = deposit value=$clsTour->getOneField('deposit',$tour_id)} 
                                            {if $deposit|intval gt '0'}
                                            <option {if $deposit_Book eq $deposit}selected="selected" {/if} value="{$deposit}">{$core->get_Lang('Deposit')}</option>
                                            {/if}
                                            <option {if $deposit_Book eq '100'}selected="selected" {/if} value="100">{$core->get_Lang('Pay Full')}</option>
                                        </select>
                                        </div>
                                    </td>
                                    <td style="text-align: right;color: #000; font-size: 18px;font-weight: bold;">{$clsISO->getRate()} <span id="deposit">0</span></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">{$core->get_Lang('Remaining amount')}</td>
                                    <td style="text-align: right;color: #000; font-size: 18px;font-weight: bold;">{$clsISO->getRate()} <span id="total_remaining">0</span></td>
                                  </tr>
                                </table> 
                            </div>
                            {else}
                            <div class="infoTour">
                                <div class="row" style="margin:5px 0px;">
                                  <div class="has-feedback">
                                  	<h3>{$core->get_Lang('Booking Information')}</h3>
                                     <p style="margin-bottom:5px">{$core->get_Lang('Choose your date')}</p>
                                    <input type="text" name="departure_date" class="form-input-lg datepicker inputDate" value="{if $show eq Departure}{$departure_date}{else}{$now|date_format:"%m/%d/%Y"}{/if}" />
                                  </div>
                                </div>
                                <div style="padding:5px;"> 
                                    <span class="head-book">{$core->get_Lang('Basic price')}</span> 
                                    <span style="float:right">({$clsISO->getRate()})</span>
                                </div>
                                <table class="table table-bordered" width="100%" id="priceTableDeparture"> </table>
                            </div>
                            {/if}
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12 768left">
                            <div class="infoCustome">
                            	<h3>{$core->get_Lang('Contact Information')}</h3>
                                <table class="table contacForm" border="0">
                                  <tbody>
                                    <tr>
                                      <td style=" width:10%">{$core->get_Lang('Full name')}(<span class="price">*</span>) </td>
                                      <td style="width:50%"><input id="contact_name" name="contact_name" placeholder="{$core->get_Lang('Full name')}" type="text" value="{$name}" class="required form-control"></td> 
                                    </tr>
                                    <tr>
                                      <td style=" width:10%">{$core->get_Lang('Address')} (<span class="price">*</span>) </td>
                                      <td style=" width:50%"><input id="address" name="address" placeholder="{$core->get_Lang('Address')}" type="text" value="{$address}" class="form-control required"></td>
                                    </tr>
                                    <tr>
                                      <td>{$core->get_Lang('Phone')} (<span class="price">*</span>)</td>
                                      <td><input id="telephone" name="telephone" onkeypress="return" placeholder="{$core->get_Lang('Phone')}" type="text" value="{$phone}" class="form-control required"></td>
                                    </tr>
                                     <tr>
                                      <td>{$core->get_Lang('Nationality')}</td>
                                      <td><select name="country_id" id="country_id" class="form-control required">
                                            {$clsCountryBK->getSelectByCountry($country_id)}
                                        </select>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>{$core->get_Lang('Email')} (<span class="price">*</span>)</td>
                                      <td><input id="email" name="email" placeholder="{$core->get_Lang('Email')}" type="email" value="{$email}" class="form-control required"></td>
                                    </tr>
                                    <tr>
                                      <td >{$core->get_Lang('Request')}</td>
                                      <td><input id="note" name="note" placeholder="{$core->get_Lang('Request')}" type="text" value="" class="form-control"></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                        <div class="clearfix"></div>
                </div>
                <div class="cleafix"></div>
                    <div class="col-md-12 listCustome">
                        <h3>{$core->get_Lang('Enter a list of travelers')}</h3>
                        <div class="table table-border travelers_info">
                            <div class="mb10 hidden768 title">
                                <span>{$core->get_Lang('No.')}</span>
                                <span>{$core->get_Lang('Full name')}</span>
                                <span>{$core->get_Lang('Birthday')}</span>
                                <span>{$core->get_Lang('Address')}</span>
                                <span>{$core->get_Lang('Gender')}</span>
                                <span>{$core->get_Lang('Traveler Types')}</span>
                            </div>
                            <div id="customer_list">
                                <div>
                                    <span><input type="text" class="form-control input-sm" value="1"></span>
                                    <span><input type="text" class="form-control input-sm" name="input_0.name" id="input_0.name"></span>
                                    <span><input type="text" class="form-control input-sm datepicker inputDate" name="input_0.birthday" id="input_0.birthday"></span>
                                    
                                    <span><input type="text" class="form-control input-sm" name="input_0.address" id="input_0.address"></span>
                                    <span>
                                        <select class="form-control input-sm" name="input_0.gender" id="input_0.gender">
                                        <option value="{$core->get_Lang('Female')}">{$core->get_Lang('Female')}</option>
                                        <option value="{$core->get_Lang('Male')}">{$core->get_Lang('Male')}</option>
                                        </select>
                                    </span>
                                    <span>
                                        <select class="form-control input-sm appearance_none" name="input_0.tourist_age_type" id="input_0.tourist_age_type">
                                        <option value="{$core->get_Lang('Adult')}">{$core->get_Lang('Adult')}</option>
                                        <option value="{$core->get_Lang('Children')}">{$core->get_Lang('Children')}</option>
                                        <option value="{$core->get_Lang('Infant')}">{$core->get_Lang('Infant')}</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="cleafix"></div>
                <div class="col-sm-12 col-xs-12 fright768 block768" style="display:none; background:#fff; padding:10px; margin-bottom:15px">
                    <div class="infoCustome">
                        <h3>{$core->get_Lang('Contact Information')}</h3>
                        <table class="table" border="0">
                          <tbody>
                            <tr>
                              <td style=" width:10%">{$core->get_Lang('Full name')}(<span class="price">*</span>) </td>
                              <td style="width:50%"><input id="contact_name" name="contact_name" placeholder="{$core->get_Lang('Full name')}" required="required" type="text" value="" class="form-control"></td> 
                            </tr>
                            <tr>
                              <td style=" width:10%">{$core->get_Lang('Address')} (<span class="price">*</span>) </td>
                              <td style=" width:50%"><input id="address" name="address" placeholder="{$core->get_Lang('Address')}" required="required" type="text" value="" class="form-control"></td>
                            </tr>
                            <tr>
                              <td>{$core->get_Lang('Phone')} (<span class="price">*</span>)</td>
                              <td><input id="telephone" name="telephone" onkeypress="return" placeholder="{$core->get_Lang('Phone')}" type="text" value="" class="form-control"></td>
                            </tr>
                             <tr>
                              <td>{$core->get_Lang('Nationality')}</td>
                              <td><select name="country_id" id="country_id" class="form-control required">
                                    {$clsCountryBK->getSelectByCountry($country_id)}
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td>{$core->get_Lang('Email')} (<span class="price">*</span>)</td>
                              <td><input id="email" name="email" placeholder="{$core->get_Lang('Email')}" required="required" type="email" value="" class="form-control"></td>
                            </tr>
                            <tr>
                              <td >{$core->get_Lang('Request')}</td>
                              <td><input id="note" name="note" placeholder="{$core->get_Lang('Request')}" type="text" value="" class="form-control"></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
                <div class="cleafix"></div>
                {if $clsISO->getVar('PAYMENT_GLOBAL') eq '1'}
                	{$core->getBlock('pay_gateway')}
                {/if}
                <div class="col-md-12">
                    <input type="checkbox" class="mb10"  name="agree" value="1" checked="">
                    {$core->get_Lang('I have read and agree to the terms of use and the privacy policy')} <br>
                    <input type="hidden" id="totalgrand_price" name="totalgrand" value="0"/>
                    <input type="hidden" id="deposit_price" name="deposit" value="0"/>
                    <input type="hidden" id="balance_price" name="balance" value="0" >
                    <input type="hidden" name="result" value="0" id="result">
                    <input type="hidden" name="adult" value="0" id="adult">
                    <input type="hidden" name="child" value="0" id="child">
                    <input type="hidden" name="baby" value="0" id="baby">
                    <input type="hidden" name="booking" value="booking">
                    <input class="btn btn-orange" type="submit" name="nextstep" value="{$core->get_Lang('Submit Now')}">
                </div>
              </form>
            </div>
        </div>
      </div>
    </section>
</div>
<script type="text/javascript">
	var rate = '{$clsTour->getTripPriceOrgin($tour_id)}';
	var tour_id = '{$tour_id}';
	var departure_date = '{$departure_date}';
	var deposit = $('select[name=pay_deposit]').val();
	var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
	var Traveller = '{$core->get_lang("Traveller")}';
	var FullName = '{$core->get_lang("FullName")}';
	var DateofBirth = '{$core->get_lang("Date of Birth")}';
	var Address = '{$core->get_lang("Address")}';
	var Female = '{$core->get_lang("Female")}';
	var Male = '{$core->get_lang("Male")}';
	var Gender = '{$core->get_lang("Gender")}';
	var Adult = '{$core->get_lang("Adult")}';
	var Children = '{$core->get_lang("Children")}';
	var Infant = '{$core->get_lang("Infant")}';
</script> 
<script defer type="text/javascript" src="{$URL_JS}/bookingen.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    $('#frmRateCruise').validate();
    var $ww = $(window).width();
    if($ww>768){
      $( ".fright768" ).remove();
    }
    if($ww<=768){
      $( ".768left" ).remove();
    }
  })
</script> 
{/literal}
{if $show eq Departure}
    {literal}
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function () {
        $(function(){
            total_tourist = $("#result");
			      national_adults = $("#national_visitor16");
            national_child = $("#national_visitor17");
            national_infant = $("#national_visitor18");
            
            national_adults_price = parseInt($("#people_price16").val());
            national_child_price = parseInt($("#people_price17").val());
            national_infant_price = parseInt($("#people_price18").val());
            tinhtoan();
            national_adults.change(function(){
            if(!isNaN(parseInt($(this).val()))){
                if(parseInt($(this).val()) >= 0){
                    tinhtoan();
                }else{
                    alert(Input_data_is_invalid);
                    $(this).val(1);
                    tinhtoan();
                }
            }else{
                alert(Input_data_is_invalid);
                $(this).val(1);
                tinhtoan();
                }
            });
            national_child.change(function(){
                if(!isNaN(parseInt($(this).val()))){
                    if(parseInt($(this).val()) >= 0){
                        tinhtoan();
                    }else{
                        alert(Input_data_is_invalid);
                        $(this).val(1);
                        tinhtoan();
                    }
                }else{
                    alert(Input_data_is_invalid);
                    $(this).val(1);
                    tinhtoan();
                }
            });
            national_infant.change(function(){
                if(!isNaN(parseInt($(this).val()))){
                    if(parseInt($(this).val()) >= 0){
                        tinhtoan();
                    }else{
                        alert(Input_data_is_invalid);
                        $(this).val(1);
                        tinhtoan();
                    }
                }else{
                    alert(Input_data_is_invalid);
                    $(this).val(1);
                    tinhtoan();
                }
            });
        });
      })
    </script> 
    {/literal}
{/if}