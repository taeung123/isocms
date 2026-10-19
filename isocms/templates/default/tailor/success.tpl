<link rel="stylesheet" type="text/css" href="{$URL_CSS}/tailor.css" />
<div id="customize_wrap">
	<h2 class="headPage">Tailor Made Your Tour Success !</h2>
    <div class="breadcrumb">
        <a href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a> 
        <a>|</a> 
        <a href="{$extLang}/travel-styles/" title="{$core->get_Lang('Travel styles')}">{$core->get_Lang('Travel styles')}</a>
       	<a>|</a> 
		<a href="{$curl}" title="{$core->get_Lang('Tailor made tour')}">{$core->get_Lang('Tailor made tour')}</a>
    </div>
	<div class="formatTextStandard">
		{$clsConfiguration->getValue('SiteMsgTailorSuccess')|html_entity_decode}
	</div>
	<br />
	<br />
</div>