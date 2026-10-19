<div class="container-fluid my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="txt_introh3">
            <h3 class="txt_history">{$core->get_Lang('Actions History')}</h3>
            <p class="txt_introhistory">{$core->get_Lang('Easily track actions like logins, information edits, and transactions made. Data is stored for the last 6 months')}.</p>
        </div>
        <div>
            <button class="btn btn_export">{$core->get_Lang('Export')}</button>
        </div>
    </div>


    <table class="table table-striped table-bordered">
        <thead class="table-light">
        <tr>
            <th>{$core->get_Lang('User')}</th>
            <th>{$core->get_Lang('Operating Area')}</th>
            <th>{$core->get_Lang('Action')}</th>
            <th>{$core->get_Lang('Time Span')}</th>
            <th>{$core->get_Lang('IP Address')}</th>
        </tr>
        <tr class="filter-row">
            <th>
                <select class="form-select form-select-sm">
                    <option selected>All</option>
                    <option value="1">User 1</option>
                    <option value="2">User 2</option>
                </select>
            </th>
            <th>
                <select class="form-select form-select-sm">
                    <option selected>All</option>
                    <option value="1">Admin Roles</option>
                    <option value="2">Admin Settings</option>
                </select>
            </th>
            <th></th>
            <th style="width: 220px;">
                <div class="time-span-box position-relative">
                    <input id="from-date" type="text" placeholder="From">
                    <input id="to-date" type="text" placeholder="To">
                    <button id="clear-filter" class="btn btn-sm btn-outline-secondary position-absolute"
                            style="right: 5px; top: 5px; display: none;">x
                    </button>
                </div>
            </th>
            <th></th>
        </tr>
        </thead>
        <tbody id="data-table">
        <tr class="user_actions">
            <td>
                <a href="#">Ly Tran</a>
            </td>
            <td>Administrator Roles <span class="txt_actionsuser">[Settings]</span></td>
            <td>Read</td>
            <td>31/10/2024, 11:39</td>
            <td>27.73.97.68</td>
        </tr>
        <tr class="user_actions">
            <td>
                <a href="#">Ly Tran</a>
            </td>
            <td>Administrator <span class="txt_actionsuser">[Setting]</span></td>
            <td>Add new administrator (hahohiyi@gmail.com)</td>
            <td>01/09/2024, 10:30</td>
            <td>27.73.97.68</td>
        </tr>

        <tr class="user_actions">
            <td>
                <a href="#">Ly Tran</a>
            </td>
            <td>Administrator <span class="txt_actionsuser">[Setting]</span></td>
            <td>Add new administrator (hahohiyi@gmail.com)</td>
            <td>01/09/2024, 10:30</td>
            <td>27.73.97.68</td>
        </tr>

        </tbody>
    </table>

    <nav>
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">«</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
        </ul>
    </nav>
</div>


