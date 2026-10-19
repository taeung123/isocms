<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('transfer')}">{$core->get_Lang('transfer')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$core->get_Lang('edit')}">{$core->get_Lang('edit')} #{$pvalTable}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2 style="font-size:19px;">{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}<strong style="color:#F00; font-size:12px;" title="{$core->get_Lang('Transfer is in Private Mode')}!">[P]</strong>{/if}</h2>
        <div class="permalinkbox mb20">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</strong></a>
            </div>
        </div> 
		<p>{$core->get_Lang('Chức năng bao gồm các dữ liệu quản lý cho 01 transfer ở mức cơ sở')}</p>
		<p>{$core->get_Lang('This function is intended to manage transfer programe in data system')}</p>
    </div>
    <div class="clearfix"><br /></div>
    {if $clsClassTable->getErrorMsg($pvalTable) ne ''}
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
			{if $pvalTable gt '0' }
            <li><a href="javascript:void(0);"><i class="fa fa-car" aria-hidden="true"></i> {$core->get_Lang('Car')}</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Configuration')}</a></li>
			<li><a href="javascript:void(0);"><i class="fa fa-tag"></i> {$core->get_Lang('Seo Tool')}</a></li>
			{/if}
        </ul>
    </div>
    <div id="tab_content" style="width:100%; float: left">
        <div class="tabbox">
            <form id="frmEditTour" method="post" action="" enctype="multipart/form-data" class="validate-form">
                <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
                <div class="wrap">
					<div class="fl col_Left full_width_767">
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
						<h3 class="small text-center">{$core->get_Lang('Image Size')} (WxH=720x480)</h3>
					</div>
                    <div class="fr col_Right full_width_767">
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Name')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold title_capitalize required" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Type of trip')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
								<select name="iso-type_of_trip_id" id="type_of_trip_id" class="text_32 full-width border_aaa chosen-select required" style="width:250px">
									{assign var = selected value = $oneItem.type_of_trip_id}
									{$clsProperty->getSelectByProperty('TypeOfTrip',$selected)}
									{$selected}
								</select> 
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('departurepoint')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
								<select class="slb required full" name="country_departure_point_id" id="slb_Country_Departurepoint" style="font-size:14px;width:150px">
									{$clsCountry->makeSelectboxOption($departure_country_id)}
								</select>
                                {if $clsConfiguration->getValue('SiteActive_region') eq '1'}
								<select class="slb full" name="region_departure_point_id" id="slb_Region_Departurepoint" style="font-size:14px;width:150px"> 
									{$clsRegion->makeSelectboxOption($departure_country_id,$departure_region_id)}
								</select>
                                {/if}
                                <select class="slb full" name="departure_point_id" id="slb_City_Departurepoint" style="font-size:14px;width:150px"> 
                                    {$clsCity->makeSelectboxOption($departure_point_id,$departure_country_id)}
                                </select>
                                <em style="margin-top:5px; font-size:10px">{$core->get_Lang('ex')}: Ha Noi, Ho Chi Minh City, Da Nang</em>
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Pick up address')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold title_capitalize required" id="pick_up" name="iso-pick_up" value="{$clsClassTable->getPickUp($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Endpoint')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
								<select class="slb required full" name="country_end_point_id" id="slb_Country_Endpoint" style="font-size:14px;width:150px">
									{$clsCountry->makeSelectboxOption($country_end_point_id)}
								</select>
                                {if $clsConfiguration->getValue('SiteActive_region') eq '1'}
								<select class="slb full"  name="region_end_point_id" id="slb_Region_Endpoint" style="font-size:14px;width:150px"> 
									{$clsRegion->makeSelectboxOption($country_end_point_id,$region_end_point_id)}
								</select>
                                {/if}
                                <select class="slb full" name="end_point_id" id="slb_City_Endpoint" style="font-size:14px;width:150px"> 
                                    {$clsCity->makeSelectboxOption($end_point_id,$country_end_point_id)}
                                </select>
                                <em style="margin-top:5px; font-size:10px">{$core->get_Lang('ex')}: Ha Noi, Ho Chi Minh City, Da Nang</em>
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Drop off address')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold title_capitalize required" id="drop_off" name="iso-drop_off" value="{$clsClassTable->getDropOff($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Estimated distance')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea"><input class="text_32 border_aaa w120 required fontLarge" name="iso-distance" value="{$clsClassTable->getDistanceTrip($pvalTable)}" maxlength="255" placeholder="100" type="text"> ({$core->get_Lang('Km')})</div>
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Estimated time')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea"><input class="text_32 border_aaa w120 required fontLarge" name="iso-time" placeholder="1h20 - 2h30" value="{$clsClassTable->getTimeTrip($pvalTable)}" maxlength="255" type="text"></div>
                        </div>
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
                    </div>
                </div>
                <div class="clearfix"><br /></div>
				{if $clsISO->getBrowser() eq 'computer'}
                <div id="v-nav">
                    <ul>
                        <li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Overview')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Highlight')}</strong></a> <span class="color_r">*</span></li>
					    <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('What are include?')}</strong></a> <span class="color_r">*</span></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('What are exclude?')}</strong></a> <span class="color_r">*</span></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang("Service Information")}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang("Embed map")}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang("Banner")} (WxH:1600x500)</strong></a> <span class="color_r">*</span></li>
                    </ul>
                    <div class="tab-content" style="display: block;">
                        {$clsForm->ShowInput('overview')}
                    </div>
					<div class="tab-content">
                        {$clsForm->ShowInput('highlight')}
                    </div>
                    <div class="tab-content" id="whatInCluded" style="display: none;">
						{$clsForm->ShowInput('inclusion')}
                    </div>
					<div class="tab-content" style="display:none">
                        {$clsForm->ShowInput('exclusion')}
                    </div>
					<div class="tab-content" style="display:none">
                        {$clsForm->ShowInput('service_information')}
                    </div>
					<div class="tab-content" style="display:none">
						<h3 class="mb10"><a href="https://www.google.com/maps/dir///@11.7903087,-85.0423029,3z/data=!4m2!4m1!3e0" title="{$core->get_Lang('get embed map code')}" target="_blank">{$core->get_Lang('get embed map code')} <i class="fa fa-eye" aria-hidden="true"></i></a></h3>
                       <textarea class="text_32 full-width border_aaa" id="embed_map" name="iso-embed_map" value="{$clsClassTable->getMaps($pvalTable)}" maxlength="1000000" type="text" style="height:150px" />
					   {$clsClassTable->getMaps($pvalTable)}
					   </textarea>
					   <div class="clearfix"></div>
					   <h3 class="mb10">{$core->get_Lang('Note maps')}</h3>
					   {$clsForm->ShowInput('note_map')}
                    </div>
					<div class="tab-content" style="display:none">
						<div class="photobox photoBanner image span100">
							{if $_isoman_use eq '1'}
							<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_image_banner" class="span100" />
							<input type="hidden" id="isoman_hidden_image_banner" name="isoman_url_image_banner" value="{$oneItem.image_banner}" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_banner" isoman_val="{$oneItem.image_banner}" isoman_name="image_banner"><i class="iso-edit"></i></a>
							{if $oneItem.image_banner}
							<a pvalTable="{$pvalTable}" clsTable="Transfer" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImageHtml" data-name_input="isoman_url_image_banner" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
							{/if}
							{else}
							<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('noimages')}" id="imgTransfer_banner" class="span100" />
							<input type="hidden" name="image_banner_src" value="{$oneItem.image_banner}" class="hidden_src" id="imgTransfer_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTransfer">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgTransfer_file" g="imgTransfer" class="editInlineImageFile" name="image_banner" />
							{/if}
						</div>
                	</div>
				</div>
				{else}
				<div id="v-nav">
                    <div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Overview')}</strong></div>
						<div class="fieldarea">
							{$clsForm->ShowInput('overview')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Highlight')}</strong></div>
						<div class="fieldarea">
							{$clsForm->ShowInput('highlight')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('What are include?')}</strong></div>
						<div class="fieldarea">
							{$clsForm->ShowInput('inclusion')}
						</div>
					</div>
                    <div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('What are exclude?')}</strong></div>
						<div class="fieldarea">
							{$clsForm->ShowInput('exclusion')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Service Information')}</strong></div>
						<div class="fieldarea">
							{$clsForm->ShowInput('service_information')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Embed map')}</strong></div>
						<div class="fieldarea">
							<h3 class="mb10"><a href="https://www.google.com/maps/dir///@11.7903087,-85.0423029,3z/data=!4m2!4m1!3e0" title="{$core->get_Lang('get embed map code')}" target="_blank">{$core->get_Lang('get embed map code')} <i class="fa fa-eye" aria-hidden="true"></i></a></h3>
						   <textarea class="text_32 full-width border_aaa" id="embed_map" name="iso-embed_map" value="{$clsClassTable->getMaps($pvalTable)}" maxlength="1000000" type="text" style="height:150px" />
						   {$clsClassTable->getMaps($pvalTable)}
						   </textarea>
						   <div class="clearfix"></div>
						   <h3 class="mb10">{$core->get_Lang('Note maps')}</h3>
						   {$clsForm->ShowInput('note_map')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang("Banner")} (WxH:1600x500)</strong></div>
						<div class="fieldarea">
							<div class="photobox photoBanner image span100">
								{if $_isoman_use eq '1'}
								<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_image_banner" class="span100" />
								<input type="hidden" id="isoman_hidden_image_banner" name="isoman_url_image_banner" value="{$oneItem.image_banner}" />
								<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_banner" isoman_val="{$oneItem.image_banner}" isoman_name="image_banner"><i class="iso-edit"></i></a>
								{if $oneItem.image_banner}
								<a pvalTable="{$pvalTable}" clsTable="Transfer" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImageHtml" data-name_input="isoman_show_image_banner" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
								{/if}
								{else}
								<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('noimages')}" id="imgTransfer_banner" class="span100" />
								<input type="hidden" name="image_banner_src" value="{$oneItem.image_banner}" class="hidden_src" id="imgTransfer_hidden" />
								<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTransfer">
									<i class="iso-edit"></i>
								</a> 
								<input type="file" style="display:none" id="imgTransfer_file" g="imgTransfer" class="editInlineImageFile" name="image_banner" />
								{/if}
							</div>
						</div>
					</div>
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
        <div class="tabbox" style="display:none">
			<p>{$core->get_Lang('Note: Please enter price & system price automatic save !')}</p>
			<form class="mt30" method="post" action="">
            <div class="accordion_in acc_active">
				<div class="acc_content full_width" style="overflow-x:auto">
					<table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0" style="min-width:991px">
						<tr>
							<td class="gridheader"><strong>{$core->get_Lang('ID')}</strong></td>
							<td class="gridheader" style="width:80px"><strong>{$core->get_Lang('Image')}</strong></td>
							<td class="gridheader text-left"><strong>{$core->get_Lang('Name')}</strong></td>
							{section name=j loop=$listTypeOfTrip}
							<td class="gridheader" style="width:120px; text-align:center"><strong>{$core->get_Lang('Price')} {$clsProperty->getTitle($listTypeOfTrip[j].property_id)} ({$clsISO->getRate()})</strong></td>
							{/section}
							
							<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Vehicle type')}</strong></td>
							<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Seat number')}</strong></td>
							<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Passenger')}</strong></td>
							<td class="gridheader" style="width:70px"><strong>{$core->get_Lang('func')}</strong></td>
						</tr>
						{section name=i loop=$lstCarTransfer}
						<tr class="{cycle values=" row1,row2 "}">
							<td class="index">{$lstCarTransfer[i].car_id}</td>
							<td class="index">
							{if $clsCar->getImage($lstCarTransfer[i].car_id,60,40)}
								<img src="{$clsCar->getImage($lstCarTransfer[i].car_id,60,40)}" width="60" /> 
							{/if}
							</td>
							<td>{$clsCar->getTitle($lstCarTransfer[i].car_id)}</td>
							{section name=j loop=$listTypeOfTrip}
							<td style="text-align:center; color:#f00"><input type="text"  class="color_f00 text full transfer_car_price fontLarge" type_of_trip_id="{$listTypeOfTrip[j].property_id}" car_id="{$lstCarTransfer[i].car_id}" transfer_id="{$pvalTable}" value="{$clsTransferPrice->getPrice($pvalTable,$lstCarTransfer[i].car_id,$listTypeOfTrip[j].property_id)}"  /></td>
							{/section}
							<td width="120px" style="text-align:center">{$clsProperty->getTitle($clsCar->getOneField('vehicle_type_id',$lstCarTransfer[i].car_id))}</td>
							<td width="100px" style="text-align:center">{$clsCar->getOneField('number_seat',$lstCarTransfer[i].car_id)}</td>
							<td width="40px" style="text-align:center">{$clsCar->getOneField('passenger',$lstCarTransfer[i].car_id)}</td>
							<td class="text-center"><input type="checkbox" name="list_car_id[]" {$lstCarTransfer[i].check} value="{$lstCarTransfer[i].car_id}" {if $clsISO->checkInArray($oneItem.list_car_id,$lstCarTransfer[i].car_id)}checked="checked"{/if} /></td>
						</tr>
						{/section}
					</table>
					<div class="clearfix"><br /><br /></div>
					<div class="row-bottom">
						<div class="row-buttons">
							<div class="clear"></div>
							<button type="submit" id="SaveTourStep2" class="btn-update" name="button" value="Update">
								<i class="iso-update"></i> {$core->get_Lang('Submit')}
							</button>
							<input type="hidden" name="UpdateStep2" value="UpdateStep2" />
						</div>
					</div>
				</div>
			</div>
			</form>
        </div>
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
                    <li><a href="javascript:void(0);"><i class="iso-gallery"></i> {$core->get_Lang('gallery')}</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <div class="tab_contentglobal">
                <div class="tabboxchild_globaltabs_config">
                    <div id="TransferGalleryHolder"></div>
                </div>
				{literal}
				<script type="text/javascript">
					$().ready(function() {
						initSysGalleryTransfer();
					});
				</script>
				{/literal}
            </div>
        </div>
		<div class="tabbox" style="display:none">
		<form method="post" action="" enctype="multipart/form-data">
			<input type="hidden" name="UpdateStep6" value="UpdateStep6" />
			{$core->getBlock('meta_box_detail')}
			 <fieldset class="submit-buttons">
				{$saveBtn}
			</fieldset>
		</form>
		</div>
    </div>
</div>
{literal}
<style type="text/css">
#tab_content .col-right{width: calc(100% - 230px)}
.row-span .fieldlabel{width: 180px;padding:0px 10px;float:left;height:32px;line-height:32px;text-align:left;font-size:13px;}
.row-span .fieldarea{width: calc(100% - 180px);float:right;}
</style>
{/literal}
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<link rel="stylesheet" href="{$URL_JS}/vietiso_datepicker/css/datepicker.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<script type="text/javascript">
    var path_ajax_datepicker = '{$URL_JS}/vietiso_datepicker/js';
    var aj_search = 0;
	var transfer_id = '{$pvalTable}';
   
</script>
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/transfer/jquery.transfer.js?v={$upd_version}"></script>
