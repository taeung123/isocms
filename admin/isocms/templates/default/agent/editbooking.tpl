<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('bookingmanagement')} #{$pvalTable}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
{assign var=BookingStore value=$clsClassTable->getBookingValue($pvalTable)}
{assign var=Currency value=$clsISO->getShortRate()}
<div class="container-fluid">
	<div class="admin-content-wrap">
    <form action="" method="post" class="form-horizontal form-edit form-table cm-processed-form cm-check-changes">
		<input type="hidden" id="name_tour" name="name_tour" value="{$BookingStore.name_tour}">
		<input type="hidden" id="code_tour" name="code_tour" value="{$BookingStore.code_tour}">
		<input type="hidden" id="id" name="id" value="{$id}">
		<input type="hidden" id="contact_name" name="contact_name" value="{$BookingStore.contact_name}">
		<input type="hidden" id="address" name="address" value="{$BookingStore.address}">
		<input type="hidden" id="telephone" name="telephone" value="{$BookingStore.telephone}">
		<input type="hidden" id="country_id" name="country_id" value="{$BookingStore.country_id}">
		<input type="hidden" id="email" name="email" value="{$BookingStore.email}">
		<input type="hidden" id="note" name="note" value="{$BookingStore.note}">
		<input type="hidden" id="totalgrand3" name="totalgrand" value="0">
		<input type="hidden" id="balance_price" name="balance" value="0" >
		<input type="hidden" name="result" value="0" id="result">
		<input type="hidden" name="adult" value="0" id="adult">
		<input type="hidden" name="child" value="0" id="child">
		<input type="hidden" name="baby" value="0" id="baby">
        <input type="hidden" name="booking_id" value="{$pvalTable}">
		<input type="hidden" name="update_booking" value="UPDATE">
        <script type="text/javascript">
            // Init ajax callback (rebuild)
			var number_travelers = '{$BookingStore.adult+$BookingStore.child+$BookingStore.baby}';
            var menu_content = '';
        </script>

        <!-- Actions -->
        <div class="actions cm-sticky-scroll" id="actions_panel">
            <div class="title pull-left">
                <h2>{$core->get_Lang('Order')} {$clsClassTable->getOneField('booking_code',$pvalTable)} <span class="f-middle">{$core->get_Lang('Total')}: <span> $<span>{$clsClassTable->getOneField('totalgrand',$pvalTable)}</span></span> / {$PAGE_NAME}</span>
				<span class="f-small">
						/ {$clsISO->formatDateMinute($clsClassTable->getOneField('reg_date',$pvalTable))}
				</span>
			</h2>
            </div>
            <div class="btn-bar btn-toolbar dropleft pull-right">
                <div class="btn-group prev-next">
					{if  $bookingPrevItem eq ''}
					<a class="btn cm-tooltip disabled"><i class="icon-chevron-left"></i></a>
					{else}
					<a class="btn cm-tooltip " href="{$PCMS_URL}/?mod=member&act=viewbooking&booking_id={$core->encryptID($bookingPrevItem)}" title="Booking {$bookingPrevItem}"> <i class="icon-chevron-left"></i> </a>
					{/if}
					
					{if  $bookingNextItem eq ''}
					<a class="btn cm-tooltip disabled"><i class="icon-chevron-right"></i></a>
					{else}
					  <a class="btn cm-tooltip " href="{$PCMS_URL}/?mod=member&act=viewbooking&booking_id={$core->encryptID($bookingNextItem)}" title="Booking {$bookingNextItem}"> <i class="icon-chevron-right"></i> </a>
					{/if}
                </div>

                <div class="btn-group dropleft">
                    <a class="btn iso-button-standard dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-cog"></i>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_id={$core->encryptID($pvalTable)}" class="cm-new-window" target="_blank">{$core->get_Lang('Print invoice')} </a>
                        </li>
                        <li>
                            <a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_id={$core->encryptID($pvalTable)}" target="_blank"> {$core->get_Lang('Print invoice')} (pdf)</a>
                        </li>
						{if 1 eq 2}
                        <li>
                            <a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_id={$core->encryptID($pvalTable)}" class="cm-new-window" target="_blank">{$core->get_Lang('Print packing slip')} </a>
                        </li>
                        <li>
                            <a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_id={$core->encryptID($pvalTable)}" class="cm-new-window" target="_blank"> {$core->get_Lang('Print packing slip')} (pdf) </a>
                        </li>
						{/if}
                        <li>
                            <a href="{$PCMS_URL}/?mod={$mod}&act=viewbooking&booking_id={$core->encryptID($pvalTable)}" target="_blank">{$core->get_Lang('View order')}  </a>
                        </li>
                    </ul>
                </div>
                <div class="btn-group btn-hover dropleft">
                    <button type="submit" class="btn btn-primary cm-submit cm-no-ajax" name="updateBooking" value="Update"> {$core->get_Lang('Save changes')}</button>
                    <ul class="dropdown-menu">
                        <li>
                            <a>
                                <input type="checkbox" name="notify_user" id="notify_user" value="Y"> {$core->get_Lang('Notify customer')}</a>
                        </li>
                        <li>
                            <a>
                                <input type="checkbox" name="notify_department" id="notify_department" value="Y"> {$core->get_Lang('Notify orders department')}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--actions_panel-->
        </div>
        <div class="clearfix"></div>
        <div class="sidebar sidebar-left" id="elm_sidebar">
            <div class="sidebar-wrapper">
                <div class="sidebar-row">
                    <h6>{$core->get_Lang('Customer information')}</h6>
                    <div class="profile-info">
                        <i class="icon-user"></i>
                        <p class="strong">
                            {$clsAgent->getFullname($agent_id)},
                            <a href="mailto:{$clsAgent->getEmail($agent_id)}">{$clsAgent->getEmail($agent_id)}</a>
                        </p>
                        <span>{$core->get_Lang('IP address')}:</span> {$clsISO->getRealIP()}
                        <div class="clear">
                            <span>{$core->get_Lang('Phone')}:</span>
                            <span>{$clsAgent->getPhone($agent_id)}</span>
                        </div>
                        <p>
                        </p>
                    </div>
                </div>
                <hr class="profile-info-delim">
                <div class="sidebar-row">
                    <h6>{$core->get_Lang('Billing address')}</h6>
                    <div class="profile-info">
                        <i class="icon-tag"></i>
                        <p class="strong">{$BookingStore.address}</p>
                    </div>
                </div>
                <hr class="profile-info-delim">
            </div>
            <!--elm_sidebar-->
        </div>
        <!--Content-->
        <div class="content ufa">
            <div class="content-wrap">
                <div class="cm-j-tabs cm-track tabs">
                    <ul class="nav nav-tabs" id="clienttabs">
                        <li id="general" class="">
                            <a>{$core->get_Lang('General')}</a>
                        </li>
                        <li class="dropdown cm-subtabs subtab dropleft pull-right" style="display: none;"><a class="dropdown-toggle" data-toggle="dropdown">{$core->get_Lang('More')}<b class="caret icon-down-dir ty-icon-down-dir"></b></a>
                            <ul class="dropdown-menu"></ul>
                        </li>
                    </ul>
                </div>
				<div id="tab_content" class="cm-tabs-content" style="width:100%; float: left">
                    <div id="content_general" class="tabbox" style="display: block;" >
                        <div class="row-fluid">
                            <div class="span8">
                                <table width="100%" class="table table-middle">
                                    <thead>
                                        <tr>
                                            <th width="50%">{$core->get_Lang('Product')}</th>
                                            <th class="center" width="10%">{$core->get_Lang('Quantity')}</th>
                                            <th width="10%">{$core->get_Lang('Price')}</th>
                                            <th width="5%">{$core->get_Lang('Discount')}</th>
                                            <th width="5%">{$core->get_Lang('Pickup')}</th>
                                            <th width="10%" class="right">&nbsp;{$core->get_Lang('Subtotal')}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 5px 10px; background-color: #ffffff; font-size: 12px; font-family: Arial;">
                                                {$clsTable->getTitle($target_id)}
                                                <p style="margin: 2px 0px 3px 0px;">{$core->get_Lang('CODE')}: {$clsTable->getTripCode($target_id)}</p>
                                                {$core->get_Lang('Product option')}:&nbsp;GROUP TOUR
                                                <br>{$core->get_Lang('Departure date')}:&nbsp;<input type="text" name="departure_date" id="departure_date" value="{if $clsClassTable->getOneField('departure_date',$pvalTable) ne ''}{$clsClassTable->getOneField('departure_date',$pvalTable)}{else}{$BookingStore.departure_date}{/if}" class="boder_none" width="100%"/>
                                                <br>
                                                <!--pickup-detail-->
                                                {$core->get_Lang('Pickup address')}:&nbsp; <textarea type="text" name="pickup_address"  class="boder_none" style="height:80px; width:100%"/>{if $clsClassTable->getOneField('pickup_address',$pvalTable) ne ''}{$clsClassTable->getOneField('pickup_address',$pvalTable)}{else}{$BookingStore.pickup_address}{/if}</textarea>
                                                <!--/pickup-->
                                            </td>
                                            <td style="padding: 5px 10px; background-color: #ffffff; text-align: center; font-size: 12px; font-family: Arial;">                                                <table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                               {$core->get_Lang('Adult')}
                                                            </td>
                                                            <td class="ty-right">
																<input type="number" name="national_visitor16" value="{$BookingStore.national_visitor16}" id="national_visitor16" class="boder_none" style="width:40px"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {$core->get_Lang('Child')}
                                                            </td>
                                                            <td class="ty-right">
																<input type="number" name="national_visitor17" value="{$BookingStore.national_visitor17}" id="national_visitor17" class="boder_none" style="width:40px"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {$core->get_Lang('Baby')}
                                                            </td>
                                                            <td class="ty-right">
																<input type="number" name="national_visitor18" value="{$BookingStore.national_visitor18}" id="national_visitor18" class="boder_none" style="width:40px"/>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td style="padding: 5px 10px; background-color: #ffffff; text-align: right; font-size: 12px; font-family: Arial;">
                                                <table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
                                                    <tbody>
                                                        <tr>
                                                            <td class="ty-right">
                                                                {$Currency}<span>
																<input type="text" name="people_price16" value="{$BookingStore.people_price16}" id="people_price16" class="boder_none" style="width:60px"/></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                {$Currency}<span>
																<input type="text" name="people_price17" value="{$BookingStore.people_price17}" id="people_price17" class="boder_none" style="width:60px"/></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                {$Currency}<span>
																<input type="text" name="people_price18" value="{$BookingStore.people_price18}" id="people_price18" class="boder_none" style="width:60px"/>
																</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td style="padding: 5px 10px; background-color: #ffffff; text-align: right; font-size: 12px; font-family: Arial;">
                                                <table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
                                                    <tbody>
                                                        <tr>
                                                            <td class="ty-right">

                                                                {$Currency} <span><input type="text" name="discount_adult" value="{$BookingStore.discount_adult}" id="discount_adult" class="boder_none" style="width:40px"/></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                {$Currency} <span><input type="text" name="discount_child" value="{$BookingStore.discount_child}" id="discount_child" class="boder_none" style="width:40px"/></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                 {$Currency} <span><input type="text" name="discount_baby" value="{$BookingStore.discount_baby}" id="discount_baby" class="boder_none" style="width:40px"/></span>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                            <td style="padding: 5px 10px; background-color: #ffffff; text-align: right; font-size: 12px; font-family: Arial;">
                                                <table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
                                                    <tbody>
                                                        <tr>
                                                            <td class="ty-right">
                                                               {$Currency} <span id="total_price_adult">{$BookingStore.people_price16*$BookingStore.adult}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                {$Currency} <span id="total_price_child">{$BookingStore.people_price17*$BookingStore.child}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                {$Currency} <span id="total_price_baby">{$BookingStore.people_price18*$BookingStore.baby}</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td style="padding: 5px 10px; background-color: #ffffff; text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"><b>
    {$Currency}<span id="totalgrand1">{$BookingStore.totalgrand}</span>
