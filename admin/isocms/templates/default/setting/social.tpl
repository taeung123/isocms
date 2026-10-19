<div class="breadcrumb">
    <a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('Social Media Settings')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">Quay lại</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2><i class="fa fa-wrench"></i> {$core->get_Lang('Settings')} &raquo; {$core->get_Lang('Social Media')}</h2>
		<p>{$core->get_Lang('Social Media setting')}</p>
    </div>
    <div class="clearfix"></div>
	<form method="post" action="" enctype="multipart/form-data" style="width:100%; max-width:768px">
		<div id="clientsummarycontainer">
			<table width="100%" class="block_full_width_700">
				<tbody class="block_full_width_700">
					<tr class="block_full_width_700">
						<div class="clientssummarybox" id="social_media_config">
							<div class="title">{$core->get_Lang('social media config')}</div>
							<table class="clientssummarystats" width="100%" border="0" cellspacing="2" cellpadding="3">
								<tr>
									<td class="fieldlabel">{$core->get_Lang('Facebook Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-Facebook_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('Facebook_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('Twitter Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-Twitter_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('Twitter_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('Youtube Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-Youtube_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('Youtube_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('Whatsapp Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-Whatsapp_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('Whatsapp_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('Google Plus Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-Google_Plus_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('Google_Plus_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('Instagram')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-Instagram_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('Instagram_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('Printest Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-Printest_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('Printest_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('LinkedIn Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-LinkedIn_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('LinkedIn_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="fieldlabel">{$core->get_Lang('TripAdvisor Link')}</td>
									<td class="fieldarea" style="width:100px">
										<select name="iso-TripAdvisor_Link">
											<option value="0">OFF</option>
											<option value="1" {if $clsConfiguration->getValue('TripAdvisor_Link')}selected="selected"{/if}>ON</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="social_link_box">
			<div class="col-sm-10">
				{if $clsConfiguration->getValue('Facebook_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon facebook ir" href="{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('Facebook Link')}</span>
					</div>
					<div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">http://www.facebook.com/</span>
						<input type="text" name="iso-SiteFacebookLink" value="{$clsConfiguration->getValue('SiteFacebookLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('Twitter_Link')}
				 <div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon twitter ir" href="{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('Twitter Link')}</span>
					</div>
					<div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">http://www.twitter.com/</span>
						<input type="text" name="iso-SiteTwitterLink" value="{$clsConfiguration->getValue('SiteTwitterLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('Youtube_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon youtube ir" href="{$clsConfiguration->getValue('SiteYoutubeLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('Youtube Link')}</span>
					</div>
					<div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">http://www.youtube.com/</span>
						<input type="text" name="iso-SiteYoutubeLink" value="{$clsConfiguration->getValue('SiteYoutubeLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('Whatsapp_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon whatsapp ir" href="{$clsConfiguration->getValue('SiteWhatsappLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('Whatsapp')}</span>
					</div>
					 <div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">http://wa.me/</span>
						<input type="text" name="iso-SiteWhatsappLink" value="{$clsConfiguration->getValue('SiteWhatsappLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('Google_Plus_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon google-plus ir" href="{$clsConfiguration->getValue('SiteGoogleLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('Google Plus Link')}</span>
					</div>
					 <div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">https://plus.google.com/</span>
						<input type="text" name="iso-SiteGoogleLink" value="{$clsConfiguration->getValue('SiteGoogleLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('Instagram_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon instagram ir" href="{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('Instagram')}</span>
					</div>
					<div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">https://www.instagram.com/</span>
						<input type="text" name="iso-SiteInstagramLink" value="{$clsConfiguration->getValue('SiteInstagramLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('Printest_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon pinterest ir" href="{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('Printest Link')}</span>
					</div>
					 <div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">http://pinterest.com/</span>
						<input type="text" name="iso-SitePrintestLink" value="{$clsConfiguration->getValue('SitePrintestLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('LinkedIn_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon ta-25 ir" href="{$clsConfiguration->getValue('LinkedIn')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('LinkedIn')}</span>
					</div>
					<div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">https://www.linkedin.com/</span>
						<input type="text" name="iso-SiteLinkedInLink" value="{$clsConfiguration->getValue('SiteLinkedInLink')}">
					</div>
				</div>
				{/if}
				{if $clsConfiguration->getValue('TripAdvisor_Link')}
				<div class="row-span">
					<div class="fieldlabel width25_767">
						<a class="social-icon ta-24 ir" href="{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank"></a><span class="hiden767">{$core->get_Lang('TripAdvisor')}</span>
					</div>
					<div class="fieldarea inputGroup" style="width:50%">
						<span class="input-group-addon">http://www.tripadvisor.com/</span>
						<input type="text" name="iso-SiteTripAdvisorLink" value="{$clsConfiguration->getValue('SiteTripAdvisorLink')}">
					</div>
				</div>
				{/if}
			</div>
			<div class="col-sm-2"> </div>
		</div>
		<div class="clearfix"></div>
		<fieldset class="submit-buttons">
			{$saveBtn}
			<input value="UpdateConfiguration" name="submit" type="hidden">
		</fieldset>
	</form>
</div>
{literal}
<script type="text/javascript">
	$(function(){
		$('select[name^=iso]').each(function(){
			var $_this = $(this);
			if($_this.val()==1){
				$_this.css({'border-color':'#0C0', 'background':'#e9ffd9'});
			}
		});
	});
</script>
<style>
.row-span .fieldlabel{width: 200px !important}
.row-span .fieldarea{width: calc(100% - 200px) !important}
</style>
{/literal}
