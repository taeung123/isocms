<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('hotel')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('settinghotel')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('settinghotel')}</h2>
        <p>{$core->get_Lang('systemmanagementsettinghotel')}</p>
    </div>
	<div class="wrap mt10 mb20">
		<div class="hd">
			<span class="bold">{$core->get_Lang('selectsetting')}</span>
		</div>
		<ul class="rsl-list-buttons">
			{if $clsConfiguration->getValue('SiteHasHotelToP') eq '1'}
			<li>
				<a title="{$core->get_Lang('hoteltop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=hoteltop&fromid=COUNTRY&target_id=1" >
					<img class="imgIcon" src="{$URL_IMAGES}/burn.png" width="32" height="32" />
					<span class="text">{$core->get_Lang('hoteltop')}</span>
				</a>
			</li>
			{/if}
            {if $clsConfiguration->getValue('SiteHasHotelPriceRange')}
			<li>
				<a title="{$core->get_Lang('pricerange')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=price_range" >
					<img class="imgIcon" src="{$URL_IMAGES}/career.png" width="32" height="32" />
					<span class="text">{$core->get_Lang('pricerange')}</span>
				</a>
			</li>
            {/if}
			{assign var=lstHotelProperty value=$clsHotelProperty->getListType()}
            {if $lstHotelProperty && $clsConfiguration->getValue('SiteHasHotelsProperty')}
            {foreach from=$lstHotelProperty key=k item=v}
			<li>
				<a title="{$v}" href="{$PCMS_URL}/index.php?mod={$mod}&act=property&type={$k}" >
					<img class="imgIcon" src="{$URL_IMAGES}/career.png" width="32" height="32" />
					<span class="text">{$v}</span>
				</a>
			</li>
            {/foreach}
            {/if}
            {if $clsConfiguration->getValue('SiteHasChild_slide')}
            <li>
				<a title="{$core->get_Lang('hotelslide')}" href="{$PCMS_URL}/index.php?mod=slide&mod_page={$mod}&act_page=default" >
					<img class="imgIcon" src="{$URL_IMAGES}/slide.png" width="32" height="32" />
					<span class="text">{$core->get_Lang('hotelslide')}</span>
				</a>
			</li>
            {/if}
		</ul>
	</div>
	<div id="clienttabs">
		<ul>
			<li><a><i class="fa fa-cog"></i> {$core->get_Lang('general')}</a></li>
		</ul>
	</div>
	<div id="tab_content">
		<div class="tabbox">
			<form method="post" action="" enctype="multipart/form-data">
				<table class="form" cellpadding="3" cellspacing="3">
                	{if $_DEV && $clsConfiguration->getValue('SiteConfigModLink')}
					<tr>
						<td class="fieldlabel span20">{$core->get_Lang('link')}</td>
						<td class="fieldarea">
                        	{assign var=site_hotel_link value=site_hotel_link_|cat:$_LANG_ID}
							<input class="text full required" name="iso-{$site_hotel_link}" value="{$clsConfiguration->getValue($site_hotel_link)}" maxlength="255" type="text" />
						</td>
					</tr>
                    {/if}
					<tr>
						<td class="fieldlabel">{$core->get_Lang('intropage')}</td>
						<td class="fieldarea">
                        	{assign var=site_hotel_intro value=site_hotel_intro_|cat:$_LANG_ID}
                            <textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_hotel_intro}" style="width:100%">{$clsConfiguration->getValue($site_hotel_intro)}</textarea>
						</td>
					</tr>
					<tr style="display:none">
						<td class="fieldlabel span20">{$core->get_Lang('recordperpage')}</td>
						<td class="fieldarea">
							<select class="slb span20" name="iso-SiteRecordPerPage_Hotels">
								<option value="10" {if $clsConfiguration->getValue('SiteRecordPerPage_Hotels') eq '10'}selected="selected"{/if}> -- 10 record/page --</option>
								<option value="20" {if $clsConfiguration->getValue('SiteRecordPerPage_Hotels') eq '20'}selected="selected"{/if}> -- 20 record/page --</option>
								<option value="30" {if $clsConfiguration->getValue('SiteRecordPerPage_Hotels') eq '30'}selected="selected"{/if}> -- 30 record/page --</option>
								<option value="40" {if $clsConfiguration->getValue('SiteRecordPerPage_Hotels') eq '40'}selected="selected"{/if}> -- 40 record/page --</option>
								<option value="50" {if $clsConfiguration->getValue('SiteRecordPerPage_Hotels') eq '50'}selected="selected"{/if}> -- 50 record/page --</option>
							</select>
						</td>
					</tr>
                    <tr>
                        <td class="fieldlabel">{$core->get_Lang('bannercover')}</td>
                        <td class="fieldarea">
                            <div class="photobox span98">
                                <img src="{$clsConfiguration->getValue('site_hotel_banner')}" id="isoman_show_site_hotel_banner" class="span100" height="156px" style="width:100%;" />
                                <input type="hidden" id="isoman_hidden_site_hotel_banner" name="isoman_url_site_hotel_banner" value="{$clsConfiguration->getValue('site_hotel_banner')}" />
                                <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="site_hotel_banner" isoman_val="{$clsConfiguration->getValue('site_hotel_banner')}" isoman_name="site_hotel_banner" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr>
						<td class="fieldlabel span20">{$core->get_Lang('introBanner')}</td>
						<td class="fieldarea">
                        	{assign var=site_intro_hotel_banner value=site_intro_hotel_banner_|cat:$_LANG_ID}
							<input class="text full required" name="iso-{$site_intro_hotel_banner}" value="{$clsConfiguration->getValue($site_intro_hotel_banner)}" maxlength="1000" type="text" />
						</td>
					</tr>
				</table>
				<div class="clearfix mt10"></div>
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker();
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/hotel/jquery.hotel.js"></script>