</b>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="order-notes statistic">

                                    <div class="clearfix">
                                        <table class="pull-right">
                                            <tbody>
                                                <tr class="totals">
                                                    <td>&nbsp;</td>
                                                    <td width="100px">
                                                        <h4>{$core->get_Lang('Totals')}</h4>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>{$core->get_Lang('Total amount')}:</td>
                                                    <td data-ct-totals="subtotal">{$Currency}<span id="totalgrand2">{$BookingStore.totalgrand}</span></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{$core->get_Lang('Including discount')}:</td>
                                                    <td data-ct-totals="including_discount">
                                                        {$Currency}<span id="total_discount">0.0</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{$core->get_Lang('Payment surcharge')}:</td>
                                                    <td data-ct-totals="payment_surcharge">
                                                        {$Currency} <span><input type="text" value="{if $clsClassTable->getOneField('surcharge_price',$pvalTable) gt '0'}{$clsClassTable->getOneField('surcharge_price',$pvalTable)}{else}0.0{/if}" name="total_surcharge" id="total_surcharge" style="width:35px"/></span>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td>{$core->get_Lang('Deposit')}:</td>
                                                    <td data-ct-totals="payment_deposit">
                                                        {$Currency} <span><input type="text" value="{if $clsClassTable->getOneField('deposit',$pvalTable) gt '0'}{$clsClassTable->getOneField('deposit',$pvalTable)}{else}0.0{/if}" name="deposit" id="deposit" style="width:60px; text-align:right"/></span>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td>{$core->get_Lang('Pay now')}:</td>
                                                    <td data-ct-totals="pay_now">
                                                        {$Currency} <span id="pay_now">{if $clsClassTable->getOneField('deposit',$pvalTable) gt '0'}{$clsClassTable->getOneField('deposit',$pvalTable)}{else}{$BookingStore.balance}{/if}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4>{$core->get_Lang('Remaining amount')}:</h4>
                                                    </td>
                                                    <td class="price" data-ct-totals="total">
                                                        {$Currency}<span id="totalgrand4">{$BookingStore.balance}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									{if 1 eq 2}
                                    <div class="note clearfix">
                                        <div class="span6">
                                            <label for="details">{$core->get_Lang('Customer notes')}</label>
                                            <textarea class="span12" name="customer_note" id="notes" cols="40" rows="5">{$BookingStore.customer_note}</textarea>
                                        </div>
                                        <div class="span6">
                                            <label for="details">{$core->get_Lang('Staff only notes')}</label>
                                            <textarea class="span12" name="staff_note" id="details" cols="40" rows="5">{$BookingStore.staff_note}</textarea>
                                        </div>
                                    </div>
									<div class="center">
										<img src="{$URL_IMAGES}/admin199.png" alt="BarCode" width="250" height="60">
									</div>
									{/if}
                                </div>
                                
                            </div>
                            <div class="span4">
                                <div class="well orders-right-pane form-horizontal">
                                    <div class="control-group">
                                        <div class="control-label">
                                            <h4 class="subheader">{$core->get_Lang('Status')}</h4>
                                        </div>
                                        <div class="controls">
											{assign var=status value=$clsClassTable->getOneField('status',$pvalTable)}
                                            <div class="cm-popup-box dropleft dropdown dropleft">
                                                <a id="sw_select_169_wrap" class="btn-text btn dropdown-toggle cm-combination" data-toggle="dropdown">
												
                       {$clsClassTable->getBookingStatus($status)}<span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li {if $status eq '5'}class="disabled"{/if}><a class="update_status" data="5" booking_id="{$pvalTable}" href="javascript:void(0);">{$core->get_Lang('Backordered')}</a></li>
                                                    <li {if $status eq '6'}class="disabled"{/if}><a class="update_status {if $status eq '6'}active{/if}" data="6" booking_id="{$pvalTable}" href="">{$core->get_Lang('Complete')}</a></li>
                                                    <li {if $status eq '4'}class="disabled"{/if}><a class="update_status {if $status eq '4'}active{/if}" data="4" booking_id="{$pvalTable}" href="javascript:void(0);">{$core->get_Lang('Declined')}</a></li>
                                                    <li {if $status eq '3'}class="disabled"{/if}><a class="update_status {if $status eq '3'}active{/if}" data="3" booking_id="{$pvalTable}" href="javascript:void(0);" >{$core->get_Lang('Failed')}</a></li>
                                                    <li {if $status eq '2'}class="disabled"{/if}><a class="update_status {if $status eq '2'}active{/if}" data="2" booking_id="{$pvalTable}" href="javascript:void(0);" >{$core->get_Lang('Canceled')}</a></li>
                                                    <li {if $status eq '1'}class="disabled"{/if}><a class="update_status {if $status eq '1'}active{/if}" data="1" booking_id="{$pvalTable}" href="javascript:void(0);">{$core->get_Lang('Open')}</a></li>
                                                    <li {if $status eq '0'}class="disabled"{/if}><a class="update_status {if $status eq '0'}active{/if}" data="0" booking_id="{$pvalTable}" href="javascript:void(0);">{$core->get_Lang('Processed')}</a></li>
                                                    <li>
                                                        <a>
                                                            <label for="select_169_notify">
                                                                <input type="checkbox" name="__notify_user" id="select_169_notify" value="Y" checked="checked">{$core->get_Lang('Notify customer')}</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <label for="select_169_notify_department">
                                                                <input type="checkbox" name="__notify_department" id="select_169_notify_department" value="Y" checked="checked"> {$core->get_Lang('Notify orders department')}</label>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group shift-top">
                                        <div class="control-label">
                                            <h4 class="subheader">
    {$core->get_Lang('Payment information')}
    </h4>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label">{$core->get_Lang('Method')}</div>
                                        <div id="tygh_payment_info" class="controls">
										<select id="paymentMethod" name="payment_method" style="width:100%">
											<option {if $BookingStore.payment_method eq '1'} selected="selected" {/if} value="1">{$core->get_Lang('Cash payments')}</option>
											<option {if $BookingStore.payment_method eq '2'} selected="selected" {/if} value="2">{$core->get_Lang('Bank Transfer')}</option>
											<option {if $BookingStore.payment_method eq '3'} selected="selected" {/if} value="3">{$core->get_Lang('ONEPAY Inbound')}</option>
											<option {if $BookingStore.payment_method eq '4'} selected="selected" {/if} value="4">{$core->get_Lang('ONEPAY Outbound')}</option>
										</select>
										</div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label">
                                            {$core->get_Lang('Payment processor response')} </div>
                                        <div class="controls">
                                            {$core->get_Lang('Success')}
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label">
                                            {$core->get_Lang('Order status')} </div>
                                        <div class="controls">
											 {$clsClassTable->getBookingStatus($status)}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						<div id="listTraveler" class="mt30">
							{assign var=number_travelers value=$BookingStore.adult+$BookingStore.child+$BookingStore.baby}
							<h3 class="mb10">{$core->get_Lang('Add Remove a list of travelers')}</h3>
								<div class="listTraveler">
										<div class="buttonAddRemoveTraveler">
											<button type="button" class="delete mt10 buttonTraveler">- {$core->get_Lang('Delete')}</button>
											<button type="button" class="addmore mt10 buttonTraveler">+ {$core->get_Lang('Add More')}</button>
										</div>
										<table border="0" cellspacing="0" id="lstTraveler">
										  <tr>
											<th><input class="check_all" type="checkbox" onclick="select_all()"/></th>
											<th>No.</th>
											<th>{$core->get_Lang('Full Name')}</th>
											<th>{$core->get_Lang('Birthday')}</th>
											<th>{$core->get_Lang('Address')}</th>
											<th>{$core->get_Lang('Gender')}</th>
											<th>{$core->get_Lang('Traveler Types')}</th>
										  </tr>
											{section name=i loop=$number_travelers}
											{assign var=idx value=$smarty.section.i.index}
											{assign var = nameTraveler value = 'input_'|cat:$idx|cat:'_name'}
											{assign var = nameTravelerFull value = $BookingStore.$nameTraveler}
											{assign var = birthday value = 'input_'|cat:$idx|cat:'_birthday'}
											{assign var = birthdayFull value = $BookingStore.$birthday}
											{assign var = address value = 'input_'|cat:$idx|cat:'_address'}
											{assign var = addressFull value = $BookingStore.$address}
											{assign var = gender value = 'input_'|cat:$idx|cat:'_gender'}
											{assign var = genderFull value = $BookingStore.$gender}
											{assign var = tourist_age_type value = 'input_'|cat:$idx|cat:'_tourist_age_type'}
											{assign var = tourist_age_typeFull value = $BookingStore.$tourist_age_type}
											{assign var = tourist_age_type value = 'input_'|cat:$idx|cat:'_tourist_age_type'}
											{assign var = tourist_age_typeFull value = $BookingStore.$tourist_age_type}
											  <tr>
												<td><input type="checkbox" class="case"/></td>
												<td><span id="snum{$smarty.section.i.index}">{$smarty.section.i.iteration}</span></td>
												<td>
													<input type="text"  name="input_{$smarty.section.i.index}.name" id="input_{$smarty.section.i.index}.name" value="{$nameTravelerFull}"/>
												</td>
												<td>
													<input type="text" class="form-control input-sm datepicker inputDate" name="input_{$smarty.section.i.index}.birthday" id="input_{$smarty.section.i.index}.birthday" value="{$birthdayFull}">
												</td>
												<td>
													<input type="text" class="form-control input-sm" name="input_{$smarty.section.i.index}.address" id="input_{$smarty.section.i.index}.address" value="{$addressFull}" style="width:200px">
												</td>
												<td>
													<select class="form-control input-sm" name="input_{$smarty.section.i.index}.gender" id="input_{$smarty.section.i.index}.gender" style="width:100px">
														<option {if $genderFull eq 'Female'} selected="selected"{/if} value="{$core->get_Lang('Female')}">{$core->get_Lang('Female')}</option>
														<option {if $genderFull eq 'Male'} selected="selected"{/if} value="{$core->get_Lang('Male')}">{$core->get_Lang('Male')}</option>
												</select>
											</td>
												<td>
													<select class="form-control input-sm appearance_none" name="input_{$smarty.section.i.index}.tourist_age_type" id="input_{$smarty.section.i.index}.tourist_age_type" style="width:120px">
														<option {if $tourist_age_typeFull eq 'Adult'} selected="selected"{/if} value="{$core->get_Lang('Adult')}">{$core->get_Lang('Adult')}</option>
														<option {if $tourist_age_typeFull eq 'Children'} selected="selected"{/if} value="{$core->get_Lang('Children')}">{$core->get_Lang('Children')}</option>
														<option {if $tourist_age_typeFull eq 'Infant'} selected="selected"{/if} value="{$core->get_Lang('Infant')}">{$core->get_Lang('Infant')}</option>
													</select>
												</td>
											  </tr>
											  {/section}
										</table>
								</div>
								{literal}
								<script type="text/javascript">
								$(".delete").on('click', function() {
									$('.case:checkbox:checked').parents("tr").remove();
									$('.check_all').prop("checked", false); 
									check();
								});
								var i=number_travelers;
								$(".addmore").on('click',function(){
									count=$('table#lstTraveler tr').length;
									var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
									data +="<td><input type='text' id='input_"+i+".name' name='input_"+i+".name'/></td> ";
									data +="<td><input type='text' class='form-control input-sm datepicker2 inputDate hasDatepicker' placeholder='mm-dd-yyyy' id='input_"+i+".birthday' name='input_"+i+".birthday'/></td>";
									
									data +="<td><input type='text' id='input_"+i+".address' name='input_"+i+".address' style='width:200px' /></td>";
									data +="<td><select id='input_"+i+".gender' name='input_"+i+".gender'  style='width:100px'><option value='Female'>Female</option><option value='Male'>Male</option></select></td>";
									
									data +="<td><select  id='input_"+i+".tourist_age_type' name='input_"+i+".tourist_age_type' style='width:120px'><option value='Adults'>Adults</option><option value='Children'>Children</option><option value='Infant'>Infant</option></select></td></tr>";
									$('table#lstTraveler').append(data);
									$(".datepicker2").datepicker({
										altFormat: "mm-dd-yy",
										dateFormat: "mm-dd-yy",
										changeMonth: true,
										changeYear: true,
										yearRange: '1900:Y',
										minDate: new Date(1900, 10 - 1, 25),
									});
									i++;
								});
								function select_all() {
									$('input[class=case]:checkbox').each(function(){ 
										if($('input[class=check_all]:checkbox:checked').length == 0){ 
											$(this).prop("checked", false); 
										} else {
											$(this).prop("checked", true); 
										} 
									});
								}
								
								function check(){
									obj=$('table#lstTraveler tr').find('span');
									$.each( obj, function( key, value ) {
									id=value.id;
									$('#'+id).html(key+1);
									});
									}
								
								</script>
								{/literal}
						</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        var ajax_callback_data = menu_content;
    </script>
