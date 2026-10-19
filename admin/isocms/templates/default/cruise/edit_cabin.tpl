<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('cruise')}</a>
	<a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&cruise_id={$core->encryptID($cruise_id)}#isotab1">{$core->get_Lang('Cruise cabin')}</a>
    <a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back-->
    <!--<a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&cruise_id={$core->encryptID($cruise_id)}#isotab1" class="back fr">{$core->get_Lang('back')}</a>-->
    <a href="{$PCMS_URL}/cruise/insert/{$cruise_id}/cabin/cabin" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{if $pvalTable gt '0'}{$core->get_Lang('Edit Cruise Cabin')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add Cruise Cabin')}{/if}</h2>
    	<p>{$core->get_Lang('systemmanagementcruiseitinerary')}</p>
    </div>
	<a href="{$PCMS_URL}/cruise/insert/{$cruise_id}/cabin/cabin" class="back fr">{$core->get_Lang('Back to cabin list')}</a>
	<div class="clearfix mt30"></div>
	<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<div id="clienttabs">
			<ul>
				<li><a href="javascript:void();"><i class="iso-bassic"></i> {$core->get_Lang('Information')}</a></li>
			</ul>
		</div>
    	<div id="tab_content">
        	<div class="tabbox">
				<div class="wrap mt10">
                	<div class="fl col_Left full_width_767">
						<div class="photobox image">
							{if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}">
							<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
							{if $oneItem.image}
								<a pvalTable="{$pvalTable}" clsTable="CruiseCabin" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
							{/if}
							{else}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
							<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
							{/if}
						</div>
                    </div>
					<div class="fr col_Right full_width_767">
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Title')}</strong> <span class="color_r">* </span></div>
							<div class="fieldarea">
                        		<input class="text_32 full-width bold border_aaa required title_capitalize" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
							</div>
                        </div>
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Group size')}</strong> <span class="color_r">* </span></div>
							<div class="fieldarea">
								<div class="border_aaa inline-block full-width" style="line-height:30px">
									{section name=i loop=$lstGroupSize}
									<label class="col-lg-4 inline mb0" style="font-size:0.9em;display:inline-block"><input type="checkbox" {if $clsISO->checkContainer($oneItem.list_group_size,$lstGroupSize[i].cruise_property_id)}checked="checked" {else}{/if} name="listGroupSize[]" value="{$lstGroupSize[i].cruise_property_id}" style="margin:0"> {$clsCruiseProperty->getTitle($lstGroupSize[i].cruise_property_id)}</label>
									{/section}
								</div>
							</div>
                        </div>
						
						{*<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Max Children')}</strong></div>
							<div class="fieldarea">
								<select class="slb mr10" name="iso-max_child" style="width:120px;">
									{$clsISO->makeSelectNumber(4,$oneItem.max_child)}
								</select>
							</div>
						</div>*}
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Cabin size')}</strong> <span class="color_r">* </span></div>
							<div class="fieldarea">
                        		<input class="text_32 border_aaa required" name="iso-cabin_size" value="{$clsClassTable->getCabinSize($pvalTable)}" maxlength="255" type="text" style="width:120px" />(m<sup>2</sup>)
							</div>
                        </div>
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Bed size')}</strong> <span class="color_r">* </span></div>
							<div class="fieldarea">
                        		<input class="text_32 border_aaa full-width required" name="iso-bed_size" value="{$clsClassTable->getBedOption($pvalTable)}" maxlength="255" type="text"/>
							</div>
                        </div>
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Ex.Bed')}</strong> <span class="color_r">* </span></div>
							<div class="fieldarea">
								<select class="glSlBox" name="iso-extra_bed" style="width:120px"> 
									<option value="0" {if $clsClassTable->getOneField('extra_bed',$cruise_cabin_id)==0}selected=selected{/if}>{$core->get_Lang('No')}</option> 
									<option value="1" {if $clsClassTable->getOneField('extra_bed',$pvalTable)==1}selected=selected{/if}>{$core->get_Lang('Yes')}</option> 
								</select>
							</div>
                        </div>
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Floor')}</strong> <span class="color_r">* </span></div>
							<div class="fieldarea">
								<input class="text_32 border_aaa required" name="iso-floor" value="{$clsClassTable->getFloor($pvalTable)}" min="1" max="10" type="number"  style="width:120px"/>
							</div>
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <div class="vietiso_status_button"></div>
                                <script type="text/javascript">var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';</script>
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
                                <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
                                <span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
                            </div>
                        </div>
					</div>
				</div>
				<div class="clearfix mt20"></div>
				{if $clsISO->getBrowser() eq 'computer'}
                <div id="v-nav">
					<ul>
						<li class="first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Short text')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Easy Cancel')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Cabin Facilities')}</strong></a> <span class="color_r">*</span></li>  
						
						
					</ul>
					<div class="tab-content" style="display: block;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('intro')}</div>
						</div>
					</div>
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('easy_cancel')}</div>
						</div>
					</div>
					 <div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">
								<div class="listCabinFacilities">
									{section name=i loop=$listCabinFacilities}
									<label class="w25 inline-block mb5" style="font-size:0.9em;display:inline-block"><input type="checkbox" {if $clsISO->checkContainer($oneItem.list_cabin_facilities,$listCabinFacilities[i].cruise_property_id)}checked="checked"{/if} name="listCabinFacilities[]" value="{$listCabinFacilities[i].cruise_property_id}"> &nbsp;{$clsCruiseProperty->getTitle($listCabinFacilities[i].cruise_property_id)}</label>
									{/section}
								</div>
							</div>
						</div>
					</div>
				</div>
				{else}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Short text')}</strong> <span class="color_r">* </span></div>
					<div class="fieldarea">
						{$clsForm->showInput('intro')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Easy Cancel')}</strong> <span class="color_r">* </span></div>
					<div class="fieldarea">
						{$clsForm->showInput('easy_cancel')}
					</div>
				</div>
				{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','property','default','CabinFacilities')}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Cabin Facilities')}</strong> <span class="color_r">* </span></div>
					<div class="fieldarea">
						<div class="listCabinFacilities">
							{section name=i loop=$listCabinFacilities}
							<label class="w25 inline-block mb5" style="font-size:0.9em;display:inline-block"><input type="checkbox" {if $clsISO->checkContainer($oneItem.list_cabin_facilities,$listCabinFacilities[i].cruise_property_id)}checked="checked"{/if} name="listCabinFacilities[]" value="{$listCabinFacilities[i].cruise_property_id}"> &nbsp;{$clsCruiseProperty->getTitle($listCabinFacilities[i].cruise_property_id)}</label>
							{/section}
						</div>
						<div> <i class="fa fa-cog"></i> <a title="{$core->get_Lang('Cabin Facilities Manage')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=property&type=CabinFacilities"> <span class="text">{$core->get_Lang('Cabin Facilities Manage')}</span> </a> </div>
					</div>
				</div>
				{/if}
				{/if}
            </div>
            </div>
            <div class="clearfix"><br /></div>
		<fieldset class="submit-buttons">
			 {$saveBtn}{$saveList}
			<input value="Update" name="submit" type="hidden">
		</fieldset>
	</form>
</div>	
<script type="text/javascript">
	var $cruise_id = '{$cruise_id}';
	var $cruise_itinerary_id='{$pvalTable}';
	var $cruise_cabin_id='{$listCabin[0].cruise_cabin_id}';
</script>
{literal}
<style type="text/css">
.fc-row .fc-highlight-skeleton {
    z-index:0 !important;
}
.listCabinFacilities .w25{width:25%; float:left}
</style>
<script type="text/javascript">
	var st_timezone = {"timezone_string":""};
	var st_params = {"locale":"en","text_refresh":"Refresh"};
	
	$(document).on('change', 'select[name=iso-number_day]', function(ev){
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod=cruise&act=loadPriceDayItinerary",
		data:{
			'cruise_id':$cruise_id,
			"number_day":$_this.val(),
		},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			var htm = html.split('|||');
			$('input[name=trip_price]').val(htm[1]);
		}
	}); 
});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/cruise/jquery.cruise.js?v={$upd_version}"></script>  
<link rel="stylesheet" type="text/css" href="{$URL_JS}/fullcalendar/fullcalendar.min.css" />
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment-timezone-with-data-2010-2020.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/date.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/customcruise.js"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>