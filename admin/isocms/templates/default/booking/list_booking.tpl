<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />
<script type="text/javascript" src="{$URL_JS}/list_booking_v2.js?v={$upd_version}"></script>

<div id="page_v2" class="page_container booking-list-page">
    <div class="page-title d-flex booking-legacy-heading">
        <div class="title">
            <h2>{$core->get_Lang('Bán hàng')}
                <div class="info_module" data-toggle="tooltip" data-placement="right"
                     title="Chức năng quản lý danh sách booking trong hệ thống isoCMS">i
                </div>
            </h2>
            <p>{$totalItem} {$core->get_Lang('booking')}</p>

        </div>
        <div class="button_right">
           <button
    type="button"
    class="btn btn-main btn-addnew btn_addBooking"
    title="{$core->get_Lang('Create Booking')}"
    data-bs-toggle="modal"
    data-bs-target="#addBooking"
>
    {$core->get_Lang('Create Booking')}
</button>
        </div>
    </div>
    <!--    modal-->
<div
    class="modal right fade"
    id="addBooking"
    tabindex="-1"
    aria-labelledby="addBookingLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">

            <form
                method="post"
                id="frmForm"
                class="frmform"
                enctype="multipart/form-data"
            >
                <div class="modal-header">
                    <div class="content_head">

                            <div class="text_booking">
                                <p class="booking_name" id="addBookingLabel">
                                    {$core->get_Lang('booking')} {$core->get_Lang('new')}
                                </p>
                                <p class="status">
                                    {$core->get_Lang('Create by')}
                                    <span class="name_create_by">
                                        {$clsUser->getOneField('first_name',$_loged_id)}
                                        {$clsUser->getOneField('last_name',$_loged_id)}
                                    </span>
                                </p>
                            </div>
                        </a>

                        <div class="box_button">
                            <button
                                type="button"
                                class="btn_cancel close_modal_booking btn_cancel_booking"
                                data-bs-dismiss="modal"
                            >
                                {$core->get_Lang('Cancel')}
                            </button>

                            <button
                                type="button"
                                class="btn_submit btnClickToSubmitBooking"
                            >
                                {$core->get_Lang('Complete')}
                            </button>
                        </div>
                    </div>
                </div>

              
					<div class="modal-body">
							<div class="box_section box_contact">
								<a class="btn btn-primary btn_title" role="button" data-bs-toggle="collapse" data-bs-target="#collapseContact" aria-expanded="true" aria-controls="collapseContact">
                                    {$core->get_Lang('Customers')} ({$core->get_Lang('contact')})</a>
								<div class="box_form collapse show" id="collapseContact">
									<div class="row">
										<div class="col-lg-3 d-flex justify-content-between">
											<div class="inp_full_name">
												<input name="fullname" class="text full required" value="" placeholder="{$core->get_Lang('Fullname')}*" type="text"/>
											</div>											
											<div class="box_inp_fullname">
												<input class="text full" id="full_name" name="full_name" value="" type="text" placeholder="{$core->get_Lang('Fullname')}*"/>
											</div>
											<button
    class="btn-main btn_addCustomer"
    id="btn_addCustomer"
    type="button"
    data-bs-toggle="modal"
    data-bs-target="#addCustomer"
>
    <i class="fa fa-plus"></i>
</button>										
											
										</div>
										<div class="col-lg-3">
											<input class="text full birthday" name="birthday" value="" type="text" placeholder="{$core->get_Lang('Birthday')}"/>
										</div>
										<div class="col-lg-3">
											<input class="text full required" name="email" value="" type="text" placeholder="{$core->get_Lang('Email')}*" />
										</div>
										<div class="col-lg-3">
											<input class="text full required" name="phone" value="" type="text" placeholder="{$core->get_Lang('Phone')}*" />
										</div>
										<div class="col-lg-3">
											<select name="country_id" id="country_id" class="iso-selectbox required" id="">
												<option value="">{$core->get_Lang('Country')}*</option>
												{$clsCountry->getSelectByCountry('',false)}
											</select>
										</div>					
										<div class="col-lg-6">
											<input class="text full" name="address" value="" type="text" placeholder="{$core->get_Lang('Address')}" />
										</div>
									</div>
								</div>
							</div>
							<div class="box_section box_product_service">
								<span class="text_error" hidden>{$core->get_Lang('You have not selected a product/service')}</span>
								<a
    class="btn btn-primary btn_title"
    role="button"
    data-bs-toggle="collapse"
    data-bs-target="#collapseProduct"
    aria-expanded="true"
    aria-controls="collapseProduct"
>
    {$core->get_Lang('Inventory')}


</a>

<div
    class="collapse show"
    id="collapseProduct"
>
									<div class="box_total_price">{$core->get_Lang('Total')}: <span class="total_price"><span id="total_price">0</span> {$clsISO->getShortRate()}</span><input id="inp_total_price" type="hidden" value="0"/></div>
									<div class="box_form">
										<div class="row">
											<div class="col-lg-3">
												<select class="form-control iso-selectbox" onchange="show_option_product(this)" name="product_group">
													<option value="">{$core->get_Lang('Group product')}</option>
													<option value="tour">{$core->get_Lang('Tour')}</option>
													<option value="hotel">{$core->get_Lang('Hotel')}</option>
													<option value="cruise">{$core->get_Lang('Cruise')}</option>
													{*<option value="combo">{$core->get_Lang('Combo')}</option>*}
													<option value="voucher">{$core->get_Lang('Voucher')}</option>
												</select>
											</div>							
											<div id="box_option_product">					
												
											</div>
										</div>
										<div id="box_booking">
										</div>
									</div>
								</div>						
							</div>
							<div class="box_section box_note_booking">
								<a
    class="btn btn-primary btn_title"
    role="button"
    data-bs-toggle="collapse"
    data-bs-target="#collapseNoteBooking"
    aria-expanded="true"
    aria-controls="collapseNoteBooking"
>
    {$core->get_Lang('Special Requests')}


</a>

<div
    class="box_form collapse show"
    id="collapseNoteBooking"
