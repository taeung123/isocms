<link rel="stylesheet" href="{$URL_CSS}/chosen.css" type="text/css" media="all">
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript">
	var hotel_room_id = '{$pvalTable}';
	var hotel_id = '{$hotel_id}';
</script>
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('hotels')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&hotel_id={$core->encryptID($hotel_id)}">{$clsHotel->getTitle($hotel_id)}</a>
	 <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&hotel_id={$core->encryptID($hotel_id)}">{$clsClassTable->getTitle($pvalTable)}</a>
   <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
		<h2>{$clsHotel->getTitle($hotel_id)} <img src="{$clsHotel->getImageStar($clsHotel->getStar($hotel_id))}" /></h2>
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsHotel->getLink($hotel_id)}" target="_blank"><img align="absmiddle" style="vertical-align:-2px" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsHotel->getLink($hotel_id)}</strong></a> 
            </div>
        </div>
    </div>
	<div class="hr"></div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<div class="wrap">
			<div class="image">
				<div class="photobox fl">
					{if $_isoman_use eq '1'}
					<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
					<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}">
					<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image" title="{$core->get_Lang('change')}"><i class="iso-edit"></i></a>
						{if $oneItem.image}
						<a pvalTable="{$pvalTable}" clsTable="Hotel" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
					{/if}
					{else}
					<img src="{$clsClassTable->getImage($pvalTable,180,156)}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
					<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
					<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
						<i class="iso-edit"></i>
					</a> 
					<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
					{/if}
				</div>
			</div>
			<div style="vertical-align:top; margin-left:200px">
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Name')}* </strong></div>
					<div class="fieldarea">
						<input class="text full" id="title" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('TypeOfRoom')}* </strong></div>
					<div class="fieldarea">
						<select name="iso-room_stype_id">
							{$clsISO->getSelectPropertyType('TypeRoom',$oneItem.room_stype_id)}
						</select>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Description')}* </strong></div>
					<div class="fieldarea">
						<textarea id="textarea_content_editor{$now}" rows="2" class="textarea_content_editor" name="iso-intro" style="width:99%">{$clsClassTable->getIntro($pvalTable)}</textarea>
					</div>
				</div>
			</div>
			<div class="clearfix mb10"></div>
			<div id="v-nav">
				<ul>
					<li class="first current"><a href="javascript:void(0);">{$core->get_Lang('General')}</a></li>
					<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('RoomPrice')}</a></li>
					<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('RoomFacility')}</a></li>
					<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('OtherFacility')}</a></li>
					<li class="tabchildcol"><a href="#setting_availability_tab">{$core->get_Lang('Availbility')}</a></li>
                    {if 1 eq 2}
					<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('CancelBooking')}</a></li>
					<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Payment')}</a></li>
                    {/if}
				</ul>
				<div class="tab-content" style="display: block;">
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Number Room')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" value="{$oneItem.number_val}" name="iso-number_val" style="width:50%" />
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Breakfast')}</label>
						</div>
						<div class="format-setting-content">
							<input type="checkbox" name="is_breakfast" {if $oneItem.is_breakfast eq '1'}checked="checked"{/if} value="1">
                            {literal}
                        	<script type="text/javascript">
								new DG.OnOffSwitch({
									el: 'input[name=is_breakfast]',
									textOn: 'On',
									textOff: 'Off',
									listener:function(name, checked){
										if(checked){
											$('#room_external_booking_link').show();
										}else{
											$('#room_external_booking_link').hide();
										}
									}
								});
							</script>
                            {/literal}
						</div>
					</div>
                    {if 1 eq 2}
					<div class="format-setting-wrap">
						<div class="format-setting-label border-bottom">
							<label>{$core->get_Lang('Room Gallery')}</label>
						</div>
						<div class="format-setting-content">
							<div id="RoomGalleryHolder"></div>
						</div>
						<script type="text/javascript">
							var pvalTable = '{$pvalTable}';
							var type = '_ROOM';
						</script>
						{literal}
						<script type="text/javascript">
							$(function(){
								initSysGalleryRoom(pvalTable,type,'RoomGalleryHolder');
							});
							function initSysGalleryRoom($pvalTable, $type, $container){
								$.ajax({
									type: "POST",
									url: path_ajax_script+'/index.php?mod='+mod+'&act=ajaxInitPhotosGallery',
									data: {'table_id':$pvalTable,'type':$type},
									dataType: "html",
									success: function(html){
										$('#'+$container).html(html);
										loadTableGallery($pvalTable,type,'',1,10);
									}
								});
							}
						</script>
						{/literal}
					</div>
                    {/if}
				</div>
				<div class="tab-content" style="display: none;">
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Price')} (.000 {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))})</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full autosavefield" name="rate" value="{$clsISO->formatPrice($oneItem.price)}" field_id="price" tbl="HotelRoom" pval="{$pvalTable}" ipn="number" style="width:50%" />
							<span>{$core->get_Lang('Per night')}</span>
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Giường phụ')} (.000 {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))})</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full priceFormat" name="price_extra" value="{$clsISO->formatPrice($oneItem.price_extra)}" style="width:50%" />
							<span>{$core->get_Lang('Per night')}</span>
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Price Unit')}</label>
						</div>
						<div class="format-setting-content">
							<select name="iso-extra_price_unit">
								<option {if $oneItem.extra_price_unit eq 'perday'}selected="selected"{/if} value="perday">{$core->get_Lang('Per Day')}</option>
								<option {if $oneItem.extra_price_unit eq 'fixed'}selected="selected"{/if} value="fixed">{$core->get_Lang('Fixed')}</option>
							</select>
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Discount Rate')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" style="width:50%" name="iso-discount_rate" value="{$oneItem.discount_rate}" />
							<span>{$core->get_Lang('Discount by')} %</span>
						</div>
					</div>
				</div>
				<div class="tab-content" style="display: none;">
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Adult')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" name="iso-number_adult" value="{$oneItem.number_adult}" style="width:50%" />
							<span>{$core->get_Lang('Number of Adults in room')}</span>
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Children')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" name="iso-number_children" value="{$oneItem.number_children}" style="width:50%" />
							<span>{$core->get_Lang('Number of children in room')}</span>
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('No. beds')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" name="iso-number_bed" {if $oneItem.number_bed ne '0' and $oneItem.number_bed ne ''}value="{$oneItem.number_bed}" {else}placeholder="1 giường đôi (2mx2m) hoặc 2 giường đơn (1m2x2m)"{/if} style="width:50%"  />
							<span>{$core->get_Lang('Number of Beds in room')}</span>
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Diện tích phòng')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" name="iso-footage" value="{$oneItem.footage}" style="width:50%" />
							<span>{$core->get_Lang('Diện tích phòng')}</span>
						</div>
					</div>
                    {if 1 eq 2}
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Room external booking')}</label>
						</div>
						<div class="format-setting-content">
                        	<input type="checkbox" name="is_external_booking" {if $oneItem.is_external_booking eq '1'}checked="checked"{/if} value="1">
                            {literal}
                        	<script type="text/javascript">
								new DG.OnOffSwitch({
									el: 'input[name=is_external_booking]',
									textOn: 'On',
									textOff: 'Off',
									listener:function(name, checked){
										if(checked){
											$('#room_external_booking_link').show();
										}else{
											$('#room_external_booking_link').hide();
										}
									}
								});
							</script>
                            {/literal}
						</div>
					</div>
					<div class="format-setting-wrap" id="room_external_booking_link" style="{if $oneItem.is_external_booking eq '1'}{else}display:none{/if}">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Room external booking')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" name="iso-external_booking_link" value="{$oneItem.external_booking_link}" style="width:50%" />
							<span>{$core->get_Lang('Notice: Must be http://...')}</span>
						</div>
					</div>
                    {/if}
				</div>
				<div class="tab-content" style="display: none;">
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Add a facility')}</label>
						</div>
						<div id="SiteCustomFieldContaciner">
							
						</div>
						<a href="javascript:void(0);" class="option-tree-list-item-add option-tree-ui-button btn btn-primary fr hug-right ClickCustomField" type="ADDFACILITY" data-hotel_id="{$hotel_id}" data-hotel_room_id="{$pvalTable}" forid="SiteCustomFieldContaciner">{$core->get_Lang('Add New')}</a>
						<div class="format-setting-content">
							{$core->get_Lang('You can re-order with drag & drop, the order will update after saving')}.
						</div>
						
					</div>
					<div class="format-setting-wrap" style="display:none">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Description')}</label>
						</div>
						<div class="format-setting-content">
							<textarea class="textarea" rows="10" style="width:100%" name="iso-description">{$oneItem.description}</textarea>
							{literal}
							<script type="text/javascript">
								setViewTextAreaByClass('textarea');
							</script>
							{/literal}
						</div>
					</div>
				</div>
				<div class="tab-content" style="display: none;">
					<div class="format-setting-wrap" style="width:250px; display:inline-block; vertical-align:top;padding-left:10px; padding-right:10px; border-right:1px solid #ddd">
						<div class="format-setting-label">
							<label>{$core->get_Lang('DefaultState')}</label>
						</div>
						<div class="format-setting-content">
							<select name="iso-default_state" class="autosavefield" field_id="default_state" tbl="HotelRoom" pval="{$pvalTable}" ipn="text">
								<option {if $oneItem.default_state eq 'available'}selected="selected"{/if} value="available">{$core->get_Lang('Available')}</option>
								<option {if $oneItem.default_state eq 'unavailable'}selected="selected"{/if} value="unavailable">{$core->get_Lang('Unavailable')}</option>
							</select>
						</div>
					</div>
                    <div class="format-setting-wrap" style="width:200px; display:inline-block; vertical-align:top;padding-left:10px; padding-right:10px; border-right:1px solid #ddd">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Đặt phòng')}</label>
						</div>
						<div class="format-setting-content">
							<input type="checkbox" name="is_booking" id="is_booking" {if $oneItem.is_booking eq '1'}checked="checked"{/if} value="1">
                            {literal}
                        	<script type="text/javascript">
								new DG.OnOffSwitch({
									el: 'input[name=is_booking]',
									textOn: 'On',
									textOff: 'Off',
									listener:function(name, checked){
										if(checked){
											DG.switches["is_getprice"].uncheck();
											DG.switches["is_sendrequest"].uncheck();
										}
									}
								});
							</script>
                            {/literal}
						</div>
					</div>
                    <div class="format-setting-wrap" style="width:200px; display:inline-block; vertical-align:top;padding-left:10px; padding-right:10px; border-right:1px solid #ddd">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Yêu cầu giá')}</label>
						</div>
						<div class="format-setting-content">
							<input type="checkbox" name="is_sendrequest" {if $oneItem.is_sendrequest eq '1'}checked="checked"{/if} value="1">
                            {literal}
                        	<script type="text/javascript">
								new DG.OnOffSwitch({
									el: 'input[name=is_sendrequest]',
									textOn: 'On',
									textOff: 'Off',
									listener:function(name, checked){
										if(checked){
											DG.switches["is_booking"].uncheck();
											DG.switches["is_getprice"].uncheck();
										}
									}
								});
							</script>
                            {/literal}
						</div>
					</div>
                    <div class="format-setting-wrap" style="width:200px; display:inline-block; vertical-align:top;">
						<div class="format-setting-label">
							<label>{$core->get_Lang('Click để lấy giá')}</label>
						</div>
						<div class="format-setting-content">
							<input type="checkbox" name="is_getprice" {if $oneItem.is_getprice eq '1'}checked="checked"{/if} value="1">
                            {literal}
                        	<script type="text/javascript">
								new DG.OnOffSwitch({
									el: 'input[name=is_getprice]',
									textOn: 'On',
									textOff: 'Off',
									listener:function(name, checked){
										if(checked){
											DG.switches["is_booking"].uncheck();
											DG.switches["is_sendrequest"].uncheck();
										}
									}
								});
							</script>
                            {/literal}
						</div>
					</div>
					<div class="format-setting-wrap">
						<div class="format-setting-label border-bottom">
							<label>{$core->get_Lang('Calendar')}</label>
						</div>
						<div class="format-setting-content">
							<div class="row calendar-wrapper" data-hotel_room_id="{$pvalTable}">
								<div class="col-xs-4">
									<div class="calendar-form">
										<div class="form-group">
											<label for="calendar_check_in">{$core->get_Lang('Check-in Date')}</label>
											<input readonly="readonly" placeholder="mm/dd/yyyy" type="text" class="widefat option-tree-ui-input date-picker" name="check_in" id="calendar_check_in">
										</div> 
										<div class="form-group">
											<label for="calendar_check_out">{$core->get_Lang('Check-out Date')}</label>
											<input readonly="readonly" placeholder="mm/dd/yyyy" type="text" class="widefat option-tree-ui-input date-picker" name="check_out" id="calendar_check_out">
										</div>
										<div class="form-group">
											<label for="calendar_price">{$core->get_Lang('Price')} (.000 {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))})</label>
											<input type="text" name="price" id="calendar_price" class="widefat form-control">
										</div>
										<div class="form-group row" style="display:none">
											<div class="col-xs-6">
												<label for="calendar_status">{$core->get_Lang('Status')}</label>
												<select name="status" id="calendar_status" class="form-control">
													<option value="available">{$core->get_Lang('Available')}</option>
													<option value="unavailable">{$core->get_Lang('Unavailable')}</option>
												</select>
											</div>
											<div class="col-xs-6">
												<label for="calendar_allotement">{$core->get_Lang('allotement')}</label>
												<input type="number" min="0" value="0" max="{$oneItem.number_val}" name="allotement" id="calendar_allotement" class="widefat form-control">
											</div>
										</div>
                                        
                                        
                                        {if 1 eq 2}
										<div class="form-group">
											<input type="checkbox" value="1" name="request_price" id="calendar_request_price">
											<label style="display:inline-block" for="calendar_request_price">{$core->get_Lang('request_price')}</label>
										</div>
                                        
                                        {/if}
										<div class="form-group">
                                        	<input type="hidden" name="hotel_id" value="{$hotel_id}">
											<input type="hidden" name="target_id" value="{$pvalTable}">
											<input type="hidden" name="tp" value="S">
											<input type="hidden" name="type" value="_ROOM">
											<input type="button" id="calendar_submit" class="btn btn-primary" value="{$core->get_Lang('Update')}">
										</div>
									</div>
								</div>
								<div class="col-xs-8">
									<div class="calendar-content">
									</div>
									<div class="overlay">
										<span class="spinner is-active"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-content" style="display: none;">
					<div class="format-setting-wrap">
						<div class="format-setting-label">
							<label>{$core->get_Lang('AllowCancel')}</label>
						</div>
						<div class="format-setting-content">
                        	<input type="checkbox" name="is_cancel" value="1" {if $oneItem.is_cancel eq '1'}checked="checked"{/if} />
                            {literal}
                            <script type="text/javascript">
								new DG.OnOffSwitch({
									el: 'input[name=is_cancel]',
									textOn: 'On',
									textOff: 'Off',
									listener:function(name, checked){
										if(checked){
											$('#st_cancel_number_days').show();
											$('#st_cancel_percent').show();
										}else{
											$('#st_cancel_number_days').hide();
											$('#st_cancel_percent').hide();
										}
									}
								});
                            </script>
                            {/literal}
						</div>
					</div>
					<div class="format-setting-wrap" id="st_cancel_number_days" {if $oneItem.is_cancel eq '1'}{else} style="display:none"{/if}>
						<div class="format-setting-label">
							<label>{$core->get_Lang('Number of days before the arrival')}</label>
						</div>
						<div class="format-setting-content">
							<input type="text" class="text full" name="iso-cancel_number_days" value="{$oneItem.cancel_number_days}" style="width:50%" />
							<span>{$core->get_Lang('Number of days before the arrival')}</span>
						</div>
					</div>
					<div class="format-setting-wrap" id="st_cancel_percent" {if $oneItem.is_cancel eq '1'}{else} style="display:none"{/if}>
						<div class="format-setting-label">
							<label>{$core->get_Lang('Percent of total price')}</label>
						</div>
						<div class="format-setting-content">
							<select name="iso-cancel_percent">
								{$clsISO->getSelect(1,100,$oneItem.cancel_percent)} %
							</select>
							<span>{$core->get_Lang('Percent of total price for the canceling')}</span>
						</div>
					</div>
				</div>
				<div class="tab-content" style="display: none;">
					{$core->get_Lang('Updating')}...
				</div>
			</div>
			<!-- Room Service -->
			<div class="h4 mv10">
				{$core->get_Lang('RoomService')}</strong>
				<p class="checkall">{$core->get_Lang('Check/Uncheck All')} <input type="checkbox" rel="room_facility" id="all_check"></p>
			</div>
			<div class="wrap">
				{section name=i loop=$lstRoomService}
				<label class="lblcheck">
					<input type="checkbox" value="{$lstRoomService[i].property_id}" {if $clsISO->checkContainer2($oneItem.list_RoomServices,$lstRoomService[i].property_id)} checked="checked"{/if} class="room_facility" name="list_RoomServices[]" />
					{$clsProperty->getTitle($lstRoomService[i].property_id)}
				</label>
				{/section}
				<label class="lblcheck"><a href="{$PCMS_URL}/index.php?mod=property&type=RoomService"><img src="{$URL_IMAGES}/v2/add.png" align="absmiddle" style="vertical-align-3px" /> {$core->get_Lang('AddMoreRoomService')}</a></label>
			</div>
		</div>
		<div class="clearfix mt10"></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
{literal}
<script type="text/javascript">
    if($('.textarea_content_editor').length > 0){
		$('.textarea_content_editor').each(function(){
			var $_this = $(this);
			var $editorID = $_this.attr('id');
			$('#'+$editorID).isoTextArea();
		});
	}
</script>
<script type="text/javascript">
	var st_timezone = {"timezone_string":""};
	var st_params = {"locale":"vi","text_refresh":"Refresh"};
</script>
{/literal}
<link rel="stylesheet" type="text/css" href="{$URL_JS}/fullcalendar/fullcalendar.min.css" />
    
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment-timezone-with-data-2010-2020.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/date.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/custom.js"></script>
<script type="text/javascript" src="{$URL_THEMES}/hotelpro/jquery.hotelpro.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>
<script type="text/javascript">
	loadCustomField(hotel_id,hotel_room_id,'ADDFACILITY','SiteCustomFieldContaciner');
</script>