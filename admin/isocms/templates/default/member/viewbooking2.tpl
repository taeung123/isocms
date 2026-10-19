<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('bookingmanagement')} #{$pvalTable}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
{if $oneItem.clsTable eq 'Tour'}
{assign var=BookingStore value=$clsClassTable->getBookingValue($pvalTable)}
{assign var=Currency value=$clsISO->getShortRate()}
<div class="container-fluid">
	<div class="admin-content-wrap">
    <form action="" method="post" class="form-horizontal form-edit form-table cm-processed-form cm-check-changes">
        <input type="hidden" name="booking_id" value="{$pvalTable}">
		<input type="hidden" name="update_booking" value="UPDATE">
        <script type="text/javascript">
            var number_travelers = '{$BookingStore.adult+$BookingStore.child+$BookingStore.baby}';
            var menu_content = '';
        </script>

        <!-- Actions -->
        <div class="actions cm-sticky-scroll" id="actions_panel">
            <div class="title pull-left">
                <h2>{$core->get_Lang('Order')} {$clsClassTable->getOneField('booking_code',$pvalTable)} <span class="f-middle">{$core->get_Lang('Total')}: <span> {$Currency}<span>{$clsClassTable->getOneField('totalgrand',$pvalTable)}</span></span> / {$PAGE_NAME}</span>
				<span class="f-small">/ {$clsISO->formatDateMinute($clsClassTable->getOneField('reg_date',$pvalTable))}</span>
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
                            <a href="{$PCMS_URL}/?mod={$mod}&act=editbooking&booking_id={$core->encryptID($pvalTable)}" target="_blank">{$core->get_Lang('Edit order')}  </a>
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
                            {$clsProfile->getFullname($profile_id)},
                            <a href="mailto:{$clsProfile->getEmail($profile_id)}">{$clsProfile->getEmail($profile_id)}</a>
                        </p>
                        <span>{$core->get_Lang('IP address')}:</span> {$clsISO->getRealIP()}
                        <div class="clear">
                            <span>{$core->get_Lang('Phone')}:</span>
                            <span>{$clsProfile->getPhone($profile_id)}</span>
                        </div>
                        <p>
                        </p>
                    </div>
                </div>
				{if 1 eq 2}
                <hr class="profile-info-delim">
                <div class="sidebar-row">
                    <h6>{$core->get_Lang('Shipping address')}</h6>
                    <div class="profile-info">
                        <i class="exicon-car"></i>
                        <p>{$clsProfile->getAddress($profile_id)}</p>
                        <p>
                        </p>
                    </div>
                </div>
				{/if}
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
                <div class="cm-j-tabs cm-track tabs" id="clienttabs">
                    <ul>
                        <li id="general"><a>{$core->get_Lang('General')}</a></li>
                        {if $clsISO->getVar('PAYMENT_GLOBAL') eq '1' and $lstBilling[0].billing_id ne ''}
                        <li id="voucher"><a>{$core->get_Lang('Billing Transaction')}</a></li>
                        {/if}
                        <li class="dropdown cm-subtabs subtab dropleft pull-right" style="display:none;">
                        	<a class="dropdown-toggle" data-toggle="dropdown">{$core->get_Lang('More')}<b class="caret icon-down-dir ty-icon-down-dir"></b></a>
                            <ul class="dropdown-menu"></ul>
                        </li>
                    </ul>
                </div>
				<div id="tab_content" class="cm-tabs-content" style="width:100%; float: left">
                    <div id="content_general" class="tabbox" style="display: block;">
                        <div class="row-fluid">
                            <div class="span8">
                                <table width="100%" class="table table-middle mb20">
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
                                                <br>{$core->get_Lang('Departure date')}:&nbsp;{$BookingStore.departure_date}
                                                <br>
                                                <!--pickup-detail-->
                                                {$core->get_Lang('Pickup address')}:&nbsp; {$BookingStore.pickup_address}
                                                <!--/pickup-->
                                            </td>
                                            <td style="padding: 5px 10px; background-color: #ffffff; text-align: center; font-size: 12px; font-family: Arial;">                                                <table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                               {$core->get_Lang('Adult')}
                                                            </td>
                                                            <td class="ty-right">
																 {$BookingStore.national_visitor16}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {$core->get_Lang('Child')}
                                                            </td>
                                                            <td class="ty-right">
																{$BookingStore.national_visitor17}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {$core->get_Lang('Baby')}
                                                            </td>
                                                            <td class="ty-right">
																{$BookingStore.national_visitor18}
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
																{$BookingStore.people_price16}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
																{if $BookingStore.people_price17 ne ''}
                                                                {$Currency}<span>
																{$BookingStore.people_price17}
																</span>
																{else}
																-
																{/if}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
																{if $BookingStore.people_price18 ne ''}
                                                                {$Currency}<span>
																{$BookingStore.people_price18}
																</span>
																{else}
																-
																{/if}
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
                                                                {$Currency} <span>{if $BookingStore.discount_adult gt 0}{$BookingStore.discount_adult}{else}0{/if}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                {$Currency} <span>{if $BookingStore.discount_child gt 0}{$BookingStore.discount_child}{else}0{/if}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ty-right">
                                                                 {$Currency} <span>{if $BookingStore.discount_baby gt 0}{$BookingStore.discount_baby}{else}0{/if}</span>
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
                                                        {$Currency} <span id="total_surcharge">{if $clsClassTable->getOneField('surcharge_price',$pvalTable) gt '0'}{$clsClassTable->getOneField('surcharge_price',$pvalTable)}{else}0.0{/if}</span>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td>{$core->get_Lang('Deposit')}:</td>
                                                    <td data-ct-totals="pay_deposit">
                                                        {$Currency} <span id="deposit">{if $clsClassTable->getOneField('deposit',$pvalTable) gt '0'}{$clsClassTable->getOneField('deposit',$pvalTable)}{else}0.0{/if}</span>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td>{$core->get_Lang('Pay now')}:</td>
                                                    <td data-ct-totals="payment_now">
                                                        {$Currency} <span id="deposit">{if $clsClassTable->getOneField('deposit',$pvalTable) gt '0'}{$clsClassTable->getOneField('deposit',$pvalTable)}{else}{$BookingStore.balance}{/if}</span>
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
                                            <textarea class="span12" name="customer_note" id="notes" cols="40" rows="5">{$clsClassTable->getOneField('customer_note',$pvalTable)}</textarea>
                                        </div>
                                        <div class="span6">
                                            <label for="details">{$core->get_Lang('Staff only notes')}</label>
                                            <textarea class="span12" name="staff_note" id="details" cols="40" rows="5">{$clsClassTable->getOneField('staff_note',$pvalTable)}</textarea>
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
                                                <a id="sw_select_169_wrap" class="btn-text btn dropdown-toggle cm-combination" data-toggle="dropdown">{$clsClassTable->getBookingStatus($status)}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group shift-top">
                                        <div class="control-label">
                                            <h4 class="subheader">{$core->get_Lang('Payment information')}</h4>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label">{$core->get_Lang('Method')}</div>
                                        <div id="tygh_payment_info" class="controls">{$clsISO->getPaymentMethod($BookingStore.payment_method)}</div>
                                    </div>
                                    <div class="control-group">
                                        <div class="control-label">{$core->get_Lang('Payment processor response')} </div>
                                        <div class="controls">{$core->get_Lang('Success')}</div>
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
						{if 1 eq 2}
						<div id="listTraveler" class="mt30">
							{assign var=number_travelers value=$BookingStore.adult+$BookingStore.child+$BookingStore.baby}
							<h3 class="mb10">{$core->get_Lang('List of travelers')}</h3>
								<div class="listTraveler">
										<table border="0" cellspacing="0" id="lstTraveler">
										  <tr>
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
												<td><span id="snum{$smarty.section.i.index}">{$smarty.section.i.iteration}</span></td>
												<td>
													{$nameTravelerFull}
												</td>
												<td>
													{$birthdayFull}
												</td>
												<td>
													{$addressFull}
												</td>
												<td>
													{$genderFull}
												</td>
												<td>
													{$tourist_age_typeFull}
												</td>
											  </tr>
											  {/section}
										</table>
								</div>
						</div>
						{/if}
                    </div>
                    {if $clsISO->getVar('PAYMENT_GLOBAL') eq '1' and $lstBilling[0].billing_id ne ''}
                    <div id="billing_history" class="tabbox" style="display: none;">
                    	<div class="fg-toolbar wrap">
                        	<div class="float-box fr">
                                <label>{$core->get_Lang('Currency')}</label>
                                <select onchange="changedCurrency(this);" style="width:60px">
                                    <option value="usd">USD($)</option>
                                    <option value="vnd">VND(₫)</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix mt10"></div>
                        <table cellspacing="0" class="tbl-grid" width="100%">
                            <thead><tr>
                                <td class="gridheader" style="width:40px"><strong>No.</strong></td>
                                <td class="gridheader" style="white-space:nowrap"><strong>{$core->get_Lang('Billing Method')}</strong></td>
                                <td class="gridheader column-usd" style="white-space:nowrap"><strong>{$core->get_Lang('Total')}($)</strong></td>
                                <td class="gridheader column-vnd" style="white-space:nowrap"><strong>{$core->get_Lang('Total')}(₫)</strong></td>
                                <td class="gridheader column-usd" style="white-space:nowrap"><strong>{$core->get_Lang('TotalPaid')}($)</strong></td>
                                <td class="gridheader column-vnd" style="white-space:nowrap"><strong>{$core->get_Lang('TotalPaid')}(₫)</strong></td>
                                <td class="gridheader column-usd" style="white-space:nowrap"><strong>{$core->get_Lang('Unpaid')}($)</strong></td>
                                <td class="gridheader column-vnd" style="white-space:nowrap"><strong>{$core->get_Lang('Unpaid')}(₫)</strong></td>
                                <td class="gridheader" style="white-space:nowrap"><strong>{$core->get_Lang('Status')}</strong></td>
                                <td class="gridheader" style="width:15%"><strong>{$core->get_Lang('Date')}</strong></td>
                                <td class="gridheader" style="width:8%"><strong>{$core->get_Lang('Action')}</strong></td>
                            </tr></thead>
                            {section name=i loop=$lstBilling}
                            <tr class="{cycle values="row1,row2"}">
                                <td class="index">{$smarty.section.i.iteration}</td>
                                <td>{$clsBilling->getFieldValue($lstBilling[i].billing_id,'billing_method')}</td>
                                <td class="fieldNumber column-usd">{$clsBilling->getFieldValue($lstBilling[i].billing_id,'totalgrand')}</td>
                                <td class="fieldNumber column-vnd">{$clsBilling->getFieldValue($lstBilling[i].billing_id,'totalgrand_VND')}</td>
                                <td class="fieldNumber column-usd">{$clsBilling->getFieldValue($lstBilling[i].billing_id,'deposit')}</td>
                                <td class="fieldNumber column-vnd">{$clsBilling->getFieldValue($lstBilling[i].billing_id,'deposit_VND')}</td>
                                <td class="fieldNumber column-usd">{$clsBilling->getFieldValue($lstBilling[i].billing_id,'balance')}</td>
                                <td class="fieldNumber column-vnd">{$clsBilling->getFieldValue($lstBilling[i].billing_id,'balance_VND')}</td>
                                <td>{$clsBilling->getFieldValue($lstBilling[i].billing_id,'status')}</td>
                                <td class="fieldNumber">{$clsBilling->getFieldValue($lstBilling[i].billing_id,'reg_date')}</td>
                                <td style="vertical-align: top; text-align: right; white-space: nowrap; width:5%"> 
                                    <div class="btn-group">
                                        <button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="icon-cog"></i> <span class="caret" style="margin-top:7px !important"></span>
                                        </button>
                                        <ul class="dropdown-menu" style="right:0px !important">
                                            <li><a href="{$PCMS_URL}/?mod=member&act=viewbooking&booking_id={$core->encryptID($booking_id)}">
                                                <i class="icon-edit"></i> {$core->get_Lang('View')}</a></li>
                                            <li><a href="{$PCMS_URL}/?mod=member&act=print&booking_id={$core->encryptID($listItem[i].booking_id)}">
                                                <i class="icon-print"></i> {$core->get_Lang('Print')}</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            {/section}
                        </table>
                    </div>
                    {/if}
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        var ajax_callback_data = menu_content;
    </script>
