<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Page')}">{$core->get_Lang('Page')}</a>
    <a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{if $pvalTable}{$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Page')}{/if}</h2>
		<!-- Edit Permalink-->
        {if $pvalTable}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
            	<a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="top" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</strong></a>
            </div>
        </div>
        {/if}
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('Information')}</a></li>
                {if $pvalTable}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
            	<div class="span100">
                    <div class="row-span" style="margin-bottom:10px; padding-bottom:10px;">
                        <input style="border:2px solid #ccc; padding:6px 10px; font-family:Arial;" class="text full required fontLarge" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                    </div>
                </div>
				{if 1 eq 2}
                <div class="row-span">
					<div class="notice">{$core->get_Lang('Link Url')}</div>
                    <input  class="text full url" name="iso-url" value="{$clsClassTable->getUrl($pvalTable)}" maxlength="255" type="text">
                </div>
				{/if}
                <div class="row-span">
					<div class="notice">{$core->get_Lang('content')}</div>
					{$clsForm->showInput('intro')}
				</div>
        	</div>
            {if $pvalTable}
			<div class="tabbox" style="display:none">
                {$core->getBlock('meta_box_detail')}
            </div>
            {/if}
        </div>
        <br class="clearfix" />
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script>var domain_name="{$DOMAIN_NAME}";</script>
{literal}
<script>
$('#config_link').bind('blur change click',function(){
	var config_link=$(this).val();
	var regex=domain_name;
	if(config_link.match(regex)){
		var link_config=config_link.replace(regex,'');
		$(this).val(link_config);
	}
});
</script>
{/literal}