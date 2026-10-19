<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Administrators Role')}">{$core->get_Lang('Administrators Role')}</a>
    <a href="javascript:history.back();" class="back fr" style="width:50px;">{$core->get_Lang('Back')}</a>
</div>
<div class="page-tour_setting">
	<div class="container-fluid">
		<div class="content_setting_box">
			<div class="page_detail-title">
				<h2>{if $pvalTable gt 0}{$core->get_Lang('Edit Administrators Role Details')}{else}{$core->get_Lang('Add New Administrators Role')}{/if}</h2>
			</div>
			<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
				<fieldset>
					<dl>
						<dt><label for="{$name|default:''}">{$core->get_Lang('Name')}:</label></dt>
						<dd><input class="text medium required" id="name" name="name" value="{$oneItem.name|default:''}" maxlength="255" type="text" style="font-size:14px !important;"></dd>
					</dl>     
					<dl>
						<dt><label for="intro">{$core->get_Lang('Permissions')}</label></dt>
						<dd>

							<table width="100%" style="border:none;">
								<tr>
									<td valign="top" width="50%">
										<table cellspacing="1" cellpadding="2" class="tbl-grid" width="100%">
											{section name=i loop=$listModule}
											{if $core->checkAccess($listModule[i].name)}
											{if $smarty.section.i.index%2 eq 0}
											<tr>
												<td style="font-size:12px;">
													<label style="font-size:12px"><input type="checkbox" value="{$listModule[i].name}" name="listModule[]" {if $core->checkPermission($pvalTable,$listModule[i].name)}checked="checked"{/if} {if $pvalTable eq 1}disabled="disabled"{/if} />
													{$listModule[i].intro}</label>
												</td>
											</tr>
											{/if}
											{/if}
											{/section}
										</table>
									</td>
									<td valign="top" width="50%">
										<table cellspacing="1" cellpadding="2" class="tbl-grid" width="100%">
											{section name=i loop=$listModule}
											{if $core->checkAccess($listModule[i].name)}
											{if $smarty.section.i.index%2 eq 1}
											<tr>
												<td style="font-size:12px;">
													<label><input type="checkbox" value="{$listModule[i].name}" name="listModule[]" {if $core->checkPermission($pvalTable,$listModule[i].name)}checked="checked"{/if} {if $pvalTable eq 1}disabled="disabled"{/if} />
													{$listModule[i].intro}</label>
												</td>
											</tr>
											{/if}
											{/if}
											{/section}
										</table>
									</td>
								</tr>
							</table>
							<div align="right"><a href="#" onclick="zCheckAll('edititem');return false">Check All</a> {if $pvalTable ne 1}| <a href="#" onclick="zUncheckAll('edititem');return false">Uncheck All</a>{/if}</div>
						</dd>
					</dl>                
				</fieldset>
				<br class="clearfix" />
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="Update" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
	</div>
</div>