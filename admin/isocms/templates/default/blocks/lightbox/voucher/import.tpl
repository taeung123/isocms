<div class="import-voucher">
    <div class="import-voucher-header">
        <div class="import-voucher-icon">
            <i class="fa fa-folder-open"></i>
        </div>
        <div class="import-voucher-header-content">
            <h2>{$core->get_Lang('Import Voucher Code')}</h2>
        </div>
    </div>

    <div class="import-voucher-upload">
        <input type="file" id="voucher_import_file" name="voucher_import_file" accept=".xlsx,.xls" hidden>
        <label for="voucher_import_file" class="import-voucher-dropzone">
            <div class="import-voucher-upload-icon">
                <i class="fa fa-cloud-upload"></i>
            </div>
            <div class="import-voucher-upload-title">
                {$core->get_Lang('Drag & drop your file here')}
            </div>
            <div class="import-voucher-upload-text">
                {$core->get_Lang('or click to browse')}
            </div>
            <div class="import-voucher-formats">
                {$core->get_Lang('Supported format: .xlsx, .xls &nbsp;|&nbsp; Max file size: 10MB')}
            </div>
        </label>
    </div>

    <div class="import-voucher-file-info" id="import_voucher_file_info" style="display:none;">
        <div class="import-voucher-file-icon">
            <i class="fa fa-file-text-o"></i>
        </div>
        <div class="import-voucher-file-details">
            <div class="import-voucher-file-name" id="import_voucher_file_name"></div>
            <div class="import-voucher-file-size" id="import_voucher_file_size"></div>
        </div>
        <button type="button" class="import-voucher-remove-file" id="btn_remove_import_file">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div id="voucher_import_preview" style="display:none;">

        <div class="voucher-import-summary">

            <div class="summary-item">
                <strong id="import_total">0</strong>
                <span>Total</span>
            </div>

            <div class="summary-item">
                <strong id="import_valid">0</strong>
                <span>Valid</span>
            </div>

            <div class="summary-item">
                <strong id="import_invalid">0</strong>
                <span>Invalid</span>
            </div>

        </div>

        <div class="voucher-import-table-wrapper">
            <table class="table table-bordered" id="voucher_import_table">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>{$core->get_Lang('Voucher Code')}</th>
                        <th>{$core->get_Lang('Start Date')}</th>
                        <th>{$core->get_Lang('Expiry Date')}</th>
                        <th>{$core->get_Lang('Price')}</th>
                        <th>{$core->get_Lang('Usage Limit')}</th>
                        <th>{$core->get_Lang('Notes')}</th>
                        <th>{$core->get_Lang('Status')}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="voucher-import-actions">
            <button type="button" class="btn btn-default" id="btn_back_import_voucher">
                {$core->get_Lang('Back')}
            </button>

            <button type="button" class="btn btn-primary" id="btn_save_import_voucher">
                {$core->get_Lang('Import Valid Vouchers')}
            </button>
            <input type="hidden" id="voucher_product_id" name="voucher_product_id" value="{$pvalTable}" />

        </div>

    </div>

    <div class="import-voucher-supported">
        <!-- File Guidelines -->
        <div class="file-guidelines">

            <div class="guideline-icon">
                <i class="fa fa-info-circle"></i>
            </div>

            <div class="guideline-content">

                <strong>{$core->get_Lang('File Guidelines')}</strong>

                <ul>
                    <li>{$core->get_Lang('Use the provided template to ensure correct format.')}</li>
                    <li>{$core->get_Lang('Required columns: Voucher Code (or leave empty to auto-generate)')}</li>
                    <li>{$core->get_Lang('Optional columns: Expiry Date, Usage Limit, Notes')}</li>
                    <li>{$core->get_Lang('Maximum 10,000 codes per file')}</li>
                    <li>{$core->get_Lang('Duplicate codes will be skipped automatically')}</li>
                </ul>

            </div>

        </div>
    </div>

    <div class="import-voucher-actions">
        <button type="button" class="btn btn-default mr-3" id="btn_cancel_import_voucher">
            {$core->get_Lang('Cancel')}
        </button>
        <button type="button" class="btn btn-primary" id="btn_import_voucher" disabled>
            {$core->get_Lang('Next')}
            <i class="fa fa-angle-right"></i>
        </button>
    </div>
</div>

