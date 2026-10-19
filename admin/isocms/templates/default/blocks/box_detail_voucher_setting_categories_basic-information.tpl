<!-- BASIC INFORMATION -->
<div class="tm-section-heading">
    <h2>{$core->get_Lang('Basic Information')}</h2>
    <p>{$core->get_Lang('Update the essential details of your voucher.')}</p>
</div>


    <div class="tm-form-grid-2">
        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherName">{$core->get_Lang('Category Name')} <span
                    class="required">*</span></label>
            <input id="voucherName" class="tm-input input_text_form input-title required" data-table_id="{$pvalTable}"
                name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="200" type="text"
                onClick="loadHelp(this)" required>
            <p class="tm-field-hint tm-field-hint--right"><span id="voucherNameCount">16</span>/200</p>
        </div>

        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherCode">{$core->get_Lang('Category Code')} <span
                    class="required">*</span></label>
            <input id="voucherCode" class="tm-input input_text_form input-title required" data-table_id="{$pvalTable}"
                name="code" value="{$oneItem.code}" maxlength="200" type="text"
                onClick="loadHelp(this)" required>
            <p class="tm-field-hint tm-field-hint--right"><span ></span></p>
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

<!-- DESCRIPTION -->

<div class="tm-section-heading">
    <h2>{$core->get_Lang('Description')}</h2>
</div>
<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor"
    data-column="iso-content" id="textarea_intro_content_overview_{$now}" cols="255"
    rows="2">{$oneItem.intro}</textarea>
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

{literal}
    <style type="text/css">
        .tm-form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 24px;
        }
    </style>
{/literal}