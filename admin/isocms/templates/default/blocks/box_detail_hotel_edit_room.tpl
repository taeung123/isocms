{assign var=Adult value=$core->get_Lang('Adult')}
{assign var=Adults value=$core->get_Lang('Adults')}
{assign var=Child value=$core->get_Lang('Child')}
{*<form method="post" action="" class="form_add_hotel_room" id="form_add_hotel_room">*}
<div class="row">
    <div class="col-sm-12">
        <input type="hidden" value="{$table_id}" name="hotel_id"/>
        <input type="hidden" value="{$tp}" name="tp"/>
        <div class="info_room">
            <div class="row mb15">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>{$core->get_Lang('Room Type')}<span class="color_r">*</span></label>
                        <div class="d-flex align-items-center">
                            <select id="room_type_id" name="room_type_id" class="form-control required">
                                {$clsISO->getSelectPropertyType('TypeRoom',$oneItem.room_type_id)}
                            </select>
                            <a class="clickToAddRoomType">+</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <label>{$core->get_Lang('Room Name')}<span class="color_r">*</span></label>
                        <input class="form-control required" id="title_room" name="title"
                               value="{$clsHotelRoom->getTitle($hotel_room_id)}" maxlength="255" type="text"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>{$core->get_Lang('Number Room')}<span class="color_r">*</span></label>
                        <input type="text" class="text form-control required" value="{$oneItem.number_val}"
                               id="number_val" name="number_val"/>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>{$core->get_Lang('Room size')}<span class="color_r">*</span></label>
                        <div class="room_size">
                            <input type="text" class="text form-control required" id="footage" name="footage"
                                   value="{$oneItem.footage}"/>
                            <span class="unit">m<sup>2</sup></span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="view_info">
                <label>{$core->get_Lang('View Room')}</label>
                <select id="room_views_id" name="room_views_id[]" class="chosen-select required" multiple="multiple">
                    {$clsISO->getSelectPropertyTypeHotel('RoomDirection',$oneItem.list_viewroom_id)}
                </select>
            </div>

            <div class="status_cancel_room mt-3 mb-3">
                <label>{$core->get_Lang('Meal Status')}</label>
                <select id="status_meal_id" name="status_meal_id" class="form-control item_cancel_status">
                    {$clsISO->getSelectPropertyType('StatusMeal',$oneItem.meal_id)}
                </select>
            </div>

            <div class="status_cancel_room mt-3 mb-3">
                <label>{$core->get_Lang('Cancellation Status')}</label>
                <select id="cancel_room_id" name="cancel_room_id" class="form-control item_cancel_status">
                    {$clsISO->getSelectPropertyType('StatusCancel',$oneItem.cancel_id)}
                </select>
            </div>

            <div class="status_payment_room mt-3 mb-3">
                <label>{$core->get_Lang('Payment Status')}</label>
                <select id="status_payment_id" name="status_payment_id" class="form-control item_cancel_status">
                    {$clsISO->getSelectPropertyType('StatusPayment',$oneItem.payment_id)}
                </select>
            </div>

            <div class="status_cancel_room mt-3 mb-3">
                <label>{$core->get_Lang('Highlight Room')}</label>
                <select id="highlight_room_id" name="highlight_room_id[]" class="chosen-select required"
                        multiple="multiple">
                    {$clsISO->getSelectPropertyTypeHotel('Highlight',$oneItem.list_highlight_id)}
                </select>
            </div>
            <div class="facilities_box">
                <div class="facilities_header d-flex justify-content-between align-items-center">
                    <label>{$core->get_Lang('Room Facilities')}</label>
                    <div class="action-buttons">
                        {assign var="countFacilities" value=count($listRoomFacilities)}
                        <a href="#" id="checkAllBtn" onclick="checkAll('{$countFacilities}'); return false;">{$core->get_Lang('Check All')}</a> |
                        <a href="#" id="uncheckAllBtn" onclick="uncheckAll('{$countFacilities}'); return false;">{$core->get_Lang('Uncheck All')}</a>
                    </div>
                </div>

                <div class="row d-flex flex-wrap mt-2" onClick="loadHelp(this)">
                    {section name=i loop=$listRoomFacilities}
                        {if $clsProperty->getTitle($listRoomFacilities[i].property_id)}
                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <div class="facilities_item">
                                    <input
                                            type="checkbox"
                                            class="room_facilities_checkbox"
                                            id="room_facilities_id_{$listRoomFacilities[i].property_id}"
                                            name="room_facilities_id[]"
                                            {if $clsISO->isPropertySelected('RoomFacilities', $oneItem.list_RoomFacilities, $listRoomFacilities[i].property_id)} checked {/if}
                                            value="{$listRoomFacilities[i].property_id}"
                                    />
                                    <span class="text">
                            {$clsProperty->getTitle($listRoomFacilities[i].property_id)}
                        </span>
                                </div>
                            </div>
                        {/if}
                    {/section}
                </div>
            </div>
        </div>
        <div class="info_bed add_room_box">
            <p class="title-box">
                {$core->get_Lang('Bed option')}
            </p>
            <div class="form-group" id="repeater">
                <label>{$core->get_Lang('Phòng này có loại giường nào')}?<span class="color_r">*</span></label>
                <table class="table table_bed" id="table_bed">
                    {if $bed_option}
                        {foreach from=$bed_option item=item name=item}
                            <tr>
                                <td class="name">
                                    <select name="item_bed[]" class="form-control item_bed_name">
                                        <option value="0">{$core->get_Lang('Select Bed')}</option>
                                        {section name=i loop=$listTypeBed}
                                            <option value="{$listTypeBed[i].property_id}"
                                                    {if $listTypeBed[i].property_id==$item.id}selected{/if}>{$clsProperty->getTitle($listTypeBed[i].property_id)}</option>
                                        {/section}
                                    </select>
                                </td>
                                <td class="x_text">x</td>
                                <td class="number">
                                    <select name="item_bed_number[]" class="form-control item_bed_number">
                                        {section name=i loop=6}
                                            {assign var=number value=$smarty.section.i.iteration}
                                            <option value="{$number}"
                                                    {if $number==$item.number}selected{/if}>{$number}</option>
                                        {/section}
                                    </select>
                                </td>
                                <td class="td_remove">
                                    {if !$smarty.foreach.item.first}
                                        <a href="javascript:void(0);" class="btn_remove remove"><i
                                                    class="ico ico-remove"></i></a>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    {else}
                        <tr>
                            <td class="name">
                                <select name="item_bed[]" class="form-control item_bed_name">
                                    <option value="0">{$core->get_Lang('Select Bed')}</option>
                                    {$fill_bed_name_select_box}
                                </select>
                            </td>
                            <td class="x_text">x</td>
                            <td class="number">
                                <select name="item_bed_number[]" class="form-control item_bed_number">
                                    {$fill_bed_number_select_box}
                                </select>
                            </td>
                            <td class="td_remove"></td>
                        </tr>
                    {/if}
                </table>
                <div class="btn_add">
                    <a href="javascript:void(0);" class="add" title="{$core->get_Lang('Addline')}"><i
                                class="fa fa-plus-circle" aria-hidden="true"></i> {$core->get_Lang('Addline')}</a>
                    <a href="javascript:void(0);" class="clickToAddTypeBed"
                       title="{$core->get_Lang('Add other bed')}"><i class="fa fa-plus-circle"
                                                                     aria-hidden="true"></i> {$core->get_Lang('Add other bed')}
                    </a>
                </div>
            </div>
            <div class="form-group mt25">
                <label>{$core->get_Lang('Max People')}</label>
                <div class="row">
                    <div class="col-xs-5">
                        <select name="number_adult" id="number_adult" class="form-control required">
                            {$clsISO->makeSelectNumber(11,$number_adult,"$Adult,$Adults")}
                        </select>
                    </div>
                    <div class="col-xs-5">
                        <select name="number_child" id="number_child" class="form-control required">
                            {$clsISO->makeSelectNumber(6,$number_child,"$Child,$Child")}
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="info_price add_room_box">
            <p class="title-box">
                {$core->get_Lang('Giá cơ bản mỗi đêm')}
            </p>
            <p class="intro-box">
                {$core->get_Lang('Đây là giá thấp nhất mà chúng tôi tự động áp dụng đối với phòng này cho tất cả các ngày')}
            </p>
            <div class="form-group">
                <label class="full-width">{$core->get_Lang('Giá')}<span class="color_r">*</span></label>
                <div class="price_box">
                    <input type="text" class="text form-control price_format required" id="price" name="price"
                           value="{$oneItem.price}"/>
                    <span class="unit">{$clsISO->getRate()}/{$core->get_Lang('night')}</span>
                </div>
            </div>
        </div>

        {*            <div class="info_price add_room_box">*}
        {*                <p class="title-box">*}
        {*                    {$core->get_Lang('Giá ưu tiên')}*}
        {*                </p>*}
        {*                <p class="intro-box">*}
        {*                    {$core->get_Lang('Giá được áp dụng trong những ngày nhất định được tạo tại vùng “Cài đặt”.')}*}
        {*                </p>*}
        {*                <div class="form-group">*}
        {*                    <label class="full-width">{$core->get_Lang('Cuối tuần')}</label>*}
        {*                    <div class="price_box">*}
        {*                        <input type="text" class="text form-control price_format" name="price_weekend" value="{$oneItem.price_weekend}" />*}
        {*                        <span class="unit">{$clsISO->getRate()}/{$core->get_Lang('night')}/2{$core->get_Lang('pax')}</span>*}
        {*                    </div>*}
        {*                </div>*}
        {*                <div class="form-group">*}
        {*                    <label class="full-width">{$core->get_Lang('Thời gian cao điểm')}</label>*}
        {*                    <div class="price_box">*}
        {*                        <input type="text" class="text form-control price_format" name="price_peak_time" value="{$oneItem.price_peak_time}" />*}
        {*                        <span class="unit">{$clsISO->getRate()}/{$core->get_Lang('night')}/2{$core->get_Lang('pax')}</span>*}
        {*                    </div>*}
        {*                </div>*}
        {*            </div>*}

        <div class="photo_library_room add_room_box mb-3">
            <p class="title-box">
                {$core->get_Lang('Photo Library Room')}
            </p>
            {$core->getBlock('box_detail_hotel_room_gallery')}
        </div>

    </div>
