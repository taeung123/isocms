<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&type={$oneItem.type}">{$core->get_Lang('reviews')} {$oneItem.type}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{if $pvalTable}{$core->get_Lang('Edit Reviews')}{else}{$core->get_Lang('Add New Reviews')}{/if}</h2>
		</div>
    </div>
	<div class="container-fluid">
		<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
			<div id="clienttabs">
				<ul>
					<li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div id="tab_content">
				<div class="tabbox" style="display:block">
					<div class="wrap">
						<div class="fl span75 full_width_767">
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('Name')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
									<input class="text full required" name="iso-fullname" value="{$clsClassTable->getFullname($pvalTable)}" maxlength="255" type="text" disabled="disabled">
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('email')}</div>
								<div class="fieldarea">
									<input class="text full email" name="iso-email" value="{$clsClassTable->getEmail($pvalTable)}" maxlength="255" type="text" disabled="disabled">
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('Type')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
									<input class="text full email" name="iso-type" value="{$clsClassTable->getOneField('type',$pvalTable)}" maxlength="255" type="text" disabled="disabled">
								</div>
							</div>
							{if $clsClassTable->getOneField('profile_id',$pvalTable) gt 0}
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('international')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
{*									<input class="text full country" name="iso-country" value="{$clsProfile->getCountry($clsClassTable->getOneField('profile_id',$pvalTable))}" maxlength="255" type="text" disabled="disabled">*}

									<input class="text full country" name="iso-country" value="{$clsClassTable->getCountry($pvalTable)}" maxlength="255" type="text" disabled="disabled">
								</div>
							</div>
							{else}
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('international')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
									<input class="text full country" name="iso-country" value="{$clsClassTable->getCountry($pvalTable)}" maxlength="255" type="text" disabled="disabled">
								</div>
							</div>
							{/if}

							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('Name service')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
									<input class="text full"  value="{$clsClassTable->getNameService($pvalTable)}" maxlength="255" type="text" disabled="disabled">
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('Link service')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
									<input class="text full"  value="{$clsClassTable->getLinkService($pvalTable)}" maxlength="255" type="text" disabled="disabled">
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('Select rate')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
									<select name="iso-rates" class="glSlBox required" style="width:120px">
										{$clsISO->makeSelectNumber2(6,$oneItem.rates,'star,stars')}
									</select>
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('Review date')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
									<input value="{$clsISO->formatDate($oneItem.review_date,'-')}" class="ext full required showdate" name="review_date" type="text" autocomplete="off" style="width:120px"/>
									<img src="{$URL_IMAGES}/date-icon.gif" style="position:relative;top:6px;z-index:1;left:-25px;"/>
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('status')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
								<div class="checkbox-switch switch_public">
									{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
									<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
									{else}
									<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
									{/if}
									<div class="checkbox-animate">
										<span class="checkbox-off">PRIVATE</span>
										<span class="checkbox-on">PUBLIC</span>
									</div>
								</div>	
								<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
								<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
							</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel ">{$core->get_Lang('content')} <span class="requiredMask">*</span></div>
								<div class="fieldarea">
                                    <textarea rows="25" cols="25" class="content" name="content" style="width:100%;height:125px">{$clsISO->parseBr2nl($oneItem.content)}</textarea>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"><br /></div>
			<fieldset class="submit-buttons">
				{$saveBtn}{$saveList}
				<input value="Update" name="submit" type="hidden">
			</fieldset>
		</form>
	</div>
</div>
<script type="text/javascript">
	var $reviews_id = '{$pvalTable}';
</script>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js"></script>
<link rel="stylesheet" href="{$URL_JS}/datepicker/jquery-ui.css?v={$upd_version}" type="text/css" media="all">
{literal}
<script>
$(".showdate").datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true});
</script>
<style>
#ui-datepicker-div{z-index:999 !important;}
</style>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/reviews/jquery.reviews.js?v={$upd_version}"></script>