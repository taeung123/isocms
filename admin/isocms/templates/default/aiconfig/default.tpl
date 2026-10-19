<link rel="stylesheet" href="{$URL_CSS}/style_tour_setting.css?v={$upd_version}" type="text/css" media="all" />
<div class="page-tour_setting iso-module-list">
{$core->getBlock('breadcrumb_tour_settings')}


	{$core->getBlock('header_title_tour_setting')}

	<div class="container-fluid container-fluid-2">
		{$core->getBlock('menu_tour_exhautive_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex justify-content-between align-items-center">
				<div class="title">
					<h2><i class="fa fa-magic" style="color: #7c3aed; margin-right: 8px;"></i> {$core->get_Lang('AI Configuration')}</h2>
					<p>{$core->get_Lang('Manage Gemini AI API Key and Model settings for automatic tour creation')}</p>
				</div>
				<div>
					{if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}
						<span id="badge_ai_status" class="badge bg-success" style="font-size: 13px; padding: 7px 14px; border-radius: 20px; font-weight: 500; background-color: #10b981; color: #fff;">
							<i class="fa fa-check-circle"></i> {$core->get_Lang('AI Enabled')}
						</span>
					{else}
						<span id="badge_ai_status" class="badge bg-secondary" style="font-size: 13px; padding: 7px 14px; border-radius: 20px; font-weight: 500; background-color: #9ca3af; color: #fff;">
							<i class="fa fa-power-off"></i> {$core->get_Lang('AI Disabled')}
						</span>
					{/if}
					{if $clsConfiguration->getValue('gemini_api_key')}
						<span class="badge bg-info" style="font-size: 13px; padding: 7px 14px; border-radius: 20px; font-weight: 500; background-color: #0ea5e9; color: #fff; margin-left: 6px;">
							<i class="fa fa-key"></i> {$core->get_Lang('API Key Configured')}
						</span>
					{else}
						<span class="badge bg-warning text-dark" style="font-size: 13px; padding: 7px 14px; border-radius: 20px; font-weight: 500; background-color: #f59e0b; color: #111; margin-left: 6px;">
							<i class="fa fa-exclamation-triangle"></i> {$core->get_Lang('API Key Not Configured')}
						</span>
					{/if}
				</div>
			</div>
			<div class="wrap">
				{if $message|default:'' eq 'UpdateSuccess'}
				<div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 8px; font-weight: 500; font-size: 14px; margin-bottom: 20px; border-left: 5px solid #2ea44f;">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<i class="fa fa-check-circle" style="font-size: 16px; margin-right: 8px;"></i> {$core->get_Lang('AI Configuration updated successfully!')}
				</div>
				{/if}

				<!-- GEMINI API KEY & MODEL CONFIGURATION PANEL -->
				<div class="panel panel-default" style="border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; background: #fff; margin-top: 10px;">
					<div class="panel-heading" style="background: linear-gradient(135deg, #7c3aed 0%, #4c1d95 100%); color: #fff; font-weight: 600; font-size: 15px; padding: 14px 20px; border: none;">
						<i class="fa fa-key" style="margin-right: 8px;"></i> {$core->get_Lang('Google Gemini AI Connection Settings')}
					</div>
					<div class="panel-body" style="padding: 25px;">
						<form method="post" action="">
							<!-- FEATURE TOGGLE SWITCH -->
							<div class="row" style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f3f4f6;">
								<div class="col-md-12">
									<div style="display: flex; align-items: center; justify-content: space-between; background: #f9fafb; padding: 16px 20px; border-radius: 10px; border: 1px solid #e5e7eb;">
										<div>
											<h4 style="margin: 0 0 4px 0; font-size: 15px; font-weight: 600; color: #1f2937;">
												<i class="fa fa-toggle-on" style="color: #7c3aed; margin-right: 6px;"></i> {$core->get_Lang('Enable AI Tour Creation')}
											</h4>
											<p style="margin: 0; font-size: 13px; color: #6b7280;">
												{$core->get_Lang('Turn on or off the Create with AI button and automatic tour generation feature in Tour Management')}
											</p>
										</div>
										<div style="display: flex; align-items: center; gap: 12px;">
											<input type="hidden" name="iso-ai_tour_enabled" value="0" />
											<label class="ai-switch">
												<input type="checkbox" id="toggle_ai_tour_enabled" name="iso-ai_tour_enabled" value="1" {if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}checked{/if}>
												<span class="ai-slider"></span>
											</label>
											<span id="ai_status_text" style="font-weight: 600; font-size: 14px; min-width: 65px; color: {if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}#10b981{else}#9ca3af{/if};">
												{if $clsConfiguration->getValue('ai_tour_enabled') eq '1'}{$core->get_Lang('Enabled')}{else}{$core->get_Lang('Disabled')}{/if}
											</span>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6" style="margin-bottom: 20px;">
									<label style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">
										Gemini API Key <span style="color:#ef4444;">*</span>
									</label>
									<div class="input-group" style="width: 100%;">
										<input type="password" id="gemini_api_key_input" name="iso-gemini_api_key" value="{$clsConfiguration->getValue('gemini_api_key')}" class="form-control" style="height: 42px; border-radius: 8px 0 0 8px; border: 1px solid #d1d5db; font-size: 14px; padding: 0 14px;" placeholder="Paste Gemini API Key here (e.g. AIzaSy...)" />
										<span class="input-group-btn">
											<button type="button" class="btn btn-default" id="toggleApiKeyBtn" style="height: 42px; border-radius: 0 8px 8px 0; border: 1px solid #d1d5db; border-left: none; background: #f9fafb;">
												<i class="fa fa-eye" id="toggleApiKeyIcon"></i>
											</button>
										</span>
									</div>
									<div style="margin-top: 6px; font-size: 12px; color: #6b7280; display: flex; justify-content: space-between;">
										<span>Get API Key from Google AI Studio</span>
										<a href="https://aistudio.google.com/app/apikey" target="_blank" style="color: #7c3aed; font-weight: 600; text-decoration: none;">
											<i class="fa fa-external-link"></i> Open Google AI Studio
										</a>
									</div>
								</div>

								<div class="col-md-6" style="margin-bottom: 20px;">
									<label style="font-weight: 600; color: #374151; font-size: 14px; margin-bottom: 8px; display: block;">
										Gemini Model ID
									</label>
									<select name="iso-gemini_model_id" class="form-control" style="height: 42px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 14px; padding: 0 12px; background: #fff;">
										<option value="gemini-3.1-flash-lite" {if $clsConfiguration->getValue('gemini_model_id') eq 'gemini-3.1-flash-lite'}selected{/if}>Gemini 3.1 Flash Lite (Fast & Optimized)</option>
										<option value="gemini-2.5-flash-lite" {if $clsConfiguration->getValue('gemini_model_id') eq 'gemini-2.5-flash-lite'}selected{/if}>Gemini 2.5 Flash Lite</option>
										<option value="gemini-2.5-flash" {if $clsConfiguration->getValue('gemini_model_id') eq 'gemini-2.5-flash' || !$clsConfiguration->getValue('gemini_model_id')}selected{/if}>Gemini 2.5 Flash (Recommended - Stable)</option>
										<option value="gemini-3.5-flash" {if $clsConfiguration->getValue('gemini_model_id') eq 'gemini-3.5-flash'}selected{/if}>Gemini 3.5 Flash</option>
										<option value="gemini-3.6-flash" {if $clsConfiguration->getValue('gemini_model_id') eq 'gemini-3.6-flash'}selected{/if}>Gemini 3.6 Flash</option>
									</select>
									<div style="margin-top: 6px; font-size: 12px; color: #6b7280;">
										Model used to analyze tour itineraries and generate structured tour data.
									</div>
								</div>
							</div>

							<hr style="margin: 15px 0 20px 0; border-color: #f3f4f6;" />

							<div style="display: flex; justify-content: flex-end;">
								<button type="submit" name="submit" value="UpdateConfiguration" class="btn btn-main" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: #fff; font-weight: 600; padding: 10px 24px; border-radius: 8px; border: none; font-size: 14px; box-shadow: 0 2px 8px rgba(124, 58, 237, 0.3);">
									<i class="fa fa-save" style="margin-right: 6px;"></i> {$core->get_Lang('Save AI Config')}
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var path_ajax_script = '{$PCMS_URL}';
</script>

{literal}
<style>
.ai-switch {
  position: relative;
  display: inline-block;
  width: 52px;
  height: 28px;
  margin: 0;
  vertical-align: middle;
}
.ai-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.ai-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cbd5e1;
  transition: .3s;
  border-radius: 28px;
}
.ai-slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .3s;
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
.ai-switch input:checked + .ai-slider {
  background: linear-gradient(135deg, #10b981, #059669);
}
.ai-switch input:checked + .ai-slider:before {
  transform: translateX(24px);
}
@media (max-width: 767px) {
	.content_setting_box{
		  width: 100% !important;
	}
	.d-flex {
    display: inline-block !important;
    width: 100%;
}
}
</style>
<script>
$(document).ready(function(){
    $('#toggleApiKeyBtn').on('click', function(){
        var input = $('#gemini_api_key_input');
        var icon = $('#toggleApiKeyIcon');
        if(input.attr('type') === 'password'){
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#toggle_ai_tour_enabled').on('change', function(){
        var isChecked = $(this).is(':checked');
        var status = isChecked ? 1 : 0;
        if(isChecked) {
            $('#ai_status_text').text('Enabled').css('color', '#10b981');
            $('#badge_ai_status').replaceWith('<span id="badge_ai_status" class="badge bg-success" style="font-size: 13px; padding: 7px 14px; border-radius: 20px; font-weight: 500; background-color: #10b981; color: #fff;"><i class="fa fa-check-circle"></i> AI Enabled</span>');
        } else {
            $('#ai_status_text').text('Disabled').css('color', '#9ca3af');
            $('#badge_ai_status').replaceWith('<span id="badge_ai_status" class="badge bg-secondary" style="font-size: 13px; padding: 7px 14px; border-radius: 20px; font-weight: 500; background-color: #9ca3af; color: #fff;"><i class="fa fa-power-off"></i> AI Disabled</span>');
        }
        var ajaxPath = (typeof path_ajax_script !== 'undefined' && path_ajax_script) ? path_ajax_script : (window.location.origin + '/admin');
        $.ajax({
            url: ajaxPath + '/index.php?mod=aiconfig&act=ajax_toggle_ai_tour_status',
            type: 'POST',
            data: { status: status },
            dataType: 'json',
            success: function(res) {
                var msg = status ? 'AI Tour Creation Enabled' : 'AI Tour Creation Disabled';
                if($('#ai_toggle_toast').length === 0){
                    $('body').append('<div id="ai_toggle_toast" style="position:fixed;bottom:25px;right:25px;z-index:999999;padding:12px 22px;border-radius:8px;color:#fff;font-weight:600;font-size:14px;box-shadow:0 10px 25px rgba(0,0,0,0.2);transition:all 0.3s ease;"></div>');
                }
                $('#ai_toggle_toast').css('background', status ? '#10b981' : '#4b5563').text(msg).stop(true, true).fadeIn().delay(1800).fadeOut();
            },
            error: function(err) {
                console.error('Failed to toggle AI status:', err);
                alert('Could not update AI status. Please try clicking "Save AI Config" below.');
            }
        });
    });
});
</script>
{/literal}
