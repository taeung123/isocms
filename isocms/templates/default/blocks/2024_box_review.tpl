{assign var = check_reviews value = $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
{if $check_reviews && $loggedIn eq '1' || !$check_reviews}
    <button type="button" class="btn view_all_review btn_write_review_2024" data-bs-toggle="modal"
            data-bs-target="#writeReviewModal">
        {$core->get_Lang('Reviews')}
    </button>
    <div class="modal fade" id="writeReviewModal" tabindex="-1" aria-labelledby="writeReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered {if $deviceType ne 'phone'}modal-lg{/if}">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="stories" id="stories">
                        <!-- Title and Close button -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="title_review">
                                <h2 class="title_wrt_review"
                                    id="writeReviewModalLabel">{$core->get_Lang('Write review')}</h2>
                                <h3 class="txt_title_hotel">
                                    {if $mod == "hotel"}
                                        {$clsHotel->getTitle($hotel_id,$oneItem)}
                                    {elseif $mod == "tour_new"}
                                        {$clsTour->getTitle($tour_id)}
                                    {elseif $mod == "cruise"}
                                        {$clsCruise->getTitle($cruise_id)}
                                    {/if}
                                </h3>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div id="writeTourReview">
                            <form action="" class="simple_form new_review" enctype="multipart/form-data" id="frmCommentCrx"
                                method="post">
                                <!-- Rating -->
                                <div class="rating-body">
                                    <div class="rate">
                                        <div class="rate_row">
                                        </div>
                                        <span class="title rating_text">{$core->get_Lang('Excellent')} </span>
                                        <input type="hidden" id="rates" value="0">

                                    </div>
                                    <div class="details">
                                        <div class="control-group text optional review_content mt10">
                                            <div class="row">
                                                {if $loggedIn eq '1'}
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="controls mb8">
                                                            <label for="fullname"
                                                                class="input-label_enterinput active">{$core->get_Lang('Your name')}
                                                                *</label>
                                                            <input class="full-width required" name="fullname" id="fullname"
                                                                value="{$clsProfile->getFullname($profile_id)}"
                                                                maxlength="255" type="text" readonly
                                                                style="background: #F0F0F0"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="controls mb8">
                                                            <label for="email"
                                                                class="input-label_enterinput active">{$core->get_Lang('Email')}
                                                                *</label>
                                                            <input class="full-width required" name="email_reviews"
                                                                id="email"
                                                                value="{$clsProfile->getEmail($profile_id)}"
                                                                maxlength="255" type="email" readonly
                                                                style="background: #F0F0F0"/>
                                                        </div>
                                                    </div>
                                                {else}
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="controls mb8">
                                                            <label for="fullname"
                                                                class="input-label_enterinput active">{$core->get_Lang('Your name')}
                                                                *</label>
                                                            <input class="full-width required" name="fullname" id="fullname"
                                                                value=""
                                                                maxlength="255" type="text"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <div class="controls mb8">
                                                            <label for="email"
                                                                class="input-label_enterinput active">{$core->get_Lang('Email')}
                                                                *</label>
                                                            <input class="full-width required" name="email_reviews"
                                                                id="email"
                                                                value=""
                                                                maxlength="255" type="email"/>
                                                        </div>
                                                    </div>
                                                {/if}
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="controls mb8">
                                                        <label for="email"
                                                            class="input-label_enterinput label_country_select active">{$core->get_Lang('Country')}
                                                            *</label>
                                                        <select name="country_id" id="country_id"
                                                                class="form-control required">
                                                            {$clsCountry->getSelectByCountry($country_id)}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="controls mb8">
                                                        <label for="full-width phone"
                                                            class="input-label_enterinput active">{$core->get_Lang('Phone')}</label>
                                                        <input class="full-width" name="phone_reviews" id="phone"
                                                            value=""
                                                            maxlength="255" type="text"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="controls">
                                                <p class="txt_review_write"
                                                style="margin-bottom: 6px">{$core->get_Lang('Write your review')} * </p>
                                                <textarea class="text optional textarea full-width" name="message"
                                                        id="message" minlength="100"
                                                        placeholder="{$core->get_Lang('Please write at least 100 characters about your experience at this destination')}."
                                                        rows="10" data-validate="true"></textarea>
                                            </div>
                                            <input type="hidden" class="textarea_val_hidden" name="message_hidden">
                                        </div>
                                        <div class="media-preview" id="media-preview"></div>

                                        <div class="image_isocms_review">
                                            <div class="isocms_images_preview"></div>

                                            <div class="custom-file-upload">
                                                <label for="file-upload">
                                                    <i class="fa-sharp fa-regular fa-rectangle-history-circle-plus"></i> {$core->get_Lang('Add some photos')}
                                                    <div id="upload-status">(0/10)</div>
                                                </label>
                                                <input id="file-upload" name="review_images[]" type="file"
                                                    accept="image/*,video/*" multiple/>
                                            </div>
                                        </div>

                                        {if $loggedIn neq '1'}
                                            <!-- Thêm thông báo đăng nhập chỉ khi người dùng chưa đăng nhập -->
                                            <p class="msg mt-2">
                                                {$core->get_Lang('You have already had an account? Please')}
                                                <a href="{$clsProfile->getLink('signin_r')}r={$REQUEST_URI}">{$core->get_Lang('Sign In')}</a>
                                                {$core->get_Lang('or')}
                                                <a href="{$clsProfile->getLink('signup')}">{$core->get_Lang('Sign Up')}</a>
                                                {$core->get_Lang('to send reviews')}.
                                            </p>
                                        {/if}

                                        <div class="bottom">
                                            <div class="right">
                                                <button type="button" id="btnClick"
                                                        class="btn btn_publish_review">{$core->get_Lang('Submit form')}</button>
                                                <input type="hidden" value="Review" name="Review">
                                                <input type="hidden" value="{$profile_id}" id="member_id" name="member_id">
                                                <input type="hidden" value="{$table_id}" id="table_id" name="table_id">
                                                <input type="hidden" value="{$type}" id="type" name="type">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else}
    <button type="button" class="btn view_all_review btn_write_review_2024" onclick="showReviewAlert()">
        {$core->get_Lang('Reviews')}
    </button>
    
    <script>
        var txt_notification = "{$core->get_Lang('Notification')}";
        var txt_notification2 = "{$core->get_Lang('Please log in your review')}";
        var txt_signin2 = "{$core->get_Lang('Sign in')}";
        var txt_signup = "{$core->get_Lang('Sign up')}";
        var txt_cancel = "{$core->get_Lang('Cancel')}";
    </script>

    {literal}
        <script>
            function showReviewAlert() {
                Swal.fire({
                    title: txt_notification,
                    text: txt_notification2,
                    icon: 'info',
                    showDenyButton: true,
                    confirmButtonText: txt_signin2,
                    denyButtonText: txt_signup,

                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/' + LANG_ID + '/login_new';
                    } else if (result.isDenied) {
                        window.location.href = '/' + LANG_ID + '/signup_new';
                    }
                });
            }
        </script>

    {/literal}