>
									<div class="row">
										<div class="col-lg-12">
											<textarea class="txt_note" name="customer_note" id="" cols="30" rows="10" placeholder="{$core->get_Lang('Special Requests')}"></textarea>
										</div>	
									</div>
								</div>
							</div>
							<div class="box_section box_info_price_booking">
							<a
    class="btn btn-primary btn_title"
    role="button"
    data-bs-toggle="collapse"
    data-bs-target="#collapseInfoPriceBooking"
    aria-expanded="true"
    aria-controls="collapseInfoPriceBooking"
>
    {$core->get_Lang('Billing Information')}


</a>

<div
    class="collapse show"
    id="collapseInfoPriceBooking"
>
									<div class="box_form box_form_price">
										<div class="row">
											<div class="col-lg-12">
												<div class="box_billing">
													<label class="lbl_billing lbl_total">{$core->get_Lang('Total')}</label>
													<span class="price"><span id="price_total">0</span> {$clsISO->getShortRate()}</span>
													<input type="hidden" id="inp_price_total" name="price_total" value="0" />
												</div>
											</div>	
											<div class="col-lg-12">
												<div class="box_billing price_deposit">
													<label class="lbl_billing">{$core->get_Lang('Deposit')}</label>
													<span class="price"><span id="price_deposit">0</span> {$clsISO->getShortRate()}</span>
													<input type="hidden" id="inp_price_deposit" name="price_deposit" value="0" />
												</div>									
											</div>	
											<div class="col-lg-12">
												<div class="box_billing">
													<label class="lbl_billing">{$core->get_Lang('Final Payment')}</label>
													<span class="price"><span id="price_final_payment">0</span> {$clsISO->getShortRate()}</span>
													<input type="hidden" id="inp_price_final_payment" name="price_final_payment" value="0" />
												</div>									
											</div>
											<div class="col-lg-12">
												<div class="box_billing mb0">
													<label class="lbl_billing lbl_total_payment">{$core->get_Lang('Total payment')}</label>
													<span class="price"><span id="price_total_payment">0</span> {$clsISO->getShortRate()}</span>
													<input type="hidden" id="inp_price_total_payment" name="price_total_payment" value="0" />
												</div>									
											</div>	
										</div>
									</div>							
									<div class="payment_tab">
										<div class="payment-choice">
											<input type="radio" class="chkPayment" name="payment_method" checked="checked" value="{$PAYMENT_CASH_ID}">
											<span class="lbl_pay">{$core->get_Lang('Direct payment')}</span>
										</div>
										<div class="payment-choice">
											<input type="radio" class="chkPayment" name="payment_method" value="{$PAYMENT_TRANSFER_ID}">
											<span class="lbl_pay">{$core->get_Lang('Transfer payments / ATM')}</span>
										</div>
										<div class="payment-choice">
											<input type="radio" class="chkPayment" name="payment_method" value="{$PAYMENT_VNPAY_GATEWAY}">
											<span class="lbl_pay">{$core->get_Lang('Payment by card / VNPAY')}</span>
										</div>
										<div class="payment-choice">
											<input type="radio" class="chkPayment" name="payment_method" value="{$PAYMENT_ONEPAY_ATM}">
											<span class="lbl_pay">{$core->get_Lang('Pay with OnePAY')}</span>
										</div>
									</div>
								</div>

							</div>
						</div>
                <div class="modal-footer">
                    <div class="box_button">
                        <div class="box_billing mb0">
                            <label class="lbl_billing lbl_total_payment">
                                {$core->get_Lang('Total payment')}
                            </label>
                            <span class="price">
                                <span id="price_total_payment_footer">0</span>
                                {$clsISO->getShortRate()}
                            </span>
                        </div>
                        <button
                            type="button"
                            class="btn_cancel close_modal_booking btn_cancel_booking"
                            data-bs-dismiss="modal"
                        >
                            {$core->get_Lang('Cancel')}
                        </button>
                        <button
                            type="button"
                            class="btn_submit btnClickToSubmitBooking"
                        >
                            {$core->get_Lang('Complete')}
                        </button>
                    </div>
                </div>
	            </form>

        </div>
    </div>
</div>
	<div class="modal right fade" id="addCustomer" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">	
				<div class="box_section box_contact">
					<div class="btn btn-primary btn_title">
						{$core->get_Lang('Customers')} ({$core->get_Lang('contact')})
					</div>
					<div class="box_form">
						<form action="" method="" id="frmAddCustomer" onsubmit="return false">
							<div class="row">
								<div class="col-lg-6">
									<input class="text full required" name="full_name_new" value="" type="text" placeholder="{$core->get_Lang('Fullname')}*"/>
								</div>
								<div class="col-lg-6">
									<input class="text full birthday" name="birthday_new" value="" type="text" placeholder="{$core->get_Lang('Birthday')}"/>
								</div>
								<div class="col-lg-6">
									<input class="text full required" name="email_new" value="" type="text" placeholder="{$core->get_Lang('Email')}*" />
								</div>
								<div class="col-lg-6">
									<input class="text full required" name="phone_new" value="" type="text" placeholder="{$core->get_Lang('Phone')}*" />
								</div>
								<div class="col-lg-6">
									<select name="country_id_new" class="iso-selectbox required" id="">
										<option value="">{$core->get_Lang('Country')}*</option>
										{$clsCountry->getSelectByCountry('',false)}
									</select>
								</div>					
								<div class="col-lg-6">
									<input class="text full" name="address_new" value="" type="text" placeholder="{$core->get_Lang('Address')}" />
								</div>				
								<div class="col-lg-12 text-right">
									<button
    type="button"
    class="btn_cancel close_modal_booking"
    data-bs-dismiss="modal"
>
    {$core->get_Lang('Cancel')}
