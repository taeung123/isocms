<script src="{$URL_JS}/highchart/highcharts.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/exporting.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/export-data.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/accessibility.js?v={$upd_version}"></script>

<!-- Thêm CSS cho daterangepicker -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<div class="top_chart_bookingnumber">
    <!-- Khu vực hiển thị tổng số booking -->
    <div class="left_info">
        <div id="booking_number">{$clsBooking->countTotalAllBooking($lstBooking2)}</div> <!-- Số booking tạm thời -->
        <div id="booking_label">{$core->get_Lang('Booking')}</div>
    </div>

    <!-- Khu vực hiển thị tổng số contacts to order -->
    <div class="left_info">
        <div id="contacts_number">50</div> <!-- Số contacts to order tạm thời -->
        <div id="contacts_label">{$core->get_Lang('Contacts to order')}</div>
    </div>
</div>

<div id="booking_chart"></div>

{literal}
    <style>
        .top_chart_bookingnumber {
            display: flex;
            justify-content: left;
            align-items: center;
            min-height: 55px;
            height: 100%;
            color: #1D2D53;
            font-size: 16px;
            font-weight: 400;
            gap: 20px; /* Tạo khoảng cách giữa hai mục */
        }

        .left_info {
            display: flex;
            flex-direction: column;
            align-items: center; /* Căn giữa nội dung */
            gap: 4px;
        }

        #booking_number, #contacts_number {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 28px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 42px */
        }

        #booking_label, #contacts_label {
            color: #666;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
        }

        /* Responsive */
        @media (max-width: 767px) {
            .top_chart_bookingnumber {
                display: block;
            }
        }

        .highcharts-container {
            width: 100% !important;
        }

        .highcharts-root {
            width: 100% !important;
        }

        .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top {
            right: auto;
            left: 305px !important;
        }
        .chart_booking .home_box.chart_booking_box {
            width: 100% !important;
        }
        .right_chart {
            display: flex;
            gap: 10px;
            align-items: center;
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
        }
        .top_chart_booking .right_chart_booking {
            width: 100%;
            max-width: 200px;
            display: unset;
        }
        .highcharts-container, .highcharts-root {
            width: 100% !important;
        }

        #booking_chart {
            width: 100%;
            height: auto;
            margin: 0 auto;
        }
        .top_chart_booking {
            min-height: 55px;
            height: 100%;
        }
        @media (max-width: 767px) {
            .top_chart_booking {
                display: unset;
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            // Gọi fillter_chart ban đầu với 'all' và thời gian mặc định là 'day' (để hiển thị theo giờ)
            fillter_chart('all', 'day'); // Đặt mặc định là 'day'

            // Đặt một hàm cập nhật biểu đồ khi bất kỳ mục chọn nào thay đổi
            function updateChart() {
                var cat = $('#booking_cat_select').val();
                var timePeriod = $('#time_select').val();
                var year = $('.year_chart_booking').val();
                console.log("Loại:", cat, "Thời gian:", timePeriod, "Năm:", year); // Để kiểm tra giá trị
                fillter_chart(cat, timePeriod);
            }

            // Gắn hàm cập nhật cho các sự kiện thay đổi của mục chọn
            $('.year_chart_booking').change(updateChart);
            $('#booking_cat_select').change(updateChart);
            $('#time_select').change(updateChart);
        });

        function fillter_chart(cat, timePeriod) {
            var year = $('.year_chart_booking').val();

            $.ajax({
                type: "POST",
                data: { year: year, cat: cat, timePeriod: timePeriod },
                dataType: 'json',
                url: path_ajax_script + "/index.php?mod=homenew2024&act=ajaxChartBooking",
                success: function (json) {
                    if (json && json.categories && json.itemSuccess && json.itemFail) {
                        Highcharts.chart('booking_chart', {
                            chart: {
                                type: 'column',
                                width: null,
                            },
                            accessibility: {
                                description: 'Booking'
                            },
                            title: {
                                text: ''
                            },
                            xAxis: {
                                categories: json.categories,
                                crosshair: true,
                                labels: {
                                    rotation: 0,
                                    style: {
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: ''
                                }
                            },
                            tooltip: {
                                shared: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                name: 'Booking thành công',
                                color: 'rgba(116, 174, 118, 1)',
                                data: json.itemSuccess,
                                marker: {
                                    symbol: 'square'
                                }
                            }, {
                                name: 'Booking đã hủy',
                                color: 'rgba(246, 164, 118, 1)',
                                data: json.itemFail,
                                marker: {
                                    symbol: 'square'
                                }
                            }],
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'top',
                                itemMarginBottom: 10
                            },
                            exporting: {
                                enabled: false
                            },
                            credits: {
                                enabled: false
                            }
                        });
                    } else {
                        console.error("Lỗi: Dữ liệu trả về không đúng định dạng hoặc bị thiếu.");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Lỗi kết nối AJAX:", textStatus, errorThrown);
                }
            });
        }
    </script>
{/literal}