</div>


<div class="btn_group">
    <input type="hidden" name="hotel_room_id" value="{$hotel_room_id}"/>
    <a class="btn btn-cancel close_pop" id="cancel_hotel_room" onclick="window.history.back();">
        <span>{$core->get_Lang('Hủy')}</span>
    </a>
    <a class="btn btn-add_new" data-tp="{$tp}" id="add_hotel_room">
        <span>{$core->get_Lang('Save')}</span>
    </a>
</div>
{*</form>*}

<script type="text/javascript">
    var type = "TypeRoom";
    var table_id = "{$table_id}";
    var SelectBed = "{$core->get_Lang('Select Bed')}";
    var fill_bed_name_select_box = '{$fill_bed_name_select_box}';
    var fill_bed_number_select_box = '{$fill_bed_number_select_box}';
</script>
{literal}
    <script type="text/javascript">
        $('.add').click(function () {
            var html = '';
            html += '<tr>';
            html += '<td class="name"><select name="item_bed[]" class="form-control item_bed_name"><option value="0">' + SelectBed + '</option>' + fill_bed_name_select_box + '</select></td>';
            html += '<td class="x_text">x</td>';
            html += '<td class="number"><select name="item_bed_number[]" class="form-control item_bed_number">' + fill_bed_number_select_box + '</select></td>';
            html += '<td class="td_remove"><a href="javascript:void(0);" class="btn_remove remove"><i class="ico ico-remove"></i></a></td></tr>';
            $('#table_bed').append(html);
        });
        $('#table_bed').on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });
        $('.clickToAddRoomType').click(function () {
            vietiso_loading(1);
            var adata = {
                'type': 'TypeRoom'
            };
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/?mod=property&act=ajLoadFormAddProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup('700px', 'auto', html, 'frmAddRoomType', 'frmPop2');
                }
            });
            return false;
        });
        $('.clickToAddTypeBed').click(function () {
            vietiso_loading(1);
            var adata = {
                'type': 'TypeBed'
            };
            $.ajax({
                type: "POST",
                url: path_ajax_script + "/?mod=property&act=ajLoadFormAddProperty",
                data: adata,
                dataType: "html",
                success: function (html) {
                    vietiso_loading(0);
                    makepopup('700px', 'auto', html, 'frmAddTypeBed', 'frmPop2');
                }
            });
            return false;
        });
        $('#clickSubmitProperty').live('click', function (e) {
            e.preventDefault();
            var _this = $(this);
            var $image = $('#isoman_url_image');
            var type = $('#type');
            if ($('#title').val() == '') {
                $('#title').addClass('errorInput').focus();
                alertify.error(title_required);
                return false;
            }
            var adata = {
                'title': $('#title').val(),
                'image': $image.val(),
                'type': type.val(),
                'property_id': _this.attr('property_id')
            };

            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=property&act=ajSubmitProperty',
                data: adata,
                dataType: 'html',
                success: function (html) {
                    if (html.indexOf("exist_title") >= 0) {
                        alertify.error(exist_title);
                        return false;
                    }
                    alertify.success(insert_success);
                    $.get(`${path_ajax_script}/index.php?mod=${mod}&act=updateListTypeBed&lang=${LANG_ID}`, (html) => {
                        $Core.popup.close($("#frmAddTypeBed"));
                        $('[name="item_bed[]"]').append(html);
                    });
                }
            });
        });

        function checkAll() {
            var checkboxes = document.querySelectorAll('.room_facilities_checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
        }

        function uncheckAll() {
            var checkboxes = document.querySelectorAll('.room_facilities_checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }

    </script>
    <Style>
        .btn_save_titile_table_code {
            display: none;
        }

        .btn_group {
            display: flex;
            justify-content: space-between;
        }

        .info_room .room_size span.unit, .price_box .unit {
            height: 50px;
            line-height: 50px;
        }

        .facilities_box .facilities_item input {
            cursor: pointer;
        }
    </Style>
{/literal}