</button>
									<button class="btn_submit btn-main btnClickToSubmitAddCustomer">{$core->get_Lang('Submit')}</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
    <main class="iso-module-list iso-bookings-list">
        {capture name=booking_header_actions}
            <button type="button" class="v2-btn v2-btn--add booking-create-btn btn_addBooking" data-bs-toggle="modal" data-bs-target="#addBooking">
                <i class="fa fa-plus"></i> {$core->get_Lang('Create Booking')}
            </button>
        {/capture}
        {capture name=booking_header_count}{$totalItem} {$core->get_Lang('booking')}{/capture}
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard')
            header_module_label=$core->get_Lang('Bookings')
            header_title=$core->get_Lang('Order/Booking')
            header_count=$smarty.capture.booking_header_count
            header_subtitle=$core->get_Lang('Manage all bookings from tours, hotels, cruises and more.')
            header_actions=$smarty.capture.booking_header_actions
            header_setting_url=""
            header_setting_label=$core->get_Lang('Setting')
        }

        <section class="booking-kpi-grid">
            <article class="booking-kpi-card booking-kpi-card--blue"><span class="booking-kpi-icon"><i class="fa fa-cog"></i></span><div><label>{$core->get_Lang('Total Bookings')}</label><strong>{$kpi_total}</strong><small>{$core->get_Lang('All bookings')}</small></div></article>
            <article class="booking-kpi-card booking-kpi-card--orange"><span class="booking-kpi-icon"><i class="fa fa-clock"></i></span><div><label>{$core->get_Lang('Pending')}</label><strong>{$kpi_pending}</strong><small>{$core->get_Lang('requires attention')}</small></div></article>
            <article class="booking-kpi-card booking-kpi-card--green"><span class="booking-kpi-icon"><i class="fa fa-check"></i></span><div><label>{$core->get_Lang('Confirmed')}</label><strong>{$kpi_confirmed}</strong><small>{$core->get_Lang('successfully booked')}</small></div></article>
            <article class="booking-kpi-card booking-kpi-card--red"><span class="booking-kpi-icon"><i class="fa fa-credit-card"></i></span><div><label>{$core->get_Lang('Unpaid')}</label><strong>{$kpi_unpaid}</strong><small>{$core->get_Lang('awaiting payment')}</small></div></article>
        </section>

        <section class="booking-filter-panel v2-filter-panel">
            <form id="forums" method="post" action="" name="filter" class="booking-filter-form" data-auto-filter="true">
                <div class="booking-field booking-search-field v2-field"><label class="booking-field-label v2-field-label" for="booking_keyword">{$core->get_Lang('Search')}</label><i class="fa fa-search"></i><input id="booking_keyword" type="search" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('Search booking code, customer, tour, hotel, voucher...')}" /></div>
                {include file="../components/list_v2/date_picker.tpl" date_picker_id="booking_date_from" date_picker_name="booking_start_date" date_picker_value=$booking_start_date|default:'' date_picker_placeholder="dd/mm/yyyy" date_picker_label=$core->get_Lang('From date')}
                {include file="../components/list_v2/date_picker.tpl" date_picker_id="booking_date_to" date_picker_name="booking_end_date" date_picker_value=$booking_end_date|default:'' date_picker_placeholder="dd/mm/yyyy" date_picker_label=$core->get_Lang('To date') date_picker_auto_filter=true}
                <div class="booking-field booking-select-field v2-field"><label class="booking-field-label v2-field-label" for="booking_status_pay">{$core->get_Lang('Status')}</label><select id="booking_status_pay" name="status_pay" class="iso-selectbox" data-width="100%"><option value="">{$core->get_Lang('All Status')}</option><option value="0" {if $status_pay eq '0'}selected{/if}>{$core->get_Lang('Unpaid')}</option><option value="1" {if $status_pay eq '1'}selected{/if}>{$core->get_Lang('Pay off')}</option><option value="2" {if $status_pay eq '2'}selected{/if}>{$core->get_Lang('Prepaid')}</option><option value="3" {if $status_pay eq '3'}selected{/if}>{$core->get_Lang('Canceled')}</option></select></div>
                <button type="submit" class="booking-search-btn v2-btn v2-btn--primary"><i class="fa fa-search"></i> {$core->get_Lang('Search')}</button>
                <a class="booking-reset-btn v2-btn v2-btn--neutral" href="{$PCMS_URL}/?mod={$mod}&act={$act}&recordperpage={$recordPerPage}"><i class="fa fa-refresh"></i> {$core->get_Lang('Reset')}</a>
                <input type="hidden" name="filter" value="filter" />
                <input type="hidden" name="recordperpage" value="{$recordPerPage}" />
                {if $booking_tab_active ne 'all'}<input type="hidden" name="booking_tab" value="{$booking_tab_active}" />{/if}
            </form>
        </section>

        <div class="booking-list-toolbar">
            {capture name=booking_status_tabs}
                <a class="booking-status-tab v2-status-tab v2-status-tab--primary {if $booking_tab_active eq 'all'}is-active{/if} v2-tab" href="{$PCMS_URL}/?mod={$mod}&act={$act}{$bookingTabFilterUrl}&recordperpage={$recordPerPage}"><i></i>{$core->get_Lang('All')} <span>({$totalItem})</span></a>
                <a class="booking-status-tab v2-status-tab v2-status-tab--danger booking-status-tab--pending {if $booking_tab_active eq 'pending'}is-active{/if} v2-tab" href="{$PCMS_URL}/?mod={$mod}&act={$act}{$bookingTabFilterUrl}&recordperpage={$recordPerPage}&booking_tab=pending"><i></i>{$core->get_Lang('Pending')} <span>({$number_unprocess})</span></a>
                <a class="booking-status-tab v2-status-tab v2-status-tab--success booking-status-tab--confirmed {if $booking_tab_active eq 'confirmed'}is-active{/if} v2-tab" href="{$PCMS_URL}/?mod={$mod}&act={$act}{$bookingTabFilterUrl}&recordperpage={$recordPerPage}&booking_tab=confirmed"><i></i>{$core->get_Lang('Confirm')} <span>({$number_process})</span></a>
                <a class="booking-status-tab v2-status-tab v2-status-tab--warning booking-status-tab--payment {if $booking_tab_active eq 'payment'}is-active{/if} v2-tab" href="{$PCMS_URL}/?mod={$mod}&act={$act}{$bookingTabFilterUrl}&recordperpage={$recordPerPage}&booking_tab=payment"><i></i>{$core->get_Lang('Payment')} <span>({$number_paid})</span></a>
                <a class="booking-status-tab v2-status-tab v2-status-tab--purple booking-status-tab--customer {if $booking_tab_active eq 'customer'}is-active{/if} v2-tab" href="{$PCMS_URL}/?mod={$mod}&act={$act}{$bookingTabFilterUrl}&recordperpage={$recordPerPage}&booking_tab=customer"><i></i>{$core->get_Lang('Customer')} <span>({$number_customer})</span></a>
                <a class="btn-delete-all booking-bulk-delete v2-tabs-delete" id="btn_delete" clsTable="Booking" style="display:none"><i class="fa fa-trash"></i> {$core->get_Lang('Delete')}</a>
            {/capture}
            {include file="../components/list_v2/status_tabs.tpl"
                status_tabs_label=$core->get_Lang('status')
                status_tabs_content=$smarty.capture.booking_status_tabs
            }
            {capture name=booking_records_query}?mod={$mod}&act={$act}{$recordPerPageFilterUrl}{/capture}
            {include file="../components/list_v2/records_per_page.tpl"
                records_per_page_id="booking_records_per_page"
                records_per_page_label=$core->get_Lang('Records per page')
                records_per_page_value=$recordPerPage
                records_per_page_base_url=$PCMS_URL
                records_per_page_query=$smarty.capture.booking_records_query
            }
        </div>

        <div class="list-table-v2-card booking-table-card v2-table-card">
            <div class="list-table-v2-scroll booking-table-scroll v2-table-scroll">
                <table class="list-table-v2 booking-list-table v2-table">
                    <thead><tr><th class="list-table-v2-check booking-check-cell"><input id="check_all" class="el-checkbox" type="checkbox" aria-label="{$core->get_Lang('Select all')}" /></th><th class="list-table-v2-code">{$core->get_Lang('Booking code')}</th><th class="list-table-v2-name">{$core->get_Lang('Booking name')}</th><th class="list-table-v2-customer">{$core->get_Lang('Customers')}</th><th class="list-table-v2-price is-right">{$core->get_Lang('Total Price')}</th><th class="list-table-v2-paid is-right">{$core->get_Lang('Completly payment')}</th><th class="list-table-v2-status is-center">{$core->get_Lang('status')}</th><th class="list-table-v2-action is-center list-table-action-cell">{$core->get_Lang('Action')}</th></tr></thead>
                    <tbody id="SortAble">
                    {if $listItem|@count gt 0}
                        {foreach from=$listItem item=item key=k}
                            {assign var=CARTSTORE value=$clsClassTable->getCartStore($item.booking_id)}
                            {assign var=booking_id value=$item.booking_id}
                            {assign var=deposit value=$clsBillingHistory->getPaymentTermComplete($item.booking_id)}
                            {assign var=booking_status_item value=$clsClassTable->getBookingWorkflowStatus($item.booking_id,$item.cart_store)}
                            {assign var=booking_service_image value=$clsClassTable->getPrimaryServiceImage($item.booking_id,$CARTSTORE,46,38)}
                            <tr>
                                <td class="list-table-v2-check booking-check-cell"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$item.booking_id}" aria-label="{$core->get_Lang('Select')} {$item.booking_code}" /></td>
                                <td class="list-table-v2-code"><a class="list-table-v2-key booking-code list-table-link list-table-key" href="{$PCMS_URL}/?mod=booking&act=edit&action=list_booking&booking_id={$core->encryptID($item.booking_id)}">{$item.booking_code}</a><span class="list-table-v2-meta booking-type list-table-meta">{if isset($CARTSTORE.TOUR)}[{$core->get_Lang('Travel tour')}]{elseif isset($CARTSTORE.HOTEL)}[{$core->get_Lang('Hotel')}]{elseif isset($CARTSTORE.CRUISE)}[{$core->get_Lang('Cruise')}]{elseif isset($CARTSTORE.VOUCHER)}[{$core->get_Lang('Voucher')}]{/if}</span></td>
                                <td class="list-table-v2-name"><div class="list-table-v2-wrap booking-name-wrap list-table-content">{if $booking_service_image}<img class="list-table-v2-thumb booking-service-thumb list-table-thumbnail v2-thumbnail" src="{$booking_service_image}" alt="" width="46" height="38" onerror="this.style.display='none';" />{else}<span class="list-table-v2-thumb booking-service-thumb booking-service-thumb--empty list-table-thumbnail list-table-thumbnail--empty v2-thumbnail"><i class="fa fa-tag"></i></span>{/if}<div><div class="list-table-v2-title booking-service-name list-table-heading">{$clsClassTable->getHTMLServiceOther($item.booking_id)}</div><span class="list-table-v2-meta booking-source list-table-meta">{if $item.user_id eq 0}{$core->get_Lang('From')} {$core->get_Lang('website')}{else}{$clsUser->getOneField('first_name',$item.user_id)} {$clsUser->getOneField('last_name',$item.user_id)}{/if} | {$item.reg_date|date_format:"%d/%m/%Y %H:%M"}</span></div></div></td>
                                <td class="list-table-v2-customer"><div class="list-table-v2-contact booking-customer list-table-detail-list list-table-contact"><strong class="list-table-detail-line list-table-contact-line list-table-contact-name"><i class="fa-solid fa-user" aria-hidden="true"></i><span>{$clsClassTable->getContactName($item.booking_id)}</span></strong><a class="list-table-detail-line list-table-contact-line" href="tel:{$clsClassTable->getPhone($item.booking_id)}"><i class="fa-solid fa-phone" aria-hidden="true"></i><span>{$clsClassTable->getPhone($item.booking_id)}</span></a><a class="list-table-detail-line list-table-contact-line" href="mailto:{$clsClassTable->getEmail($item.booking_id)}"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span>{$clsClassTable->getEmail($item.booking_id)}</span></a></div></td>
                                <td class="v2-price is-right">{$clsISO->priceFormat($item.totalgrand)} {$clsISO->getShortRateText()}</td>
                                <td class="v2-price v2-price--muted is-right">{$clsISO->priceFormat($deposit)} {$clsISO->getShortRateText()}</td>
                                <td class="list-table-v2-status is-center"><span class="list-table-v2-badge booking-payment-status booking-payment-status--{$booking_status_item} list-table-badge {if $booking_status_item eq 'confirmed'}list-table-v2-badge--success list-table-badge--success{elseif $booking_status_item eq 'canceled'}list-table-v2-badge--neutral list-table-badge--neutral{else}list-table-v2-badge--danger list-table-badge--danger{/if} v2-badge"><i></i>{if $booking_status_item eq 'confirmed'}{$core->get_Lang('Confirmed')}{elseif $booking_status_item eq 'canceled'}{$core->get_Lang('Canceled')}{else}{$core->get_Lang('Pending')}{/if}</span></td>
                                <td class="list-table-v2-action is-center list-table-action-cell"><div class="btn-group"><button class="list-table-v2-action-btn booking-row-menu list-table-action dropdown-toggle v2-action" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button><ul class="dropdown-menu dropdown-menu-end">{if _ISOCMS_CLIENT_LOGIN eq '111'}<li><a href="{$PCMS_URL}/?mod=member&act=viewbooking&booking_id={$core->encryptID($item.booking_id)}"><i class="icon-edit"></i> {$core->get_Lang('view')}</a></li>{else}<li><a href="{$PCMS_URL}/?mod=booking&act=edit&action=list_booking&booking_id={$core->encryptID($item.booking_id)}"><i class="icon-edit"></i> {$core->get_Lang('view')}</a></li>{/if}<li><a class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=delete&booking_id={$core->encryptID($item.booking_id)}"><i class="icon-remove"></i> {$core->get_Lang('delete')}</a></li><li><a href="javascript:void(0)" class="syncBookingTMS" booking_id="{$booking_id}" tms_crm_order_id="{$item.tms_crm_order_id}">{$clsISO->makeIMO('sync',$core->get_Lang('Booking TMS'))}</a></li></ul></div></td>
                            </tr>
                        {/foreach}
                    {else}
                        <tr><td class="list-table-v2-empty booking-empty list-table-empty" colspan="8">{$core->get_Lang('nodata')}!</td></tr>
                    {/if}
                    </tbody>
                </table>
            </div>
            {include file="../components/list_v2/pagination.tpl"
                pagination_showing_label=$core->get_Lang('Showing')
                pagination_showing_start=$showingStart
                pagination_showing_end=$showingEnd
                pagination_of_label=$core->get_Lang('of')
                pagination_total_records=$totalRecord
                pagination_entity_label=$core->get_Lang('bookings')
                pagination_total_pages=$totalPage
                pagination_current_page=$currentPage
                pagination_previous_page=$previousPage
                pagination_next_page=$nextPage
                pagination_pages=$listPageNumber
                pagination_base_url=$PCMS_URL
                pagination_page_query=$link_page_current
                pagination_label=$core->get_Lang('pagination')
                pagination_previous_label=$core->get_Lang('Previous')
                pagination_next_label=$core->get_Lang('Next')
            }
        </div>
    </main>
    <div class="container-fluid booking-legacy-list" hidden aria-hidden="true">
        <div class="wrap">
            <div class="filter_box">
                <form id="legacy-booking-filter" method="post" action="" name="legacy_filter" class="filterForm">
                    <div class="form-group form-keyword">
                        <input type="text" class="text form-control" name="keyword" value="{$keyword|default:''}"
                               placeholder="{$core->get_Lang('search')}..."/>
                    </div>
                    {*<div class="form-group form-category">
                        <select name="group_product" class="form-control" id="booking_date">
                            <option value="">{$core->get_Lang('Group product')}</option>
                            <option value="TOUR" {if $group_product=='TOUR'} selected{/if} >{$core->get_Lang('Tour')}</option>
                            <option value="HOTEL" {if $group_product=='HOTEL'} selected{/if}>{$core->get_Lang('Hotel')}</option>
                            <option value="CRUISE" {if $group_product=='CRUISE'} selected{/if}>{$core->get_Lang('Cruise')}</option>
                            <option value="VOUCHER" {if $group_product=='VOUCHER'} selected{/if}>{$core->get_Lang('Voucher')}</option>
                        </select>
                    </div>*}
                    <div class="form-group">
                        <input type="date" name="booking_start_date" class="form-control" value="{$booking_start_date|default:''}">
                    </div>
                    <div class="form-group">
                        <input type="date" name="booking_end_date" class="form-control" value="{$booking_end_date|default:''}">
                    </div>
                    <div class="form-group form-keyword">
                        <select name="status_pay" class="form-control">
                            <option value="">{$core->get_Lang('Status')}</option>
                            <option value="0" {if $status_pay eq '0'}selected{/if}>{$core->get_Lang('Unpaid')}</option>
                            <option value="1" {if $status_pay eq '1'}selected{/if}>{$core->get_Lang('Pay off')}</option>
                            <option value="2" {if $status_pay eq '2'}selected{/if}>{$core->get_Lang('Prepaid')}</option>
                            <option value="3"
                                    {if $status_pay eq '3'}selected{/if}>{$core->get_Lang('Canceled')}</option>
                        </select>
                    </div>
                    <div class="form-group form-button">
                        <button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
                        <input type="hidden" name="filter" value="filter">
                    </div>
                </form>

            </div>
            <div class="record_per_page" style="float: right; margin-bottom: 15px;">
                <label>{$core->get_Lang('Record/page')}</label>
                {$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl|default:'',$act)}
            </div>
            <div class="clearfix"></div>
            <div class="tabbox">
                <div class="hastable">

                    <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
                        <thead>
                        <tr>
                            <th class="gridheader name_responsive text-left" style="width: 130px;">
                                <strong>{$core->get_Lang('Booking code')}</strong></th>
                            <th class="gridheader hiden_responsive text-left" style="">
                                <strong>{$core->get_Lang('Booking name')}</strong></th>
                            <th class="gridheader hiden_responsive text-left" style="">
                                <strong>{$core->get_Lang("Customers")}</strong></th>
                            <th class="gridheader hiden_responsive text-right" style="width:130px">
                                <strong>{$core->get_Lang("Total Price")}</strong></th>
                            <th class="gridheader hiden_responsive text-right" style="width:150px">
                                <strong>{$core->get_Lang("Completly payment")}</strong></th>
                            <th class="gridheader text-left hiden_responsive" style="width: 100px">
                                <strong>{$core->get_Lang('status')}</strong></th>
                            <th class="gridheader text-center hiden_responsive" width="40px"></th>
                        </tr>
                        </thead>
                        {if $listItem|@count gt 0}
                            <tbody id="legacy-SortAble">
                                {foreach from=$listItem item=item key=k}
                                    {assign var=BOOKINGVALUE value=$clsClassTable->getBookingValue($item.booking_id)}
                                         {assign
                                            var=CARTSTORE
                                            value=$clsClassTable->getCartStore($item.booking_id)
                                        }
                                    {assign var=booking_id value=$item.booking_id}
                                    {assign var=deposit value=$clsBillingHistory->getPaymentTermComplete($item.booking_id)}
                                    <tr {if $k%2 eq 0}class="row1"{else}class="row2"{/if}>
                                        <td style="text-align: left" class="text-left name_service">
                                            <span class="title"
                                                title="{if $clsClassTable->getOneField('is_online',$booking_id) eq 0}{$core->get_Lang('Booking PRIVATE')}{/if}">
                                                {$item.booking_code}
                                            </span>
                                            <p class="text_booking_group">
                                                {if isset($CARTSTORE.TOUR)}
                                                    [{$core->get_Lang('Travel tour')}]
                                                {elseif isset($CARTSTORE.HOTEL)}
                                                    [{$core->get_Lang('Hotel')}]
                                                {elseif isset($CARTSTORE.CRUISE)}
                                                    [{$core->get_Lang('Cruise')}]
                                                {elseif isset($CARTSTORE.VOUCHER)}
                                                    [{$core->get_Lang('Voucher')}]
                                                {/if}
                                            </p>
                                        </td>
                                        <td class="block_responsive border_top_responsive"
                                            data-title="{$core->get_Lang('Booking name')}">
                                            {$clsClassTable->getHTMLServiceOther($item.booking_id)}
                                            <p class="text_bot">
                                                {if $item.user_id eq 0}
                                                    {$core->get_Lang('From')} {$core->get_Lang('website')}
                                                {else}
                                                    {$clsUser->getOneField('first_name',$item.user_id)} {$clsUser->getOneField('last_name',$item.user_id)}
                                                {/if}
                                                | {$item.reg_date|date_format:"%d/%m/%Y %H:%M"}
                                            </p>
                                        </td>
                                        <td class="block_responsive border_top_responsive" style="white-space:nowrap"
                                            data-title="{$core->get_Lang('Customers')}">
                                            <div class="customer_box">
                                                <p class="td_name">{$clsClassTable->getContactName($item.booking_id)}</p>
                                                <p class="text_bot">
                                                    <a href="tel:+{$clsClassTable->getPhone($item.booking_id)}"
                                                    title="{$clsClassTable->getPhone($item.booking_id)}">{$clsClassTable->getPhone($item.booking_id)}</a>
                                                    <br/>
                                                    <a href="mailto:{$clsClassTable->getEmail($item.booking_id)}"
                                                    title="{$clsClassTable->getEmail($item.booking_id)}">{$clsClassTable->getEmail($item.booking_id)}</a>
                                                </p>
                                            </div>
                                        </td>
                                        {assign var=total_cashback value=$clsBillingHistory->getPaymentTermComplete($item.booking_id,'CASHBACK')}
                                        {math assign="totalgrand" equation="x-y-z" x=$item.totalgrand|default:0 y=$item.totalcancel|default:0 z=$total_cashback|default:0}
                                        <td class="block_responsive border_top_responsive text-right price"
                                            style="white-space:nowrap"
                                            data-title="{$core->get_Lang('Total Price')}">
                                            {$clsISO->priceFormat($item.totalgrand)} {$clsISO->getShortRateText()}
                                        </td>
                                        <td class="block_responsive border_top_responsive text-right price"
                                            style="white-space:nowrap;padding-right:20px!important"
                                            data-title="{$core->get_Lang('Completly payment')}">
                                            {$clsISO->priceFormat($deposit)} {$clsISO->getShortRateText()}
                                        </td>

                                        {assign var=status_pay value=$clsClassTable->getOneField('status_pay',$item.booking_id)}
                                        <td class="block_responsive border_top_responsive booking_status status_pay_{$status_pay}"
                                            data-title="{$core->get_Lang('status')}" style="text-align: center;">
                                            <span class="text" style="height: 15px;"></span>
                                        </td>

                                        <td class="block_responsive text-center"
                                            style="text-align: center; white-space: nowrap; width:5%"
                                            data-title="{$core->get_Lang('func')}">
                                            <div class="btn-group">
                                                <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu" style="right:0px !important">
                                                    {if _ISOCMS_CLIENT_LOGIN eq '111'}
                                                        <li>
                                                            <a href="{$PCMS_URL}/?mod=member&act=viewbooking&booking_id={$core->encryptID($item.booking_id)}"
                                                            title="{$core->get_Lang('view')}">
                                                                <i class="icon-edit"></i> {$core->get_Lang('view')}
                                                            </a>
                                                        </li>
                                                    {else}
                                                        <li>
                                                            <a href="{$PCMS_URL}/?mod=booking&act=edit&action=list_booking&booking_id={$core->encryptID($item.booking_id)}"
                                                            title="{$core->get_Lang('view')}">
                                                                <i class="icon-edit"></i> {$core->get_Lang('view')}
                                                            </a>
                                                        </li>
                                                    {/if}
                                                    <li>
                                                        <a class="confirm_delete"
                                                        href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=delete&booking_id={$core->encryptID($item.booking_id)}"
                                                        title="{$core->get_Lang('delete')}">
                                                            <i class="icon-remove"></i> {$core->get_Lang('delete')}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="syncBookingTMS"
                                                        booking_id="{$booking_id}"
                                                        tms_crm_order_id="{$item.tms_crm_order_id}">
                                                            {if $item.tms_crm_order_id}
                                                                {$clsISO->makeIMO('sync',$core->get_Lang('Booking TMS'),'color-green')}
                                                            {else}
                                                                {$clsISO->makeIMO('sync',$core->get_Lang('Booking TMS'))}
                                                            {/if}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        {else}
                            <tr>
                                <td colspan="15">{$core->get_Lang('nodata')}!</td>
                            </tr>
                        {/if}

                    </table>
                    <div class="clearfix"></div>
                    <div class="statistical mb5">
                        <table width="100%" border="0" cellpadding="3" cellspacing="0">
                            <tr>
                                <td width="50%" align="left">{$core->get_Lang('statistical')}
                                    <strong>{$totalRecord}</strong> {$core->get_Lang('records')}
                                    /<strong>{$totalPage}</strong> {$core->get_Lang('page')}
                                    . {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
                                <td width="50%" align="right">
                                    {$core->get_Lang('gotopage')}:
                                    <select name="page"
                                            onchange="window.location = this.options[this.selectedIndex].value">
                                        {section name=i loop=$listPageNumber}
                                            <option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if}
                                                    value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
                                        {/section}
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var Departure_date_invalid = '{$core->get_Lang("Departure date is invalid")}';
    var Not_Available = "{$core->get_Lang('No vacancy')}";
    var Available = "{$core->get_Lang('Still empty')}";
    var Promotions = "{$core->get_Lang('Promotions')}";
