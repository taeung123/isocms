<form action="" method="post"  enctype="multipart/form-data" class="validate-form" id="frm_addCabin">
	<div class="box_head_cabin">
		<a href="javscript:void(0);" class="back_list btn_back_list_cabin"><i class="fa fa-angle-left"></i></a>
		<p class="title_add_cabin" data-title_add_cabin="{if $cabin_id}{$core->get_Lang('Edit cabin')}{else}{$core->get_Lang('Add new cabin')}{/if}">{if $cabin_id}{$oneCabin.title}{else}{$core->get_Lang('Add new cabin')}{/if}</p>
	</div>
	<div class="box_body_cabin">
		<div class="row">
			<div class="col-md-9">
				<div class="inpt_tour">
					<label for="title">{$core->get_Lang('Name Of Cabin')} <span class="required_red">*</span></label>
					<input class="input_text_form input-title required" id="title_cabin" name="title" value="{$oneCabin.title|default:''}" maxlength="255" type="text" />
				</div>
				<div class="form-group inpt_tour">
					<label for="title">{$core->get_Lang('BedType')} <span class="required_red">*</span></label>
					<div class="admin-toolbar-action">
						<a href="{$PCMS_URL}/?mod=cruise&act=property&type=GroupSize" target="_blank" style="text-decoration: underline">{$core->get_Lang('Change')}</a>
					</div>
					<div>
						<select name="list_group_size[]" id="list_group_size" class="required full-width chosen-select" multiple="multiple" cruise_type="{$oneCruise.cruise_type}">
							{$clsCruiseProperty->getSelectByProperty2('GroupSize',$oneCabin.list_group_size,1,$oneCruise.cruise_type)}
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="d-flex flex-wrap justify-content-center">
					<div class="photobox image">
						{if $_isoman_use eq '1'}
							<img src="{$oneCabin.image|default:''}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneCabin.image|default:''}">
							<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneCabin.image|default:''}" isoman_name="image" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
							{if $oneCabin.image|default:''}
								<a pvalTable="{$pvalTable}" clsTable="CruiseCabin" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
							{/if}
						{else}
							<img src="{$oneCabin.image|default:''}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
							<input type="hidden" name="image_src" value="{$oneCabin.image|default:''}" class="hidden_src" id="imgTour_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
						{/if}
					</div>
					<div class="wrap mt10 boxShowImages">
						<p class="text-center"><strong>{$core->get_Lang('Image Size')} (WxH=204x134)</strong></p>
						<p class="text-center">
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="0" {if $oneCabin.is_show_image|default:0 eq 0}checked{/if} /> OFF
							</label>
							<label>
								<input type="radio" class="margin_0" name="is_show_image" value="1" {if $oneCabin.is_show_image|default:0 eq 1}checked{/if} /> ON
							</label>
						</p>
					</div>
				</div>
			</div>
		</div>				

		<div class="box_info_cabin">
			<ul class="nav nav-tabs nav_tab_reviews" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active"
						id="info-tab"
						data-bs-toggle="tab"
						data-bs-target="#info"
						type="button"
						role="tab">
						{$core->get_Lang('Info cabin')}
					</button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link"
						id="easy_cancel-tab"
						data-bs-toggle="tab"
						data-bs-target="#easy_cancel"
						type="button"
						role="tab">
						{$core->get_Lang('Easy Cancel')}
					</button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link"
						id="CabinFacilities-tab"
						data-bs-toggle="tab"
						data-bs-target="#CabinFacilities"
						type="button"
						role="tab">
						{$core->get_Lang('Cabin Facilities')}
					</button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link"
						id="CabinGallery-tab"
						data-bs-toggle="tab"
						data-bs-target="#CabinGallery"
						type="button"
						role="tab">
						{$core->get_Lang('Photo Gallery')}
					</button>
				</li>
			</ul>
		</div>

		<div class="tab-content" id="myTabContent">

			<!-- Info -->
			<div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
				<div class="row">
					<div class="col-md-3">
						<div class="inpt_tour">
							<label>{$core->get_Lang('Cabin size')}</label>
							<div class="fieldarea span100 relative">
								<input class="text full fontLarge price-In" name="cabin_size"
									value="{$oneCabin.cabin_size|default:''}" type="text">
								<span class="percent">m<sup>2</sup></span>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="inpt_tour">
							<label>{$core->get_Lang('Quantity')}</label>
							<div class="fieldarea span100">
								<input class="text full fontLarge price-In" name="number_cabin"
									value="{$oneCabin.number_cabin|default:0}" type="text">
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="inpt_tour">
							<label>{$core->get_Lang('Floor')}</label>
							<div class="fieldarea span100">
								<input class="text full fontLarge price-In" name="floor"
									value="{$oneCabin.floor|default:''}" type="text">
							</div>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-md-6">
						<div class="inpt_tour">
							<label>{$core->get_Lang('Bed')}</label>
							<div class="fieldarea span100 relative">
								<input class="text full fontLarge" name="bed_size"
									value="{$oneCabin.bed_size|default:''}" type="text">
							</div>
						</div>
					</div>

					<div class="col-md-2">
						<div class="inpt_tour">
							<label>{$core->get_Lang('Ex.Bed')}</label>
							<div class="fieldarea span100">
								<select class="form-select" name="extra_bed">
									<option value="0" {if $oneCabin.extra_bed|default:0 == 0}selected{/if}>
										{$core->get_Lang('No')}
									</option>
									<option value="1" {if $oneCabin.extra_bed|default:0 == 1}selected{/if}>
										{$core->get_Lang('Yes')}
									</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="inpt_tour mt-3">
					<label>{$core->get_Lang('Short text')}</label>
					<textarea class="textarea_intro_editor"
						style="width:100%"
						name="intro"
						table_id="{$pvalTable|default:0}"
						id="textarea_intro_cabin_editor_overview_{$now}"
						data-column="intro"
						rows="3">{$oneCabin.intro|default:''}</textarea>
				</div>
			</div>

			<!-- Easy Cancel -->
			<div class="tab-pane fade" id="easy_cancel" role="tabpanel" aria-labelledby="easy_cancel-tab">
				<div class="inpt_tour">
					<textarea class="textarea_intro_editor"
						style="width:100%"
						name="easy_cancel"
						table_id="{$pvalTable|default:0}"
						id="textarea_easy_cancel_editor_overview_{$now}"
						data-column="easy_cancel"
						rows="3">{$oneCabin.easy_cancel|default:''}</textarea>
				</div>
			</div>

			<!-- Cabin Facilities -->
			<div class="tab-pane fade" id="CabinFacilities" role="tabpanel" aria-labelledby="CabinFacilities-tab">

				<div class="admin-toolbar-action d-flex justify-content-between">
					<a href="{$PCMS_URL}/?mod=cruise&act=property&type=CabinFacilities"
					target="_blank" class="text-decoration-underline">
						{$core->get_Lang('Change')}
					</a>

					<div class="checkall mb-2">
						<label for="all_check">Check/Uncheck All</label>
						<input type="checkbox" rel="CheckCabinFacilities" id="all_check" class="form-check-input ms-1">
					</div>
				</div>

				<div class="row">
					{foreach from=$listCabinFacilities item=facility}
						{assign var=title_cabin_facilities value=$clsCruiseProperty->getTitle($facility.cruise_property_id)}
						<div class="col-md-4 mb-2">
							<label class="lbl_checkbox_cabin_facilities">
								<input class="chkitem CheckCabinFacilities form-check-input" type="checkbox"
									name="listCabinFacilities[]"
									value="{$facility.cruise_property_id}"
									{if $clsISO->checkContainer($oneCabin.list_cabin_facilities|default:'', $facility.cruise_property_id)}checked{/if}>

								<img src="{$clsCruiseProperty->getImage($facility.cruise_property_id,20,20)}"
									onerror="this.src='{$URL_IMAGES}/none_image.png'"
									width="20" height="20" alt="{$title_cabin_facilities}"
									class="img_cabin_facilities mx-1">

								{$title_cabin_facilities}
							</label>
						</div>
					{/foreach}
				</div>
			</div>

			<!-- Gallery -->
			<div class="tab-pane fade" id="CabinGallery" role="tabpanel" aria-labelledby="CabinGallery-tab">
				{assign var=cruise_cabin_id value=$oneCabin.cruise_cabin_id|default:0}

				<div class="form_option_tour">
					<div class="inpt_tour">
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class="filedrop-picker">

									<div class="filedrop"
										onclick="file_explorer(this,event);"
										ondrop="file_drop(this,event)"
										ondragover="return false"
										toId="selectFile"
										data-options='{ldelim}"openFrom":"gallery","table_id":"{$cruise_cabin_id}","clsTableGal":"{$clsTableGal}"{rdelim}'>
										<h3>Kéo ảnh vào đây để tải lên</h3>
										<p>Kích thước (WxH=750x500)<br>Hỗ trợ: .png,.jpg,.jpeg</p>
										<button type="button" class="btn btn-upload">{$core->get_Lang('From computer')}</button>
									</div>

									<input class="d-none" id="selectFile" type="file"
										data-options='{ldelim}"openFrom":"gallery","clsTableGal":"{$clsTableGal}","table_id":"{$cruise_cabin_id}"{rdelim}'
										name="image">

									<input class="d-none" type="file" multiple name="image[]" id="ajAttachFile">

									<a table_id="{$cruise_cabin_id}"
									isoman_multiple="1"
									isoman_callback='isoman_gallery_callback({ldelim}"openFrom":"gallery","clsTableGal":"{$clsTableGal}","table_id":"{$cruise_cabin_id}"{rdelim})'
									class="btn btn-upload-choice ajOpenDialog mt-2"
									isoman_for_id="image_val"
									isoman_name="image">
										{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}
									</a>
								</div>
							</div>

							<div class="col-md-7 col-sm-12">
								<div id="holder_gallery" class="list-unstyled gallery"></div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
	<div class="box_footer_cabin">
		<button type="button" class="btn_back_cabin">{$core->get_Lang('Back')}</button>
		<input type="hidden" name="cabin_id" value="{$cabin_id}">
		<button id="submit_form" type="submit" class="btn_save_cruise_new btn_save_cabin">{$core->get_Lang('Continute')}</button>
	</div>
