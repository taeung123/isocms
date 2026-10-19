<section class="hnv_setting_main">
    <div class="container-fluid">
        <div class="row">
            <div class="iso_setting_row col-md-12 col-lg-3 col-xl-2">
                {$core->getBlock('box_setting_menu')}
            </div>
            <div class="iso_setting_row col-md-12 col-lg-9 col-xl-10">
                <div class="hnv_setting_main_right {$action}">
                    <div class="tab-content" id="nav-tabSetting">
                        {$core->getBlock($setting_block)}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{$URL_JS}/languages.min.js"></script>
<link href="https://unpkg.com/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://unpkg.com/flatpickr"></script>
<script> 
    let txtSelect = `{$core->get_Lang('Select option')}`;
</script>
{literal}
    <style>
        .hnv_setting_main {
            background: #fff;
        }
        .hnv_setting_main_left,
        .hnv_setting_main_right {
            margin-top: 36px;
        }
        .hnv_setting_main_left_title h3 {
            color: #222;
            font-family: Roboto;
            font-size: 20px;
            font-style: normal;
            font-weight: 700;
            line-height: 150%; /* 30px */
        }
        .hnv_list_tab {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .hnv_list_tab .list-group-item, .hnv_list_tab .box_lst_setting_title {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 21px */
            border: unset;
            border-radius: 4px;
            background: #FFF;
            /*box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.04);*/
            cursor: pointer;
        }
        .hnv_list_tab .hnv_list_tab_sub {
            margin-top: 10px;
        }
        .hnv_list_tab .list-group-item.active, .hnv_list_tab .box_lst_setting_title.active {
            color: #fff;
            background: #191F2F;
        }
        .hnv_list_tab_sub .list-group-item.active2 {
            color: var(--secondary-177-fa-4, #177FA4);
            background: #fff;
        }
        .list-group-item-child{
            font-weight: 400 !important;
        }
        .hnv_setting_main_right {
            padding: 0 20px;
        }
        .hnv_setting_main_right_title {
            margin-bottom: 20px;
        }
        .hnv_setting_main_right_title h2 {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 28px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 42px */
        }
        .hnv_setting_main_right_content_avatar_upload_circle_content {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }
        .hnv_setting_main_right_content_avatar_title {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
            margin-bottom: 6px;
        }
        .hnv_setting_main_right_content_avatar_upload_circle {
            width: 160px;
            height: 160px;
            background: #E8F8F8;
            border: 2px dashed #ccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
        }
        .hnv_setting_main_right_content_avatar_upload_text_top {
            color: var(--primary-18-babd, #18BABD);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 24px */
        }
        .hnv_setting_main_right_content_avatar_upload_text_bot {
            color: var(--chroma-a-5-a-5-a-5, #A5A5A5);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 21px */
        }
        .upload_input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            width: 160px;
            height: 160px;
            border-radius: 50%;
        }
        .hnv_setting_main_right_content .form-label {
            color: var(--chroma-717171, #717171);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
        }
        .hnv_setting_main_right_content .form-control,
        .hnv_setting_main_right_content .form-select {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
            padding: 10px 12px;
        }
        .hnv_setting_main_right_content .btn_change_password {
            color: var(--primary-18-babd, #18BABD) !important;
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 24px */
        }
        #hnv_setting_profile #iso-email,
        #hnv_setting_profile #iso-password {
            background: var(--chroma-dadfe-6, #DADFE6);
        }
        .hnv_btn_submit_form {
            color: #FFF;
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 24px */
            display: inline-flex;
            padding: 12px 16px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 4px;
            background: var(--chroma-c-8-cbd-0, #C8CBD0);
            margin-top: 16px;
            float: right;
        }
        .mb_20 {
            margin-bottom: 20px;
        }
        .mb_24 {
            margin-bottom: 24px;
        }
        .mb_30 {
            margin-bottom: 30px;
        }
        .hnv_list_tab_sub {
            display: none;
        }
        .hnv_setting_main_right_title p {
            color: var(--chroma-717171, #717171);
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }
        .iso_setting_row{
            border-right: 1px solid #DADFE6;
        }
        @media (min-width: 992px) and (max-width: 1199px) {}
        @media (min-width: 375px) {}
        @media (min-width: 576px) {}
        @media (min-width: 768px) {}
        @media (min-width: 992px) {
            .hnv_setting_main_left {
                height: 100vh;
                padding-left: 13px;
                padding-right: 16px;
            }
            .hnv_setting_main_right_content .btn_change_password {
                position: absolute;
                top: 50%;
                left: 10px;
            }
        }
        @media (min-width: 1200px) {}
        @media (min-width: 1401px) {}
        @media (max-width: 1400px) {}
        @media (max-width: 1200px) {}
        @media (max-width: 992px) {}
        @media (max-width: 768px) {}
        @media (max-width: 576px) {}
        @media (max-width: 375px) {}
    </style>

    <script>
        $(document).ready(function() {
            const $uploadInput = $('.upload_input');
            const $uploadCircle = $('.hnv_setting_main_right_content_avatar_upload_circle');
            let hasUploadedImage = false; // Biến để kiểm tra xem đã tải ảnh lên hay chưa

            // Gán sự kiện 'change' cho phần tử 'uploadInput'
            $uploadInput.on('change', handleFileSelect);
            // Gán sự kiện 'dragover' cho phần tử 'uploadCircle'
            $uploadCircle.on('dragover', handleDragOver);
            // Gán sự kiện 'drop' cho phần tử 'uploadCircle'
            $uploadCircle.on('drop', handleDrop);

            // Gán sự kiện 'click' cho phần tử 'uploadCircle'
            $uploadCircle.on('click', function() {
                // Nếu đã tải ảnh lên
                if (hasUploadedImage) {
                    // Gọi sự kiện click của 'uploadInput'
                    $uploadInput.click();
                    // Gán lại sự kiện 'change'
                    $uploadInput.on('change', handleFileSelect);
                }
            });
            // Hàm xử lý khi chọn ảnh
            function handleFileSelect(event) {
                event.preventDefault();
                handleFiles(event.target.files); // Gọi hàm xử lý ảnh
            }
            // Hàm xử lý khi kéo và thả ảnh
            function handleDrop(event) {
                event.preventDefault();
                handleFiles(event.originalEvent.dataTransfer.files); // Gọi hàm xử lý ảnh
            }
            // Hàm xử lý các ảnh
            function handleFiles(files) {
                console.log(vietiso_loading(1));
                vietiso_loading(1);
                if (files.length === 0) { // Kiểm tra nếu không có ảnh nào được chọn
                    console.error('No files selected'); // In ra lỗi không có ảnh nào được chọn
                    return;
                }
                const file = files[0]; // Lấy ảnh đầu tiên từ danh sách ảnh
                if (!(file instanceof Blob)) { // Kiểm tra nếu ảnh không thuộc loại 'Blob'
                    console.error('File is not of type Blob'); // In ra lỗi ảnh không đúng loại
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) { // Khi quá trình đọc ảnh hoàn thành
                    $uploadCircle.html('<img src="' + e.target.result + '" alt="Uploaded Image" style="width: 100%; height: 100%; border-radius: 50%;">');
                    vietiso_loading(0);
                    hasUploadedImage = true; // Đánh dấu đã tải ảnh lên
                };
                reader.readAsDataURL(file); // Đọc ảnh dưới dạng URL
            }

            // Hàm xử lý khi kéo ảnh vào 'uploadCircle'
            function handleDragOver(event) {
                event.preventDefault();
                event.originalEvent.dataTransfer.dropEffect = 'copy'; // Thiết lập kiểu kéo thả là 'copy'
            }
        });

    </script>
{/literal}