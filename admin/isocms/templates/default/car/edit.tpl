<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')}: </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&{$pkeyTable}={$pvalTable}">{$core->get_Lang('Edit')}</a>
</div>
<div class="container-fluid">
	<div class="page-title">
        <h2 style="font-size:19px;">{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}<strong style="color:#F00; font-size:12px;" title="{$core->get_Lang('Car is in Private Mode')}!">[P]</strong>{/if}</h2> 
		<p>{$core->get_Lang('Chức năng bao gồm các dữ liệu quản lý cho 01 car ở mức cơ sở')}</p>
		<p>{$core->get_Lang('This function is intended to manage car programe in data system')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
        	<ul>
            	<li><a href="javascript:void(0);"><i class="icon-info-sign"></i>{$core->get_Lang('Information')}</a></li>
            </ul>
        </div>
        <div class="tab_content" id="tab_content">
        	<div class="tabbox">
                <div class="wrap">
					<div class="col_Left fl full_width_767">
						<div class="photobox image">
							{if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
							{if $oneItem.image}
							<a pvalTable="{$pvalTable}" clsTable="Car" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
							{/if}
							{else}
								<img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
								<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
								<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
									<i class="iso-edit"></i>
								</a> 
								<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
							{/if}
						</div>
					</div>
					<div class="col_Right fr full_width_767">
                    	<div class="row-span">
                        	<div class="fieldlabel"><strong> {$core->get_Lang('Name of car')} <span class="requiredMask">*</span></strong></div>
                            <div class="fieldarea">
                            	<input class="text full fontLarge required" name="iso-title" value="{$clsClassTable->getOneField('title',$pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Vehicle type')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
								<select name="iso-vehicle_type_id" id="vehicle_type_id" class="text_32 full-width border_aaa chosen-select" style="width:250px">
									{assign var = selected value = $oneItem.vehicle_type_id}
									{$clsProperty->getSelectByProperty('VehicleType',$selected)}
									{$selected}
								</select> 
                            </div>
                        </div>
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
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
						<div class="clearfix mb10"></div>
						{if $clsISO->getBrowser() eq 'computer'}
						<table class="form" cellpadding="2" cellspacing="2">
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Seat number')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-number_seat" value="{$clsClassTable->getOneField('number_seat',$pvalTable)}" style="width:100px" min="0" />
									{literal}
									<script type="text/javascript">
										$(function(){
											$('#slb_Seat').change(function(){
												var $_this = $(this);
												var $min_value = $_this.find('option:selected').attr('min_value');
												$('input[name=iso-passenger]').val($min_value);
											});
										});
									</script>
									{/literal}
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Passenger')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-passenger" value="{$clsClassTable->getOneField('passenger',$pvalTable)}" style="width:100px" min="0" />
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Luggage')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-luggage" value="{$clsClassTable->getOneField('luggage',$pvalTable)}" style="width:100px" min="0" />
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Air-conditioner')}</td>
								<td class="fieldarea">
									<select name="iso-air_condition" style="width:100px">
										<option  {if $clsClassTable->getOneField('air_condition',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('air_condition',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
							</tr>
							<tr class="mt20">
								<td class="fieldlabel span15">{$core->get_Lang('Seat belt')}</td>
								<td class="fieldarea">
									<select name="iso-belt_seat" style="width:100px">
										<option {if $clsClassTable->getOneField('belt_seat',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('belt_seat',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Infant seat')}</td>
								<td class="fieldarea">
									<select name="iso-infant_seat" style="width:100px">
										<option {if $clsClassTable->getOneField('infant_seat',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('infant_seat',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Toddle seat')}</td>
								<td class="fieldarea">
									<select name="iso-toddle_seat" style="width:100px">
										<option {if $clsClassTable->getOneField('toddle_seat',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('toddle_seat',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Price/Km')} ({$clsISO->getRate()})</td>
								<td class="fieldarea">
									<input class="text full fontLarge color_f00" name="price_one_km" value="{$clsClassTable->getOneField('price_one_km',$pvalTable)}"/>
								</td>
							</tr>
						</table>
						{else}
						<table class="form" cellpadding="2" cellspacing="2">
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Seat number')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-number_seat" value="{$clsClassTable->getOneField('number_seat',$pvalTable)}" style="width:100px" min="0" />
									{literal}
									<script type="text/javascript">
										$(function(){
											$('#slb_Seat').change(function(){
												var $_this = $(this);
												var $min_value = $_this.find('option:selected').attr('min_value');
												$('input[name=iso-passenger]').val($min_value);
											});
										});
									</script>
									{/literal}
								</td>
							</tr>
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Passenger')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-passenger" value="{$clsClassTable->getOneField('passenger',$pvalTable)}" style="width:100px" min="0" />
								</td>
							</tr>
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Luggage')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-luggage" value="{$clsClassTable->getOneField('luggage',$pvalTable)}" style="width:100px" min="0" />
								</td>
							</tr>
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Air-conditioner')}</td>
								<td class="fieldarea">
									<select name="iso-air_condition" style="width:100px">
										<option  {if $clsClassTable->getOneField('air_condition',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('air_condition',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
							</tr>
							<tr class="mt20">
								<td class="fieldlabel span15">{$core->get_Lang('Seat belt')}</td>
								<td class="fieldarea">
									<select name="iso-belt_seat" style="width:100px">
										<option {if $clsClassTable->getOneField('belt_seat',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('belt_seat',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Infant seat')}</td>
								<td class="fieldarea">
									<select name="iso-infant_seat" style="width:100px">
										<option {if $clsClassTable->getOneField('infant_seat',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('infant_seat',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Toddle seat')}</td>
								<td class="fieldarea">
									<select name="iso-toddle_seat" style="width:100px">
										<option {if $clsClassTable->getOneField('toddle_seat',$pvalTable) eq 'No'} selected="selected"{/if} value="No">{$core->get_Lang('No')}</option>
										<option {if $clsClassTable->getOneField('toddle_seat',$pvalTable) eq 'Yes'} selected="selected"{/if} value="Yes">{$core->get_Lang('Yes')}</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Price/Km')} ({$clsISO->getRate()})</td>
								<td class="fieldarea">
									<input class="text full fontLarge color_f00" name="price_one_km" value="{$clsClassTable->getOneField('price_one_km',$pvalTable)}"/>
								</td>
							</tr>
						</table>
						{/if}
					</div>
                </div>
				<div class="clearfix mb20"></div>
				{if $clsISO->getBrowser() eq 'computer'}
				<div id="v-nav">
					<ul>
						<li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Seat belt notes')}</strong></a></li>
						<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Luggage notes')}</strong></a></li>
						<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Vehicle Description')}</strong></a></li>
					</ul>
					<div class="tab-content" style="display: block;">
						{$clsForm->showInput('seat_belt_note')}
					</div>
					<div class="tab-content" style="display: none;">
						{$clsForm->showInput('luggage_note')}
					</div>
					<div class="tab-content" style="display: none;">
						{$clsForm->showInput('intro')}
					</div>
				</div>
				{else}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Seat belt notes')}<span class="color_r">*</span> </strong> </div>
					<div class="fieldarea">
						{$clsForm->showInput('seat_belt_note')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Luggage notes')}<span class="color_r">*</span> </strong> </div>
					<div class="fieldarea">
						{$clsForm->showInput('luggage_note')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Vehicle Description')}<span class="color_r">*</span> </strong> </div>
					<div class="fieldarea">
						{$clsForm->showInput('intro')}
					</div>
				</div>
				{/if}
        	</div>
        </div>
		<div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}{$resetBtn}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>