</form>
<script type="text/javascript">
	var cruise_cabin_id = '{$cruise_cabin_id}';
	var clsTableGal = '{$clsTableGal}';
</script>
{literal}
	<script type="text/javascript">
		var options_gallery = {
			"openFrom":'gallery',
			"clsTableGal":clsTableGal,
			"table_id":cruise_cabin_id
		};
		$(function () {
			loadGallery(cruise_cabin_id, {"clsTable":clsTableGal});
		});
		function loadGallery($table_id, options){
			var $_adata = options || {};
			$_adata['tp'] = 'L';
			$_adata['table_id'] = cruise_cabin_id;
			$.post(path_ajax_script + '/index.php?mod=home&act=ajOpenGallery', $_adata, function(html){
				$('#holder_gallery').html(html);
			});
		}
		function isoman_gallery_callback(options){
			var $_adata = options || {},
					$list_images = isoman_selected_files();
			$_adata['tp'] = '_insert';
			$_adata['list_images'] = $list_images;
			$.post(path_ajax_script+'/?mod=cropper&act=upload_gallery', $_adata, function(res){
				loadGallery(options.table_id, {"clsTable":clsTableGal});
			});
		}
		function delete_gallery(_this){
			var table_id = $(_this).attr('table_id'),
					table_image_id = $(_this).attr('table_image_id');
			$Core.alert.confirm(__['Confirm'], __['Are you sure you want to delete this?'], function(){
				var $_adata = {'table_id':table_id,'clsTable':clsTableGal,'image_id':table_image_id};
				$Core.util.toggleIndicatior(1);
				$.post(path_ajax_script+'/index.php?mod=home&act=ajDeleteGallery',$_adata, function(respJson){
					$Core.util.toggleIndicatior(0);
					if(respJson.result.indexOf('success') >= 0){
						loadGallery(table_id, {"clsTable":clsTableGal});
					}
				}, 'json');
			});
		}
	</script>
{/literal}
