{literal}
<style type="text/css">
	#modal_auto_ai_import {
		display: none;
		position: fixed !important;
		top: 0 !important;
		left: 0 !important;
		width: 100% !important;
		height: 100% !important;
		background: rgba(15, 23, 42, 0.65) !important;
		z-index: 999999 !important;
		overflow-x: hidden !important;
		overflow-y: auto !important;
		backdrop-filter: blur(4px) !important;
		-webkit-backdrop-filter: blur(4px) !important;
		padding: 20px !important;
		box-sizing: border-box !important;
	}
	#modal_auto_ai_import.show-modal {
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
	}
	#modal_auto_ai_import .modal-dialog {
		margin: auto !important;
		width: 100% !important;
		max-width: 620px !important;
	}
	#modal_auto_ai_import .modal-content {
		display: flex !important;
		flex-direction: column !important;
		position: relative !important;
		height: auto !important;
		max-height: calc(100vh - 60px) !important;
		overflow: hidden !important;
		border-radius: 14px !important;
		border: none !important;
		box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
		background: #ffffff !important;
	}
	#modal_auto_ai_import .modal-header {
		flex-shrink: 0 !important;
		background: linear-gradient(135deg, #6d28d9, #4f46e5) !important;
		color: #ffffff !important;
		border-top-left-radius: 14px !important;
		border-top-right-radius: 14px !important;
		padding: 20px 24px !important;
	}
	#modal_auto_ai_import .modal-body {
		position: relative !important;
		flex: 1 1 auto !important;
		overflow-y: auto !important;
		padding: 24px !important;
		height: auto !important;
		max-height: none !important;
	}
	#modal_auto_ai_import .modal-footer {
		position: relative !important;
		bottom: auto !important;
		top: auto !important;
		left: auto !important;
		right: auto !important;
		flex-shrink: 0 !important;
		clear: both !important;
		background: #faf5ff !important;
		border-bottom-left-radius: 14px !important;
		border-bottom-right-radius: 14px !important;
		padding: 16px 24px !important;
		display: flex !important;
		justify-content: flex-end !important;
		gap: 12px !important;
		border-top: 1px solid #f3e8ff !important;
	}
	.ai-dropzone-box {
		border: 2px dashed #a78bfa !important;
		background: #f5f3ff !important;
		border-radius: 14px !important;
		padding: 24px 16px !important;
		text-align: center !important;
		cursor: pointer !important;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
		min-height: 140px !important;
		display: flex !important;
		flex-direction: column !important;
		align-items: center !important;
		justify-content: center !important;
		gap: 8px !important;
	}
	.ai-dropzone-box:hover {
		background: #ede9fe !important;
		border-color: #7c3aed !important;
	}
	.ai-file-badge {
		display: inline-flex !important;
		align-items: center !important;
		gap: 8px !important;
		background: #ffffff !important;
		border: 1px solid #ddd6fe !important;
		color: #6d28d9 !important;
		padding: 8px 16px !important;
		border-radius: 20px !important;
		font-weight: 600 !important;
		font-size: 13px !important;
		max-width: 95% !important;
		word-break: break-all !important;
		box-shadow: 0 2px 8px rgba(109, 40, 217, 0.08) !important;
	}
	.ai-progress-container {
		background: #f5f3ff !important;
		border: 1px solid #ddd6fe !important;
		border-radius: 12px !important;
		padding: 18px 20px !important;
		margin-top: 20px !important;
	}
	.ai-progress-bar-custom {
		background: linear-gradient(90deg, #8b5cf6, #4f46e5) !important;
	}
	.btn-ai-submit {
		background: linear-gradient(135deg, #7c3aed, #4f46e5) !important;
		border: none !important;
		color: #ffffff !important;
		font-weight: 600 !important;
		padding: 10px 26px !important;
		border-radius: 8px !important;
		box-shadow: 0 4px 14px rgba(124, 58, 237, 0.35) !important;
		transition: all 0.25s ease !important;
	}
	.btn-ai-submit:hover {
		background: linear-gradient(135deg, #6d28d9, #4338ca) !important;
		box-shadow: 0 6px 18px rgba(124, 58, 237, 0.45) !important;
		color: #ffffff !important;
	}
	.btn-ai-submit:disabled, .btn-ai-submit.is-loading {
		background: linear-gradient(135deg, #7c3aed, #4f46e5) !important;
		color: #ffffff !important;
		opacity: 0.95 !important;
		cursor: not-allowed !important;
		box-shadow: 0 4px 16px rgba(124, 58, 237, 0.5) !important;
	}
	.ai-source-tabs {
		display: flex !important;
		background: #f1f5f9 !important;
		padding: 4px !important;
		border-radius: 10px !important;
		margin-bottom: 20px !important;
		border: 1px solid #e2e8f0 !important;
		gap: 4px !important;
	}
	.ai-source-tab-btn {
		flex: 1 !important;
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
		gap: 8px !important;
		padding: 9px 12px !important;
		border: none !important;
		background: transparent !important;
		border-radius: 8px !important;
		font-size: 13.5px !important;
		font-weight: 600 !important;
		color: #64748b !important;
		cursor: pointer !important;
		transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
		outline: none !important;
	}
	.ai-source-tab-btn:hover {
		color: #4f46e5 !important;
		background: rgba(255, 255, 255, 0.6) !important;
	}
	.ai-source-tab-btn.active {
		background: #ffffff !important;
		color: #6d28d9 !important;
		box-shadow: 0 2px 6px rgba(109, 40, 217, 0.12), 0 1px 2px rgba(0, 0, 0, 0.05) !important;
	}
	.ai-source-tab-btn i {
		font-size: 14px !important;
	}
	.ai-tab-pane {
		display: none;
	}
	.ai-tab-pane.active {
		display: block;
		animation: aiPaneFadeIn 0.25s ease forwards;
	}
	@keyframes aiPaneFadeIn {
		from { opacity: 0; transform: translateY(4px); }
		to { opacity: 1; transform: translateY(0); }
	}
	.ai-textarea-input {
		width: 100% !important;
		box-sizing: border-box !important;
		border: 1.5px solid #d8b4fe !important;
		background: #faf5ff !important;
		border-radius: 12px !important;
		padding: 12px 16px !important;
		font-size: 13.5px !important;
		line-height: 1.6 !important;
		color: #1e293b !important;
		min-height: 160px !important;
		max-height: 320px !important;
		resize: vertical !important;
		outline: none !important;
		transition: border-color 0.2s, box-shadow 0.2s, background 0.2s !important;
		font-family: inherit !important;
	}
	.ai-textarea-input:focus {
		background: #ffffff !important;
		border-color: #7c3aed !important;
		box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15) !important;
	}
	.ai-url-input-group {
		display: flex !important;
		align-items: center !important;
		position: relative !important;
		border: 1.5px solid #d8b4fe !important;
		background: #faf5ff !important;
		border-radius: 12px !important;
		padding: 2px 6px !important;
		transition: border-color 0.2s, box-shadow 0.2s, background 0.2s !important;
	}
	.ai-url-input-group:focus-within {
		background: #ffffff !important;
		border-color: #7c3aed !important;
		box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15) !important;
	}
	.ai-url-icon {
		padding: 10px 14px !important;
		color: #7c3aed !important;
		font-size: 16px !important;
		display: flex !important;
		align-items: center !important;
		justify-content: center !important;
	}
	.ai-url-input {
		flex: 1 !important;
		border: none !important;
		background: transparent !important;
		font-size: 14px !important;
		color: #1e293b !important;
		outline: none !important;
		padding: 10px 10px 10px 0 !important;
	}
	.ai-hint-box {
		margin-top: 8px !important;
		font-size: 12.5px !important;
		color: #64748b !important;
		display: flex !important;
		align-items: flex-start !important;
		gap: 6px !important;
		line-height: 1.5 !important;
	}
</style>
{/literal}

<!-- Modal Popup Create Tour with ISO AI (Fully Automatic) -->
<div id="modal_auto_ai_import" style="display:none;">
    <div class="modal-dialog" style="max-width: 620px;">
        <div class="modal-content">
            <div class="modal-header ai-modal-header">
                <h5 class="modal-title" id="modalAutoAILabel" style="font-weight: 700; font-size: 18px; margin: 0; display: flex; align-items: center; gap: 10px; color: #fff;">
                    <i class="fa fa-magic" style="color: #c4b5fd; font-size: 20px;"></i> Create Tour with AI (Fully Automatic)
                </h5>
                <button type="button" class="close btn_close_auto_ai" aria-label="Close" style="color: #fff; opacity: 0.9; font-size: 24px; outline: none; background: transparent; border: none; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_auto_ai_import" enctype="multipart/form-data">
                    <input type="hidden" id="ai_source_type" name="ai_source_type" value="file" />

                    <!-- 3 Options Tabs -->
                    <div class="ai-source-tabs" role="tablist">
                        <button type="button" class="ai-source-tab-btn active" data-source="file">
                            <i class="fa fa-cloud-upload"></i> Upload file
                        </button>
                        <button type="button" class="ai-source-tab-btn" data-source="text">
                            <i class="fa fa-align-left"></i> Text content
                        </button>
                        <button type="button" class="ai-source-tab-btn" data-source="url">
                            <i class="fa fa-link"></i> URL
                        </button>
                    </div>

                    <!-- Option 1: Upload file -->
                    <div class="ai-tab-pane active" id="pane_ai_file">
                        <div class="form-group mb-0">
                            <label style="font-weight: 600; color: #374151; margin-bottom: 10px; font-size: 14px; display: block;">Select tour itinerary file (.PDF, .DOCX, .TXT): <span style="color:#ef4444;">*</span></label>
                            <div class="ai-dropzone-box" id="auto_ai_dropzone">
                                <i class="fa fa-cloud-upload" style="font-size: 44px; color: #7c3aed; margin-bottom: 6px;"></i>
                                <div id="dropzone_filename" style="width: 100%;">
                                    <p style="margin: 0; font-size: 15px; color: #4b5563; font-weight: 600;">Drag & drop file here or <span style="color: #7c3aed; text-decoration: underline;">browse file from computer</span></p>
                                </div>
                                <span style="font-size: 12px; color: #9ca3af; display: block; margin-top: 4px;">Supported formats: .pdf, .docx, .txt (Max 20MB)</span>
                            </div>
                            <input type="file" id="file_auto_ai" name="file_ai" accept=".pdf,.docx,.doc,.txt" style="display: none;" />
                        </div>
                    </div>

                    <!-- Option 2: Text content -->
                    <div class="ai-tab-pane" id="pane_ai_text">
                        <div class="form-group mb-0">
                            <label style="font-weight: 600; color: #374151; margin-bottom: 10px; font-size: 14px; display: block;">Paste tour itinerary content / text: <span style="color:#ef4444;">*</span></label>
                            <textarea id="ai_text_content" name="text_content" class="ai-textarea-input" placeholder="Paste full tour itinerary content here (e.g. Tour title, duration, overview, day-by-day itinerary, inclusions/exclusions, pricing...)..."></textarea>
                            <div class="ai-hint-box">
                                <i class="fa fa-info-circle" style="color: #7c3aed; margin-top: 2px;"></i>
                                <span>Copy and paste tour program text from any source. ISO AI will extract all details and structure automatically.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Option 3: URL -->
                    <div class="ai-tab-pane" id="pane_ai_url">
                        <div class="form-group mb-0">
                            <label style="font-weight: 600; color: #374151; margin-bottom: 10px; font-size: 14px; display: block;">Enter tour webpage URL: <span style="color:#ef4444;">*</span></label>
                            <div class="ai-url-input-group">
                                <span class="ai-url-icon"><i class="fa fa-globe"></i></span>
                                <input type="url" id="ai_url_content" name="url_content" class="ai-url-input" placeholder="https://example.com/tour-program-detail..." autocomplete="off" />
                            </div>
                            <div class="ai-hint-box">
                                <i class="fa fa-info-circle" style="color: #7c3aed; margin-top: 2px;"></i>
                                <span>Enter direct link of the tour page. ISO AI will fetch the webpage content and extract all tour information.</span>
                            </div>
                        </div>
                    </div>

                    <div id="auto_ai_progress_box" class="ai-progress-container" style="display: none;">
                        <div class="d-flex align-items-center" style="gap: 12px; display: flex; align-items: center; margin-bottom: 8px;">
                            <div class="spinner-border" role="status" style="width: 22px; height: 22px; border-width: 3px; color: #7c3aed; margin-right: 10px;">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <span id="auto_ai_step_text" style="font-weight: 600; color: #4c1d95; font-size: 14px;">Reading and processing tour document...</span>
                        </div>
                        <div class="progress" style="height: 10px; border-radius: 6px; overflow: hidden; background: #ddd6fe; margin: 0;">
                            <div id="auto_ai_progress_bar" class="progress-bar progress-bar-striped progress-bar-animated ai-progress-bar-custom" role="progressbar" style="width: 15%;"></div>
                        </div>
                    </div>

                    <div id="auto_ai_error_alert" class="alert alert-danger mt-3" style="display: none; border-radius: 10px; font-weight: 500;"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn_close_auto_ai" id="btn_cancel_auto_ai" style="border-radius: 8px; font-weight: 500; padding: 9px 20px;">Cancel</button>
                <button type="button" class="btn btn-ai-submit" id="btn_submit_auto_ai">
                    <i class="fa fa-bolt" style="margin-right: 6px;"></i> Create with AI
                </button>
            </div>
        </div>
    </div>
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    var autoAISelectedFile = null;

    async function extractDocxTextBrowser(file) {
        try {
            if (typeof DecompressionStream === 'undefined') return '';
            var arrayBuffer = await file.arrayBuffer();
            var bytes = new Uint8Array(arrayBuffer);
            var view = new DataView(bytes.buffer, bytes.byteOffset, bytes.byteLength);
            var offset = 0;
            while (offset < bytes.length - 30) {
                if (view.getUint32(offset, true) === 0x04034b50) {
                    var compMethod = view.getUint16(offset + 8, true);
                    var compSize = view.getUint32(offset + 18, true);
                    var fnLen = view.getUint16(offset + 26, true);
                    var extraLen = view.getUint16(offset + 28, true);
                    var fnBytes = bytes.subarray(offset + 30, offset + 30 + fnLen);
                    var fn = new TextDecoder().decode(fnBytes);
                    var dataStart = offset + 30 + fnLen + extraLen;
                    if (fn === 'word/document.xml') {
                        var compData = bytes.subarray(dataStart, dataStart + compSize);
                        var xmlStr = '';
                        if (compMethod === 0) {
                            xmlStr = new TextDecoder().decode(compData);
                        } else if (compMethod === 8) {
                            var ds = new DecompressionStream('deflate-raw');
                            var writer = ds.writable.getWriter();
                            writer.write(compData);
                            writer.close();
                            var reader = ds.readable.getReader();
                            var chunks = [];
                            while (true) {
                                var res = await reader.read();
                                if (res.done) break;
                                chunks.push(res.value);
                            }
                            var totalLen = chunks.reduce(function(acc, c){ return acc + c.length; }, 0);
                            var merged = new Uint8Array(totalLen);
                            var pos = 0;
                            for (var i = 0; i < chunks.length; i++) {
                                merged.set(chunks[i], pos);
                                pos += chunks[i].length;
                            }
                            xmlStr = new TextDecoder().decode(merged);
                        }
                        var text = xmlStr.replace(/<\/w:p>/gi, '\n');
                        text = text.replace(/<w:tab[^>]*\/>/gi, ' ');
                        text = text.replace(/<w:br[^>]*\/>/gi, '\n');
                        text = text.replace(/<[^>]+>/g, '');
                        text = text.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"').replace(/&#39;/g, "'");
                        return text.trim();
                    }
                    offset = dataStart + compSize;
                } else {
                    offset++;
                }
            }
        } catch(err) {
            console.warn('Docx browser unpacker fallback to server:', err);
        }
        return '';
    }

    function resetAutoAIModalState() {
        autoAISelectedFile = null;
        $('#file_auto_ai').val('');
        $('#ai_text_content').val('');
        $('#ai_url_content').val('');
        $('#dropzone_filename').html('<p style="margin: 0; font-size: 15px; color: #4b5563; font-weight: 600;">Drag & drop file here or <span style="color: #7c3aed; text-decoration: underline;">browse file from computer</span></p>');
        $('#auto_ai_progress_box').hide();
        $('#auto_ai_error_alert').hide().text('');
        $('#btn_submit_auto_ai').prop('disabled', false).removeClass('is-loading').html('<i class="fa fa-bolt" style="margin-right: 6px;"></i> Create with AI').show();
        $('#btn_cancel_auto_ai').prop('disabled', false);
        $('.ai-source-tab-btn').prop('disabled', false).css('pointer-events', 'auto');
    }

    function openAutoAIModal() {
        resetAutoAIModalState();
        $('#modal_auto_ai_import').addClass('show-modal');
        $('body').css('overflow', 'hidden');
    }

    function closeAutoAIModal() {
        $('#modal_auto_ai_import').removeClass('show-modal');
        $('body').css('overflow', '');
        resetAutoAIModalState();
    }

    $(document).on('click', '#btn_open_auto_ai_modal, [data-lightbox="lightbox_create_with_ai"]', function(e){
        e.preventDefault();
        $('.lightbox.is-open, .iso-lightbox.is-open, #lightbox_select_create_tour').removeClass('is-open').hide();
        openAutoAIModal();
    });

    $(document).on('click', '.btn_close_auto_ai, #btn_cancel_auto_ai', function(e){
        e.preventDefault();
        closeAutoAIModal();
    });

    $(document).on('click', '#modal_auto_ai_import', function(e){
        if($(e.target).closest('.modal-content').length === 0) {
            closeAutoAIModal();
        }
    });

    $(document).on('keyup', function(e){
        if (e.key === 'Escape' && $('#modal_auto_ai_import').is(':visible')) {
            closeAutoAIModal();
        }
    });

    // Tab Switching
    $(document).on('click', '.ai-source-tab-btn', function(e){
        e.preventDefault();
        if($(this).hasClass('active')) return;
        var source = $(this).data('source');
        $('.ai-source-tab-btn').removeClass('active');
        $(this).addClass('active');
        $('#ai_source_type').val(source);
        $('.ai-tab-pane').removeClass('active');
        $('#pane_ai_' + source).addClass('active');
        $('#auto_ai_error_alert').hide().text('');

        if (source === 'text') {
            setTimeout(function(){ $('#ai_text_content').focus(); }, 120);
        } else if (source === 'url') {
            setTimeout(function(){ $('#ai_url_content').focus(); }, 120);
        }
    });

    // Dropzone Events
    $('#auto_ai_dropzone').on('click', function(e){
        if(e && e.target && e.target.id === 'file_auto_ai') return;
        $('#file_auto_ai').click();
    });

    $('#file_auto_ai').on('click', function(e){
        e.stopPropagation();
    });

    $('#file_auto_ai').on('change', function(){
        if(this.files && this.files[0]) {
            autoAISelectedFile = this.files[0];
            var fileName = autoAISelectedFile.name;
            $('#dropzone_filename').html('<div class="ai-file-badge"><i class="fa fa-file-text-o"></i> <span>' + fileName + '</span></div>');
        }
    });

    var dropzone = document.getElementById('auto_ai_dropzone');
    if(dropzone) {
        dropzone.addEventListener('dragover', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).css('background', '#ede9fe');
        });
        dropzone.addEventListener('dragleave', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).css('background', '#f5f3ff');
        });
        dropzone.addEventListener('drop', function(e){
            e.preventDefault();
            e.stopPropagation();
            $(this).css('background', '#f5f3ff');
            if(e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0]) {
                autoAISelectedFile = e.dataTransfer.files[0];
                var dt = e.dataTransfer;
                try {
                    document.getElementById('file_auto_ai').files = dt.files;
                } catch(err) {}
                var fileName = autoAISelectedFile.name;
                $('#dropzone_filename').html('<div class="ai-file-badge"><i class="fa fa-file-text-o"></i> <span>' + fileName + '</span></div>');
            }
        });
    }

    // Submit Processing
    $('#btn_submit_auto_ai').on('click', async function(e){
        e.preventDefault();
        var ajaxPath = (typeof path_ajax_script !== 'undefined' && path_ajax_script) ? path_ajax_script : '';
        var currentLang = (typeof $_LANG_ID !== 'undefined' && $_LANG_ID) ? $_LANG_ID : ('{/literal}{$_LANG_ID}{literal}' || 'en');
        var sourceType = $('#ai_source_type').val() || 'file';
        var formData = new FormData();
        formData.append('lang_id', currentLang);
        var targetUrl = '';
        var loadingText = '';

        if (sourceType === 'file') {
            var fileInput = document.getElementById('file_auto_ai');
            var selectedFile = autoAISelectedFile || (fileInput && fileInput.files && fileInput.files[0] ? fileInput.files[0] : null);
            if(!selectedFile) {
                $('#auto_ai_error_alert').text('Please select a tour itinerary file (.pdf, .docx, .doc, .txt)!').show();
                return;
            }
            if (selectedFile.size > 30 * 1024 * 1024) {
                $('#auto_ai_error_alert').text('File size (' + (selectedFile.size / (1024*1024)).toFixed(1) + 'MB) exceeds 30MB limit. Please choose a smaller file.').show();
                return;
            }

            var ext = '';
            if (selectedFile.name) {
                var nameParts = selectedFile.name.split('.');
                if (nameParts.length > 1) ext = nameParts.pop().toLowerCase();
            }

            var safeAsciiName = 'tour_file_' + Date.now() + (ext ? ('.' + ext) : '');
            formData.append('original_filename', selectedFile.name);

            // If it's a DOCX file, extract text on client-side as well for instant & reliable transmission
            if (ext === 'docx') {
                try {
                    console.log('[ISO AI Debug] Unpacking DOCX on client-side...');
                    var docxText = await extractDocxTextBrowser(selectedFile);
                    console.log('[ISO AI Debug] Client-side DOCX text length:', docxText ? docxText.length : 0);
                    if (docxText && docxText.length > 20) {
                        formData.append('doc_text', docxText);
                        console.log('[ISO AI Debug] Attached doc_text parameter (length: ' + docxText.length + ')');
                    }
                } catch(e) {
                    console.warn('[ISO AI Debug] Docx extraction note:', e);
                }
            }

            formData.append('file_ai', selectedFile, safeAsciiName);
            targetUrl = ajaxPath + '/index.php?mod=aiconfig&act=ajax_create_tour_auto_ai';
            loadingText = '🤖 ISO AI is reading file & creating tour details, itineraries, images...';
        } else if (sourceType === 'text') {
            var textContent = $.trim($('#ai_text_content').val());
            if(!textContent || textContent.length < 20) {
                $('#auto_ai_error_alert').text('Please enter or paste tour itinerary text (minimum 20 characters)!').show();
                $('#ai_text_content').focus();
                return;
            }
            formData.append('text_content', textContent);
            targetUrl = ajaxPath + '/index.php?mod=aiconfig&act=ajax_create_tour_auto_ai_text';
            loadingText = '🤖 ISO AI is analyzing text & creating tour details, itineraries, images...';
        } else if (sourceType === 'url') {
            var urlContent = $.trim($('#ai_url_content').val());
            if(!urlContent) {
                $('#auto_ai_error_alert').text('Please enter a tour webpage URL!').show();
                $('#ai_url_content').focus();
                return;
            }
            if(!urlContent.match(/^https?:\/\/.+/i)) {
                $('#auto_ai_error_alert').text('Please enter a valid website URL starting with http:// or https://!').show();
                $('#ai_url_content').focus();
                return;
            }
            formData.append('url_content', urlContent);
            targetUrl = ajaxPath + '/index.php?mod=aiconfig&act=ajax_create_tour_auto_ai_url';
            loadingText = '🌐 Fetching webpage & ISO AI is extracting tour details, itineraries, images...';
        }

        console.log('[ISO AI Debug] Sending request to:', targetUrl);

        $('#auto_ai_error_alert').hide().text('');
        $('#btn_submit_auto_ai').prop('disabled', true).addClass('is-loading').html('<i class="fa fa-spinner fa-spin" style="margin-right: 8px; font-size: 15px;"></i> Thinking...');
        $('#btn_cancel_auto_ai').prop('disabled', true);
        $('.ai-source-tab-btn').prop('disabled', true).css('pointer-events', 'none');

        $('#auto_ai_step_text').text(loadingText);
        $('#auto_ai_progress_bar').css('width', '25%');
        $('#auto_ai_progress_box').show();

        // Progress simulation during single request
        var currentProgress = 25;
        var progressTimer = setInterval(function(){
            if(currentProgress < 88) {
                currentProgress += Math.floor(Math.random() * 8) + 3;
                if(currentProgress > 88) currentProgress = 88;
                $('#auto_ai_progress_bar').css('width', currentProgress + '%');
            }
        }, 1200);

        function showError(msg) {
            clearInterval(progressTimer);
            $('#auto_ai_progress_box').hide();
            $('#btn_submit_auto_ai').prop('disabled', false).removeClass('is-loading').html('<i class="fa fa-bolt" style="margin-right: 6px;"></i> Create with AI');
            $('#btn_cancel_auto_ai').prop('disabled', false);
            $('.ai-source-tab-btn').prop('disabled', false).css('pointer-events', 'auto');
            $('#auto_ai_error_alert').html(msg).show();
        }

        $.ajax({
            url: targetUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            timeout: 300000,
            success: function(res) {
                clearInterval(progressTimer);
                console.log('[ISO AI Debug] Server Response:', res);
                if(typeof res === 'string') {
                    showError(res);
                    return;
                }
                if(res.ok) {
                    $('#auto_ai_progress_bar').css('width', '100%');
                    $('#auto_ai_step_text').text('✅ Tour created successfully! Redirecting...');
                    $('#btn_submit_auto_ai').html('<i class="fa fa-check" style="margin-right: 6px;"></i> Complete!');
                    setTimeout(function(){
                        if(res.edit_url) {
                            window.location.href = res.edit_url;
                        } else {
                            window.location.reload();
                        }
                    }, 600);
                } else {
                    showError(res.error || res.message || 'Error creating tour with AI.');
                }
            },
            error: function(xhr, status, error) {
                clearInterval(progressTimer);
                console.error('[ISO AI Debug] AJAX Raw ResponseText:', xhr.responseText);
                if(xhr.responseText) {
                    showError(xhr.responseText);
                } else {
                    showError('Connection error or timeout (' + (error || status) + '). Please try again.');
                }
            }
        });
    });
});
</script>
{/literal}