</script>
{literal}
    <style>
        .page_container .filter_box .filterForm {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

		#addBooking.modal.right.fade .modal-dialog{
            right: 0;
        }

        /*
         * isoCMS dùng Bootstrap 5, trong khi AuAsia dùng Bootstrap 3.
         * Giữ giao diện drawer giống AuAsia nhưng dùng trạng thái .show.
         */
        #addBooking.modal {
            padding: 0 !important;
            overflow: hidden !important;
            z-index: 1060 !important;
        }

        #addBooking.modal.right.fade .modal-dialog {
            position: fixed !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            left: var(--booking-modal-left, 230px) !important;
            width: auto !important;
            max-width: none !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: translate3d(100%, 0, 0) !important;
            transition: transform .3s ease-in-out !important;
        }

        #addBooking.modal.right.fade.show .modal-dialog,
        #addBooking.modal.right.show .modal-dialog {
            transform: translate3d(0, 0, 0) !important;
        }

        #addBooking .modal-content {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            height: 100vh !important;
            max-height: 100vh !important;
            overflow: hidden !important;
            border: 0 !important;
            border-radius: 0 !important;
            background: var(--color-white) !important;
            box-shadow: -5px 0 20px rgba(0, 0, 0, .18) !important;
        }

        #addBooking #frmForm {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            height: 100% !important;
            min-height: 0 !important;
            margin: 0 !important;
        }

        #addBooking .modal-header {
            display: block !important;
            flex: 0 0 auto !important;
            min-height: 110px;
            padding: 24px 30px !important;
            background: var(--color-white) !important;
            border: 0 !important;
            border-bottom: 1px solid var(--color-muted) !important;
        }

        #addBooking .modal-header .content_head {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            gap: 20px;
        }

        #addBooking .booking_modal_back {
            min-width: 0;
            color: inherit;
            text-decoration: none;
        }

        #addBooking .booking_modal_back > .fa-angle-left {
            flex: 0 0 auto;
            margin-right: 24px;
            color: var(--color-body);
            font-size: var(--font-size-4xl);
            font-weight: 300;
        }

        #addBooking .text_booking {
            min-width: 0;
        }

        #addBooking .booking_name {
            margin: 0 0 5px;
            color: var(--color-body);
            font-size: var(--font-size-xl);
            font-weight: 700;
            line-height: 1.3;
        }

        #addBooking .status {
            margin: 0;
        }

        #addBooking .modal-header .box_button,
        #addBooking .modal-footer .box_button {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 14px;
        }

        #addBooking .modal-header .box_button {
            flex: 0 0 auto;
        }

        #addBooking .modal-body {
            display: block !important;
            flex: 1 1 auto !important;
            min-height: 0 !important;
            padding: 20px 30px !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
            background: var(--color-white) !important;
        }

        #addBooking .modal-footer {
            display: block !important;
            flex: 0 0 auto !important;
            padding: 10px 16px !important;
            background: var(--color-white) !important;
            border: 0 !important;
            border-top: 1px solid var(--color-muted) !important;
        }

        #addBooking .modal-footer .box_button {
            width: 100%;
        }

        #addBooking .modal-footer .box_billing {
            margin-right: 10px;
            margin-bottom: 0 !important;
        }

        #addBooking .modal-footer .lbl_total_payment {
            margin: 0 6px 0 0;
            font-size: var(--font-size-base);
            font-weight: 700;
        }

        #addBooking .modal-footer .price {
            color: var(--color-add);
            font-weight: 700;
        }

        #addBooking .btn_cancel,
        #addBooking .btn_submit {
            min-width: 92px;
            min-height: 50px;
            padding: 12px 18px;
            border: 0;
            border-radius: 3px;
            font-weight: 600;
        }

        #addBooking .btn_cancel {
            background: var(--color-muted);
            color: var(--color-white);
        }

        #addBooking .btn_submit {
            background: var(--color-add);
            color: var(--color-white);
        }

        #addBooking .box_section {
            margin-bottom: 20px;
            background: var(--color-white);
        }


        #addBooking .collapse.show {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        #addBooking .box_form {
            padding: 20px;
            background: var(--color-white);
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        .modal-backdrop.show {
            opacity: .55 !important;
        }

        @media (max-width: 991px) {
            #addBooking.modal.right.fade .modal-dialog {
                left: 0 !important;
            }

            #addBooking .modal-header {
                min-height: 90px;
                padding: 15px !important;
            }

            #addBooking .modal-body {
                padding: 15px !important;
            }

            #addBooking .booking_modal_back > .fa-angle-left {
                margin-right: 12px;
            }

            #addBooking .booking_name {
                font-size: var(--font-size-lg);
            }
        }

		.bk_item {
			border-radius: 8px;
			border: 1px solid var(--color-muted);
			background: var(--color-white);
			box-shadow: 0 8px 8px 0 rgba(0, 0, 0, .05);
		}

		.bk_sts {
			border-radius: 6px 0 0 6px;
		}

		.box_top_bk {
			padding: 8px 12px;
			background: var(--color-white);
			height: 62px;
		}

		.bk_code {
			color: var(--color-primary);
			font-size: var(--font-size-base);
			font-weight: 600;
			line-height: normal;
		}

		.info_persion_bk {
			font-size: var(--font-size-base);
			font-style: normal;
			font-weight: 400;
		}
		.info_persion_bk span {
			color: var(--color-muted);
		}

		.box_bottom {
			padding: 12px;
			/*height: calc(100% - 62px);*/
            color: var(--color-body);
            font-family: "Open Sans";
            font-size: var(--font-size-base);
            font-style: normal;
            font-weight: 400;
            line-height: normal;
		}

		.bk_quantity, .bk_title {
			color: var(--color-body);
		}

		.bk_user {
			color: var(--color-body);
			font-size: var(--font-size-base);
			font-style: normal;
			font-weight: 500;
			line-height: 150%; /* 24px */
		}

		.total_booking {
			color: var(--color-primary);
			font-size: var(--font-size-base);
			font-style: normal;
			font-weight: 500;
			line-height: 150%;
		}

		.bk_cusname, .bk_title {
			margin-bottom: 6px;
		}

		.bk_title {
			color: var(--color-body);
			font-size: var(--font-size-base);
			font-style: normal;
			font-weight: 500;
			line-height: 150%; /* 24px */
		}
		.bk_quantity {
			font-size: var(--font-size-base);
		}
		.bk_cusname {
			line-height: 150%
		}
		.bk_quantity {
			font-weight: 400;
		}

		.bk_mail {
			color: var(--color-muted);
			font-size: var(--font-size-base);
			font-style: normal;
			font-weight: 400;
			line-height: 150%; /* 21px */
		}

		.status_text {
			display: inline-block;
			padding: 5px 10px;
			border-radius: 80px;
			color: var(--color-white);
			font-size: var(--font-size-base);
			font-weight: 700;
			line-height: normal;
			height: fit-content;
		}

		.tool_box {
			min-width: 140px;
		}

		.tool_box .drop-item {
			cursor: pointer;
			padding: 3px 12px;
			margin: 0;
		}
		.tool_box .drop-item:hover {
			background: var(--color-primary);
			color: var(--color-white);
		}

        .confirm_booking .deposit_booking {
            text-align: end;
            padding: 9px 18px;
            border-radius: 20px;
            background: var(--color-white);
            color: var(--color-add);
            font-family: "Open Sans";
            font-size: var(--font-size-base);
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 18px */
        }
