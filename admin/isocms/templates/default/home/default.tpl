<!-- DASHBOARD V2 STYLES & LIBRARIES -->
<link rel="stylesheet" href="{$URL_CSS}/dashboard_v2.css?v={$upd_version}&t=178924">
<script src="{$URL_JS}/highchart/highcharts.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/exporting.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/export-data.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/accessibility.js?v={$upd_version}"></script>

<div id="isocms_dashboard_v2" class="dashboard_v2_container">
    
    <!-- 1. HERO GREETING BANNER -->
    <div class="dash_hero_banner">
        <div class="dash_hero_left">
            <div class="dash_hero_greeting">{$dash_greeting|default:'Good Morning,'} {$dash_greeting_emoji|default:'☀️'}</div>
            <div class="dash_hero_headline">
                <h1 class="dash_user_title"><span class="highlight">{if $user_full_name}{$user_full_name}{elseif $clsUser->getOneField('first_name',$_loged_id) or $clsUser->getOneField('last_name',$_loged_id)}{$clsUser->getOneField('first_name',$_loged_id)} {$clsUser->getOneField('last_name',$_loged_id)}{else}{$core->_USER.user_name|default:'ENTER'}{/if}!</span></h1>
                <span class="dash_hero_subtitle">{$core->get_Lang("Here's what's happening with your travel business today.")}</span>
            </div>
        </div>
    </div>

    <!-- 2. TOP 5 KPI CARDS -->
    <div class="dash_kpi_grid" aria-live="polite">
        <!-- Card 1: Bookings Today -->
        <div class="dash_kpi_card">
            <div class="dash_kpi_icon icon_blue">
                <i class="fa fa-cog"></i>
            </div>
            <div class="dash_kpi_info">
                <div class="dash_kpi_top">
                    <span class="dash_kpi_title">Bookings on end date</span>
                </div>
                <div class="dash_kpi_val_row">
                    <span class="dash_kpi_value" data-kpi="today_bookings">{$kpi_data.today_bookings}</span>
                    <span class="dash_kpi_trend up" data-kpi-trend="today_pct"><i class="fa fa-arrow-up"></i> {$kpi_data.today_pct}</span>
                </div>
                <div class="dash_kpi_period">vs. previous day</div>
            </div>
        </div>

        <!-- Card 2: Total Bookings -->
        <div class="dash_kpi_card">
            <div class="dash_kpi_icon icon_green">
                <i class="fa fa-ticket-alt"></i>
            </div>
            <div class="dash_kpi_info">
                <div class="dash_kpi_top">
                    <span class="dash_kpi_title">{$core->get_Lang('Total Bookings')}</span>
                </div>
                <div class="dash_kpi_val_row">
                    <span class="dash_kpi_value" data-kpi="month_bookings">{$kpi_data.month_bookings}</span>
                    <span class="dash_kpi_trend up" data-kpi-trend="month_bookings_pct"><i class="fa fa-arrow-up"></i> {$kpi_data.month_bookings_pct}</span>
                </div>
                <div class="dash_kpi_period" data-kpi-period>{$kpi_data.period_label}</div>
            </div>
        </div>

        <!-- Card 3: Revenue (USD) -->
        <div class="dash_kpi_card">
            <div class="dash_kpi_icon icon_blue_alt">
                <i class="fa fa-dollar-sign"></i>
            </div>
            <div class="dash_kpi_info">
                <div class="dash_kpi_top">
                    <span class="dash_kpi_title">{$core->get_Lang('Revenue (USD)')}</span>
                </div>
                <div class="dash_kpi_val_row">
                    <span class="dash_kpi_value" data-kpi="month_revenue">{$kpi_data.month_revenue}</span>
                    <span class="dash_kpi_trend up" data-kpi-trend="month_revenue_pct"><i class="fa fa-arrow-up"></i> {$kpi_data.month_revenue_pct}</span>
                </div>
                <div class="dash_kpi_period" data-kpi-period>{$kpi_data.period_label}</div>
            </div>
        </div>

        <!-- Card 4: Total Customers -->
        <div class="dash_kpi_card">
            <div class="dash_kpi_icon icon_purple">
                <i class="fa fa-users"></i>
            </div>
            <div class="dash_kpi_info">
                <div class="dash_kpi_top">
                    <span class="dash_kpi_title">{$core->get_Lang('Total Customers')}</span>
                </div>
                <div class="dash_kpi_val_row">
                    <span class="dash_kpi_value" data-kpi="total_customers">{$kpi_data.total_customers}</span>
                    <span class="dash_kpi_trend up" data-kpi-trend="customers_pct"><i class="fa fa-arrow-up"></i> {$kpi_data.customers_pct}</span>
                </div>
                <div class="dash_kpi_period" data-kpi-period>{$kpi_data.period_label}</div>
            </div>
        </div>

        <!-- Card 5: Conversion Rate -->
        <div class="dash_kpi_card">
            <div class="dash_kpi_icon icon_purple_bar">
                <i class="fa fa-chart-bar"></i>
            </div>
            <div class="dash_kpi_info">
                <div class="dash_kpi_top">
                    <span class="dash_kpi_title">{$core->get_Lang('Conversion Rate')}</span>
                </div>
                <div class="dash_kpi_val_row">
                    <span class="dash_kpi_value" data-kpi="conversion_rate">{$kpi_data.conversion_rate}</span>
                    <span class="dash_kpi_trend up" data-kpi-trend="conversion_pct"><i class="fa fa-arrow-up"></i> {$kpi_data.conversion_pct}</span>
                </div>
                <div class="dash_kpi_period" data-kpi-period>{$kpi_data.period_label}</div>
            </div>
        </div>
    </div>

    <!-- 3. MIDDLE 2-PANEL LAYOUT (LEFT 74% | RIGHT 26%) -->
    <div class="dash_middle_layout">
        
        <!-- LEFT MAIN PANEL -->
        <div class="dash_left_panel">
            
            <!-- Quick Access Section -->
            <div class="dash_quick_access_card">
                <div class="dash_section_header">
                    <div>
                        <h3 class="dash_section_title">{$core->get_Lang('Quick Access')}</h3>
                        <div class="dash_section_subtitle">{$core->get_Lang('Everything you need to manage your travel business')}</div>
                    </div>
                    <a href="javascript:void(0);" class="dash_btn_customize" onClick="dash_manager_tasks(); return false;">
                        <i class="fa fa-cog"></i> {$core->get_Lang('Customize')}
                    </a>
                </div>

                <div class="dash_quick_grid" id="dash_quick_access_container">
                    {foreach from=$listQuickAccessShow item=item}
                        {assign var=_adminbutton_id value=$item.adminbutton_id}
                        {if $clsAdminButton->getDefaultQuickAccessRank($item) neq 9}
                            {if $clsAdminButton->checkPackage($_adminbutton_id, $package_id)}
                                {if $core->checkAccess($item.mod_page)}
                                    {assign var=quick_title value=$core->get_Lang($item.title_page)}
                                    <a href="{$clsAdminButton->getURL($item.adminbutton_id)}" class="dash_quick_item" title="{$quick_title}">
                                        <div class="dash_quick_icon_wrap">
                                            {if $item.image}
                                                <img class="imgIcon" src="{$item.image}" alt="{$quick_title}" width="28" height="28" style="object-fit: contain;" />
                                            {else}
                                                <i class="fa fa-th-large" style="color:#0066FF;"></i>
                                            {/if}
                                        </div>
                                        <span class="dash_quick_text">{$quick_title}</span>
                                    </a>
                                {/if}
                            {/if}
                        {/if}
                    {/foreach}
                    {if $core->checkAccess('setting')}
                        <a href="{$PCMS_URL}/index.php?mod=setting" class="dash_quick_item dash_quick_item_setting" title="{$core->get_Lang('Settings')}">
                            <div class="dash_quick_icon_wrap">
                                <i class="fa fa-cog" style="color: #0066FF; font-size: 22px;"></i>
                            </div>
                            <span class="dash_quick_text">{$core->get_Lang('Settings')}</span>
                        </a>
                    {/if}
                </div>
            </div>

            <!-- 2-Column Inner Grid -->
            <div class="dash_inner_2col_grid">
                
                <!-- Inner Column 1: Revenue & Top Tours -->
                <div class="dash_inner_col">
                    <!-- Revenue Overview Card -->
                    <div class="dash_card">
                        <div class="dash_card_header">
                            <h4 class="dash_card_title">
                                <i class="fa fa-chart-line" style="color: #0066FF;"></i> {$core->get_Lang('Revenue Overview')}
                            </h4>
                            <select id="dash_filter_revenue" class="dash_select_filter">
                                <option value="this_month" selected>{$core->get_Lang('This month')}</option>
                                <option value="last_month">{$core->get_Lang('Last month')}</option>
                                <option value="this_year">{$core->get_Lang('This year')}</option>
                                <option value="all">{$core->get_Lang('All time')}</option>
                            </select>
                        </div>

                        <div class="dash_revenue_stat_row">
                            <div>
                                <span class="dash_revenue_big" id="dash_rev_big_val">$ {$kpi_data.month_revenue}</span>
                                <span class="dash_revenue_trend" id="dash_rev_trend_val"><i class="fa fa-arrow-up"></i> {$kpi_data.month_revenue_pct}</span>
                                <div class="dash_revenue_period" id="dash_rev_period_val">vs. last month</div>
                            </div>
                            <div class="dash_chart_legend">
                                <span><span class="dash_legend_dot dot_blue"></span> Revenue</span>
                                <span><span class="dash_legend_dot dot_green"></span> Orders</span>
                            </div>
                        </div>

                        <div id="dash_revenue_chart" class="dash_chart_container"></div>
                    </div>

                    <!-- Top Selling Tours Card -->
                    <div class="dash_card">
                        <div class="dash_card_header">
                            <h4 class="dash_card_title">
                                <span style="color: #FFB547; font-size: 16px;">🏆</span> {$core->get_Lang('Top Selling Tours')}
                            </h4>
                            <a href="{$PCMS_URL}/?mod=tour_exhautive" class="dash_link_viewall">{$core->get_Lang('View all')}</a>
                        </div>

                        <div class="dash_tour_list">
                            {if $top_selling_tours && $top_selling_tours|@count > 0}
                                {section name=i loop=$top_selling_tours}
                                <a href="{$top_selling_tours[i].link_edit}" class="dash_tour_item" title="{$top_selling_tours[i].title}">
                                    <div class="dash_tour_rank rank_{$smarty.section.i.iteration}">{$smarty.section.i.iteration}</div>
                                    <img class="dash_tour_thumb" src="{$top_selling_tours[i].image}" alt="{$top_selling_tours[i].title}" />
                                    <div class="dash_tour_info">
                                        <div class="dash_tour_name" title="{$top_selling_tours[i].title}">{$top_selling_tours[i].title}</div>
                                        <div class="dash_tour_bookings">{$top_selling_tours[i].bookings} {if $top_selling_tours[i].bookings == 1}{$core->get_Lang('booking')}{else}{$core->get_Lang('bookings')}{/if}</div>
                                    </div>
                                    <div class="dash_tour_stat">
                                        <div class="dash_tour_price">{$top_selling_tours[i].revenue}</div>
                                        {if $top_selling_tours[i].trend}
                                        <div class="dash_tour_trend"><i class="fa fa-arrow-up"></i> {$top_selling_tours[i].trend}</div>
                                        {/if}
                                    </div>
                                </a>
                                {/section}
                            {else}
                                <div class="dash_empty_state" style="padding: 36px 16px; text-align: center; color: #A3AED0; font-size: 13px;">
                                    <i class="fa fa-inbox" style="font-size: 32px; margin-bottom: 8px; display: block; opacity: 0.45;"></i>
                                    {$core->get_Lang('Chưa có tour nào')}
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>

                <!-- Inner Column 2: Bookings by Status & Customers by Market -->
                <div class="dash_inner_col">
                    <!-- Bookings by Status Card -->
                    <div class="dash_card">
                        <div class="dash_card_header">
                            <h4 class="dash_card_title">
                                <i class="fa fa-briefcase" style="color: #0066FF;"></i> {$core->get_Lang('Bookings by Status')}
                            </h4>
                            <select id="dash_filter_status" class="dash_select_filter">
                                <option value="this_month" selected>{$core->get_Lang('This month')}</option>
                                <option value="last_month">{$core->get_Lang('Last month')}</option>
                                <option value="this_year">{$core->get_Lang('This year')}</option>
                                <option value="all">{$core->get_Lang('All time')}</option>
                            </select>
                        </div>

                        <div class="dash_donut_wrapper">
                            <div class="dash_donut_chart_box">
                                <div id="dash_status_donut" style="width:140px; height:140px;"></div>
                                <div class="dash_donut_center_text">
                                    <div class="dash_donut_center_num" id="dash_status_center_num">{$status_breakdown.total}</div>
                                    <div class="dash_donut_center_lbl">{$core->get_Lang('Bookings')}</div>
                                </div>
                            </div>

                            <div class="dash_status_list">
                                <div class="dash_status_row">
                                    <span class="dash_status_name"><span class="dash_status_square" style="background:#05CD99;"></span> {$core->get_Lang('Confirmed')}</span>
                                    <div class="dash_status_pct" id="dash_st_pct_confirmed">{$status_breakdown.confirmed.pct}%</div>
                                    <div class="dash_status_cnt" id="dash_st_cnt_confirmed">{$status_breakdown.confirmed.count}</div>
                                </div>
                                <div class="dash_status_row">
                                    <span class="dash_status_name"><span class="dash_status_square" style="background:#FFB547;"></span> {$core->get_Lang('Pending')}</span>
                                    <div class="dash_status_pct" id="dash_st_pct_pending">{$status_breakdown.pending.pct}%</div>
                                    <div class="dash_status_cnt" id="dash_st_cnt_pending">{$status_breakdown.pending.count}</div>
                                </div>
                                <div class="dash_status_row">
                                    <span class="dash_status_name"><span class="dash_status_square" style="background:#0066FF;"></span> {$core->get_Lang('On Hold')}</span>
                                    <div class="dash_status_pct" id="dash_st_pct_onhold">{$status_breakdown.onhold.pct}%</div>
                                    <div class="dash_status_cnt" id="dash_st_cnt_onhold">{$status_breakdown.onhold.count}</div>
                                </div>
                                <div class="dash_status_row">
                                    <span class="dash_status_name"><span class="dash_status_square" style="background:#EE5D50;"></span> {$core->get_Lang('Cancelled')}</span>
                                    <div class="dash_status_pct" id="dash_st_pct_cancelled">{$status_breakdown.cancelled.pct}%</div>
                                    <div class="dash_status_cnt" id="dash_st_cnt_cancelled">{$status_breakdown.cancelled.count}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customers by Market Card -->
                    <div class="dash_card">
                        <div class="dash_card_header">
                            <h4 class="dash_card_title">
                                <i class="fa fa-globe" style="color: #0066FF;"></i> {$core->get_Lang('Customers by Market')}
                            </h4>
                            <select id="dash_filter_market" class="dash_select_filter">
                                <option value="this_month" selected>{$core->get_Lang('This month')}</option>
                                <option value="last_month">{$core->get_Lang('Last month')}</option>
                                <option value="this_year">{$core->get_Lang('This year')}</option>
                                <option value="all">{$core->get_Lang('All time')}</option>
                            </select>
                        </div>

                        <div class="dash_market_wrapper">
                            <div class="dash_market_list" id="dash_market_list" style="width: 100%;">
                                {foreach from=$market_breakdown item=item}
                                <div class="dash_market_row" id="dash_market_row_{$item.key}">
                                    <span class="dash_market_flag">
                                        {if $item.flag}
                                            <img src="{$item.flag}" width="20" height="14" alt="{$item.name}" class="dash_flag_img" />
                                        {else}
                                            <span class="dash_flag_dot_other"></span>
                                        {/if}
                                    </span>
                                    <span class="dash_market_name">{$item.name}</span>
                                    <div class="dash_market_bar_bg">
                                        <div class="dash_market_bar_fill" id="dash_market_bar_{$item.key}" style="width: {$item.pct}%; background: {$item.color};"></div>
                                    </div>
                                    <span class="dash_market_pct" id="dash_market_pct_{$item.key}">{$item.pct}%</span>
                                </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT SIDEBAR PANEL -->
        <div class="dash_right_sidebar">
            <!-- Notifications Card -->
            <div class="dash_card dash_notif_card">
                <div class="dash_card_header">
                    <h4 class="dash_card_title">
                        <span style="display:inline-flex; align-items:center; justify-content:center; width:20px; height:20px; border-radius:50%; background:#EE5D50; color:#fff; font-size:10px;"><i class="fa fa-star"></i></span> {$core->get_Lang('Recent Notifications')}
                    </h4>
                    <a href="{$PCMS_URL}/index.php?mod=booking" class="dash_link_viewall">{$core->get_Lang('View all')}</a>
                </div>

                <div class="dash_notif_list">
                    <div class="iso-shell-empty">Loading bookings...</div>
                </div>
            </div>

            <!-- Promo Banner Card -->
            <div class="dash_promo_card">
                <h3 class="dash_promo_title">Turn trips into amazing journeys</h3>
                <p class="dash_promo_desc">Discover new features to grow your travel business with isoCMS.</p>
                <a href="https://vietiso.com" target="_blank" class="dash_btn_demo">
                    <i class="fa fa-play" style="font-size:10px;"></i> Watch demo
                </a>
            </div>
        </div>

    </div>

    <!-- 4. ACTIONS REQUIRED TABLE SECTION -->
    <div class="dash_actions_card">
        <div class="dash_actions_header">
            <div class="dash_actions_left">
                <h4 class="dash_section_title" style="display:flex; align-items:center; gap:8px;">
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:20px; height:20px; border-radius:50%; background:#EE5D50; color:#fff; font-size:10px;"><i class="fa fa-star"></i></span> {$core->get_Lang('Actions Required')}
                </h4>
                <div class="dash_tab_filter_group">
                    <button type="button" class="dash_tab_btn active" data-filter="all">All ({$actions_counts.all|default:0})</button>
                    <button type="button" class="dash_tab_btn" data-filter="pending">Pending ({$actions_counts.pending|default:0})</button>
                    <button type="button" class="dash_tab_btn" data-filter="confirmed">Confirm ({$actions_counts.confirm|default:0})</button>
                    <button type="button" class="dash_tab_btn" data-filter="cancelled">Cancel ({$actions_counts.cancel|default:0})</button>
                    <button type="button" class="dash_tab_btn" data-filter="customer">Customer ({$actions_counts.customer|default:0})</button>
                </div>
            </div>
            <a href="{$PCMS_URL}/?mod=booking&amp;act=list_booking" class="dash_link_viewall" id="dash_link_viewall">{$core->get_Lang('View all')}</a>
        </div>

        <div class="dash_table_container">
            <table class="dash_custom_table">
                <thead>
                    <tr>
                        <th width="70">#</th>
                        <th width="120">{$core->get_Lang('Date')}</th>
                        <th width="190">{$core->get_Lang('Customer')}</th>
                        <th id="dash_th_service">{$core->get_Lang('Service')}</th>
                        <th width="120" class="dash_col_booking_extra">{$core->get_Lang('Amount')}</th>
                        <th width="130" class="dash_col_booking_extra">{$core->get_Lang('Status')}</th>
                        <th width="100" style="text-align: right;">{$core->get_Lang('Action')}</th>
                    </tr>
                </thead>
                <tbody id="dash_booking_tbody">
                    {if $lstBooking && $lstBooking|@count > 0}
                        {section name=i loop=$lstBooking}
                            {assign var=bk_id value=$lstBooking[i].booking_id}
                            {assign var=bk_status_raw value=$lstBooking[i].status}
                            {assign var=bk_status_pay value=$lstBooking[i].status_pay}
                            {if $bk_status_raw eq 6 || $bk_status_raw eq '6' || $bk_status_raw eq 3 || $bk_status_raw eq '3' || $bk_status_raw eq 4 || $bk_status_raw eq '4' || $bk_status_raw eq 'Cancelled' || $bk_status_raw eq 'Canceled' || $bk_status_pay eq 3}
                                {assign var=row_class value="cancelled"}
                                {assign var=status_label value="Cancelled"}
                            {elseif $bk_status_pay eq 1 || $bk_status_raw eq 7 || $bk_status_raw eq '7' || $bk_status_raw eq 1 || $bk_status_raw eq '1' || $bk_status_raw eq 2 || $bk_status_raw eq '2' || $bk_status_raw eq 'Complete' || $bk_status_raw eq 'Approved' || $bk_status_raw eq 'Confirmed' || $bk_status_raw eq 'Reviewed'}
                                {assign var=row_class value="confirmed"}
                                {assign var=status_label value="Confirm"}
                            {elseif $bk_status_pay eq 2 || $bk_status_raw eq 5 || $bk_status_raw eq '5' || $bk_status_raw eq 'Prepaid' || $bk_status_raw eq 'Backordered' || $bk_status_raw eq 'On Hold'}
                                {assign var=row_class value="onhold"}
                                {assign var=status_label value="On Hold"}
                            {else}
                                {assign var=row_class value="pending"}
                                {assign var=status_label value="Pending"}
                            {/if}
                            <tr data-status="{$row_class}">
                                <td><strong>#{$bk_id}</strong></td>
                                <td>{$clsISO->formatDate($lstBooking[i].reg_date,'dot')}</td>
                                <td><strong>{$clsBooking->getDashboardContactName($bk_id)|default:'Customer'}</strong></td>
                                <td>{$clsBooking->getHTMLService($bk_id)|default:$clsBooking->getHTMLServiceOther($bk_id)|default:'Ha Long Bay 5-Star Cruise'}</td>
                                <td><strong>${$clsISO->priceFormat($lstBooking[i].totalgrand)|default:'0'}</strong></td>
                                <td><span class="dash_badge_status {$row_class}">{$status_label}</span></td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <a href="{$PCMS_URL}/?mod=booking&act=edit&action=booking_tour&booking_id={$core->encryptID($bk_id)}" class="dash_btn_action_view">View</a>
                                </td>
                            </tr>
                        {/section}
                    {else}
                        <tr>
                            <td colspan="7" style="text-align:center; padding:32px 16px; color:#A3AED0;">
                                <i class="fa fa-inbox" style="font-size:28px; margin-bottom:8px; display:block; opacity:0.5;"></i>
                                {$core->get_Lang('No bookings found')}
                            </td>
                        </tr>
                    {/if}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DASHBOARD V2 DYNAMIC DATA FOR CHARTS -->