</div>
</div>
{literal}
<script type="text/javascript">
 $(document).on('click', '.update_status', function(ev) {
	var $_this = $(this);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajUpdateStatusBooking',
		data: {
			'booking_id': $_this.attr('booking_id'),
			'status':  $_this.attr('data'),
		},
		dataType: 'html',
		success: function(html) {
			location.href = REQUEST_URI;
		}
	});
});

</script>
{/literal}
<link rel="stylesheet" href="{$URL_CSS}/viewbooking.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript">
var Input_data_is_invalid = "{$core->get_Lang('Input data is invalid')}";
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
var numberTraveler='{$number_travelers}';
</script>
{literal}
<script type="text/javascript">
	$(function(){
		$('#departure_date').datepicker({
			minDate : new Date(),
			DateFormat: "mm-dd-yy",
			changeMonth: true,
			changeYear: true,
		});
		$('.datepicker').datepicker({
			minDate : new Date(),
			DateFormat: "mm-dd-yy",
			changeMonth: true,
			changeYear: true,
		});
		
		national_adults = $("#national_visitor16");
		national_child = $("#national_visitor17");
		national_infant = $("#national_visitor18");
		
		national_adults_price =$("#people_price16");
		national_child_price =$("#people_price17");
		national_infant_price =$("#people_price18");
		
		discount_adult =$("#discount_adult");
		discount_child =$("#discount_child");
		discount_baby =$("#discount_baby");
		
		total_surcharge =$("#total_surcharge");
		deposit =$("#deposit");
		
		tinhtoan();
		national_adults.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) > 0){
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
		national_adults_price.change(function(){
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
		discount_adult.change(function(){
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
		national_child_price.change(function(){
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
		discount_child.change(function(){
		if(national_child.val() >0 && national_child_price.val() >0){
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
		}else{
			alert(Input_data_is_invalid);
			$(this).val(0);
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
		national_infant_price.change(function(){
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
		discount_baby.change(function(){
		if(national_infant.val() >0 && national_infant_price.val() >0){
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
		}else{
			alert(Input_data_is_invalid);
			$(this).val(0);
			tinhtoan();
		}
		});
		total_surcharge.change(function(){
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
		deposit.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert(Input_data_is_invalid);
				$(this).val(0);
				tinhtoan();
			}
		}else{
			alert(Input_data_is_invalid);
			$(this).val(0);
			tinhtoan();
		}
		});
		
	});
Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function tinhtoan(){
	var totalgrand1 = document.getElementById("totalgrand1");
	var totalgrand2 = document.getElementById("totalgrand2");
	var totalgrand3 = document.getElementById("totalgrand3");
	var totalgrand4 = document.getElementById("totalgrand4");
	
	var adult_discount = document.getElementById("discount_adult");
	var child_discount = document.getElementById("discount_child");
	var baby_discount = document.getElementById("discount_baby");
	var total_discount = document.getElementById("total_discount");
	var total_price_adult = document.getElementById("total_price_adult");
	var total_price_child = document.getElementById("total_price_child");
	var total_price_baby = document.getElementById("total_price_baby");
	var pay_now = document.getElementById("pay_now");
	var tong = parseInt(national_adults.val()) + 
		parseInt(national_child.val()) + 
		parseInt(national_infant.val());

	if(national_adults.val() > 0 && national_adults_price.val() >0 && parseFloat(discount_adult.val()) >0){
		var discount_adult_price=parseFloat(discount_adult.val());
	}else{
		var discount_adult_price=0;
	}
		
	if(national_child.val() > 0 && national_child_price.val() >0 && parseFloat(discount_child.val())>0){
		var discount_child_price=parseFloat(discount_child.val());
	}else{
		var discount_child_price=0;
	}
	
	if(national_infant.val() > 0 && national_infant_price.val() >0 && parseFloat(discount_baby.val()) >0){
		var discount_baby_price=parseFloat(discount_baby.val());
	}else{
		var discount_baby_price=0;
	}
	var national = (parseInt(national_adults.val()) * (national_adults_price.val()) - discount_adult_price)
		+ (parseInt(national_child.val()) * (national_child_price.val()) - discount_child_price)
		+ (parseInt(national_infant.val()) * (national_infant_price.val()) - discount_baby_price);
	var national_on_surcharge = (parseInt(national_adults.val()) * (national_adults_price.val()) - discount_adult_price)
		+ (parseInt(national_child.val()) * (national_child_price.val()) - discount_child_price)
		+ (parseInt(national_infant.val()) * (national_infant_price.val()) - discount_baby_price) + (parseFloat(total_surcharge.val()));
	var national_on_deposit = (parseInt(national_adults.val()) * (national_adults_price.val()) - discount_adult_price)
		+ (parseInt(national_child.val()) * (national_child_price.val()) - discount_child_price)
		+ (parseInt(national_infant.val()) * (national_infant_price.val()) - discount_baby_price) + (parseFloat(total_surcharge.val()))-(parseFloat(deposit.val()));		
	var national_price_peple = (parseInt(national_adults.val()) * (national_adults_price.val()))
		+ (parseInt(national_child.val()) * (national_child_price.val()))
		+ (parseInt(national_infant.val()) * (national_infant_price.val()));
	var total_price_discount = (discount_adult_price)
		+ (discount_child_price)
		+ (discount_baby_price);
	var total_adult_price = (parseInt(national_adults.val()) * (national_adults_price.val()) - discount_adult_price);
	var total_child_price = (parseInt(national_child.val()) * (national_child_price.val()) - discount_child_price);
	var total_baby_price = (parseInt(national_infant.val()) * (national_infant_price.val()) - discount_baby_price);
	if (!isNaN(tong)){
		$('#adult').val(parseInt(national_adults.val()));
		$('#child').val(parseInt(national_child.val()));
		$('#baby').val(parseInt(national_infant.val()));
		if(national>0){
			national=national
		}else{
			national=0;
		}
		if(total_adult_price >0){
			total_price_adult.innerHTML = total_adult_price.format();
		}else{
			total_price_adult.innerHTML = 0;
		}
		if(total_child_price >0){
			total_price_child.innerHTML = total_child_price.format();
		}else{
			total_price_child.innerHTML = 0;
		}
		if(total_baby_price >0){
			total_price_baby.innerHTML = total_baby_price.format();
		}else{
			total_price_baby.innerHTML = 0;
		}
		adult_discount.value = discount_adult_price;
		child_discount.value=discount_child_price;
		baby_discount.value = discount_baby_price;
		if(parseFloat(deposit.val())> parseFloat(national_on_surcharge)){
			alert('Erorr');
			deposit.val(national_on_surcharge);
			pay_now.innerHTML = national_on_surcharge;
		}else{
			pay_now.innerHTML = parseFloat(deposit.val());
		}
		
		if(parseFloat(deposit.val())==0){
			pay_now.innerHTML = national_on_surcharge;
		}
		
		total_discount.innerHTML = total_price_discount;
		totalgrand1.innerHTML = national;
		totalgrand2.innerHTML = national_price_peple;
		totalgrand3.value = national_on_surcharge;
		if(national_on_deposit > 0){
			totalgrand4.innerHTML = national_on_deposit;
		}else{
			totalgrand4.innerHTML = 0;
		}
		
		
	}else{
		alert('Error');
	}
}


</script> 
{/literal}
