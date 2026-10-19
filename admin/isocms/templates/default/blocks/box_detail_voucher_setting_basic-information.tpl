<!-- BASIC INFORMATION -->
<div class="tm-section-heading">
    <h2>{$core->get_Lang('Basic Information')}</h2>
    <p>{$core->get_Lang('Update the essential details of your voucher.')}</p>
</div>

<div class="tm-basic-grid">
    <!-- COLUMN 1 -->
    <div class="tm-form-col">
        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherName">{$core->get_Lang('Supplier Name')} <span
                    class="required">*</span></label>
            <input id="voucherName" class="tm-input input_text_form input-title required" data-table_id="{$pvalTable}"
                name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="200" type="text"
                onClick="loadHelp(this)" required>
            <p class="tm-field-hint tm-field-hint--right"><span id="voucherNameCount">16</span>/200</p>
        </div>
        <div class="tm-field-block">
            <label class="tm-form-label" for="countryRegion">{$core->get_Lang('Country / Region')} <span
                    class="required">*</span></label>
            <div class="tm-select-wrap">
                <span class="tm-select-icon tm-select-icon--status" aria-hidden="true"><i
                        class="fa-solid fa-globe"></i></span>
                <select id="countryRegion" name="country_id" required>
                    {$clsCountry->makeSelectboxOption($oneItem.country_id)}
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <p class="tm-field-hint">{$core->get_Lang('Inactive voucher will not be available for sale.')}</p>
        </div>
        
    </div>

    <!-- COLUMN 2 -->
    <div class="tm-form-col">
        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherProductCode">{$core->get_Lang('Supplier Code ')} <span
                    class="required">*</span></label>
            <input type="text" name="code" id="voucherProductCode" class="tm-input"
                value="{$clsClassTable->getCode($pvalTable)}" required>
            <p class="tm-field-hint">{$core->get_Lang('Short code for internal reference.')}</p>
        </div>
        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherStatus">{$core->get_Lang('Status')} <span
                    class="required">*</span></label>
            <div class="tm-select-wrap">
                <span class="tm-select-icon tm-select-icon--status" aria-hidden="true"><i
                        class="fa-solid fa-check"></i></span>
                <select id="voucherStatus" name="is_online" required>
                    {foreach from=$clsVoucher->getListVoucherStatus() key=statusKey item=statusValue}
                        <option value="{$statusKey}" {if $statusKey == $oneItem.is_online}selected{/if}>
                            {$statusValue}
                        </option>
                    {/foreach}
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <p class="tm-field-hint">{$core->get_Lang('Inactive voucher will not be available for sale.')}</p>
        </div>

    </div>
                   
    <!-- MAIN IMAGE PANEL -->
    <div class="tm-main-image-panel">
        <label class="tm-form-label">{$core->get_Lang('Main Image')}</label>
        <div class="tm-main-image-frame">
            <img alt="{$oneItem.title}" class="aspect-ratio__content radius-3" id="isoman_show_image"
                src="{$oneItem.image}"
            />

            <div class="tm-main-image-frame__actions">
                <div class="tm-main-image-frame__actions-inner">
                    
                    <input type="hidden" value="{$oneItem.image}" name="image" id="image" />

                    <a table_id="{$pvalTable}" isoman_multiple="0"
                        isoman_callback='isoman_callback({ldelim}"openFrom":"image", "clsTable":"{$clsTable}", "pvalTable":"{$pvalTable}", "table_id":"{$pvalTable}","toField":"image","toId":"isoman_show_image"{rdelim})'
                        class="tm-btn--change-image btn-upload-2 ajOpenDialog" isoman_for_id="image"
                        isoman_name="image">
                        <i class="fa-regular fa-image"></i>
                        {$clsISO->makeIcon('folder-o', $core->get_Lang('Change image'))}
                    </a>
                </div>

                <button 
                    type="button" 
                    class="tm-btn--delete-image btnDeleteMainImage" 
                    id="btnDeleteMainImage"
                    aria-label="Delete main image"
                    data-table='VoucherSupply'
                    data-id="{$pvalTable}"
                    >
                    <i class="fa-regular fa-trash-can"></i
                ></button>
            </div>

        </div>

    </div>
</div>
<div class="tm-field-block">
        <label class="tm-form-label" for="tmAddress">{$core->get_Lang('Address ')} <span
                class="required">*</span></label>
        <input type="text" name="address" id="tmAddress" class="tm-input" placeholder="{$core->get_Lang('Enter full address (e.g. Quy Nhon, Binh Dinh, Vietnam)')}"
            value="{$oneItem.address}" required>
    </div> 
<!-- DESCRIPTION -->

<div class="tm-section-heading">
    <h2>{$core->get_Lang('Description')}</h2>
</div>
<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor"
    data-column="iso-content" id="textarea_intro_content_overview_{$now}" cols="255"
    rows="2">{$oneItem.content}</textarea>
{literal}
    <script type="text/javascript">
        $(document).on('input', '.input-title[maxlength]', function () {
            var $this = $(this);
            var maxLength = $this.attr('maxlength');
            var length = $this.val().length;

            $('#' + $this.attr('id') + 'Count').text(length);
        });
        // Khởi tạo số ký tự khi load trang
        $(function () {
            $('#voucherName').trigger('input');
        });
        $(document).on("click", ".btnDeleteMainImage", function (ev) {
            //console.log("CLICK DELETE");

            var _this = $(this);
            // console.log("element:", _this);
            // console.log("confirm_delete:", confirm_delete);
            if (confirm(confirm_delete)) {
                var $_this = $(this);
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url:
                        path_ajax_script +
                        "/index.php?mod=voucher&act=ajDeleteMainImage",
                    data: { 
                        table: $_this.attr("data-table"), 
                        id: $_this.attr("data-id") 
                    },
                    dataType: "html",
                    success: function (html) {
                        $('#isoman_show_image').attr('src', '');
                        vietiso_loading(0);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Save changes successfully!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                });
            }
            return false;
        });
    </script>
{/literal}