<script type="text/javascript">
    window.dashChartDays = {$chart_days_json|default:'[]'};
    window.dashRevenueData = {$chart_revenue_json|default:'[]'};
    window.dashOrdersData = {$chart_orders_json|default:'[]'};
    window.dashStatusBreakdown = {$status_breakdown_json|default:'[0,0,0,0]'};
    window.dashTotalBookings = {$status_breakdown.total|default:0};
    window.dashLangEmail = '{$core->get_Lang("Email")|default:"Email"}';
    window.dashLangService = '{$core->get_Lang("Service")|default:"Service"}';
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{$URL_JS}/dashboard_v2.js?v={$upd_version}&t=178928"></script>

{literal}
<script type="text/javascript">
    function loadHtmlQuickAccess() {
        if (typeof path_ajax_script !== 'undefined') {
            $.post(path_ajax_script + '/index.php?mod=home&act=load_quick_access', {
                'holderG': '_list'
            }, function (html) {
                $('.quick_access_html').html(html);
                if (typeof window.initQuickAccessCustomizer === 'function') window.initQuickAccessCustomizer();
            });
        }
    }

    $(function () {
        var quickAccessChanged = false;
        $(document).on('quickAccess:changed', function () {
            quickAccessChanged = true;
        });
        $(document).on('click', "#add_task [data-dismiss=\"modal\"], #isoblanketpop_add_task", function () {
            if (quickAccessChanged) {
                window.location.reload();
            }
        });
    });
</script>
{/literal}
