<!-- BASIC INFORMATION -->
<div class="tm-section-heading">
    <h2>{$core->get_Lang('Basic Information')}</h2>
    <p>{$core->get_Lang('Update the essential details of your voucher.')}</p>
</div>

<div class="tm-basic-grid">
    <!-- COLUMN 1 -->
    <div class="tm-form-col">
        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherName">{$core->get_Lang('Voucher Name')} <span
                    class="required">*</span></label>
            <input id="voucherName" class="tm-input input_text_form input-title required" data-table_id="{$pvalTable}"
                name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="200" type="text"
                onClick="loadHelp(this)" required>
            <p class="tm-field-hint tm-field-hint--right"><span id="voucherNameCount">16</span>/200</p>
        </div>

        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherProductCode">{$core->get_Lang('Voucher Code (Product Code)')} <span
                    class="required">*</span></label>
            <input type="text" name="code" id="voucherProductCode" class="tm-input"
                value="{$clsClassTable->getCode($pvalTable)}" required>
        </div>

        <div class="tm-field-block">
            <label class="tm-form-label" for="slb_supplier">
                {$core->get_Lang('Supplier')}
                <span class="required">*</span>
            </label>
            <select name="supplier_id" class="iso-selectbox" data-width="100%" id="slb_supplier" required>
                {$clsSupplier->makeSelectboxOption($oneItem.supplier_id)}
            </select>
        </div>
    </div>

    <!-- COLUMN 2 -->
    <div class="tm-form-col">
        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherStatus">{$core->get_Lang('Status')} <span
                    class="required">*</span></label>
            <div class="tm-select-wrap">
                <span class="tm-select-icon tm-select-icon--status" aria-hidden="true"><i
                        class="fa-solid fa-check"></i></span>
                <select id="voucherStatus" name="is_online">
                    {foreach from=$clsClassTable->getListVoucherStatus() key=statusKey item=statusValue}
                        <option value="{$statusKey}" {if $statusKey == $oneItem.is_online}selected{/if}>
                            {$statusValue}
                        </option>
                    {/foreach}
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <p class="tm-field-hint">{$core->get_Lang('Inactive voucher will not be available for sale.')}</p>
        </div>

        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherCategory">{$core->get_Lang('Category')} <span
                    class="required">*</span></label>
            <div class="tm-select-wrap">
                <span class="tm-select-icon tm-select-icon--category" aria-hidden="true"><i
                        class="fa-solid fa-bed"></i></span>
                <select id="voucherCategory" name="iso-cat_id" onClick="loadHelp(this)" required>
                    {$clsVoucherCat->makeSelectboxOption($oneItem.cat_id)}
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </div>
        <div class="tm-field-block">
            <label class="tm-form-label" for="voucherDisplayLabel">{$core->get_Lang('Display Label')}</label>
            <div class="tm-select-wrap">
                <span class="tm-select-icon tm-select-icon--label" aria-hidden="true"><i
                        class="fa-solid fa-circle"></i></span>
                <select id="voucherDisplayLabel" name="label">
                    {foreach from=$clsClassTable->getListLabelVoucherStatus() key=labelKey item=labelValue}
                        <option value="{$labelKey}" {if $labelKey == $oneItem.label}selected{/if}>
                            {$labelValue}
                        </option>
                    {/foreach}
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </div>
    </div>

    <!-- MAIN IMAGE PANEL -->
    <div class="tm-main-image-panel">
        <label class="tm-form-label">{$core->get_Lang('Main Image')} <span class="required">*</span></label>
        <div class="tm-main-image-frame">
            <img alt="{$oneItem.title}" class="aspect-ratio__content radius-3" id="isoman_show_image"
                src="{$clsClassTable->getImage($pvalTable,250,170)}"
                onerror="this.src='{$oneItem.image}'" />

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

                <button type="button" class="tm-btn--delete-image" id="btnDeleteMainImage"
                    aria-label="Delete main image"><i class="fa-regular fa-trash-can"></i></button>
            </div>

        </div>

    </div>
</div>

<!-- DESCRIPTION -->

<div class="tm-section-heading">
    <h2>{$core->get_Lang('Description')}</h2>
    <p>{$core->get_Lang('Provide a clear and attractive description for your voucher.')}</p>
</div>
<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor"
    data-column="iso-content" id="textarea_intro_content_overview_{$now}" cols="255"
    rows="2">{$oneItem.content}</textarea>


<!-- HIGHLIGHTS -->
<div class="tm-section-heading">
    <h2>{$core->get_Lang('Highlights')} <span
            style="font-weight:600;color:var(--tm-text-secondary);font-size:14px;">({$core->get_Lang('Optional')})</span>
    </h2>
    <p>{$core->get_Lang('Add key features or benefits of this voucher.')}</p>
</div>
<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro" class="textarea_intro_editor"
    data-column="iso-intro" id="textarea_intro_editor_overview_{$now + 1}" cols="255"
rows="2">{$oneItem.intro}</textarea>