#addBooking .collapse.show {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

#addBooking .box_form {
    padding: 20px;
    background: var(--color-white);
}


#addBooking .btn_title[aria-expanded="false"] .fa-angle-up {
    transform: rotate(180deg);
}

#addBooking .btn_title .fa-angle-up {
    transition: transform .2s ease;
}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {

            var bookingToday = new Date();
            bookingToday.setHours(0, 0, 0, 0);

            $('#booking_date_from').datepicker({
                dateFormat: "dd/mm/yy",

                maxDate: bookingToday,
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                showOtherMonths: true,
                onSelect: function (dateStr) {
                    var date = $(this).datepicker('getDate');
                    if (date) {
                        date.setHours(0, 0, 0, 0);
                    }
                    $('#booking_date_to').datepicker('option', 'minDate', date);
                    if (!$('#booking_date_to').datepicker('getDate') || $('#booking_date_to').datepicker('getDate') < date) {
                        $('#booking_date_to').datepicker('setDate', date);
                    }
                },
                onClose: function (dateText, inst) {
                    $('#booking_date_to').focus();
                }
            });
            $("#booking_date_to").datepicker({
                dateFormat: "dd/mm/yy",

                maxDate: bookingToday,
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                showOtherMonths: true,

                onSelect: function () {

                    $(this).trigger('change');

                }
            });
        });
    </script>
{/literal}
<link rel="stylesheet" type="text/css" href="{$URL_JS}/datepicker/jquery-ui.css?ver={$upd_version}"/>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_JS}/jquery-easyui/themes/gray/easyui.css?v={$upd_version}" type="text/css"
      media="screen">
