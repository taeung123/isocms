<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<div id="hnv_setting_profile" role="tabpanel">
    <div class="hnv_setting_main_right_title">
        <h2>{$core->get_Lang('Profile')}</h2>
    </div>
    <div class="hnv_setting_main_right_content">
        <div id="hnv_setting_profile_main">
            <form method="post">
                <div class="row">
                    <div class="col-md-12 col-lg-4 col-xl-3 col-xxl-2">
                        <div class="hnv_setting_main_right_content_avatar mb_24">
                            <div class="hnv_setting_main_right_content_avatar_title">
                                <span>{$core->get_Lang('Avatar')}</span>
                            </div>
                            <div class="hnv_setting_main_right_content_avatar_upload">
                                <div class="hnv_setting_main_right_content_avatar_upload_circle" title="{$core->get_Lang('Upload image')}">
                                    <div class="hnv_setting_main_right_content_avatar_upload_circle_content">
                                        <img src="/uploads/AdminButton/bi_image.png" width="36" height="36" alt="Upload Icon">
                                        <div class="hnv_setting_main_right_content_avatar_upload_text">
                                            <span class="hnv_setting_main_right_content_avatar_upload_text_top">
                                                {$core->get_Lang('Click to upload')}
                                            </span><br>
                                            <span class="hnv_setting_main_right_content_avatar_upload_text_bot">
                                                {$core->get_Lang('or drag and drop')}
                                            </span>
                                        </div>
                                    </div>
                                    <input type="file" class="upload_input" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-7 col-xl-7 col-xxl-7">
                        <div class="hnv_setting_main_right_content_form">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb_24">
                                        <label for="firstName" class="form-label">{$core->get_Lang('First Name')}</label>
                                        <input type="text" class="form-control" id="iso-firstName" placeholder="Trần Thanh" value="{$clsUser->getOneField('first_name',$_loged_id)}">
                                    </div>
                                    <div class="mb_24">
                                        <label for="email" class="form-label">{$core->get_Lang('Email')}</label>
                                        <input type="email" class="form-control" id="iso-email" placeholder="thanhthtran@gmail.com" value="{$clsUser->getOneField('email',$_loged_id)}" disabled>
                                    </div>
                                    <div class="mb_24">
                                        <label for="country" class="form-label">{$core->get_Lang('Country')}</label>
                                        <select class="form-control select2" id="iso-country">
                                            <option value="">{$core->get_Lang('Country')}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb_24">
                                        <label for="lastName" class="form-label">{$core->get_Lang('Last Name')}</label>
                                        <input type="text" class="form-control" id="iso-lastName" placeholder="Trần" value="{$clsUser->getOneField('last_name',$_loged_id)}">
                                    </div>
                                    <div class="mb_24">
                                        <label for="phoneNumber" class="form-label">{$core->get_Lang('Phone Number')}</label>
                                        <input type="tel" class="form-control" id="iso-phoneNumber" value="{$clsUser->getOneField('phone',$_loged_id)}">
                                    </div>
                                    <div class="mb_24">
                                        <label for="provinceCity" class="form-label">{$core->get_Lang('Province/City')}</label>
                                        <select class="form-control select2" id="iso-provinceCity" disabled>
                                            <option value="">{$core->get_Lang('Province/City')}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb_24">
                                    <label for="dob" class="form-label">{$core->get_Lang('Date of Birth')}</label>
                                    <input type="date" class="form-control" id="iso-dob">
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb_24 relative">
                                        <label for="password" class="form-label">{$core->get_Lang('Password')}</label>
                                        <input type="password" class="form-control" id="iso-password" value="********">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 relative mb_24">
                                    <a href="#" class="btn_change_password" title="{$core->get_Lang('Change Password')}">
                                        {$core->get_Lang('Change Password')}
                                    </a>
                                </div>
                            </div>
                            <input type="submit" class="hnv_btn_submit_form" name="hnv_btn_submit_form" value="{$core->get_Lang('Save')}">
                            <input type="hidden" name="hnv_profile_list" value="hnv_profile_list">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var option_city = "{$core->get_Lang('Province/City')}";
</script>
{literal}
    <script>
        $(document).ready(function () {
            $('.select2').select2({ width: '100%' });

            // Gọi API lấy danh sách quốc gia và tỉnh thành
            $.get('https://countriesnow.space/api/v0.1/countries', function (response) {
                const countries = response.data;
                const $country = $('#iso-country');
                const $provinceCity = $('#iso-provinceCity');

                // Đổ danh sách quốc gia vào dropdown
                countries.forEach(country => {
                    $country.append(`<option value="${country.country}">${country.country}</option>`);
                });

                // Khi chọn quốc gia
                $country.on('change', function () {
                    const selectedCountry = $(this).val();
                    const selectedData = countries.find(c => c.country === selectedCountry);

                    if (selectedCountry) {
                        // Nếu có chọn quốc gia, bật (enable) city
                        $provinceCity.prop('disabled', false);
                    } else {
                        // Nếu chưa chọn, giữ trạng thái disabled
                        $provinceCity.prop('disabled', true);
                    }

                    // Xóa danh sách tỉnh thành cũ
                    $provinceCity.empty().append('<option value="">' + option_city + '</option>');

                    // Nếu có tỉnh thành thì đổ vào dropdown
                    if (selectedData && selectedData.cities.length > 0) {
                        selectedData.cities.forEach(city => {
                            $provinceCity.append(`<option value="${city}">${city}</option>`);
                        });
                    }
                });
            });
        });
    </script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 42px; /* Điều chỉnh chiều cao */
            font-size: 16px; /* Điều chỉnh cỡ chữ */
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px; /* Canh giữa chữ */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px;
            width: 38px;
        }

    </style>
{/literal}