</div>
</div>
{else}
<div class="container-fluid">
	<div class="page-title">
        <h2>{$core->get_Lang('viewbooking')}
            <a href="{$PCMS_URL}/?mod={$mod}&act=print&booking_id={$core->encryptID($pvalTable)}" class="btn-print fr">
                <i class="fa fa-print"></i> {$core->get_Lang('print')}
            </a>
        </h2>
        {assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
        {if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
        {/if}
    </div>
    <div class="clearfix"></div>
    <div class="bookingItem">
        <div class="bookingTop">
            <div class="row">
                <div class="col-sm-1">
                    <div class="pic_hotel">
                        <img src="{$clsTable->getImage($target_id,193,129)}" class="static" width="90" height="60" alt="{$clsTable->getTitle($target_id)}" style="height: 60px; width: 90px;">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="detail_hotel_booking">
                        <p class="content_blue">
                            <b>
                                <a class="hotelLinks" href="{$clsTable->getLink($target_id)}" title="{$clsTable->getTitle($target_id)}">{$clsTable->getTitle($target_id)}</a>
                            </b>
                        </p>
                        {if $oneItem.clsTable eq 'Hotel'}
                            {if $clsTable->getAddress($target_id) ne ''}
                                <p class="address"><i class="fa fa-map-marker"></i> {$clsTable->getAddress($target_id)}</p>
                             {/if}
                        {else}
                            {if $clsTable->getCityAround($target_id) ne ''}
                                <p class="address"><i class="fa fa-map-marker"></i> {$clsTable->getCityAround($target_id)}</p>
                             {/if}
                         {/if}
                        <div class="clear">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
         <div class="clear"></div>
        <div class="allbox">
            {assign var=BookingStore value=$clsClassTable->getBookingValue($pvalTable)}
            <div class="row">
                {if $oneItem.clsTable eq 'Cruise'}
                <div class="allbox_left col-sm-6">
                    <p class="booking_left">
                        {$core->get_Lang('Booking ID')}
                    </p>
                    <p class="booking_right">
                        {$clsClassTable->getOneField('booking_code',$pvalTable)}
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Check-in')}:
                    </p>
                    <p class="booking_right">
                        <span>{$BookingStore.departure_date}</span>
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Check-out')}:
                    </p>
                    <p class="booking_right">
                        <span>{$clsClassTable->getOneField('check_out',$pvalTable)}</span>
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Cabin of name')}:
                    </p>
                    <p class="booking_right">
                        {$clsCruiseCabin->getTitle($BookingStore.cruise_cabin_id)}
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Number of Cabin')}
                    </p>
                    <p class="booking_right">
                        {$BookingStore.number_room}
                    </p>
                </div>
                <div class="allbox_right col-sm-4">
                	<p>
                        <span class="date_hotel_on">{$core->get_Lang('Booked on')}</span> 
                        <span class="date_hotel">{$clsISO->converTimeToText($clsClassTable->getOneField('reg_date',$pvalTable))}</span>
                    </p>
                    <p class="mt10">
                        <span class="money_hotel">{$clsISO->getRate()} {$BookingStore.totalGrand}</span>
                    </p>
                    <div>
                        <p class="text_conditions">
                            <span title="Any cancellation received within 1 day prior to arrival date will incur the first night charge. Failure to arrive at your hotel will be treated as a No-Show and will incur the first night charge (Hotel policy).">{$core->get_Lang('Booking Conditions')} <i class="ficon ficon-10 ficon-hover-details"></i></span>
                        </p>
                    </div>
                </div>
                {elseif  $oneItem.clsTable eq 'Hotel'}
                <div class="allbox_left col-sm-6">
                    <p class="booking_left">
                        {$core->get_Lang('Booking ID')}
                    </p>
                    <p class="booking_right">
                        {$clsClassTable->getOneField('booking_code',$pvalTable)}
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Check-in')}:
                    </p>
                    <p class="booking_right">
                        
                        <span>{$BookingStore.checkin}</span>
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Check-out')}:
                    </p>
                    <p class="booking_right">
                        <span>{$BookingStore.checkout}</span>
                    </p>
                </div>
                <div class="allbox_right col-sm-4">
                    <p>
                        <span class="money_hotel">{$clsTable->getPrice($target_id)}</span>
                    </p>
                    <div>
                        <p class="text_conditions">
                            <span title="Any cancellation received within 1 day prior to arrival date will incur the first night charge. Failure to arrive at your hotel will be treated as a No-Show and will incur the first night charge (Hotel policy).">{$core->get_Lang('Booking Conditions')} <i class="ficon ficon-10 ficon-hover-details"></i></span>
                        </p>
                    </div>
                </div>
                {else}
                <div class="allbox_left col-sm-6">
                    <p class="booking_left">
                        {$core->get_Lang('Booking ID')}
                    </p>
                    <p class="booking_right">
                        {$clsClassTable->getOneField('booking_code',$pvalTable)}
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Check-in')}:
                    </p>
                    <p class="booking_right">
                        <span>{$BookingStore.departure_date}</span>
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Check-out')}:
                    </p>
                    <p class="booking_right">
                        <span>{if $BookingStore.end_date ne ''}{$BookingStore.end_date}{else}{$clsClassTable->getOneField('check_out',$pvalTable)}&nbsp;{/if}</span>
                    </p>
                </div>
                <div class="allbox_right col-sm-4">
                    <p>
                        <span class="money_hotel">{$clsISO->getRate()} {$BookingStore.totalGrand}</span>
                    </p>
                    <div>
                        <p class="text_conditions">
                            <span title="Any cancellation received within 1 day prior to arrival date will incur the first night charge. Failure to arrive at your hotel will be treated as a No-Show and will incur the first night charge (Hotel policy).">{$core->get_Lang('Booking Conditions')} <i class="ficon ficon-10 ficon-hover-details"></i></span>
                        </p>
                    </div>
                </div>
                {/if}
            </div>
        </div>
    </div>
    <div class="clearfix mt10"></div>
    <form id="newitem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="row-field">
            <div class="row-heading">{$core->get_Lang('detailbooking')} {$oneItem.booking_code}</div>
            <div class="coltrols">{$clsClassTable->getBookingHTML($pvalTable)}</div>
        </div>
        <div class="row-field">
            <div class="row-heading">{$core->get_Lang('Note Booking')}</div>
            <div class="coltrols">{$clsForm->showInput('note')}</div>
        </div>
        {if $oneItem.status eq '1'}
        <div class="row-field">
            <div class="row-heading">{$core->get_Lang('Send Email Support Booking')}*</div>
            <div class="coltrols">
                <input type="checkbox" name="sendmail" id="sendmail" value="1" {if $oneItem.is_send_email eq '1'}checked="checked"{/if} />
                <label for="status">&nbsp;&nbsp;{$core->get_Lang('Tick choose if send email')}!</label>
            </div>
        </div>
        {else}
        <div class="row-field">
            <div class="row-heading">{$core->get_Lang('processbooking')}*</div>
            <div class="coltrols">
                <input type="checkbox" name="status" id="status" value="1" {if $oneItem.status eq '1'}checked="checked"{/if} />
                <label for="status">&nbsp;{$core->get_Lang('Tick choose if this Booking already dealing')}!</label>
            </div>
        </div>
        {/if}
        <fieldset class="submit-buttons">
            {$saveBtn} {$resetBtn}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
{literal}
<style type="text/css">
	td{ font-size:13px !important}
	.hidden { display:none !important}
	.form-group{margin-bottom:10px;}
	.form-group label{width:150px; text-align:right; display: inline-block; line-height:32px}
	.form-group .col-right{width:300px;display: inline-block}
	.form-group input{width:100%; padding:0 10px; line-height:32px}
	.bookingItem {
		width: 100%;
		margin-top: 20px;
		position: relative;
	}
	.bookingItem .col-sm-3{width:25%;float:left}
	.bookingItem .col-sm-9{width:75%;float:left}
	#tab_content .col-sm-9{width:75%;float:left}
	.bookingItem .col-sm-2{width:16.6%; display:inline-block; float:left}
	.bookingItem .col-sm-4{width:33.3%; display:inline-block; float:left}
	#tab_content .col-sm-6{width:50%;float:left}
	.bookingItem .col-sm-8{width:66.6%; display:inline-block; float:left}
	.col-sm-1{width:8.3%; display:inline-block; float:left}
	.col-sm-6{width:50%;float:left}
	.col-sm-8{width:66.6%; display:inline-block; float:left}
	.allbox_right {
		text-align: right;
		position: relative;
	}
	.money_hotel {
		font-size: 16px;
		color: #000;
		font-weight: 700;
	}
	.date_hotel_booking{text-align:right}
	.allbox {
		width: 100%;
		padding: 12px 12px 16px;
		margin-top: 10px;
		background-color: #fcfcfc;
		border: 1px solid #ebebeb;
		height: auto;
	}
	.allbox p, .detail_hotel_booking p {
		margin-bottom: 0;
		margin-top: 0;
	}
	.address {
		font-size: 13px;
		color: #666;
	}
	.booking_left {
		text-align: right;
		width: 40%;
		margin-top: 5px;
		font-weight: 700;
		color: #000;
	}
	.booking_right {
		text-align: left;
		width: 55%;
		margin-left: 4%;
		color: #666;
	}
	.booking_left,
	.booking_right {
		position: relative;
		float: left;
		font-size: 13px;
		white-space: normal;
	}
	.text_conditions, .text_conditions span {
		font-size: 11px;
		color: #36B66F;
	}
	.allbox .manage_booking, .buttonconnect, .css3button, .css3button1 {
		border: 1px solid #2ca4fb;
		background-color: #2ca4fb;
	}
	.allbox .manage_booking, .button_loginemail, .buttonconnect, .css3button, .css3button1, .css3buttoncancel, .submit_reviews {
		color: #fff;
		cursor: pointer;
		text-align: center;
	}
	.allbox .manage_booking, .allbox .submit_reviews, .button_loginemail, .buttonconnect, .css3button, .css3button1, .css3buttoncancel {
		border-radius: 7px;
		-webkit-border-radius: 7px;
		-moz-border-radius: 7px;
	}
	.allbox .manage_booking {
		padding: 5px 15px;
	}
	.rate-1{padding:0}
	.rate-1, .rate-1 span {
		display: inline-block;
		width: 77px;
		height: 13px;
		background: url(/isocms/templates/default/skin/images/rate-1.png) repeat-x 0 -13px;
	}
	.rate-1 span {
		display: inline-block;
		background-position: 0 0;
	}
	</style>
{/literal}
{/if}
<link rel="stylesheet" href="{$URL_CSS}/viewbooking.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript">
var Input_data_is_invalid = "{$core->get_Lang('Input data is invalid')}";
var national_adults = "{if $BookingStore.national_visitor16 gt '0'}{$BookingStore.national_visitor16}{else}0{/if}";
var national_child = "{if $BookingStore.national_visitor17 gt '0'}{$BookingStore.national_visitor17}{else}0{/if}";
var national_infant = "{if $BookingStore.national_visitor18 gt '0'}{$BookingStore.national_visitor18}{else}0{/if}";

var national_adults_price = "{if $BookingStore.people_price16 gt '0'}{$BookingStore.people_price16}{else}0{/if}";
var national_child_price = "{if $BookingStore.people_price17 gt '0'}{$BookingStore.people_price17}{else}0{/if}";
var national_infant_price = "{if $BookingStore.people_price18 gt '0'}{$BookingStore.people_price18}{else}0{/if}";

var discount_adult = "{if $BookingStore.discount_adult gt '0'}{$BookingStore.discount_adult}{else}0{/if}";
var discount_child = "{if $BookingStore.discount_child gt '0'}{$BookingStore.discount_child}{else}0{/if}";
var discount_baby = "{if $BookingStore.discount_baby gt '0'}{$BookingStore.discount_baby}{else}0{/if}";

var total_surcharge = "{if $BookingStore.surcharge_price gt '0'}{$BookingStore.surcharge_price}{else}0{/if}";
var deposit = "{if $clsClassTable->getOneField('deposit',$pvalTable) gt '0'}{$clsClassTable->getOneField('deposit',$pvalTable)}{else}0{/if}";

</script>
{literal}
<script type="text/javascript">
$(function(){

	tinhtoan();
});
Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function tinhtoan(){
	var totalgrand1 = document.getElementById("totalgrand1");
	var totalgrand2 = document.getElementById("totalgrand2");
	var totalgrand4 = document.getElementById("totalgrand4");
	var adult_discount = document.getElementById("discount_adult");
	var child_discount = document.getElementById("discount_child");
	var baby_discount = document.getElementById("discount_baby");
	var total_discount = document.getElementById("total_discount");
	var total_price_adult = document.getElementById("total_price_adult");
	var total_price_child = document.getElementById("total_price_child");
	var total_price_baby = document.getElementById("total_price_baby");
	
	if(national_adults > 0 && national_adults_price >0 && discount_adult >0){
		var discount_adult_price=parseFloat(discount_adult);
	}else{
		var discount_adult_price=0;
	}
		
	if(national_child> 0 && national_child_price >0 && discount_child>0){
		var discount_child_price=parseFloat(discount_child);
	}else{
		var discount_child_price=0;
	}
	
	if(national_infant > 0 && national_infant_price>0 && discount_baby >0){
		var discount_baby_price=parseFloat(discount_baby);
	}else{
		var discount_baby_price=0;
	}
	var national = (parseInt(national_adults) * national_adults_price - discount_adult_price)
		+ (parseInt(national_child) * national_child_price - discount_child_price)
		+ (parseInt(national_infant) * national_infant_price - discount_baby_price);
	var national_on_surcharge = ((parseInt(national_adults) * national_adults_price) - discount_adult_price)
		+ ((parseInt(national_child) * national_child_price) - discount_child_price)
		+ ((parseInt(national_infant) * national_infant_price)- discount_baby_price) + parseFloat(total_surcharge);		
	var national_on_deposit = ((parseInt(national_adults) * national_adults_price) - discount_adult_price)
		+ ((parseInt(national_child) * national_child_price) - discount_child_price)
		+ ((parseInt(national_infant) * national_infant_price)- discount_baby_price) + parseFloat(total_surcharge)-parseFloat(deposit);		
	
	var national_price_peple = (parseInt(national_adults) * national_adults_price)
		+ (parseInt(national_child) * national_child_price)
		+ (parseInt(national_infant) * national_infant_price);
	var total_price_discount = (discount_adult_price)
		+ (discount_child_price)
		+ (discount_baby_price);
	var total_adult_price = (parseInt(national_adults)) * (national_adults_price) - discount_adult_price;
	var total_child_price = (parseInt(national_child)) * (national_child_price) - discount_child_price;
	var total_baby_price = (parseInt(national_infant)) * (national_infant_price) - discount_baby_price;
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
	
	total_discount.innerHTML = total_price_discount;
	totalgrand1.innerHTML = national;
	totalgrand2.innerHTML = national_price_peple;
	totalgrand4.innerHTML = national_on_deposit;
}
function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	console.log(x);
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
function changedCurrency(_this){
	var $cu = $(_this).val();
	var $hd = 'usd';
	if($cu=='usd') $hd = 'vnd';
	$('.column-'+$hd).hide();
	$('.column-'+$cu).show();
}
</script> 
{/literal}
