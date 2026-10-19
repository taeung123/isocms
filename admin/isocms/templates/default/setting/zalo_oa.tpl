<div class="breadcrumb">
    <a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=central" title="{$mod}">{$core->get_Lang('System Settings')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">Quay lại</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2><i class="fa fa-wrench"></i> {$core->get_Lang('Settings')} &raquo; {$core->get_Lang('companyprofile')}</h2>
		<p>{$core->get_Lang('System setting')}</p>
    </div>
    <div class="clearfix"></div>
    <form method="post" action="" enctype="multipart/form-data" class="validate-form">
		<div class="bootstrap">
            <div class="hd">
                <span class="bold">{$core->get_Lang('Zalo OA Information')}</span>
            </div>
            <div class="row-span">
                <div class="fieldlabel">
                    {$core->get_Lang('App Id')}
                </div>
                <div class="fieldarea" style="width:calc(100% - 180px)">
                    <input class="inputFix" type="text" name="iso-ZaloAppId" value="{$clsConfiguration->getValue('ZaloAppId')}">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel">
                    {$core->get_Lang('Secret')}
                </div>
                <div class="fieldarea" style="width:calc(100% - 180px)">
                    <input class="inputFix" type="text" name="iso-ZaloSecret" value="{$clsConfiguration->getValue('ZaloSecret')}">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel">
                    {$core->get_Lang('Refresh Token')}
                </div>
                <div class="fieldarea" style="width:calc(100% - 180px)">
                    <input class="inputFix"type="text" name="iso-ZaloRefreshToken" value="{$clsConfiguration->getValue('ZaloRefreshToken')}">
                </div>
            </div>
        </div>
		<div class="clearfix"></div>
		<fieldset class="submit-buttons fixed">
			{$saveBtn}
			<input value="CompanyProfile" name="submit" type="hidden">
		</fieldset>
	</form> 
</div>