{literal}
    <script>
        $(document).on('click', '#btn_back_import_voucher', function() {
            $('#voucher_import_preview').hide();
            $('.import-voucher-upload').show();
            $('.import-voucher-supported').show();
            $('#import_voucher_file_info').show();
            $('.import-voucher-actions').show();
        });

        $(document).on('click', '#btn_save_import_voucher', function() {

            var $this = $(this);

            var validData = $.grep(
                window.importVoucherData || [],
                function(item) {
                    return item.valid === true;
                }
            );

            if (!validData.length) {
                alertify.error('No valid voucher to import');
                return;
            }

            /*
         * Tạo JSON chuẩn
         */
            var jsonData = JSON.stringify(validData);

            console.log('ORIGINAL JSON:', jsonData);

            /*
         * Test JSON trước khi gửi
         */
            try {

                JSON.parse(jsonData);

            } catch (e) {

                console.error('JSON ERROR:', e);
                console.error('JSON DATA:', jsonData);

                alertify.error('Invalid voucher JSON');
                return;
            }

            /*
         * Encode JSON -> Base64
         */
            var base64Data = btoa(
                unescape(
                    encodeURIComponent(jsonData)
                )
            );

            // console.log('BASE64 LENGTH:', base64Data.length);
            // console.log('BASE64:', base64Data);

            $this.prop('disabled', true);
            vietiso_loading(1);

            $.ajax({

                type: 'POST',
                url: path_ajax_script +
                    '/index.php?mod=voucher&act=ajSaveImportedVoucher',
                data: {
                    data_base64: base64Data,
                    voucher_product_id: $('#voucher_product_id').val()
                },
                dataType: 'json',
                success: function(response) {

                    console.log('Save result:', response);

                    vietiso_loading(0);
                    $this.prop('disabled', false);

                    if (response.status !== 'success') {
                        alertify.error(
                            response.message || 'Cannot save vouchers'
                        );
                        return;
                    }

                    alertify.success(
                        'Imported ' + response.inserted + ' vouchers successfully'
                    );
                    setTimeout(function() {
                        // Đóng popup
                        $('.iso-lightbox-cancel').click();
                        location.reload();
                    }, 1000);
                },  

                error: function(xhr) {

                    vietiso_loading(0);
                    $this.prop('disabled', false);

                    console.log(
                        'AJAX ERROR:',
                        xhr.responseText
                    );

                    alertify.error(
                        'Cannot save vouchers'
                    );
                }
            });
        });
        $(document).on('click', '#btn_cancel_import_voucher', function() {
            $('.iso-lightbox-cancel').click();
        });
        function escapeHtml(text) {
            if (text === null || text === undefined) {
                return '';
            }
            return $('<div>')
                .text(text)
                .html();
        }

        function renderVoucherPreview(response) {
            var $preview =
                $('#voucher_import_preview');
            var $tbody =
                $('#voucher_import_table tbody');
            $tbody.empty();
            $('#import_total')
                .text(response.total || 0);
            $('#import_valid')
                .text(response.valid || 0);
            $('#import_invalid')
                .text(response.invalid || 0);

            $.each(
                response.data || [],
                function(index, item) {

                    var statusHtml = '';

                    if (item.valid) {

                        statusHtml =
                            '<span class="label label-success">' +
                            'Valid' +
                            '</span>';

                    } else {

                        var errors =
                            item.errors || [];

                        statusHtml =
                            '<span class="label label-danger">' +
                            'Invalid' +
                            '</span>';

                        if (errors.length) {

                            statusHtml +=
                                '<div class="import-row-errors">' +
                                escapeHtml(
                                    errors.join(', ')
                                ) +
                                '</div>';
                        }
                    }


                    var rowClass =
                        item.valid ?
                        '' :
                        'import-row-invalid';


                    $tbody.append(

                        '<tr class="' + rowClass + '">' +
                        '<td>' + escapeHtml(item.row) +'</td>' +
                        '<td>' + escapeHtml(item.voucher_code) + '</td>' +
                        '<td>' + escapeHtml(item.start_date) + '</td>' +
                        '<td>' + escapeHtml(item.expiry_date) + '</td>' +
                        '<td>' + escapeHtml(item.price) + '</td>' +
                        '<td>' + escapeHtml(item.usage_limit) + '</td>' +
                        '<td>' + escapeHtml(item.notes) + '</td>' + 
                        '<td>' + statusHtml + '</td>' +
                        '</tr>'
                    );

                }
            );

            /*
         * Hide upload section
         */
            $('.import-voucher-upload').hide();
            $('.import-voucher-file-info').hide();
            $('.import-voucher-supported').hide();
            $('.import-voucher-actions').hide();

            /*
         * Show preview
         */
            $preview.show();

            /*
         * Disable save if nothing valid
         */
            $('#btn_save_import_voucher').prop('disabled', parseInt(response.valid || 0) <= 0);
        }


        $(document).on('click', '#btn_import_voucher', function() {

            var $this = $(this);
            var fileInput = $('#voucher_import_file')[0];

            // 1. Check file
            if (!fileInput || !fileInput.files.length) {
                alertify.error('Please select an Excel file');
                return;
            }

            var file = fileInput.files[0];

            // 2. Check size
            if (file.size > 10 * 1024 * 1024) {
                alertify.error('Maximum file size is 10MB');
                return;
            }

            // 3. Check extension
            var extension = file.name
                .split('.')
                .pop()
                .toLowerCase();

            if (extension !== 'xlsx' && extension !== 'xls') {
                alertify.error('Only .xlsx and .xls files are supported');
                return;
            }

            // console.log('FILE:', file);
            // console.log('FILE NAME:', file.name);
            // console.log('FILE SIZE:', file.size);
            // console.log('FILE TYPE:', file.type);

            // 4. Đọc file
            var reader = new FileReader();

            $this.prop('disabled', true);
            vietiso_loading(1);

            reader.onload = function(e) {

                try {

                    var arrayBuffer = e.target.result;

                    // ArrayBuffer -> Uint8Array
                    var bytes = new Uint8Array(arrayBuffer);

                    // Uint8Array -> binary string
                    var binary = '';

                    var chunkSize = 0x8000;

                    for (var i = 0; i < bytes.length; i += chunkSize) {

                        binary += String.fromCharCode.apply(
                            null,
                            bytes.subarray(
                                i,
                                Math.min(i + chunkSize, bytes.length)
                            )
                        );
                    }

                    // Binary -> Base64
                    var base64 = btoa(binary);

                    console.log('BASE64 LENGTH:', base64.length);

                    // 5. Gửi Base64 lên PHP
                    $.ajax({
                        type: 'POST',

                        url: path_ajax_script +
                            '/index.php?mod=voucher&act=ajImportVoucher',

                        data: {
                            voucher_import_file_base64: base64,
                            voucher_import_file_name: file.name
                        },

                        dataType: 'json',

                        success: function(response) {

                            vietiso_loading(0);
                            $this.prop('disabled', false);

                            console.log('Import result:', response);

                            if (response.status !== 'success') {
                                alertify.error(
                                    response.message || 'Import failed'
                                );
                                return;
                            }

                            window.importVoucherData =
                                response.data || [];

                            renderVoucherPreview(response);
                        },

                        error: function(xhr) {

                            vietiso_loading(0);
                            $this.prop('disabled', false);

                            console.log('AJAX ERROR:', xhr.responseText);

                            alertify.error(
                                'Cannot process Excel file'
                            );
                        }
                    });

                } catch (error) {

                    vietiso_loading(0);
                    $this.prop('disabled', false);

                    console.error('READ FILE ERROR:', error);

                    alertify.error(
                        'Cannot read Excel file'
                    );
                }
            };

            reader.onerror = function() {

                vietiso_loading(0);
                $this.prop('disabled', false);

                alertify.error(
                    'Cannot read Excel file'
                );
            };

            // Quan trọng: đọc binary
            reader.readAsArrayBuffer(file);
        });

        $(document).on('change', '#voucher_import_file', function() {
            var file = this.files[0];

            if (!file) {
                return;
            }

            $('#import_voucher_file_name').text(file.name);
            $('#import_voucher_file_size').text(
                formatFileSize(file.size)
            );
            $('#import_voucher_file_info').show();
            $('#btn_import_voucher').prop(
                'disabled',
                false
            );
        });

        function formatFileSize(bytes) {
            if (!bytes) {
                return '0 Bytes';
            }
            var sizes = [
                'Bytes',
                'KB',
                'MB',
                'GB'
            ];
            var i = Math.floor(
                Math.log(bytes) / Math.log(1024)
            );
            return Math.round(
                bytes / Math.pow(1024, i) * 100
            ) / 100 + ' ' + sizes[i];
        }
        $(document).on(
            'click',
            '#btn_remove_import_file',
            function() {
                $('#voucher_import_file').val('');
                $('#import_voucher_file_info').hide();
                $('#btn_import_voucher').prop(
                    'disabled',
                    true
                );
            }
        );
        $(document).on(
            'dragover',
            '.import-voucher-dropzone',
            function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            }
        );

        $(document).on(
            'dragleave',
            '.import-voucher-dropzone',
            function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            }
        );


        $(document).on(
            'drop',
            '.import-voucher-dropzone',
            function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
                var files = e.originalEvent.dataTransfer.files;
                if (!files.length) {
                    return;
                }
                $('#voucher_import_file')[0].files = files;
                $('#voucher_import_file').trigger('change');
            }
        );
    </script>
    <style>
        .voucher-import-summary {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .voucher-import-summary .summary-item {
            min-width: 130px;
            padding: 15px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            background: #fafafa;
        }

        .voucher-import-summary .summary-item strong {
            display: block;
            font-size: 22px;
            margin-bottom: 4px;
        }

        .voucher-import-summary .summary-item span {
            font-size: 13px;
            color: #777;
        }

        .voucher-import-table-wrapper {
            max-height: 450px;
            overflow: auto;
            border: 1px solid #eee;
        }

        #voucher_import_table {
            margin: 0;
        }

        #voucher_import_table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #fff;
        }

        .import-row-invalid {
            background: #fff5f5;
        }

        .import-row-errors {
            margin-top: 5px;
            color: #e74c3c;
            font-size: 12px;
        }

        .voucher-import-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }


        .import-voucher {
            width: 100%;
        }

        .import-voucher-header {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 30px;
        }

        .import-voucher-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius-md);
            background: var(--color-primary-soft);
            font-size: 20px;
            color: var(--color-primary);
        }

        .import-voucher-header h2 {
            margin: 0 0 5px;

            font-size: 22px;
        }

        .import-voucher-header p {
            margin: 0;

            color: #777;
        }

        input[type=file][hidden] {
            display: none;
        }

        #btn_continue_import_voucher[disabled] {
            border-color: #ccc;
            color: #999 !important;
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Upload */

        .import-voucher-dropzone {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 250px;
            padding: 30px;
            border: 2px dashed #d8d8d8;
            border-radius: var(--border-radius-md);
            background: var(--color-primary-soft);
            cursor: pointer;
            transition: all .2s ease;
        }

        .import-voucher-dropzone:hover,
        .import-voucher-dropzone.dragover {
            border-color: var(--color-primary);
        }

        .import-voucher-upload-icon {
            margin-bottom: 15px;

            font-size: 42px;
            color: var(--color-primary);
        }

        .import-voucher-upload-title {
            margin-bottom: 5px;

            font-size: 16px;
            font-weight: 600;
        }

        .import-voucher-upload-text {
            margin-bottom: 15px;

            font-size: 13px;
            color: #888;
        }

        .import-voucher-formats {
            font-size: 12px;
            color: #999;
        }


        /* File info */

        .import-voucher-file-info {
            display: flex;
            align-items: center;

            padding: 15px;
            margin-top: 15px;

            border: 1px solid #e5e5e5;
            border-radius: var(--border-radius-md);

            background: #fafafa;
        }

        .import-voucher-file-icon {
            margin-right: 12px;

            font-size: 28px;
            color: var(--color-primary);
        }

        .import-voucher-file-details {
            flex: 1;
        }

        .import-voucher-file-name {
            margin-bottom: 3px;

            font-size: 14px;
            font-weight: 600;
        }

        .import-voucher-file-size {
            font-size: 12px;
            color: #888;
        }

        .import-voucher-remove-file {
            border: 0;
            background: transparent;

            font-size: 18px;

            cursor: pointer;
            color: #999;
        }

        .import-voucher-remove-file:hover {
            color: #e74c3c;
        }


        /* =========================================
        GUIDELINES
        ========================================= */

        .file-guidelines {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 8px;
            padding: 12px;
            border-radius: var(--border-radius-md);
            background: var(--color-primary-soft);
        }

        .guideline-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--color-primary);
            font-size: 24px;
            font-weight: 700;
        }

        .guideline-content {
            min-width: 0;
        }

        .guideline-content strong {
            display: block;
            margin-bottom: 8px;
            color: var(--color-primary);
            font-size: 16px;
            font-weight: 600;
        }

        .guideline-content ul {
            margin: 0;
            padding-left: 11px;
            color: #647c9c;
            font-size: 14px;
        }

        .guideline-content li {
            margin-bottom: 4px;
        }


        /* Formats */

        .import-voucher-supported {
            margin-top: 25px;
        }

        .import-voucher-supported-title {
            margin-bottom: 15px;

            font-size: 14px;
            font-weight: 600;
        }

        .import-voucher-format-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);

            gap: 12px;
        }

        .import-voucher-format {
            display: flex;
            align-items: center;

            padding: 14px;

            border: 1px solid #eee;
            border-radius: var(--border-radius-md);
        }

        .import-voucher-format-icon {
            margin-right: 10px;

            font-size: 22px;
            color: var(--color-primary);
        }

        .import-voucher-format strong,
        .import-voucher-format span {
            display: block;
        }

        .import-voucher-format strong {
            font-size: 13px;
        }

        .import-voucher-format span {
            margin-top: 3px;

            font-size: 11px;
            color: #999;
        }


        /* Notice */

        .import-voucher-notice {
            display: flex;
            gap: 10px;

            margin-top: 25px;
            padding: 14px 16px;

            border: 1px solid #ddd6ff;
            border-radius: var(--border-radius-md);

            background: #faf9ff;

            font-size: 13px;
            color: #666;
        }

        .import-voucher-notice i {
            color: var(--color-primary);
        }


        /* Actions */

        .import-voucher-actions {
            display: flex;
            justify-content: flex-end;

            padding-top: 25px;
            margin-top: 25px;

            border-top: 1px solid #eee;
        }
    </style>
{/literal}