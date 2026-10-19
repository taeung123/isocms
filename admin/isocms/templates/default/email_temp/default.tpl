<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}?mod=email_template">{$core->get_Lang('emailtemplate')}</a>
	<!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>
        	{$core->get_Lang('emailtemplate')} 
            <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a>
        </h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
    </div>
    <div class="clearfix"></div>
    <div class="wrap mt30">
    	{section name=i loop=$lstCat}
        	{assign var=lstEmailTemplate value=$clsClassTable->getListEmailTemplate($lstCat[i].email_template_cat_id)}
            {if $lstEmailTemplate}
                <div class="wrap">
                    {if $smarty.section.i.first}
                    <h2 style="font-size:20px;">{$lstCat[i].title}</h2>
                    {else}
                    <h2 style="font-size:18px; margin:30px 0 5px 0">{$lstCat[i].title}</h2>
                    {/if}
					<div class="row">
						 {section name=j loop=$lstEmailTemplate}
						 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 full_width_600">
						 	<div class="emailtplstandard full-width">
								<a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&email_temp_id={$core->encryptId($lstEmailTemplate[j].email_temp_id)}" id="{if 1 eq 1}({$lstEmailTemplate[j].email_temp_id}){/if}"><img align="top" src="{$URL_IMAGES}/massmail.png" /> {$clsClassTable->getTitle($lstEmailTemplate[j].email_temp_id,2)}
								</a>
							</div>
						 </div>
						{/section}
					</div>
                </div>
            {/if}
        {/section}
	</div>
</div>