{/if}
<script>
    var msg_message_required = "{$core->get_Lang('Your message should not be empty')}!";
    var msg_login = "{$core->get_Lang('Sign in saved to review')}!";
    var msg_rating = "{$core->get_Lang('Your rating should not be empty')}!";
    var msg_insert_success = "{$core->get_Lang('Your Review is submit success')}!";
    var msg_country = "{$core->get_Lang('Your country should not be empty')}!";
    var process = "{$core->get_Lang('Processing')}......";
    var Publish_Review = "{$core->get_Lang('Publish Review')}";
    var Completed = "{$core->get_Lang('Completed')}....";
    var msg_max_img = "{$core->get_Lang('Maximum number of images exceeded!')}";
    var msg_max_capacity = "{$core->get_Lang('Maximum capacity exceeds 2MB')}";
    var msg_img_name_exist = "{$core->get_Lang('File with the same name already exists')}.";
    var msg_alert_error_submit = "{$core->get_Lang('You can only submit one review for each service per day')}.";
    let table_id = '{$table_id}';
    var isLoggedIn = `{$loggedIn|json_encode}`;
    const ratingTexts = {
        5: '{$core->get_Lang("Excellent")}',
        4: '{$core->get_Lang("Good")}',
        3: '{$core->get_Lang("Average")}',
        2: '{$core->get_Lang("Poor")}',
        1: '{$core->get_Lang("Terrible")}'
    };