<script type="text/javascript" src="{$URL_JS}/jquery-easyui/jquery.easyui.min.js?v={$upd_version}"></script>
{literal}
<script>
(function () {
    'use strict';

    function syncBookingModalLayout() {
        var modalElement = document.getElementById('addBooking');

        if (!modalElement) {
            return;
        }

        var sidebar = document.querySelector(
            '#sidebar, .sidebar'
        );
        var left = 0;

        if (
            window.innerWidth > 991 &&
            sidebar
        ) {
            var rect = sidebar.getBoundingClientRect();
            var style = window.getComputedStyle(sidebar);

            if (
                style.display !== 'none' &&
                style.visibility !== 'hidden'
            ) {
                left = Math.max(0, Math.round(rect.right));
            }
        }

        modalElement.style.setProperty(
            '--booking-modal-left',
            left + 'px'
        );
    }

    document.addEventListener('click', function (event) {
        var button = event.target.closest('.btn_addBooking');

        if (!button) {
            return;
        }

        var modalElement = document.getElementById('addBooking');

        if (!modalElement) {
            console.error('Không tìm thấy modal #addBooking');
            return;
        }

        syncBookingModalLayout();

        /*
         * Bootstrap 5 tự xử lý data-bs-toggle="modal".
         * Không gọi modal.show() lần hai.
         */
        if (
            typeof bootstrap !== 'undefined' &&
            bootstrap.Modal
        ) {
            return;
        }

        event.preventDefault();

        if (
            typeof jQuery !== 'undefined' &&
            typeof jQuery.fn.modal === 'function'
        ) {
            jQuery(modalElement).modal('show');
            return;
        }

        console.error('Bootstrap Modal chưa được tải.');
    }, true);

    window.addEventListener(
        'resize',
        syncBookingModalLayout
    );

    document.addEventListener(
        'DOMContentLoaded',
        syncBookingModalLayout
    );
})();
</script>
{/literal}
