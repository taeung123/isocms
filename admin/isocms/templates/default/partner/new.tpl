<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$mod|capitalize}</a>
    <a>&raquo;</a>
	 <a href="{$curl}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Partner')} &raquo; <span class="color_r">{$core->get_Lang('Edit')}</span></h2>
       <p>{$core->get_Lang('Partner Management')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form span70">
		<div class="wrap">
			<div class="row-span">
				<div class="fieldlabel span15">{$core->get_Lang('Title')}</div>
				<div class="fieldarea span85">
					<input class="text fontLarge full required" name="iso-title" value="" maxlength="255" type="text">
					<span class="notice-full" >  {$core->get_Lang('Each partner is the only one and can not be duplicated')}</span>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel span15"> {$core->get_Lang('Image')}</div>
				<div class="fieldarea span85">
					<img class="isoman_img_pop" id="isoman_show_image" src="{$clsClassTable->getOneField('image',$pvalTable)}" />
					<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$clsClassTable->getOneField('image',$pvalTable)}">
					<input style="width:70% !important; float:left; margin-left:4px; height:21px" type="text" id="isoman_url_image" name="image" value="{$clsClassTable->getOneField('image',$pvalTable)}" ><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="{$clsClassTable->getOneField('image',$pvalTable)}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel span15"> {$core->get_Lang('Status')}</div>
				<div class="fieldarea span85">
					<div class="vietiso_status_button"></div>
					<span class="notice-short" style="display:none" id="prv_status">PRIVATE: {$core->get_Lang("Partner only be seen via the link in the admin page!")}.</span>
					<span class="notice-short" id="pub_status">PUBLIC:{$core->get_Lang('Partner  are available online at the list normality!')}</span>
				</div>
				<script type="text/javascript">
					var is_online = 0;
				</script>
				{literal}
				<script type="text/javascript">
					$(document).ready(function(){
						$('.vietiso_status_button').isoswitchvalue({
							_value:is_online,
							_selector:'iso-is_online'
						});
					});
				</script>
				{/literal}       
			</div>
			<div class="row-span">
				<div class="fieldlabel span15">{$core->get_Lang("Path Url")}</div>
				<div class="fieldarea span85">
					<input placeholder="http://" class="text full required" name="iso-url" value="" maxlength="255" type="text">
				</div>
			</div>
			<div class="clearfix"><br /></div>
			 <fieldset class="submit-buttons">
				{$saveBtn}
				<input value="Insert" name="submit" type="hidden">
			</fieldset>
		</div>
    </form>
</div>