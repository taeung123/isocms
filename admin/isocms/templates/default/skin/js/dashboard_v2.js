/**
 * DASHBOARD V2 - JAVASCRIPT & HIGHCHARTS CONTROLLER
 */

(function ($) {
    'use strict';

    var dashRevenueChart = null;
    var dashDonutChart = null;

    $(document).ready(function () {
        initRevenueChart();
        initBookingStatusDonut();
        initChartFilters();
        initTableTabsFilter();
        initQuickAccessActions();

        // Reflow Highcharts on resize for fluid responsiveness
        var resizeDebounce = null;
        $(window).on('resize', function () {
            clearTimeout(resizeDebounce);
            resizeDebounce = setTimeout(function () {
                if (typeof Highcharts !== 'undefined' && Highcharts.charts) {
                    Highcharts.charts.forEach(function (c) {
                        if (c && typeof c.reflow === 'function') {
                            c.reflow();
                        }
                    });
                }
            }, 100);
        });
    });

    /**
     * AJAX FILTERS FOR CHARTS WITH SMOOTH TRANSITIONS
     */
    function initChartFilters() {
        // 1. Revenue Overview Filter
        $('#dash_filter_revenue').on('change', function () {
            var $select = $(this);
            var selectedFilter = $select.val();
            var $card = $select.closest('.dash_card');
            if (typeof path_ajax_script === 'undefined') return;

            $card.addClass('dash_loading');
            $select.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=home&act=ajGetRevenueOverviewData',
                data: { 'time_filter': selectedFilter },
                dataType: 'json',
                success: function (res) {
                    if (res && res.status === 'success') {
                        $('#dash_rev_big_val').text(res.total_revenue);
                        $('#dash_rev_trend_val').html('<i class="fa fa-arrow-up"></i> ' + res.revenue_pct);
                        $('#dash_rev_period_val').text(res.period_label);

                        window.dashChartDays = res.categories;
                        window.dashRevenueData = res.revenue_series;
                        window.dashOrdersData = res.orders_series;

                        if (dashRevenueChart && typeof dashRevenueChart.updateOptions === 'function') {
                            dashRevenueChart.updateOptions({
                                xaxis: { categories: res.categories },
                                series: [
                                    { name: 'Revenue', data: res.revenue_series },
                                    { name: 'Orders', data: res.orders_series }
                                ]
                            }, false, true);
                        } else {
                            initRevenueChart();
                        }
                    }
                },
                complete: function () {
                    $card.removeClass('dash_loading');
                    $select.prop('disabled', false);
                }
            });
        });

        // 2. Bookings by Status Filter
        $('#dash_filter_status').on('change', function () {
            var $select = $(this);
            var selectedFilter = $select.val();
            var $card = $select.closest('.dash_card');
            if (typeof path_ajax_script === 'undefined') return;

            $card.addClass('dash_loading');
            $select.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=home&act=ajGetBookingStatusData',
                data: { 'time_filter': selectedFilter },
                dataType: 'json',
                success: function (res) {
                    if (res && res.status === 'success') {
                        $('#dash_status_center_num').text(res.total);
                        if (res.confirmed) {
                            $('#dash_st_pct_confirmed').text(res.confirmed.pct + '%');
                            $('#dash_st_cnt_confirmed').text(res.confirmed.count);
                        }
                        if (res.pending) {
                            $('#dash_st_pct_pending').text(res.pending.pct + '%');
                            $('#dash_st_cnt_pending').text(res.pending.count);
                        }
                        if (res.onhold) {
                            $('#dash_st_pct_onhold').text(res.onhold.pct + '%');
                            $('#dash_st_cnt_onhold').text(res.onhold.count);
                        }
                        if (res.cancelled) {
                            $('#dash_st_pct_cancelled').text(res.cancelled.pct + '%');
                            $('#dash_st_cnt_cancelled').text(res.cancelled.count);
                        }

                        window.dashStatusBreakdown = res.series;
                        window.dashTotalBookings = res.total;

                        if (dashDonutChart && typeof dashDonutChart.updateSeries === 'function') {
                            dashDonutChart.updateSeries(res.series, true);
                        } else if (dashDonutChart && typeof dashDonutChart.updateOptions === 'function') {
                            dashDonutChart.updateOptions({
                                series: res.series
                            }, false, true);
                        } else {
                            initBookingStatusDonut();
                        }
                    }
                },
                complete: function () {
                    $card.removeClass('dash_loading');
                    $select.prop('disabled', false);
                }
            });
        });

        // 3. Customers by Market Filter
        $('#dash_filter_market').on('change', function () {
            var $select = $(this);
            var selectedFilter = $select.val();
            var $card = $select.closest('.dash_card');
            if (typeof path_ajax_script === 'undefined') return;

            $card.addClass('dash_loading');
            $select.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=home&act=ajGetMarketData',
                data: { 'time_filter': selectedFilter },
                dataType: 'json',
                success: function (res) {
                    if (res && res.status === 'success' && res.data) {
                        $.each(res.data, function (i, item) {
                            var $row = $('#dash_market_row_' + item.key);
                            var $bar = $('#dash_market_bar_' + item.key);
                            var $pct = $('#dash_market_pct_' + item.key);
                            if ($bar.length) {
                                $bar.css({
                                    'width': item.pct + '%',
                                    'background': item.color
                                });
                            }
                            if ($pct.length) {
                                $pct.text(item.pct + '%');
                            }
                            if ($row.length) {
                                $('#dash_market_list').append($row);
                            }
                        });
                    }
                },
                complete: function () {
                    $card.removeClass('dash_loading');
                    $select.prop('disabled', false);
                }
            });
        });
    }

    /**
     * 1. REVENUE OVERVIEW SPLINE / AREA CHART
     */
    function initRevenueChart() {
        var chartElem = document.getElementById('dash_revenue_chart');
        if (!chartElem) return;

        var revCategories = window.dashChartDays || ['1 Sep', '5 Sep', '10 Sep', '15 Sep', '20 Sep', '25 Sep', '30 Sep'];
        var revData = window.dashRevenueData || [0, 0, 0, 0, 0, 0, 0];
        var ordData = window.dashOrdersData || [0, 0, 0, 0, 0, 0, 0];

        if (typeof ApexCharts !== 'undefined') {
            chartElem.innerHTML = '';
            var options = {
                series: [
                    { name: 'Revenue', data: revData },
                    { name: 'Orders', data: ordData }
                ],
                chart: {
                    type: 'area',
                    height: 215,
                    sparkline: { enabled: false },
                    toolbar: { show: false },
                    zoom: { enabled: false },
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 600,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 450
                        }
                    }
                },
                colors: ['#0066FF', '#05CD99'],
                stroke: {
                    curve: 'smooth',
                    width: [3, 2.5]
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.28,
                        opacityTo: 0.02,
                        stops: [0, 90, 100]
                    }
                },
                markers: {
                    size: 0,
                    hover: { size: 6 }
                },
                xaxis: {
                    categories: revCategories,
                    labels: {
                        rotate: 0,
                        rotateAlways: false,
                        hideOverlappingLabels: true,
                        style: { colors: '#A3AED0', fontSize: '9px', fontWeight: 500 }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: [
                    {
                        labels: {
                            offsetX: -4,
                            style: { colors: '#A3AED0', fontSize: '9px', fontWeight: 500 },
                            formatter: function (val) {
                                if (val >= 1000000000) return (val / 1000000000).toFixed(1).replace(/\.0$/, '') + 'B';
                                if (val >= 1000000) return (val / 1000000).toFixed(0) + 'M';
                                if (val >= 1000) return (val / 1000).toFixed(0) + 'K';
                                return val;
                            }
                        }
                    },
                    {
                        opposite: true,
                        show: false
                    }
                ],
                grid: {
                    borderColor: '#F4F7FE',
                    strokeDashArray: 4,
                    padding: { top: 0, right: 10, bottom: 0, left: 10 }
                },
                legend: { show: false },
                dataLabels: { enabled: false },
                tooltip: {
                    theme: 'dark',
                    shared: true,
                    intersect: false,
                    style: { fontSize: '11px', fontFamily: 'Plus Jakarta Sans, sans-serif' },
                    y: {
                        formatter: function (val, opts) {
                            if (typeof val === 'undefined') return '';
                            return opts.seriesIndex === 0 ? '$ ' + Number(val).toLocaleString() : val + ' orders';
                        }
                    }
                }
            };
            dashRevenueChart = new ApexCharts(chartElem, options);
            dashRevenueChart.render();
            return;
        }

        if (typeof Highcharts !== 'undefined') {
            Highcharts.chart('dash_revenue_chart', {
                chart: {
                    type: 'spline',
                    backgroundColor: 'transparent',
                    height: 210,
                    spacing: [10, 0, 10, 0]
                },
                title: { text: null },
                credits: { enabled: false },
                legend: { enabled: false },
                xAxis: {
                    categories: revCategories,
                    labels: {
                        rotation: 0,
                        style: { color: '#A3AED0', fontSize: '9px', fontWeight: '500', fontFamily: 'Plus Jakarta Sans, sans-serif' }
                    },
                    lineColor: '#E9EDF7',
                    tickColor: '#E9EDF7'
                },
                yAxis: {
                    title: { text: null },
                    labels: {
                        formatter: function () {
                            var val = this.value;
                            if (val >= 1000000000) return (val / 1000000000).toFixed(1).replace(/\.0$/, '') + 'B';
                            if (val >= 1000000) return (val / 1000000).toFixed(0) + 'M';
                            if (val >= 1000) return (val / 1000).toFixed(0) + 'K';
                            return val;
                        },
                        style: { color: '#A3AED0', fontSize: '9px', fontWeight: '500', fontFamily: 'Plus Jakarta Sans, sans-serif' }
                    },
                    gridLineColor: '#F4F7FE'
                },
                tooltip: {
                    shared: true,
                    useHTML: true,
                    backgroundColor: '#111C44',
                    borderRadius: 10,
                    borderWidth: 0,
                    style: { color: '#FFFFFF', fontSize: '12px', fontFamily: 'Plus Jakarta Sans, sans-serif' },
                    formatter: function () {
                        var s = '<div style="padding: 4px 6px; font-family: Plus Jakarta Sans, sans-serif;"><b>' + this.x + ' 2026</b><br/>';
                        $.each(this.points, function () {
                            var val = this.series.name === 'Revenue' ? '$ ' + Highcharts.numberFormat(this.y, 0, ',', '.') : this.y;
                            s += '<span style="color:' + this.series.color + '">●</span> ' + this.series.name + ': <b>' + val + '</b><br/>';
                        });
                        s += '</div>';
                        return s;
                    }
                },
                plotOptions: {
                    spline: {
                        lineWidth: 3,
                        marker: {
                            enabled: false,
                            radius: 4,
                            states: {
                                hover: { enabled: true, radius: 6, lineWidth: 2, lineColor: '#FFFFFF' }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Revenue',
                    color: '#0066FF',
                    data: revData
                }, {
                    name: 'Orders',
                    color: '#05CD99',
                    data: ordData
                }]
            });
        }
    }

    /**
     * 2. BOOKINGS BY STATUS DONUT CHART
     */
    function initBookingStatusDonut() {
        var donutElem = document.getElementById('dash_status_donut');
        if (!donutElem) return;

        var seriesValues = window.dashStatusBreakdown || [0, 0, 0, 0, 0];
        var totalBookings = window.dashTotalBookings || 0;

        if (typeof ApexCharts !== 'undefined') {
            donutElem.innerHTML = '';
            var donutOptions = {
                series: seriesValues,
                labels: ['Confirmed', 'Pending', 'On Hold', 'Cancelled'],
                chart: {
                    type: 'donut',
                    height: 140,
                    width: 140,
                    fontFamily: 'Plus Jakarta Sans, sans-serif',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 600,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 450
                        }
                    }
                },
                colors: ['#05CD99', '#FFB547', '#0066FF', '#EE5D50'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',
                            labels: {
                                show: false
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 2, colors: ['#FFFFFF'] },
                legend: { show: false },
                tooltip: {
                    theme: 'dark',
                    style: { fontSize: '11px', fontFamily: 'Plus Jakarta Sans, sans-serif' },
                    y: {
                        formatter: function (val) {
                            return val + ' Bookings';
                        }
                    }
                }
            };
            dashDonutChart = new ApexCharts(donutElem, donutOptions);
            dashDonutChart.render();
            return;
        }

        if (typeof Highcharts !== 'undefined') {
            var statusData = [
                { name: 'Confirmed', y: seriesValues[0] || 0, color: '#05CD99' },
                { name: 'Pending', y: seriesValues[1] || 0, color: '#FFB547' },
                { name: 'On Hold', y: seriesValues[2] || 0, color: '#0066FF' },
                { name: 'Cancelled', y: seriesValues[3] || 0, color: '#EE5D50' }
            ];

            Highcharts.chart('dash_status_donut', {
                chart: {
                    type: 'pie',
                    backgroundColor: 'transparent',
                    height: 140,
                    margin: [0, 0, 0, 0],
                    spacing: [0, 0, 0, 0]
                },
                title: { text: null },
                credits: { enabled: false },
                tooltip: {
                    pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b> ({point.y})',
                    backgroundColor: '#111C44',
                    borderRadius: 8,
                    style: { color: '#FFFFFF', fontSize: '11px', fontFamily: 'Plus Jakarta Sans, sans-serif' }
                },
                plotOptions: {
                    pie: {
                        innerSize: '70%',
                        borderWidth: 2,
                        borderColor: '#FFFFFF',
                        dataLabels: { enabled: false }
                    }
                },
                series: [{
                    name: 'Status',
                    data: statusData
                }]
            });
        }
    }

    /**
     * 3. ACTIONS REQUIRED TABS FILTER (MAX 10 ITEMS PER TAB)
     */
    function initTableTabsFilter() {
        var tabCache = {};

        $('.dash_tab_btn').on('click', function () {
            var $this = $(this);
            var statusFilter = $this.data('filter');

            $('.dash_tab_btn').removeClass('active');
            $this.addClass('active');

            // Customer uses the same booking columns and shows the latest
            // booking attached to each customer.
            if (statusFilter === 'customer') {
                $('#dash_th_service').text(window.dashLangService || 'Service');
                $('.dash_col_booking_extra').show();
                $('#dash_link_viewall').attr('href', (typeof path_ajax_script !== 'undefined' ? path_ajax_script : '') + '/?mod=booking&act=list_booking&booking_tab=customer');
            } else {
                $('#dash_th_service').text(window.dashLangService || 'Service');
                $('.dash_col_booking_extra').show();
                $('#dash_link_viewall').attr('href', (typeof path_ajax_script !== 'undefined' ? path_ajax_script : '') + '/?mod=booking&act=list_booking');
            }

            if (tabCache[statusFilter]) {
                $('#dash_booking_tbody').html(tabCache[statusFilter]);
                return;
            }

            if (typeof path_ajax_script === 'undefined') return;

            var $tbody = $('#dash_booking_tbody');
            $tbody.css('opacity', '0.5');

            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=home&act=ajGetActionsRequired',
                data: { 'filter_tab': statusFilter },
                dataType: 'json',
                success: function (res) {
                    if (res && res.status === 'success' && res.html) {
                        tabCache[statusFilter] = res.html;
                        $tbody.html(res.html);
                    }
                },
                complete: function () {
                    $tbody.css('opacity', '1');
                }
            });
        });
    }

    /**
     * 4. QUICK ACCESS MANAGEMENT POPUP
     */
    function initQuickAccessActions() {
        window.dash_manager_tasks = function () {
            if (typeof path_ajax_script !== 'undefined' && typeof $Core !== 'undefined' && $Core.popup) {
                $.post(path_ajax_script + '/index.php?mod=home&act=load_quick_access', {
                    'holderG': '_modal'
                }, function (html) {
                    $Core.popup.open('auto', 'auto', html, 'add_task');
                    $('#add_task').addClass('tm-quick-popup-shell');
                    $('#isoblanketpop_add_task').css('z-index', '9998');
                    $('#add_task').css('z-index', '9999');
                    repositionQuickAccessPopup();
                    if (typeof loadHtmlQuickAccess === 'function') {
                        loadHtmlQuickAccess();
                    }
                });
            }
        };
    }

    function repositionQuickAccessPopup() {
        var $popup = $('#add_task.tm-quick-popup-shell');
        if (!$popup.length) return;
        $popup.css({
            left: Math.max(12, ($(window).width() - $popup.outerWidth()) / 2) + 'px',
            top: Math.max(12, ($(window).height() - $popup.outerHeight()) / 2) + 'px'
        });
    }

    window.initQuickAccessCustomizer = function () {
        var $modal = $('.tm-quick-modal');
        var $tiles = $modal.find('.tm-quick-feature-tile');
        var $search = $modal.find('#tmQuickSearch');
        var activeFilter = $modal.find('.tm-quick-modal__tab.is-active').data('quick-filter') || 'all';
        var filterSnapshot = {};
        var selectedIds = $tiles.filter('[data-quick-state="selected"]').map(function () {
            return $(this).data('adminbutton_id');
        }).get();

        $modal.find('#tmQuickSelectedCount').text(selectedIds.length);
        $modal.find('#tmQuickSelectAll').prop('checked', $tiles.length > 0 && selectedIds.length === $tiles.length);

        function syncQuickAccess(selected) {
            if (typeof path_ajax_script === 'undefined' || $modal.hasClass('is-syncing')) return;
            $modal.addClass('is-syncing');
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=home&act=load_quick_access',
                data: {
                    holderG: 'sync',
                    selected_ids: selected
                },
                dataType: 'html',
                success: function (response) {
                    if ($.trim(response) === '_success') {
                        $(document).trigger('quickAccess:changed');
                        window.location.reload();
                        return;
                    }
                    $modal.removeClass('is-syncing');
                },
                error: function () {
                    $modal.removeClass('is-syncing');
                }
            });
        }

        function applyQuickAccessFilter() {
            var query = $.trim($search.val() || '').toLowerCase();
            var visibleCount = 0;

            $modal.find('.tm-quick-select-all').toggle(activeFilter === 'all');

            $tiles.each(function () {
                var $tile = $(this);
                var adminbuttonId = String($tile.data('adminbutton_id'));
                var stateMatches = activeFilter === 'all' || filterSnapshot[adminbuttonId] === activeFilter;
                var name = String($tile.data('feature-name') || '').toLowerCase();
                var searchMatches = !query || name.indexOf(query) !== -1;
                var isVisible = stateMatches && searchMatches;
                $tile.toggleClass('is-hidden', !isVisible);
                if (isVisible) visibleCount++;
            });

            $modal.find('.tm-quick-modal__empty').remove();
            if (!visibleCount) {
                $modal.find('#tmQuickFeatureGrid').after(
                    '<div class="tm-quick-modal__empty"><i class="fa fa-search"></i> ' + $modal.data('empty-message') + '</div>'
                );
            }
        }

        $modal.off('.quickCustomizer');
        $modal.on('click.quickCustomizer', '.tm-quick-modal__tab', function () {
            var $tab = $(this);
            activeFilter = $tab.data('quick-filter') || 'all';
            filterSnapshot = {};
            $tiles.each(function () {
                var $tile = $(this);
                filterSnapshot[String($tile.data('adminbutton_id'))] = $tile.data('quick-state');
            });
            $modal.find('.tm-quick-modal__tab').removeClass('is-active').attr('aria-selected', 'false');
            $tab.addClass('is-active').attr('aria-selected', 'true');
            applyQuickAccessFilter();
        });
        $modal.on('input.quickCustomizer', '#tmQuickSearch', applyQuickAccessFilter);
        $modal.on('click.quickCustomizer', '.tm-quick-feature-tile', function () {
            var $tile = $(this);
            var isSelected = !$tile.hasClass('is-selected');
            $tile.toggleClass('is-selected', isSelected);
            $tile.attr('data-quick-state', isSelected ? 'selected' : 'available');
            $tile.data('quick-state', isSelected ? 'selected' : 'available');
            $tile.find('.tm-quick-feature-checkbox').prop('checked', isSelected);

            var selectedCount = $tiles.filter('.is-selected').length;
            $modal.find('#tmQuickSelectedCount').text(selectedCount);
            $modal.find('#tmQuickSelectAll').prop('checked', $tiles.length > 0 && selectedCount === $tiles.length);
            if (activeFilter === 'all') applyQuickAccessFilter();
        });
        $modal.on('change.quickCustomizer', '#tmQuickSelectAll', function () {
            var isSelected = this.checked;
            $tiles.toggleClass('is-selected', isSelected)
                .attr('data-quick-state', isSelected ? 'selected' : 'available')
                .data('quick-state', isSelected ? 'selected' : 'available');
            $tiles.find('.tm-quick-feature-checkbox').prop('checked', isSelected);
            $modal.find('#tmQuickSelectedCount').text(isSelected ? $tiles.length : 0);
            applyQuickAccessFilter();
        });
        $modal.on('click.quickCustomizer', '#tmQuickReset', function () {
            $tiles.each(function () {
                var $tile = $(this);
                var isSelected = String($tile.data('quick-default')) === '1';
                $tile.toggleClass('is-selected', isSelected);
                $tile.attr('data-quick-state', isSelected ? 'selected' : 'available');
                $tile.data('quick-state', isSelected ? 'selected' : 'available');
                $tile.find('.tm-quick-feature-checkbox').prop('checked', isSelected);
            });
            var defaultCount = $tiles.filter('.is-selected').length;
            $modal.find('#tmQuickSelectedCount').text(defaultCount);
            $modal.find('#tmQuickSelectAll').prop('checked', $tiles.length > 0 && defaultCount === $tiles.length);
            applyQuickAccessFilter();
        });
        $modal.on('click.quickCustomizer', '#tmQuickSave', function () {
            var idsToSave = $tiles.filter('.is-selected').map(function () {
                return $(this).data('adminbutton_id');
            }).get();
            syncQuickAccess(idsToSave);
        });

        applyQuickAccessFilter();
        repositionQuickAccessPopup();
    };

})(jQuery);
