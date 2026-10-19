<script defer type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_CSS}/bookinghotel.css?v={$upd_version}" type="text/css">
<div class="page_container">
    <nav class="breadcrumb-main breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsHotel->getLink($hotel_id)}" title="{$clsHotel->getTitle($hotel_id)}" itemprop="url">
					   <span itemprop="name" class="reb">{$clsHotel->getTitle($hotel_id)}</span></a>
					<meta itemprop="position" content="2" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active">
                  <a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$clsHotel->getTitle($hotel_id)}" itemprop="url">
					  <span itemprop="name" class="reb">{$clsHotel->getTitle($hotel_id)}</span></a>
				   <meta itemprop="position" content="3" />
               </li>
            </ol>
        </div>
    </nav>
    <section id="content" class="pd40_0">
        <div class="container">
			<h1 class="size30 pane-title mb30">{$core->get_Lang('Submit your booking')}</h1>
            <div class="hotel-decrition intro14_5">
            	 <section id="booking" class="rowbox primary">
					<div class="bk_header_box">
						<div class="hotelName">
							<h2 class="size27">{$clsHotel->getTitle($hotel_id)}</h2> <div class="clearfix"></div>
							<address class="mb0 color_666"><i class="fa fa-map-marker"></i> {$clsHotel->getAddress($hotel_id)}</address>
						</div>
						<div class="price_box text_right">
						{$core->get_Lang('Price')} <span class="block">{$clsHotel->getPrice($hotel_id)}</span>
						</div>
					</div>
					{literal}
					<style type="text/css">
						@media (min-width: 992px){.booking_box .price{ margin-top:30px !important}}
					</style>
					{/literal}
					<div class="form-book mt40">
						<div class="noteBox">
							<i class="note font13px mb10">
								{$core->get_Lang('The fields with')} <em class="requied">*</em> {$core->get_Lang('are compulsory')}
							</i>
							{if $err_msg ne ''}
							<div class="message_box corner-3px mtmm">{$err_msg}</div>
							{/if}
						</div>
						<div class="wrap mtl">
							<form id="BookingHotel" class="frmCrxBook form-horizontal" method="post" action="">
								<div class="row mtm">
									<section class="col-md-6 mbl">
										<div class="contact_info">
											<h3 class="head">{$core->get_Lang('Contact information')}</h3>
											<div class="form-group">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="name">
													{$core->get_Lang('Full Name')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<input class="required form-control" id="name" name="name"  type="text" value="{$name}" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="email">
													{$core->get_Lang('Email')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<input class="required email form-control" id="email" name="email"  type="email" value="{$email}" />
													<p class="help-block size12 mb0"><em class="requied">*</em> {$core->get_Lang("If you don&#39;t receive our answer after 1 working day, please check your spam email. It may go to your spam mailbox")}. </p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="phone">
													{$core->get_Lang('Phone number')}
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<input class="required form-control" id="phone" name="phone"  type="text" value="{$phone}" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="country_id">
													{$core->get_Lang('Nationality')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<select class="selectbox selectCountry required" name="country_id" id="country_id">
														{$clsCountryLt->getSelectByCountry($country_id)}
													</select>
												</div>
											</div>
										</div>
									</section>
									<section class="col-md-6 mbl">
										<div class="reservation_info">
											<h3 class="head">{$core->get_Lang('Reservation Information')}</h3>
											<div class="form-group w50_500">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="checkin">
													{$core->get_Lang('Check in date')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<input name="checkin" autocomplete="off" maxlength="10" id="checkin" value="{$checkin}" size="15" class="dateTxt required" placeholder="mm/dd/yyyy" />
												</div>
											</div>
											<div class="form-group w50_500">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="checkout">
													{$core->get_Lang('Check out date')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<input name="checkout" autocomplete="off" maxlength="10" id="checkout" value="{$checkout}" size="15" class="dateTxt required" placeholder="mm/dd/yyyy" />
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title">
													{$core->get_Lang('No of guest')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8 group_box">
													<div class="line">
														<div class="w100 fl">
															<select class="selectbox" name="adult" id="adult" style="width:100%;">
																{$clsISO->getSelect(1,10,$adult)}
															</select>
														</div>
														<label class="tit_1">{$core->get_Lang('Adult(s)')} ({$core->get_Lang('&gt; 12 years old')}):</label>
													</div>
													<div class="line" style="margin-bottom:0px !important">
														<div class="w100 fl">
															<select class="selectbox" name="children" id="children">
																{$clsISO->getSelect(0,10,$children)}
															</select>
														</div>
														<label class="tit_1">{$core->get_Lang('Children')} ({$core->get_Lang('2-12 years old')}):</label>
													</div>
												</div>
											</div>
											<div class="form-group w50_500">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="checkin">
													{$core->get_Lang('Room type')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<select class="selectbox selectRoom" name="hotel_room_id" id="hotel_room_id">
														{section name=i loop=$allHotelRoom}
															<option value="{$allHotelRoom[i].hotel_room_id}">{$clsHotelRoom->getTitle($allHotelRoom[i].hotel_room_id)}</option>
														{/section}
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title" for="required">
													{$core->get_Lang('Special request')} <span class="color_r">*</span>
												</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<textarea cols="44" rows="5" name="request" class="required">{$request}</textarea>
												</div>
											</div>
											<div class="form-group">
												{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
												<label class="col-md-4 control-label title" for="secure_code">
													<abbr class="required" title="required">*</abbr> {$core->get_Lang('securecode')}
												</label>
												<div class="col-md-8">
													<input autocomplete="off" type="text" class="form-control security_code required" name="secure_code" value="" maxlength="5" />
													<img src="{$PCMS_URL}/captcha.php?sid={$sid}" width="80" height="36" alt="Secure" />
												</div>
												{else}
												<label class="col-md-4 col-sm-4 col-xs-4 control-label title hidden500">&nbsp;</label>
												<div class="col-md-8 col-sm-8 col-xs-8">
													<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
												</div>
												{/if}
											</div>
											<div class="form-group mtl">
												<div class="col-md-4 col-sm-4 col-xs-4"></div> 
												<div class="col-md-8 col-sm-8 col-xs-8">
													<input type="hidden" value="book" name="book" />
													<input type="hidden" value="{$hotel_id}" name="hotel_id" />
													<button type="submit" class="submitBtn btn_main"><strong>{$core->get_Lang('Book now')}</strong></button>
													<button type="reset" class="submitBtn btn_main"> <strong>{$core->get_Lang('Cancel')}</strong> </button>
												</div>
											</div>
										</div>
									</section>
								</div>
							</form>
						</div>
					</div>
                </section>
           	</div>      
        </div>
    </section>
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
		});
	})
</script>
{/literal}