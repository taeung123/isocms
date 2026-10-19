<link rel="stylesheet" type="text/css" media="screen" href="{$URL_JS}/datepicker/bootstrap-combined.min.css?v={$upd_version}">
<link rel="stylesheet" type="text/css" media="screen" href="{$URL_JS}/datepicker/bootstrap-datetimepicker.min.css?v={$upd_version}">
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('tours')}">{$core->get_Lang('tours')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$core->get_Lang('edit')}">{$core->get_Lang('edit')} #{$pvalTable}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2 style="font-size:19px;">{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}<strong style="color:#F00; font-size:12px;" title="{$core->get_Lang('Tour is in Private Mode')}!">[P]</strong>{/if}</h2>
        <div class="permalinkbox mb20">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</strong></a>
            </div>
        </div> 
		<p>{$core->get_Lang('Chức năng bao gồm các dữ liệu quản lý cho 01 tour ở mức cơ sở')}</p>
		<p>{$core->get_Lang('This function is intended to manage Tour programe in data system')}</p>
    </div>
    <div class="clearfix"><br /></div>
    {if $msg eq 'DupTripCode'}
    <div style="padding:15px; padding-top:0;">
        <div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
            <strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('identicaltripcode')}
        </div>
    </div>
    <div class="clearfix"></div>
    {/if} {if $clsClassTable->getErrorMsg($pvalTable) ne ''}
    <br/>
    <div style="padding:15px; padding-top:0;display:none">
        <div style="padding:10px; border:3px dashed red; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" /> {$core->get_Lang('Warning')}: {$clsClassTable->getErrorMsg($pvalTable)}
        </div>
    </div>
    <div class="clearfix"></div>
    {/if}
    <div class="clearfix"></div>
    <div id="clienttabs" class="tour_tabs">
        <ul>
            <li><a href="javascript:void(0);"><i class="iso-bassic"></i> {$core->get_Lang('basic')}</a></li>
			{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'itinerary','customize')}
            <li package_id="{$package_id}"><a href="javascript:void(0);"><i class="fa fa-car" aria-hidden="true"></i> {$core->get_Lang('itinerary')}</a></li>
			{/if}
			{if $clsISO->getBrowser() ne 'computer'}
				<div class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">
					  # {$core->get_Lang('Other tab')} <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'destination','customize')}
					<li class="maps"><a href="javascript:void(0);"><i class="fa fa-map-marker"></i> {$core->get_Lang('destinations')}</a></li>
					{/if} 
					<li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Configuration')}</a></li>
						
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'store','default','REVQQVJUVVJFLVZpZXRJU08=')}
					{if $clsTourStore->checkExist($pvalTable,'DEPARTURE')}
					<li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Departure date')}</a></li>
					{else}
					<li><a href="javascript:void(0);" id="price_table_tab"><i class="fa fa-money"></i> {$core->get_Lang('pricetables')}</a></li>
					{/if}
					{else}
					<li><a href="javascript:void(0);" id="price_table_tab"><i class="fa fa-money"></i> {$core->get_Lang('pricetables')}</a></li>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','tour')}
					<li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Promotion')}</a></li>
					{/if}
					<li><a href="javascript:void(0);"><i class="iso-price"></i> {$core->get_Lang('Seo Tool')}</a></li>
					</ul>
				 </div>
			 {else}
				{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'destination','customize')}
				<li class="maps"><a href="javascript:void(0);"><i class="fa fa-map-marker"></i> {$core->get_Lang('destinations')}</a></li>
				{/if} 
				<li class=""><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Configuration')}</a></li>
			
			
				{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'store','default','REVQQVJUVVJFLVZpZXRJU08=')}
				{if $clsTourStore->checkExist($pvalTable,DEPARTURE)}
				<li class=""><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Departure date')}</a></li>
				{else}
				<li class=""><a href="javascript:void(0);" id="price_table_tab"><i class="fa fa-money"></i> {$core->get_Lang('pricetables')}</a></li>
				{/if}
				{else}
				<li class=""><a href="javascript:void(0);" id="price_table_tab"><i class="fa fa-money"></i> {$core->get_Lang('pricetables')}</a></li>
				{/if}
				{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','tour')}
				<li class=""><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Promotion')}</a></li>
				{/if}
				<li class=""><a href="javascript:void(0);"><i class="iso-price"></i> {$core->get_Lang('Seo Tool')}</a></li>
        	{/if}
		</ul>
    </div>
    <div id="tab_content" style="width:100%; float: left">
        <div class="tabbox">
            <form id="frmEditTour" method="post" action="" enctype="multipart/form-data" class="validate-form">
                <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
              
                <div class="wrap">
					<div class="fl full_width_767">
						<div class="photobox image mb10">
							{if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
							<a href="javascript:void(0)" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a> 
							{if $oneItem.image}
							<a pvalTable="{$pvalTable}" clsTable="Tour" href="javascript:void(0)" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> 
							{/if} 
							{else}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
							<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
							<a href="javascript:void(0)" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour"><i class="iso-edit"></i></a>
							<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" /> 
							{/if}
						</div>
						<h3 class="small text-center max_width_210">{$core->get_Lang('Image Size')} (WxH=720x480)</h3>
					</div>
                    <div class="fr full_width_767 col-right">
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Name')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold required" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
                        <!-- Enable TOUR_GROUP -->
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'group','default') && $_LANG_ID eq 'vn'}
                        <div class="row-span">
                            <div class="fieldlabel bold"><strong>{$core->get_Lang('tourgroup')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <select name="iso-tour_group_id" class="slbHighlight required slb full" id="slb_TourGroup" tp="multiple" style="width:260px;">
                                    {$clsTourGroup->makeSelectboxOption($tour_group_id)}
                                </select>
                            </div>
                        </div>
                        {/if}
                        <!-- Enable TOUR_CATEGORY -->
                        {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Travel style')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <div id="slb_ContainerTourCategory" class="relative">
                                    <select name="cat_id[]" id="cat_id" class="text_32 full-width border_aaa select2 required" multiple style="width:100%">
										{assign var = selected value = $oneItem.list_cat_id}
										{if $_LANG_ID eq 'vn'}
										{$clsTourCategory->makeSelectboxOption($oneItem.tour_group_id, $selected, 1)}
										{else}
										{$clsTourCategory->makeSelectboxOption(0, $selected, 1)}
										{/if}
										{$selected}
									</select>
									<input type="hidden" name="multi_cat" id="multi_cat" value="{$list_cat_selected_id}" />
                                </div>
                            </div>
                        </div>
						{literal}
						<script>
						$(document).ready(function() {
							displayed_items = $('#multi_cat').val().split(',');
							function selectItem(target, id) {
							  var option = $(target).children('[value='+id+']');
							  option.detach();
							  $(target).append(option).change();
							} 
							function customPreSelect() {
							  let items = $('#multi_cat').val().split(',');
							  $("#cat_id").val('').change();
							  initSelect(items);
							}
							function initSelect(items) {
							  items.forEach(item => {
								let value = $('#cat_id option[value='+item+']').text();
								$('#cat_id option[value='+item+']').remove();
							    if(value != ''){
								 	$('#cat_id').append(new Option(value, item, true, true));
							    }
							  });
							}
							$('#cat_id').on('select2:select', function(e){
							  selectItem(e.target, e.params.data.id);
							});
							initSelect(displayed_items);
						});
						</script>
						{/literal}
                        {/if}
                        <!-- Enable TOUR_DEPARTTURE_POINT -->

                        {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'tour_departure_point','customize')}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('departurepoint')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
								<div id="slb_ContainerDepartPoint" class="relative">
                                    <select name="departure_point_id[]" id="departure_point_id" class="text_32 full-width border_aaa select2" multiple style="width:100%">
										{assign var = selected value = $oneItem.list_departure_point_id}
										{$clsCity->getSelectMultiDeparturePoint($tour_group_id,$selected)}
										{$selected}
									</select>
                                </div>
                                <em style="margin-top:5px; font-size:10px">{$core->get_Lang('ex')}: Ha Noi, Ho Chi Minh City, Da Nang</em>
                            </div>
							<input type="hidden" name="multi_departure_point" id="multi_departure_point" value="{$list_departure_point_selected_id}"/>
                        </div>
						{literal}
						<script>
						$(document).ready(function() {
							displayed_items = $('#multi_departure_point').val().split(',');
							function selectItem(target, id) {
							  var option = $(target).children('[value='+id+']');
							  option.detach();
							  $(target).append(option).change();
							} 
							function customPreSelect() {
							  let items = $('#multi_departure_point').val().split(',');
							  $("#departure_point_id").val('').change();
							  initSelect(items);
							}
							function initSelect(items) {
							  items.forEach(item => {
								let value = $('#departure_point_id option[value='+item+']').text();
								$('#departure_point_id option[value='+item+']').remove();
							    if(value != ''){
									$('#departure_point_id').append(new Option(value, item, true, true));
							    }
							  });
							}
							$('#departure_point_id').on('select2:select', function(e){
							  selectItem(e.target, e.params.data.id);
							});
							initSelect(displayed_items);
						});
						</script>
						{/literal}
                        {/if}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Duration')}(s) <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <label style="width:120px;display: inline-block;"><input class="margin_0" type="radio" name="iso-duration_type" value="0" {if $oneItem.duration_type ne '1'}checked="checked"{/if}/> {$core->get_Lang('Number Days')}:</label>
                                <select class="text_32 border_aaa w80" name="number_day" id="select_number_days" {if $oneItem.duration_type eq '1'}disabled="disabled" {/if}>
                                    {$clsISO->makeSelectNumber2(32,$oneItem.number_day)}
                                </select>
                                <label>/ {$core->get_Lang('Number Nights')}:</label>
                                <select class="text_32 border_aaa w80" name="number_night" id="select_number_nights" {if $oneItem.duration_type eq '1'}disabled="disabled" {/if}>
                                    {$clsISO->makeSelectNumber(32,$oneItem.number_night)}
                                </select>
                                <br/>
                                <div class="cleafix" style="margin-top:10px"></div>
                                <label style="width:120px;display: inline-block;"><input class="margin_0" type="radio" name="iso-duration_type" {if $oneItem.duration_type eq '1'}checked="checked"{/if} value="1" /> {$core->get_Lang('Option')}:</label>
                                <input type="text" class="text_32 border_aaa" {if $oneItem.duration_type ne '1'}disabled="disabled" {/if} name="iso-duration_custom" value="{$clsClassTable->getOneField('duration_custom',$pvalTable)}" style="width:233px" /> {literal}
                                <script type="text/javascript">
                                    $("input[name='iso-duration_type']").live("click", function() {
                                        if ($("input[name='iso-duration_type']:checked").val() == 1) {
                                            $("select[name='number_day']").attr("disabled", "disabled");
                                            $("select[name='number_day']").val('1');
                                            $("select[name='number_night']").attr("disabled", "disabled");
                                            $("select[name='number_night']").val('0');
                                            $("input[name='iso-duration_custom']").removeAttr("disabled");
                                        } else {
                                            $("input[name='iso-duration_custom']").attr("disabled", "disabled");
                                            $("input[name='iso-duration_custom']").val('');
                                            $("select[name='number_day']").removeAttr("disabled");
                                            $("select[name='number_night']").removeAttr("disabled");
                                        }
                                    });
                                </script>
                                {/literal}
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Trip code')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
								<input class="text_32 border_aaa w120 fontLarge" id="trip_code" name="iso-trip_code" value="{$clsClassTable->getTripCode($pvalTable)}" maxlength="255" type="text">
								<div class="trip_code_email error_text" id="trip_code_email" style="display: none"></div>
							</div>
                        </div>
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'tour_program_file','customize')}
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Program File')}</strong></div>
                            <div class="fieldarea">
                            	<img class="isoman_img_pop" id="isoman_show_file_programmes" src="{$URL_IMAGES}/icon_pdf.png" width="30px" height="30px" />
								<input type="hidden" id="isoman_hidden_file_programme" name="isoman_url_file_programme"  value="{$oneItem.file_programme}">
								<input class="text_32 border_aaa bold" type="text" id="isoman_url_file_programme" name="iso-file_programme" value="{$oneItem.file_programme}" style="width:100%; max-width:300px; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="file_programme" isoman_val="{$oneItem.file_programme}" isoman_name="file_programme"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open" /></a>
                                <em style="padding-left:10px; padding-top:3px; display:inline-block">File chương trình tour</em>
                            </div>
                        </div>
						{/if}
                        {if $core->checkAccess('TOUR-PUBLIC') eq 0}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong></div>
                            <div class="fieldarea">
							<div class="checkbox-switch">
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
                        {else}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Status')}</strong></div>
                            <div class="fieldarea">
                                <div class="vietiso_status_button off" style="cursor:auto;"><span class="on" style="cursor:auto;">PUBLIC</span><span class="off" style="cursor:auto;">PRIVATE</span></div>
                                <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}> {$core->get_Lang('Tours only be seen via the link in the admin page')}.<a class="btn btn-primary fileinput-button" href="{$DOMAIN_NAME}/index.php?mod=tour&act=detail&tour_id={$pvalTable}&preview=1" target="_blank">{$core->get_Lang('View')} <img src="{$URL_IMAGES}/go-16.png" align="absmiddle"></a></span>
                            </div>
                        </div>
                        {/if} 
						{if $core->checkAccess('TOUR-BOOKABLE') eq 1}
                        <div class="row-span">
                            <div class="fieldlabel">{$core->get_Lang('alloweddeparture')}?</div>
                            <div class="fieldarea">
                                <select name="iso-book_other_date" style="font-weight:bold; width:160px; padding:4px;">
                                   <option value="0">{$core->get_Lang('notallowed')}</option>
                                   <option value="1" {if $clsClassTable->getOneField("book_other_date",$pvalTable) eq 1}selected="selected"{/if}>{$core->get_Lang('allowed')}</option>
                                </select>
                                <em>{$core->get_Lang('Allow: Users can book a tour outside of the intended date of departure')}</em>
                            </div>
                        </div>
                        {/if}
                    </div>
                </div>
                <div class="clearfix"><br /></div>
				{if $clsISO->getBrowser() eq 'computer'}
                <div id="v-nav">
                    <ul>
                        <li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Overview/highlight')}</strong></a> <span class="color_r">*</span></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Key Information')}</strong></a> <span class="color_r">*</span></li>
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'activities','default')}
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Activities')}</strong></a> <span class="color_r">*</span></li>
						{/if}
					    <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Trip Inclusion')}</strong></a> <span class="color_r">*</span></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Trip Exclusion')}</strong></a> <span class="color_r">*</span></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('What&#39;s to Carry')}</strong></a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Cancellation Policy')}</strong></a> <span class="color_r">*</span></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Refund Policy')}</strong></a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Confirmation Policy')}</strong></a></li>
						{if $listCustomField[0].tour_customfield_id ne ''}
						{section name=i loop=$listCustomField}
						<li class="tabchildcol"><a href="javascript:void(0);">{$listCustomField[i].fieldname}</a>
						<div class="Site_Custom_Field_Tools" style="display:inline-block;margin-bottom:10px; float:right">
							<a title="{$core->get_Lang('edit')}" tour_id="{$pvalTable}" data="{$listCustomField[i].tour_customfield_id}" class="btnedit_customfield" href="javascript:void();"><i class="icon-pencil"></i></a>
							<a title="{$core->get_Lang('delete')}" tour_id="{$pvalTable}" data="{$listCustomField[i].tour_customfield_id}" class="btndelete_customfield" href="javascript:void();"><i class="icon-remove"></i></a>
							{if $smarty.section.i.first}
							{else}
							<a title="{$core->get_Lang('move')}" tour_id="{$pvalTable}" data="{$listCustomField[i].tour_customfield_id}" class="btnmove_customfield" direct="up" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>
							{/if}
							{if $smarty.section.i.last}
							{else}
							<a title="{$core->get_Lang('move')}" tour_id="{$pvalTable}" data="{$listCustomField[i].tour_customfield_id}" class="btnmove_customfield" direct="down" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>
							{/if}
						</div>
						</li>
						{/section}
						{/if}
						{if $clsConfiguration->getValue('SiteHasCustomContentField_Tours') eq '1'}
						<li><a class="iso-button-full ClickCustomField color_r" data-tour_id="{$pvalTable}">
							<i class="fa fa-plus-circle"></i> <strong>{$core->get_Lang('addmoreinformation')}</strong>
						</a>
						</li>
						{/if}
                    </ul>
                    <div class="tab-content" style="display: block;">
                        {$clsForm->ShowInput('overview')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('key_information')}
                    </div>
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'activities','default')}
					<div class="tab-content" style="display: none;">
						<div class="accordion_in acc_active">
							<div class="acc_content">
								<table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0">
									<tr>
										<td class="gridheader"><strong>{$core->get_Lang('ID')}</strong></td>
										<td class="gridheader" style="width:80px"><strong>{$core->get_Lang('Image')}</strong></td>
										<td class="gridheader text-left"><strong>{$core->get_Lang('Name')}</strong></td>
										<td class="gridheader" style="width:70px"><strong>{$core->get_Lang('func')}</strong></td>
									</tr>
									{section name=i loop=$lstActivities}
									<tr class="{cycle values=" row1,row2 "}">
										<td class="index">{$lstActivities[i].activities_id}</td>
										<td class="index">
										{if $clsActivities->getUrlImage($lstActivities[i].activities_id)}
											<img src="{$clsActivities->getImage($lstActivities[i].activities_id,60,40)}" width="60" /> 
										{/if}
										</td>
										<td>{$clsActivities->getTitle($lstActivities[i].activities_id)}</td>
										<td class="text-center"><input type="checkbox" name="list_activities_id[]" {$lstActivities[i].check} value="{$lstActivities[i].activities_id}" {if $clsISO->checkContainer($oneItem.list_activities_id,$lstActivities[i].activities_id)}checked="checked"{/if} /></td>
									</tr>
									{/section}
								</table>
							</div>
						</div>
					</div>
					{/if}
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('inclusion')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('exclusion')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('thing_to_carry')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('cancellation_policy')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('refund_policy')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('confirmation_policy')}
                    </div>
					{if $listCustomField[0].tour_customfield_id ne ''}
					{section name=i loop=$listCustomField}
					<div class="tab-content" style="display: none;">
							<textarea style="width:100%;" cols="255" rows="25" class="Site_Custom_Field_Editor" id="Site_Custom_Field_{$listCustomField[i].tour_customfield_id}_{$now}" name="Site_Custom_Field_value_{$listCustomField[i].tour_customfield_id}" >{$listCustomField[i].fieldvalue}</textarea>
					</div>
					{/section}
					{literal}
					<script type="text/javascript">
						$().ready(function() {
							loadCustomField($tour_id);
						});
					</script>
					{/literal}
					{/if}
                </div>
				{else}
				<div id="v-nav">
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Overview/highlight')}<span class="color_r">*</span></strong></div>
						<div class="fieldarea">
							{$clsForm->ShowInput('overview')}
						</div>
					</div>
                    <div class="row-span">
                        <div class="fieldlabel"><strong>{$core->get_Lang('Key information')}<span class="color_r">*</span></strong></div>
                        <div class="fieldarea">
                            {$clsForm->ShowInput('key_information')}
                        </div>
                    </div>
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'activities','default')}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Activities')}<span class="color_r">*</span></strong></div>
						<div class="fieldarea">
							<div class="accordion_in acc_active">
								<div class="acc_content">
									<table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0">
										<tr>
											<td class="gridheader"><strong>{$core->get_Lang('ID')}</strong></td>
											<td class="gridheader hiden767" style="width:80px"><strong>{$core->get_Lang('Image')}</strong></td>
											<td class="gridheader text-left"><strong>{$core->get_Lang('Name')}</strong></td>
											<td class="gridheader" style="width:70px"><strong>{$core->get_Lang('func')}</strong></td>
										</tr>
										{section name=i loop=$lstActivities}
										<tr class="{cycle values=" row1,row2 "}">
											<td class="index">{$lstActivities[i].activities_id}</td>
											<td class="index hiden767">
											{if $clsActivities->getUrlImage($lstActivities[i].activities_id)}
												<img src="{$clsActivities->getImage($lstActivities[i].activities_id,60,40)}" width="60" /> 
											{/if}
											</td>
											<td><strong style="font-size:15px">{$clsActivities->getTitle($lstActivities[i].activities_id)}</strong></td>
											<td class="text-center"><input type="checkbox" name="list_activities_id[]" {$lstActivities[i].check} value="{$lstActivities[i].activities_id}" {if $clsISO->checkContainer($oneItem.list_activities_id,$lstActivities[i].activities_id)}checked="checked"{/if} /></td>
										</tr>
										{/section}
									</table>
								</div>
							</div>
						</div>
					</div>
					{/if}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Trip Inclusion')}<span class="color_r">*</span></strong></div>
						<div class="fieldarea">
							{$clsForm->ShowInput('inclusion')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Trip Exclusion')}<span class="color_r">*</span></strong></div>
						<div class="fieldarea">
                        {$clsForm->ShowInput('exclusion')}
                    	</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('What&#39;s to Carry')}</strong></div>
						<div class="fieldarea">
                        {$clsForm->ShowInput('thing_to_carry')}
                   		</div>
					</div>
                    <div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Cancellation Policy')}<span class="color_r">*</span></strong></div>
						<div class="fieldarea">
                        {$clsForm->ShowInput('cancellation_policy')}
                    	</div>
					</div>
                    <div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Refund Policy')}</strong></div>
						<div class="fieldarea">
                        {$clsForm->ShowInput('refund_policy')}
                    	</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Confirmation Policy')}</div>
						<div class="fieldarea">
                        {$clsForm->ShowInput('confirmation_policy')}
                   		</div>
					</div>
					{if $listCustomField[0].tour_customfield_id ne ''}
					{section name=i loop=$listCustomField}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$listCustomField[i].fieldname}<span class="color_r">*</span></strong></div>
						<div class="fieldarea">
							<textarea style="width:100%;" cols="255" rows="25" class="Site_Custom_Field_Editor" id="Site_Custom_Field_{$listCustomField[i].tour_customfield_id}_{$now}" name="Site_Custom_Field_value_{$listCustomField[i].tour_customfield_id}" >{$listCustomField[i].fieldvalue}</textarea>
						</div>
					</div>
					{/section}
					{literal}
					<script type="text/javascript">
						$().ready(function() {
							loadCustomField($tour_id);
						});
					</script>
					{/literal}
					{/if}
					{if $clsConfiguration->getValue('SiteHasCustomContentField_Tours') eq '1'}
					<div class="row-span"><a class="iso-button-full ClickCustomField color_r" data-tour_id="{$pvalTable}">
						<i class="fa fa-plus-circle"></i> <strong>{$core->get_Lang('addmoreinformation')}</strong>
					</a>
					</div>
					{/if}
                </div>
				{/if}
                <div class="clearfix"><br /><br /></div>
                <div class="row-bottom">
                    <div class="row-buttons">
                        <div class="clear"></div>
                        <button type="submit" class="btn-update" id="SaveTourStep1" name="submit" value="Update">
                      	<i class="iso-update"></i> {$core->get_Lang('Save')}
                      </button>
                        <input type="hidden" name="UpdateStep1" value="UpdateStep1" />
                        <input type="hidden" name="is_set" value="{$smarty.get.is_set}" />
                    </div>
                </div>
            </form>
        </div>
		{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'itinerary','customize')}
        <div class="tabbox" style="display:none">
            <form method="post" action="">
                <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" /> 
				{literal}
                <script type="text/javascript">
                    $().ready(function() {
                        makeGlobalTab('globaltabs_program');
                    });
                </script>
                {/literal}
                <div class="tab_contentglobal">
                    <div class="tabboxchild_globaltabs_program">
                        <div class="row-span row-has-border">
                            <div class="row-span-help">{$core->get_Lang('introitinerary')}</div>
                            <div class="clearfix"><br /></div>
                            <div class="wrap text-line-button">
                                <p>{$core->get_Lang('infoaddday')} </p>
								{if $clsClassTable->checkTourItinerary($pvalTable)}
								
								{else}
                                <a style="vertical-align:middle" href="javascript:void(0);" id="clickToAddItinerary" class="iso-button-primary fl"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('add')}</a>
								{/if}
                            </div>
                            <div class="hastable" style="margin-bottom:10px">
                                <table class="full-width tbl-grid table_responsive" cellspacing="0">
									<thead>
										<tr>
											{if $clsClassTable->getOneField('duration_type',$pvalTable) eq 0}
											<th class="gridheader" style="width:50px"><strong>{$core->get_Lang('day')}</strong></th>
											{/if}
											<th class="gridheader name_responsive name_responsive2" style="text-align:left"><strong>{$core->get_Lang('Itinerary name')}</strong></th>
											<th class="gridheader hiden_responsive" style="text-align:right"><strong>{$core->get_Lang('Meals')}</strong></th>
											<th class="gridheader hiden_responsive"><strong>{$core->get_Lang('func')}</strong></th>
										</tr>
									</thead>
                                    <tbody id="tblTourItinerary"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'destination','customize')}
        <div class="tabbox" style="display:none;">
			<div class="row">
				<div class="col-md-6">
					<div class="row-span">{$core->get_Lang('infodestinationadmin')}</div>
					<div class="clear"><br /></div>
					<div class="row-span">
						{if $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default') and $core->checkAccess('continent')}
						<select class="slb span20 mr5 mb05 fl" name="chauluc_id" id="slb_Chauluc" style="width:120px !important;">
							{$clsContinent->makeSelectboxOption()}
						</select> 
						{/if} 
						{if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default') and $core->checkAccess('country')} 
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'group','default') && $clsClassTable->getOneField('tour_group_id',$pvalTable) eq '2'}
						<input type="hidden" id="Hid_Country" name="country_id" value="{$country_vn_id}" /> 
						{else}
						<select class="slb mr5 mb05 fl" name="country_id" id="slb_Country" style="width:120px !important;">
						   <option value="0">{$core->get_Lang('selectcountry')}</option>
						 </select> 
						{/if} 
						{/if} 
						{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
						<select class="slb mr5 mb05 fl" id="slb_RegionID" name="region_id" style="width:120px !important;">
							<option value="0">{$core->get_Lang('selectregion')}</option>
						</select> 
						{/if} 
						{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
						<select class="slb mr10 mb05 fl" id="slb_CityID" name="city_id" style="width:120px !important;">
							<option value="0">{$core->get_Lang('selectcity')}</option>
						</select> 
						{/if}
						<select class="slb mr10 mb05 fl" id="slb_placetogoID" name="placetogo_id" style="width:120px !important;">
							<option value="0">{$core->get_Lang('selectplacetogo')}</option>
						</select>
						<button class="fl btn-add ajQuickAddDestination" type="button">{$core->get_Lang('adddestination')}</button>
					</div>
					<div class="clear"><br /></div>
					<div class="row-span">
						<div style="padding-left:10px">
							<ul class="list-group" id="lstDestination" style="width:500px;"></ul>
							<div class="clearfix mt10"></div>
							{*<span class="notice" style="padding:0;color:#0565c9">(<span class="requiredMask">*</span> ) {$core->get_Lang('infoless1destination')}</span>*}
						</div>
					</div>
					<div class="clearfix"><br /><br /></div>
					<div class="row-bottom">
						<div class="row-buttons">
							<input type="hidden" name="submit" value="Update" />
						</div>
					</div>
					{if $clsTourDestination->checkExist($pvalTable)}
					{literal}
					<script type="text/javascript">
						$().ready(function() {
							loadListDestination(tour_id);
						});
					</script>
					{/literal}
					{/if}
				</div>
				<div class="col-md-6">
				<div class="hidden">
				{$core->getBlock('Lbox_map_tour')}
				 <div class="clearfix"><br /><br /></div>
					 <form method="post" action="">
						<div class="row-bottom">
							<label>{$core->get_Lang('MapZoom')}</label>
							<input type="text" width="255" name="iso-map_zoom" value="{$clsClassTable->getOneField("map_zoom",$pvalTable)}" style="line-height:26px"/>
							<div class="row-buttons" style="width:120px;">
								<div class="clear"></div>
								<button type="submit" class="btn-update" id="SaveTourStep10" name="submit" value="Update" style="margin-top:0;float:right">
								<i class="iso-update"></i> {$core->get_Lang('Save')}
							  	</button>
								<input type="hidden" name="UpdateStep10" value="UpdateStep10" />
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
        </div>
		{/if}
        <div class="tabbox" style="display:none">
            {literal}
            <script type="text/javascript">
                $().ready(function() {
                    makeGlobalTab('globaltabs_config');
                });
            </script>
            {/literal}
            <div class="globaltabs" id="globaltabs_config_ul">
                <ul>
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'tour_related','customize')}
                    <li><a href="javascript:void(0);"><i class="iso-gallery hiden767"></i> {$core->get_Lang('Related Tours')}</a></li>
                    {/if} 
					{if $clsISO->getCheckActiveModulePackage($package_id,'property','service','default')}
					<li><a href="javascript:void(0);"><i class="iso-gallery hiden767"></i> {$core->get_Lang('Add On Services')}</a></li>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'tour_gallery','customize')}
                    <li><a href="javascript:void(0);"><i class="iso-gallery hiden767"></i> {$core->get_Lang('gallery')}</a></li>
                    {/if}
                </ul>
            </div>
            <div class="clearfix"></div>
            <div class="tab_contentglobal">
                {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'tour_related','customize')}
                <div class="tabboxchild_globaltabs_config">
                    <div class="accordion_in acc_active">
                        <div class="acc_head">
                            <div class="acc_icon_expand"></div>
                            <h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('tourextension')}</h2>
                        </div>
                        <div class="acc_content">
                            <div class="row-span-help">{$core->get_Lang('infotourextension')}</div>
                            <div class="infobox">{$core->get_Lang('notetourextension')}</div>
                            <div class="filterbox mt40">
                                <div class="wrap">
                                    <div class="searchbox">
                                        <input id="searchkey" placeholder="{$core->get_Lang('searchtour')}" type="text" class="text" style="width:240px" />
                                        <a class="btn btn-success" href="javascript:void(0);">
                                            <i class="icon-search icon-white"></i> <span></span>
                                        </a>
                                        <div class="autosugget" id="autosugget">
                                            <ul class="HTML_sugget"></ul>
                                            <div class="clearfix"></div>
                                            <a class="close_Div">{$core->get_Lang('close')}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hastable" style="margin-bottom:10px">
                                <table class="tbl-grid table_responsive" cellspacing="0">
									<thead>
										<tr>
											<th class="gridheader" style="width:50px"><strong>{$core->get_Lang('index')}</strong></th>
											<th class="gridheader name_responsive name_responsive2" style="text-align:left"><strong>{$core->get_Lang('nameoftrips')}</strong></th>
											<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('duration')}</strong></th>
											 {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
											<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('travelstyles')}</strong></th>
											{/if}
											{*<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('pricefrom')}</strong></th>*}
											<th class="gridheader hiden_responsive" style="width:2%"><strong>{$core->get_Lang('delete')}</strong></th>
										</tr>
									</thead>
                                    <tbody id="tblTourExtension"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					{if $clsTourExtension->checkExistOne($pvalTable)}
					{literal}
					<script type="text/javascript">
						$().ready(function() {
							loadTourExtension(tour_id);
						});
					</script>
					{/literal}
					{/if}
                </div>
                {/if} 
				{if $clsISO->getCheckActiveModulePackage($package_id,'property','service','default')}
				<div class="tabboxchild_globaltabs_config" style="display:none">
                    <div class="accordion_in acc_active">
                        <div class="acc_head">
                            <div class="acc_icon_expand"></div>
                            <h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('Add On Services')}</h2>
                        </div>
                        <div class="acc_content">
                            <div class="row-span-help">{$core->get_Lang('infotourextension')}</div>
                            <form class="mt30" method="post" action="">
                                <table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="gridheader"><strong>{$core->get_Lang('ID')}</strong></td>
                                        <td class="gridheader hiden767" style="width:80px"><strong>{$core->get_Lang('Image')}</strong></td>
                                        <td class="gridheader text-left"><strong>{$core->get_Lang('nameofservice')}</strong></td>
										<td class="gridheader text-right" style="width:80px"><strong>{$core->get_Lang('Price')}</strong></td>
                                        <td class="gridheader" style="width:60px"><strong>{$core->get_Lang('func')}</strong></td>
                                    </tr>
                                    {section name=i loop=$lstAddOnService}
                                    <tr class="{cycle values=" row1,row2 "}">
                                        <td class="index">{$lstAddOnService[i].addonservice_id}</td>
                                        <td class="index hiden767">
                                        {if $clsAddOnService->getUrlImage($lstAddOnService[i].addonservice_id)}
                                            <img src="{$clsAddOnService->getImage($lstAddOnService[i].addonservice_id,60,40)}" width="60" /> 
										{/if}
                                        </td>
                                        <td><strong>{$clsAddOnService->getTitle($lstAddOnService[i].addonservice_id)}</strong></td>
                                        <td style="text-align:right; white-space:nowrap">
                                            <strong class="format_price">
                                            	{$clsAddOnService->getPrice($lstAddOnService[i].addonservice_id)} {$clsISO->getRate()}
                                            </strong>

                                        </td>
                                        <td class="text-center"><input type="checkbox" name="list_service_id[]" {$lstAddOnService[i].check} value="{$lstAddOnService[i].addonservice_id}" {if $clsISO->checkContainer($oneItem.list_service_id,$lstAddOnService[i].addonservice_id)}checked="checked"{/if} /></td>
                                    </tr>
                                    {/section}
                                </table>
                                <div class="clearfix"><br /><br /></div>
                                <div class="row-bottom">
                                    <div class="row-buttons">
                                        <div class="clear"></div>
                                        <button type="submit" id="SaveTourStep5" class="btn-update" name="button" value="Update">
                                            <i class="iso-update"></i> {$core->get_Lang('Submit')}
                                        </button>
                                        <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
                                        <input type="hidden" name="UpdateStep5" value="UpdateStep5" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
				{/if}
				{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'tour_gallery','customize')}
                <div class="tabboxchild_globaltabs_config" style="display:none">
                    <div id="TourGalleryHolder"></div>
                </div>
				{literal}
				<script type="text/javascript">
					$().ready(function() {
						initSysGalleryTour();
					});
				</script>
				{/literal}
                {/if}
            </div>
        </div>
		{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'store','default','REVQQVJUVVJFLVZpZXRJU08=')}
		{if $clsTourStore->checkExist($pvalTable,'DEPARTURE')}
		{$core->getBlock('box_detail_departure_tour_tab')}
		{else}
		{$core->getBlock('box_detail_pricetable_tour_tab')}
		{/if}
		{else}
		{$core->getBlock('box_detail_pricetable_tour_tab')}
		{/if}
		{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','tour')}
		{$core->getBlock('box_detail_promotion_tour_tab')}
		{/if}
		<div class="tabbox departureTab" style="display:none;">
			 <form method="post" action="" enctype="multipart/form-data">
				<input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
				<input type="hidden" name="UpdateStep6" value="UpdateStep6" />
				{$core->getBlock('meta_box_tour')}
				 <fieldset class="submit-buttons">
					{$saveBtn}
				</fieldset>
            </form>
			</div>
			<div class="g mt30">
				<div data-hveid="70" data-ved="0ahUKEwj2yJPhpLPVAhUGqo8KHbVWCFk4ChAVCEYoBjAG">
					<div class="rc">
						<h3 class="r"><a href="" onMouseDown="" data-href="">{$clsClassTable->getTitle($pvalTable)}</a></h3>
						<div class="s">
							<div>
								<div class="f kv _SWb">
									<cite class="_Rm bc">
										<div class="breadcrumb hidden-xs" style="background:none !important; padding:0 !important">
											<a href="{$DOMAIN_NAME}"><span class="reb">{$DOMAIN_NAME}</span> ›</a> 
											<a href="{$curl}" title="{$core->get_Lang('Tour')}"><span class="reb">{$core->get_Lang('Tour')}</span> ›</a> 
											<a href="{$clsTourCategory->getLink($tourcat_id)}" title="{$clsTourCategory->getTitle($tourcat_id)}">
												<span class="reb">{$clsTourCategory->getTitle($tourcat_id)}</span> ›
											</a>
											<a title="{$clsTour->getTitle($tour_id)}">
												<span class="reb">{$clsClassTable->getTitle($pvalTable)}</span> 
											</a>
										</div>
									</cite>
								</div>
								{if $clsReviews->getRateAvg($pvalTable,'tour') gt 0}
								{assign var=getRateAvg value=$clsReviews->getRateAvg($pvalTable,'tour')}
								{else}
								{assign var=getRateAvg value=1}
								{/if}
								{if  $clsReviews->getToTalReview($pvalTable,'tour') gt 0}
								{assign var=getToTalReview value=$clsReviews->getToTalReview($pvalTable,'tour')}
								{else}
								{assign var=getToTalReview value=0}
								{/if}
								<div class="clearfix"></div>
								<div style="width:100%; max-width:600px">
									<div class="slp f">
										<g-review-stars><span class="_ayg" aria-label="Được đánh giá {$getRateAvg} trên 5"><span style="width:{$getRateAvg/5*100}%"></span></span></g-review-stars>
										Xếp hạng:{$getRateAvg} - ‎{$getToTalReview} đánh giá
									</div>
									<div>{$clsClassTable->getIntro($pvalTable)|strip_tags|truncate:300}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">

<link rel="stylesheet" href="{$URL_JS}/vietiso_datepicker/css/datepicker.css?v={$upd_version}" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css?v={$upd_version}" />

<script type="text/javascript">
    var path_ajax_datepicker = '{$URL_JS}/vietiso_datepicker/js?v={$upd_version}';
    var aj_search = 0;
    var tour_id = '{$pvalTable}';
    var $tour_id = '{$pvalTable}';
    var $tour_type_id = '{$tour_type_id}';
    var $listcatID = '{$oneItem.list_cat_id}';
    var $tourgroup_ID = '{$oneItem.tour_group_id}';//change by language
    var country = "{$core->get_Lang('country')}";
    var regions = "{$core->get_Lang('regions')}";
    var cities = "{$core->get_Lang('cities')}";
    var area = "{$core->get_Lang('Area')}";
    var attractions = "{$core->get_Lang('attractions')}";
    var continents = "{$core->get_Lang('continents')}";
    var required_country = "{$core->get_Lang('required_country')}";
    var identicaltour = "{$core->get_Lang('Error. Please enter a different name and try again tour')}";
    var existedtour = "{$core->get_Lang('This Tour has existed. Please enter a different name and try again tour')}";
    var required_client = "{$core->get_Lang('This tour is not a client type and age choose to participate. Please choose in the table above')}";
    
	var msg_trip_code_not_valid = "{$core->get_Lang('identicaltripcode')}";
	var group_size_invalid = "{$core->get_Lang('group size invalid')}";
	var msg_edit = "{$msg}";
</script>
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
$(function(){
	if(msg_edit=='updateTourOptionFailed'){
	   alert(group_size_invalid);
	}
	$("#SaveTourStep1").click(function(event){
		var trip_code = $("#trip_code").val();
		var adata = {
			'tour_id': tour_id,
			'trip_code': trip_code,
		};
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: path_ajax_script + "/?mod=" + mod + "&act=ajCheckTripCode",
			data: adata,
			dataType: "html",
			success: function(html) {
				if(html.indexOf("_ERROR") >= 0) {
					$('#trip_code_email').html(msg_trip_code_not_valid).fadeIn().delay(3000).fadeOut();
					$("#trip_code").focus();
					return false;
				}else{
					tinyMCE.triggerSave();
					document.createElement('form').submit.call(document.getElementById('frmEditTour'));
				}
			}
		});
	});
});
$('#price_table_tab').click(function(){
	 $("#SaveTourStep11").click();
});
</script>
<style type="text/css">
.avgRever .row-span{width:33.3%;float:left;clear:none}
    .dropdown-toggle .caret {
        margin-top: -4px;
    }
#box_EditPhotosGallery{min-width:240px!important; }
.tabbox .chosen-container-single .chosen-single {
    height: 32px !important;
    line-height: 32px !important;
    border-radius: 0 !important;
    margin-right: 5px !important;
}
.tabbox .btn-add {
    height: 32px !important;
    line-height: 32px !important;
}

#v-nav >ul >li {
    width: 100%;
}
#tab_content .col-right{width: calc(100% - 230px)}
.row-span .fieldlabel{width: 180px;padding:0px 10px;float:left;height:32px;line-height:32px;text-align:left;font-size:13px;}
.row-span .fieldarea{width: calc(100% - 180px);float:right;}
</style>
{/literal}