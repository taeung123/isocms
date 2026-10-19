<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('tour')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$mod}">{$core->get_Lang('OnPage description')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('OnPage description')}</h2>
        <p>{$core->get_Lang('systemmanagementonpagedesctour')}</p>
    </div>
	<div id="clienttabs">
		<ul>
			<li><a><i class="fa fa-cog"></i> {$core->get_Lang('general')}</a></li>
			{if $clsConfiguration->getValue('SitePriceTableType_Tours') eq '1'}
			<li><a href="javascript:void();"><i class="fa fa-desktop"></i> {$core->get_Lang('Config Markup')}</a></li>
			{/if}
		</ul>
	</div>
	<div id="tab_content">
		<div class="tabbox">
			<form method="post" action="" enctype="multipart/form-data">
				<table class="form" cellpadding="3" cellspacing="3">
					<tr>
						<td class="fieldlabel span20">{$core->get_Lang('link')}</td>
						<td class="fieldarea">
                        	{assign var=site_tours_link value=site_tours_link_|cat:$_LANG_ID}
							<input class="text full required" name="iso-{$site_tours_link}" value="{$clsConfiguration->getValue($site_tours_link)}" maxlength="255" type="text" />
						</td>
					</tr>
					<tr>
						<td class="fieldlabel">{$core->get_Lang('intropage')}</td>
						<td class="fieldarea">
                        	{assign var=site_tour_intro value=site_tour_intro_|cat:$_LANG_ID}
                            <textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_tour_intro}" style="width:100%">{$clsConfiguration->getValue($site_tour_intro)}</textarea>
						</td>
					</tr>
                    {if $clsConfiguration->getValue('SiteHasStore_Tours')}
                    {assign var=lstTourType value=$clsTourStore->getListType()}
					{foreach from=$lstTourType key=k item=v}
                    <tr>
						<td class="fieldlabel">{$core->get_Lang('intropage')} {$clsTourStore->getTitle($k)}</td>
						<td class="fieldarea">
                        	{assign var=siteTourType value=SiteTourType_$k}
                            {assign var=siteTourTypeLang value=$siteTourType|cat:"_"|cat:$_LANG_ID}
                            <textarea id="{$siteTourTypeLang}{$now}" class="textarea_intro_editor" name="iso-{$siteTourTypeLang}" style="width:100%">{$clsConfiguration->getValue($siteTourTypeLang)}</textarea>
						</td>
					</tr>
                    {/foreach}
                    {/if}
					<tr>
						<td class="fieldlabel span20">{$core->get_Lang('recordperpage')}</td>
						<td class="fieldarea">
							<select class="slb span20" name="iso-SiteRecordPerPage_Tours">
								<option value="10" {if $clsConfiguration->getValue('SiteRecordPerPage_Tours') eq '10'}selected="selected"{/if}> -- 10 record/page --</option>
								<option value="20" {if $clsConfiguration->getValue('SiteRecordPerPage_Tours') eq '20'}selected="selected"{/if}> -- 20 record/page --</option>
								<option value="30" {if $clsConfiguration->getValue('SiteRecordPerPage_Tours') eq '30'}selected="selected"{/if}> -- 30 record/page --</option>
								<option value="40" {if $clsConfiguration->getValue('SiteRecordPerPage_Tours') eq '40'}selected="selected"{/if}> -- 40 record/page --</option>
								<option value="50" {if $clsConfiguration->getValue('SiteRecordPerPage_Tours') eq '50'}selected="selected"{/if}> -- 50 record/page --</option>
							</select>
						</td>
					</tr>
					{if $clsConfiguration->getValue('SiteHasPriceTableTours')}
					<tr>
						<td class="fieldlabel">{$core->get_Lang('pricetabletype')}</td>
						<td class="fieldarea">
							<select class="slb span20"  name="iso-SitePriceTableType_Tours">
								<option {if $clsConfiguration->getValue('SitePriceTableType_Tours') eq '0'}selected="selected"{/if} value="0"> - Normal - </option>
								<option {if $clsConfiguration->getValue('SitePriceTableType_Tours') eq '1'}selected="selected"{/if} value="1"> - Markup - </option>
								<option {if $clsConfiguration->getValue('SitePriceTableType_Tours') eq '2'}selected="selected"{/if} value="2"> - Advanced - </option>
							</select>
						</td>
					</tr>
					{/if}
				</table>
				<div class="clearfix mt10"></div>
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
		{if $clsConfiguration->getValue('SitePriceTableType_Tours') eq '1'}
		<div class="tabbox" style="display:none">
			<form method="post" action="" enctype="multipart/form-data">
				<table class="form" cellpadding="3" cellspacing="3">
					<tbody>
						<tr>
							<td class="fieldlabel" width="25%">{$core->get_Lang('Global %Tour')}</td>
							<td class="fieldarea"> {$core->get_Lang('clients')}:
								<input type="text" style="width:60px;" class="full text" name="iso-config_markup_tour" value="{$clsConfiguration->getValue('config_markup_tour')}">
								% /	{$core->get_Lang('agents')}:
								<input type="text" style="width:60px;" class="full text" name="iso-config_markup_tour_agent" value="{$clsConfiguration->getValue('config_markup_tour_agent')}">
								% 
							</td>
						</tr>
					</tbody>
				</table>
				<br>
				<table class="form" cellpadding="3" cellspacing="3">
					<tbody>
						<tr>
							<td class="fieldlabel" width="25%">{$core->get_Lang('tourlowseason')}</td>
							<td class="fieldarea"><input type="text" class="datepicker" style="width:120px;" name="date-tour_low_from" value="{$clsConfiguration->getValue('tour_low_from')|date_format:"%m/%d/%Y"}">
								»
								<input type="text" class="datepicker" style="width:120px;" name="date-tour_low_to" value="{$clsConfiguration->getValue('tour_low_to')|date_format:"%m/%d/%Y"}">
								(mm/dd/YYYY) 
							</td>
						</tr>
						<tr>
							<td class="fieldlabel" width="25%">{$core->get_Lang('tourhighseason')}</td>
							<td class="fieldarea"><input type="text" class="datepicker" style="width:120px;" name="date-tour_high_from" value="{$clsConfiguration->getValue('tour_high_from')|date_format:"%m/%d/%Y"}">
								»
								<input type="text" class="datepicker" style="width:120px;" name="date-tour_high_to" value="{$clsConfiguration->getValue('tour_high_to')|date_format:"%m/%d/%Y"}">
								(mm/dd/YYYY) 
							</td>
						</tr>
					</tbody>
				</table>
				<div class="clearfix mt10"></div>
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration2" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
		{/if}
	</div>
</div>
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker();
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js"></script>