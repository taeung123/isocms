<div class="page_container mb80">
    <div id="content">
        <div class="container">
            <div id="breadcrumb" class="mb30">
                <div class="breadcrumb">
                    <ul itemscope itemtype="http://schema.org/BreadcrumbList">
                        <li itemprop="name"><a href="{$PCMS_URL}" title="{$core->get_Lang('home')}" itemprop="url">{$core->get_Lang('home')}</a></li>
                        <li><span>›</span></li>
                        <li itemprop="name"><a href="{$clsHotel->getLink($hotel_id)}" title="{$clsHotel->getTitle($hotel_id)}" itemprop="url">{$clsHotel->getTitle($hotel_id)}</a></li>
                        <li><span>›</span></li>
                        <li itemprop="name"><a title="{$core->get_Lang('Booking Hotels')}" itemprop="url">{$core->get_Lang('Booking Hotels')}</a></li>
                    </ul>
                </div>
            </div>
            <div class="hotel-decrition intro14_5">
            	 <section id="booking" class="rowbox primary">
        			<div class="row">
                        <div class="col-md-12 mt20">
                            <h1 class="headMod font27px">{$core->get_Lang('Submit your booking')}</h1>
                            <div class="booking_box">
                                <div class="row">
                                    <div class="col-st-7">
                                        <h2>{$clsHotel->getTitle($hotel_id)}</h2> <div class="clearfix"></div>
                                        <address class="font14px">{$clsHotel->getAddress($hotel_id)}</address>
                                    </div>
                                    <div class="col-st-5">
                                        <h4 class="price text-right">{$core->get_Lang('Price')}: <span>{$clsHotel->getPrice($hotel_id)}</span></h4> 
                                    </div>
                                </div>
                            </div>
                            {literal}
                            <style type="text/css">
                                @media (min-width: 992px){.booking_box .price{ margin-top:30px !important}}
                            </style>
                            {/literal}
                        </div>
                        <div class="form-book">
                            <div class="col-md-12">
                                <i class="note font13px">
                                    {$core->get_Lang('The fields with')} <em class="requied">*</em> {$core->get_Lang('are compulsory')}
                                </i>
                                {if $err_msg ne ''}
                                <div class="message_box corner-3px mtmm">{$err_msg}</div>
                                {/if}
                            </div>
                            <div class="wrap mtl">
                                <form id="BookingHotel" class="frmCrxBook form-horizontal" method="post" action="">
                                    <div class="wrap mtm">
                                        <div class="col-md-6 mbl">
                                            <h3 class="head">{$core->get_Lang('Contact information')}</h3>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label title" for="name">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('fullname')}
                                                </label>
                                                <div class="col-md-9">
                                                    <input class="required form-control" id="name" name="name"  type="text" value="{$name}" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label title" for="email">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('Email')}
                                                </label>
                                                <div class="col-md-9">
                                                    <input class="required email form-control" id="email" name="email"  type="email" value="{$email}" />
                                                    <p class="help-block"><em class="requied">*</em> {$core->get_Lang("If you don't receive our answer after 1 working day, please check your spam email. It may go to your spam mailbox")}. </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label title" for="phone">
                                                    {$core->get_Lang('Phone no')}
                                                </label>
                                                <div class="col-md-9">
                                                    <input class="required form-control" id="phone" name="phone"  type="text" value="{$phone}" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label title" for="country_id">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('Nationality')}
                                                </label>
                                                <div class="col-md-9">
                                                    <select class="selectbox required" name="country_id" id="country_id">
                                                        {$clsCountryLt->getSelectByCountry($country_id)}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mbl">
                                            <h3 class="head">{$core->get_Lang('Reservation Information')}</h3>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label title" for="checkin">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('Check in date')}
                                                </label>
                                                <div class="col-md-8">
                                                    <input name="checkin" autocomplete="off" maxlength="10" id="checkin" value="{$checkin}" size="15" class="dateTxt required" placeholder="mm/dd/yyyy" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label title" for="checkout">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('Check out date')}
                                                </label>
                                                <div class="col-md-8">
                                                    <input name="checkout" autocomplete="off" maxlength="10" id="checkout" value="{$checkout}" size="15" class="dateTxt required" placeholder="mm/dd/yyyy" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label title">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('No of guest')}
                                                </label>
                                                <div class="col-md-8 group_box">
                                                    <div class="line">
                                                        <div class="w30 fl">
                                                            <select class="selectbox" name="adult" id="adult" style="width:100%; padding:4px">
                                                                {$clsISO->getSelect(1,10,$adult)}
                                                            </select>
                                                        </div>
                                                        <label class="tit_1">{$core->get_Lang('Adult(s)')} (&gt; 12 years old):</label>
                                                    </div>
                                                    <div class="line" style="margin-bottom:0px !important">
                                                        <div class="w30 fl">
                                                            <select class="selectbox" name="children" id="children">
                                                                {$clsISO->getSelect(0,10,$children)}
                                                            </select>
                                                        </div>
                                                        <label class="tit_1">{$core->get_Lang('Children')} (2-12 years old):</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label title" for="required">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('Special request')}
                                                </label>
                                                <div class="col-md-8">
                                                    <textarea cols="44" rows="5" name="request" class="required">{$request}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label title" for="secure_code">
                                                    <abbr class="required" title="required">*</abbr> {$core->get_Lang('securecode')}
                                                </label>
                                                <div class="col-md-8">
                                                    <input autocomplete="off" type="text" class="form-control security_code required" name="secure_code" value="" maxlength="5" />
                                                    <img src="{$PCMS_URL}/captcha.php?sid={$sid}" width="80" height="32" alt="Secure" />
                                                </div>
                                            </div>
                                            <div class="form-group mtl">
                                            	<div class="col-md-4"></div> 
                                                <div class="col-md-8">
                                                    <input type="hidden" value="book" name="book" />
                                                    <input type="hidden" value="{$hotel_id}" name="hotel_id" />
                                                    <button type="submit" class="submitBtn"><strong>{$core->get_Lang('Book now')}</strong></button>
                                                    <button type="reset" class="submitBtn"> <strong>{$core->get_Lang('Cancel')}</strong> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
        });
    })
</script>
{/literal}