<div class="panel-panel-inner infocompany">
    <div class="panel-pane pane-views-panes clearfix no-title">
        <div class="pane-content">
			{assign var=CompanyName value=CompanyName_|cat:$_LANG_ID}
			<p class="h3">{$clsConfiguration->getValue($CompanyName)}</p>
            <ul class="d2-page">
				{assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
            	<li><span> {$core->get_Lang('Address')}:</span> {$clsConfiguration->getValue($CompanyAddress)} </li>
				<li><span>{$core->get_Lang('Email')}:</span> <a href="mailto:{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}</a>  </li>
				<li><span>{$core->get_Lang('Phone')}:</span> <a href="tel:{$clsConfiguration->getValue('CompanyPhone')}">{$clsConfiguration->getValue('CompanyPhone')}</a></li>
				<li><span>{$core->get_Lang('Hotline')}:</span> <a href="tel:{$clsConfiguration->getValue('CompanyHotline')}"> {$clsConfiguration->getValue('CompanyHotline')}</a></li>
            </ul>
        </div>
    </div>
</div>