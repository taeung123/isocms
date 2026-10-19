<div class="page_container page-tour_setting">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">	
		{$core->getBlock('menu_cruise_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('Child Policies')}</h2>
					<p>{$core->get_Lang('systemmanagementsettingchildpolicy')}</p>
				</div>
			</div>
			<div class="wrap mt10 mb20">
				<div id="tab_content"> 
					<form method="post" action="" enctype="multipart/form-data">
						<table class="full-width tbl-grid" cellspacing="0">
							<tr>
								<td class="gridheader" colspan="2" style="width:500px;text-align:center; "><strong>{$core->get_Lang('Child Age')}</strong></td>
								<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Cruise Fares')}</strong></td>
							</tr>
							<tbody id="childPolicy"> 
								<tr class="row1">
									<td style="width:250px"><input class="text_32 border_aaa bold" type="text" name="iso-InfantTitlePolicy" value="{$clsConfiguration->getValue('InfantTitlePolicy')}"></td>
									<td style="width:250px;">
									<div class="line mb10">
									<label class="width100">{$core->get_Lang('Min Age')}</label> 
									<select class="form-control" name="iso-InfantMinAgePolicy" style="width:65px">
										{$clsISO->getSelect(0,6,$clsConfiguration->getValue('InfantMinAgePolicy'))}
									</select>

									</div>
									<div class="line">
									<label class="width100">{$core->get_Lang('Max Age')}</label> 
									<select class="form-control" name="iso-InfantMaxAgePolicy" style="width:65px">
										{$clsISO->getSelect(0,6,$clsConfiguration->getValue('InfantMaxAgePolicy'))}
									</select>
									</div>
									</td>
									<td><input class="text_32 border_aaa bold" type="number" name="iso-InfantFaresPolicy" value="{$clsConfiguration->getValue('InfantFaresPolicy')}" style="width:70px" min="0" max="100"> {$core->get_Lang('% Adult fares')}</td>
								</tr>
								<tr class="row2">
									<td>
									<input class="text_32 border_aaa bold" type="text" name="iso-ChildTitlePolicy" value="{$clsConfiguration->getValue('ChildTitlePolicy')}"></td>
									<td>
									<div class="line mb10">
									<label class="width100">{$core->get_Lang('Min Age')}</label> 
									<select class="form-control" name="iso-ChildMinAgePolicy" style="width:65px">
										{$clsISO->getSelect(0,12,$clsConfiguration->getValue('ChildMinAgePolicy'))}
									</select>
									</div>
									<div class="line">
									<label class="width100">{$core->get_Lang('Max Age')}</label> 
									<select class="form-control" name="iso-ChildMaxAgePolicy" style="width:65px">
										{$clsISO->getSelect(0,12,$clsConfiguration->getValue('ChildMaxAgePolicy'))}
									</select>
									</div>
									</td>
									<td><input class="text_32 border_aaa bold" type="number" name="iso-ChildFaresPolicy" value="{$clsConfiguration->getValue('ChildFaresPolicy')}" min="0" max="100" style="width:70px"> {$core->get_Lang('% Adult fares')}</td>
								</tr>
								<tr class="row1">
									<td colspan="2">
									<input class="text_32 border_aaa bold" type="text" name="iso-AdultTitlePolicy" value="{$clsConfiguration->getValue('AdultTitlePolicy')}"></td>
									<td><input class="text_32 border_aaa bold" type="number"  value="100" style="width:70px" disabled="disabled"> {$core->get_Lang('% Adult fares')}</td>
								</tr>
							</tbody>
						</table>
						<fieldset class="submit-buttons">
							{$saveBtn}
							<input value="UpdateConfiguration" name="submit" type="hidden">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker();
	});
</script>
<style type="text/css">
#childPolicy label.width100{display:inline-block; width:100px; }
</style>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/cruise/jquery.cruise.js"></script>