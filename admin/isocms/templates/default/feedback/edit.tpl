<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}{$clsClassTable->getBreadcrumbAdmin($oneTable.feedback_id, "link")}">{$clsClassTable->getBreadcrumbAdmin($oneTable.feedback_id, "title")}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$clsClassTable->getBreadcrumbAdmin($oneTable.feedback_id, "page_title")}</h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
        <div>
		{if $oneTable.type eq "TourInquiry"}
            {$core->get_Lang("Detail Booking Module by VietISO")}
        {elseif $clsConfiguration->getValue($setting) ne ''}
            {$clsConfiguration->getValue($setting)|html_entity_decode}
		{/if}
        </div>
    </div>
    <br class="clearfix" />
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        {assign var=FEEDBACKVALUE value = $clsISO->getArrayFromString($oneTable.feedback_store)}
		 <div class="coltrols">{$clsClassTable->getFeedbackHTML($pvalTable)}</div>
		<div class="row-field mt10">
            <div class="row-heading">{$core->get_Lang('note')}:</div>
            <div class="coltrols">{$clsForm->showInput('note')}</div>
        </div>
        <div class="row-field">
            <div class="row-heading">{$core->get_Lang('processcontact')}:</div>
            <div class="coltrols">
            	<label for="is_process"><input type="checkbox" name="is_process" value="1" {if $oneTable.is_process eq '1'}checked="checked"{/if} /> {$core->get_Lang('tick here if processed')}!</label>
            </div>
        </div>
        <fieldset class="submit-buttons">
            <button type="submit" class="btn btn-primary start">
                <i class="icon-ok icon-white"></i>
                <span>{$core->get_Lang('Submit')}</span>
            </button>
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>