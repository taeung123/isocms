<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('gallery')}</a>
	<a>&raquo;</a>
    <a>{$core->get_Lang('Add New')}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
	<div class="page-title">
		<h2>{$core->get_Lang('gallery')}</h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
	</div>
	<div class="clearfix"></div>
	<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<fieldset>
			<legend>{$core->get_Lang('title')}: <font color="red">*</font></legend>
			<input class="text full required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" >
		</fieldset>
        {if 1==2}
		<fieldset>
			<legend>{$core->get_Lang('image')}:</legend>
			<table>
				<tr>
					<td width="160px">
						<img src="{$oneItem.image}" width="150px" height="100px" style="display:block; border:1px solid #ccc;"  />
					</td>
					<td valign="top" align="left">
						{$core->get_Lang('uploadfromcomputer')}<br />
						<input type="file" name="image" />
						{$core->get_Lang('systemiamgeformat')} .jpg,.png, hoặc .gif
						<br />
						{$core->get_Lang('oruseimagefromurl')}<br />
						<input type="text" name="image_url" class="full text">
					</td>
				</tr>
			</table>
		</fieldset>
        {/if}
		<fieldset class="submit-buttons">
			{$saveBtn} {$resetBtn}
			<input value="Insert" name="submit" type="hidden">
		</fieldset>
	</form>
</div>