{literal}
    <script>
        $(document).ready(function () {
            // Hàm lọc bảng dựa trên khoảng thời gian
            function filterTable(fromDate, toDate) {
                $("#data-table tr").each(function () {
                    const dateCell = $(this).find("td").eq(3).text().trim(); // Lấy nội dung cột chứa ngày
                    const rowDate = new Date(dateCell.split(",")[0]); // Chuyển đổi thành ngày
                    if (rowDate >= fromDate && rowDate <= toDate) {
                        $(this).show(); // Hiển thị dòng
                    } else {
                        $(this).hide(); // Ẩn dòng
                    }
                });
            }

            // Khởi tạo Flatpickr cho trường "From Date"
            flatpickr("#from-date", {
                dateFormat: "d/m/Y",
                onChange: function (selectedDates) {
                    if (selectedDates.length > 0) {
                        const fromDate = selectedDates[0];
                        const maxToDate = new Date(fromDate); // Sao chép ngày "From"
                        maxToDate.setMonth(maxToDate.getMonth() + 6); // Cộng 6 tháng
                        flatpickr("#to-date", {
                            dateFormat: "d/m/Y",
                            minDate: fromDate,
                            maxDate: maxToDate
                        });
                    }
                }
            });

            // Khởi tạo Flatpickr cho trường "To Date"
            flatpickr("#to-date", {
                dateFormat: "d/m/Y",
                onChange: function (selectedDates) {
                    const fromDateInput = $("#from-date").val();
                    const toDateInput = $("#to-date").val();
                    if (fromDateInput && toDateInput) {
                        const fromDate = new Date(fromDateInput.split("/").reverse().join("-"));
                        const toDate = new Date(toDateInput.split("/").reverse().join("-"));
                        filterTable(fromDate, toDate); // Lọc bảng
                        $("#clear-filter").show(); // Hiện nút xóa
                    }
                }
            });

            // Nút xóa bộ lọc
            $("#clear-filter").on("click", function () {
                $("#from-date").val(""); // Xóa giá trị ô nhập
                $("#to-date").val(""); // Xóa giá trị ô nhập
                $(this).hide(); // Ẩn nút xóa

                // Hiển thị tất cả các dòng trong bảng
                $("#data-table tr").show();
            });
        });
    </script>

    <style>
        .txt_history {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 28px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 42px */
        }

        .txt_introhistory {
            color: var(--chroma-717171, #717171);
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        .btn_export {
            display: inline-flex;
            padding: 12px 16px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
            color: #FFF;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 24px */
        }

        .btn_export:hover {
            background: var(--secondary-177-fa-4, #177FA4);
            color: #FFF;
        }

        .table-light tr th {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 21px */
            text-transform: uppercase;
        }

        .user_actions {
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        .user_actions td a {
            color: var(--secondary-177-fa-4, #177FA4);
        }

        .user_actions td {
            color: var(--primary-1-d-2-d-53, #1D2D53);
        }

        .user_actions .txt_actionsuser {
            color: var(--chroma-a-5-a-5-a-5, #A5A5A5);
        }

        .form-select-sm {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
        }

        /* Căn chỉnh hộp chọn ngày */
        .time-span-box {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .time-span-box input {
            padding: 6px 8px;
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: 5px;
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
        }

        .table-bordered > :not(caption) > * {
            border-width: inherit;
        }

        .table > thead > tr > th, #data-table tr {
            border-left: none;
            border-right: none;
        }

        .table-light {
            --bs-table-bg: #FFF;
        }

        .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
            border-bottom-width: thin;
        }

        /* Loại bỏ viền toàn bảng */
        .table {
            border-collapse: collapse; /* Gộp viền để dễ loại bỏ */
            border: none; /* Loại bỏ viền toàn bảng */
        }

        /* Loại bỏ viền giữa các cột và hàng */
        .table th,
        .table td {
            border: none; /* Không viền giữa các ô */
        }

        /* Loại bỏ đường ngang giữa các hàng dữ liệu */
        .table tbody tr {
            border: none; /* Không kẻ ngang giữa các hàng */
        }

        /* Giữ màu nền tiêu đề nếu cần */
        .table-light {
            background-color: #f8f9fa; /* Màu nền nhạt cho tiêu đề */
        }

        /* Đặt nền trắng cho nội dung bảng để trông gọn gàng */
        .table tbody tr {
            background-color: white; /* Nền trắng cho các hàng */
        }

        .table-bordered > tbody > tr > td {
            border: none;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > * {
            --bs-table-bg-type: #F9F9F9;
        }

        .pagination {
            margin-top: 24px;
        }

        .pagination .page-link {
            color: var(--primary-18-babd, #18BABD);
            background-color: white; /* Nền trắng */
            border: 1px solid #dee2e6; /* Viền nhẹ */
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        /* Nút phân trang khi di chuột */
        .pagination .page-link:hover {
            background-color: #e6f7f9; /* Màu nền khi hover */
            color: #17a2b8; /* Màu chữ khi hover */
        }

        /* Nút phân trang đang được chọn (active) */
        .pagination .page-item.active .page-link {
            background-color: var(--primary-18-babd, #18BABD);
            color: white; /* Màu chữ trắng */
            border-color: var(--primary-18-babd, #18BABD);
        }

        /* Nút phân trang bị vô hiệu hóa (disabled) */
        .pagination .page-item.disabled .page-link {
            color: #6c757d; /* Màu chữ mờ */
            background-color: #f8f9fa; /* Màu nền xám nhạt */
            border-color: #dee2e6; /* Viền nhạt */
        }

    </style>
{/literal}