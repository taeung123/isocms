{assign var="tour_id" value=$item.target_id}
{assign var="request_title" value=$clsTour->getTitle($tour_id)}
{assign var=feedback_store value = $clsISO->getArrayFromString($item.feedback_store)}
{assign var="adult" value=$feedback_store.number_adult}
{assign var="child" value=$feedback_store.number_children}
{assign var="infant" value=$feedback_store.number_infant}
{if $item.is_process == 0}
    {assign var="status_text" value="Reminding"}
    {assign var="color" value="#FC0"}
{elseif $item.is_process == 2}
    {assign var="status_text" value="Refused"}
    {assign var="color" value="#28C490"}
{else}
    {assign var="status_text" value="Offered"}
    {assign var="color" value="#FF7917"}
{/if}
<div class="list_booking">
    <div class="d-flex bk_item" style="margin: 0 0 30px 0;">
        <div class="bk_sts" style="width: 100%">
            <div class="d-flex" style="height: 100%">
                <div style="background: {$color}; width: 18px">
                    <i class="fa-solid fa-building icon"></i>
                </div>
                <div style="width: 100%">
                    <div class="box_top_bk">
                        <a href="{$PCMS_URL}/?mod={$mod}&act=viewrequest&request_id={$core->encryptID($item.feedback_id)}"
                           class="bk_code push_state">{$item.feedback_code}</a>
                        <div class="d-flex info_persion_bk mt-2">
                            <div class="mr-3">
                                {$core->get_Lang('Sales')}: <span class="info_item">{$core->get_Lang("From website")}</span>
                            </div>
                            <div class="mr-3">
                                {$core->get_Lang('Updates')}: <span class="info_item">{$clsBooking->getContactName($booking_id)}</span>
                            </div>
                            <div>
                                <i class="fa-regular fa-clock"
                                   style="color: #666666;"></i>
                                {$clsISO->convertTimeToText($item.reg_date,'dot')}
                            </div>
                        </div>
                    </div>
                    <div class="box_bottom">
                        <p class="bk_title">
                            {$request_title}
                        </p>
                        <p class="bk_quantity bk_user">
                            <i class="fa-regular fa-user"
                               style="color: #5A646D"></i>
                            {$item.fullname} <span style="color: #8591AA;">({$item.email} | {$item.phone})</span>
                        </p>
                        <p class="bk_quantity bk_mail">
                            <i class="fa-regular fa-users"
                               style="color: #5A646D"></i>
                            {if $adult}{$adult} {$core->get_Lang("Adult(s)")}{/if}
                            {if $child}- {$child} {$core->get_Lang("Children")}{/if}
                            {if $infant}- {$infant} {$core->get_Lang("Infant(s)")}{/if}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-0" style="width: 200px">
            <div class="d-flex justify-content-end box_top_bk align-items-center">
                <span class="status_text" style="background: {$color}">{$status_text}</span>
                {*<span class="status_text" style="background: #d33f2a">Yêu cầu</span>*}
                <div class="dropdown">
                    <button class="btn dropdown-toggle" style="background: none"
                            type="button" id="{$item.booking_code}"
                            data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <img src="https://i.ibb.co/DDzzTKP/icn-group.png">
                    </button>
                    <ul class="dropdown-menu tool_box" style="right:0px !important">
                        <li>
                            <a href="{$PCMS_URL}/?mod={$mod}&act=viewrequest&request_id={$core->encryptID($item.feedback_id)}"
                               title="{$core->get_Lang('View')}">
                                <i class="icon-edit"></i> {$core->get_Lang('View')}
                            </a>
                        </li>
                        {*<li>
                            <a class="confirm_delete"
                               href="{$PCMS_URL}/?mod={$mod}&act=delete&pkeyTable={$core->encryptID($booking_id)}"
                               title="{$core->get_Lang('Delete')}">
                                <i class="icon-remove"></i> {$core->get_Lang('Delete')}
                            </a>
                        </li>*}
                    </ul>
                </div>
            </div>
            <div class="text-right pr-20 box_bottom box_amount_total"
                 style="border-left: 1px solid #D9D9D9;">
                <p title="{$core->get_Lang('Total amount')}">{$clsISO->priceFormat(432)}{$clsISO->getShortRateText()}
                    <i class="fa-sharp fa-light fa-coins fa-lg"></i>
                </p>
                <p title="{$core->get_Lang('Remaining')}">{$clsISO->priceFormat(520)}{$clsISO->getShortRateText()}
                    <i class="fa-sharp fa-light fa-coins fa-lg"></i>
                </p>
                <div class="confirm_booking">
                    <span class="deposit_booking">
                        {if $deposit_bill_complete gt 0}
                            {if $deposit_bill_complete eq $oneItem.totalgrand}
                                {$core->get_Lang('Pay off')}
                            {else}
                                {$core->get_Lang('Deposit')}
                                {$deposit_bill_complete|number_format:0:".":" "} {$clsISO->getShortRateText()}
                            {/if}
                        {else}
                            {$core->get_Lang('Unpaid')}
                        {/if}
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>