</script>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(function () {
                $('.rate_row').starwarsjs({
                    stars: 5,
                    count: 1
                });
            });

            $(function () {
                let validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp'];
                const maxFileSizeMB = 2;
                const maxFileSizeBytes = maxFileSizeMB * 1024 * 1024; // Tính toán dung lượng file bằng đơn vị byte
                let lengthImages = 0;
                let totalFileSize = 0;
                let validFiles = [];
                const maxUploads = 10; // Số lượng tối đa Upload ảnh

                // Hàm cập nhật hiển thị tổng số ảnh
                function updateImageCount() {
                    $('#upload-status').text(`(${lengthImages}/${maxUploads})`);
                }

                // Sự kiện khi nhấn nút gửi form
                $(document).on('click', '#btnClick', function () {
                    const $_this = $(this);

                    if ($.trim($('input[name=rates]').val()) === '') {
                        alert(msg_rating);
                        $('input[name=rates]').focus();
                        return false;
                    }
                    if ($.trim($('input[name=fullname]').val()) === '') {
                        alert(msg_fullname_required);
                        $('input[name=fullname]').addClass('error').focus();
                        return false;
                    }
                    if ($.trim($('input[name=email_reviews]').val()) === '') {
                        alert(msg_email_required);
                        $('input[name=email_reviews]').addClass('error').focus();
                        return false;
                    }
                    if (!checkValidEmail($.trim($('input[name=email_reviews]').val()))) {
                        alert(msg_email_not_valid);
                        $('input[name=email_reviews]').addClass('error').focus();
                        return false;
                    }

                    if ($('#country_id').val() == 0) {
                        alert(msg_country);
                        $('#country_id').focus();
                        return false;
                    }

                    if ($.trim($('textarea[name=message]').val()) === '') {
                        alert(msg_message_required);
                        $('textarea[name=message]').addClass('error').focus();
                        return false;
                    }

                    var ajaxUrl = isLoggedIn == 1
                        ? path_ajax_script + '/index.php?mod=home&act=ajSaveReviews&lang=' + LANG_ID
                        : path_ajax_script + '/index.php?mod=home&act=ajSaveReviewsNoLogin&lang=' + LANG_ID;

                    $_this.closest('form.simple_form').ajaxSubmit({
                        type: "POST",
                        url: ajaxUrl,
                        beforeSend: function () {
                            $('button[id^=btnClick]').text(process);
                        },
                        dataType: "html",
                        success: function (html) {
                            const countryId = $('#country_id').val(); // Lưu giá trị của select
                            $('button[id^=btnClick]')
                                .text(Completed)
                                .delay(2000)
                                .text(Publish_Review);

                            $('#file-upload').val('');
                            $('.isocms_images_preview').html('');

                            if (html.indexOf("_ERROR") >= 0) {
                                $('#message_box').html(msg_insert_error).show();
                                return false;
                            } else if (html.indexOf("Reviewed") >= 0) {
                                Swal.fire({
                                    title: "Reviewed!!!!",
                                    icon: "success"
                                });
                            }else if (html.indexOf("_SPAM") >= 0) {
                                Swal.fire({
                                    title: msg_alert_error_submit,
                                    icon: "error"
                                });
                            } else if (html.includes('_SUCCESS')) {
                                Swal.fire({
                                    title: msg_insert_success,
                                    icon: "success"
                                });

                                lengthImages = 0; // Lưu số lượng ảnh hiện có
                                totalFileSize = 0; // Tổng kích thước tệp đã tải lên
                                validFiles = []; // Khởi tạo thành mảng

                                $('form.simple_form').trigger("reset");

                                // Reset các nhãn và hiển thị lại trạng thái ban đầu
                                $('#upload-status').text(`(0/${maxUploads})`); // Cập nhật trạng thái upload
                                $('#media-preview').empty().hide(); // Ẩn phần xem trước media

                                updateImageCount(); // Reset số lượng ảnh
                            }

                        }
                    });
                    return false;
                });
                // Sự kiện khi thay đổi file
                $(document)
                    .on('change', '#file-upload', function () {
                        renderImageReview(this.files);
                        updateInputFiles(this);
                    })

                    .on('click', '.isocms_delete_img_review', function () {
                        const dataName = $(this).data('name');
                        const dataSize = $(this).data('size');
                        validFiles = validFiles.filter(file => file.name !== dataName);
                        totalFileSize -= dataSize;
                        lengthImages--;

                        updateInputFiles($('#file-upload')[0]);
                        $(this).closest('.isocms_img_item_preview').remove();
                        updateImageCount(); // Cập nhật số lượng ảnh sau khi xóa
                    })
                    .on('keyup', '#message', function () {
                        let message = $(this).val();
                        message = message.trim().replace(/\n/g, '<br>');
                        $('.textarea_val_hidden').val(message);
                    });

                function updateInputFiles(input) {
                    const dt = new DataTransfer();
                    validFiles.forEach(file => dt.items.add(file));
                    input.files = dt.files;
                }

                function renderImageReview(fileImages) {
                    $.each(fileImages, function (key, file) {
                        let fileName = file.name;

                        let fileExtension = fileName.split('.').pop().toLowerCase();
                        let fileSizeBytes = file.size;

                        // Kiểm tra dung lượng file
                        if (fileSizeBytes > maxFileSizeBytes) {
                            Swal.fire({
                                title: msg_max_capacity + ': ' + fileName,
                                icon: "error"
                            });
                            return;
                        }

                        let fileExists = validFiles.some(existingFile => existingFile.name === fileName);

                        if (fileExists) {
                            Swal.fire({
                                title: msg_img_name_exist + fileName,
                                icon: "error"
                            });
                            return;
                        }

                        // Kiểm tra nếu là tập tin ảnh
                        if (validExtensions.includes(fileExtension)) {
                            if (totalFileSize + fileSizeBytes <= maxFileSizeBytes && lengthImages + 1 <= maxUploads) {
                                totalFileSize += fileSizeBytes;
                                validFiles.push(file);
                                lengthImages++; // Tăng khi ảnh được thêm thành công

                                $('.isocms_images_preview').append(`
                                <div class="isocms_img_item_preview">
                                    <div class="isocms_delete_img_review" data-name="${fileName}" data-size="${fileSizeBytes}">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>`);

                                // Tạo phần tử <img> để hiển thị
                                let imageElement = document.createElement('img');
                                imageElement.classList.add('preview-image');
                                imageElement.file = file;
                                $('#image-list').append(imageElement);

                                let reader = new FileReader();
                                reader.onload = (function (img) {
                                    return function (e) {
                                        img.src = e.target.result;
                                    };
                                })(imageElement);

                                reader.readAsDataURL(file);

                                $('.isocms_img_item_preview').append(imageElement);

                                updateImageCount(); // Cập nhật số lượng ảnh sau khi thêm
                            } else {
                                // Cảnh báo upload ảnh vượt dung lượng
                                Swal.fire({
                                    title: msg_max_img,
                                    icon: "error"
                                });
                            }
                        } else {
                            Swal.fire({
                                title: 'Choose Image: .jpg, .jpeg, .png, .gif, .bmp, .tiff, .webp',
                                icon: "error"
                            });
                        }
                    });
                }

                function checkValidEmail(email) {
                    const regex = /^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/;
                    return regex.test(email);
                }

                // Thiết lập mặc định cho sao
                $('.rate_star').on('click', function () {
                    const ratingValue = $(this).data('value');
                    $('#rates').val(ratingValue);
                    updateRatingText(ratingValue);
                });

                //  Đặt giá trị sao mặc định là 5 sao
                updateRatingText(5);

                function updateRatingText(value) {
                    const ratingText = ratingTexts[value] || "Select your rating";
                    $('.title.rating_text').html(ratingText); // Sử dụng .html() nếu có thẻ HTML trong nội dung
                }
            });
        })
       
    </script>
{/literal}
{literal}
    <style>
        .btn_write_review_2024 {
            color: var(--chroma-ffffff, #FFF);
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
            /* 150% */
            display: inline-flex;
            padding: 9px 20px;
            justify-content: center;
            align-items: center;
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
        }

        .btn_write_review_2024:hover {
            background: var(--secondary-177-fa-4, #177FA4) !important;
            color: var(--chroma-ffffff, #FFF) !important;
        }

        .btn_write_review_2024:focus, .btn_write_review_2024:active,
        .btn_publish_review:focus, .btn_publish_review:active {
            outline: none;
            border: none;
            color: var(--chroma-ffffff, #FFF); /* Hoặc màu bạn muốn */
            background: var(--primary-18-babd, #18BABD); /* Giữ màu nền như lúc ban đầu */
        }


        .msg a {
            background: unset;
            color: var(--primary-1-d-2-d-53, #1D2D53);
            padding: unset;
            font-size: 14px;

        }

        .msg a:hover {
            text-decoration: underline;
        }

        .isocms_images_preview {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 8px 0 10px 0;
        }

        .isocms_img_item_preview {
            max-width: 80px;
            max-height: 80px;
            display: flex;
            align-items: start;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .isocms_img_item_preview img {
            max-width: 80px !important;
            min-height: 80px !important;
        }

        .isocms_delete_img_review {
            position: absolute;
            top: 5px;
            right: 5px;
            color: #FFFFFF;
            cursor: pointer;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            border-radius: 50%;
            background: #F44336;
            border: 2px solid #FFFFFF;
            align-items: center;
        }

        /*#file-upload {*/
        /*    display: none;*/
        /*}*/

        #writeTourReview {
            margin-bottom: 0 !important;
            padding: 0 !important;
        }

        .rate_row {
            width: auto !important;
        }

        .review_content input, .review_content select {
            max-width: unset !important;
            height: 60px !important;
            background: var(--chroma-ffffff, #FFF);
            border-radius: 4px !important;
            border: 1px solid var(--chroma-c-8-cbd-0, #C8CBD0) !important;
            padding: 10px 16px 0 16px !important;
        }

        .custom-file-upload {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .custom-file-upload label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            margin-top: 10px;
            color: var(--primary-18-babd, #18BABD);
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px; /* 150% */
        }

        .custom-file-upload label:hover {
            text-decoration: underline;
        }


        #file-upload {
            display: none; /* Ẩn input file mặc định */
        }

        .add-photo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .custom-file-upload #upload-status {
            color: var(--chroma-717171, #717171);
        }

        .controls {
            position: relative;
        }

        /*.input-label_enterinput {*/
        /*    position: absolute;*/
        /*    left: 16px;*/
        /*    top: 20px;*/
        /*    transition: all 0.2s ease;*/
        /*    color: #999;*/
        /*    pointer-events: none; !* Ngăn không cho nhấp vào label *!*/
        /*    transition: all 0.2s ease; !* Thêm hiệu ứng chuyển tiếp *!*/

        /*}*/

        input:focus + .input-label_enterinput,
        input:not(:placeholder-shown) + .input-label_enterinput {
            top: 20px;
            left: 10px;
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px; /* 150% */
        }

        select:focus + .input-label_enterinput,
        select:not(:placeholder-shown) + .input-label_enterinput,
        select.active + .input-label_enterinput { /* Thêm điều kiện cho lớp active */
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #007BFF; /* Màu khi label ở trên */
        }

        .input-label_enterinput.active {
            top: 4px;
            left: 16px;
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 12px;
            font-style: normal;
            font-weight: 400;
            line-height: 18px; /* 150% */
            position: absolute;
            transition: all 0.2s ease;
            pointer-events: none; /* Ngăn không cho nhấp vào label */
        }

        #writeTourReview textarea {
            border-radius: 4px;
            border: 1px solid var(--chroma-c-8-cbd-0, #C8CBD0);
            background: var(--chroma-ffffff, #FFF);
        }

        .txt_title_hotel {
            color: var(--chroma-717171, #717171);
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px; /* 150% */
        }

        .title_review .title_wrt_review {
            color: #1C1C1C;
            font-size: 28px;
            font-style: normal;
            font-weight: 700;
            line-height: 40px; /* 142.857% */
        }

        .txt_review_write, .title.rating_text, .msg {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 21px; /* 150% */
        }

        .mb8 {
            margin-bottom: 16px;
        }

        .btn_publish_review {
            display: inline-flex;
            padding: 18px 20px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            color: var(--chroma-ffffff, #FFF);
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px; /* 150% */
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
        }

        .btn_publish_review:hover {
            background: var(--secondary-177-fa-4, #177FA4);
            color: var(--chroma-ffffff, #FFF);
        }

        #writeTourReview textarea {
            padding: 10px 15px;
            line-height: 22px;

        }

        #writeTourReview .bottom {
            overflow: hidden;
            padding: 10px 0;
        }

        #writeTourReview .bottom .right {
            float: right;
            width: 310px;
            text-align: right;
        }

        .rate_star {
            height: 27px;
        }
        #writeTourReview .iso_box_login {
            flex-direction: row;
            justify-content: center;
        }

        #writeTourReview .iso_box_login_item {
            padding: 0 10px;
        }
        .modal#writeReviewModal{
            z-index: var(--bs-modal-zindex);
        }

        .content_reviews .hnv_hotel_detail_main_review_detail_content_item {
            padding: unset;
            box-shadow: unset;
        }

        .swal2-icon-show {
            margin: 2.5em auto .6em;
            border: solid;
        }
    </style>
{/literal}


