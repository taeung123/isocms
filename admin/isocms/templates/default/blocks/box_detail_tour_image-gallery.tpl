<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<h3 class="title_box">{$core->get_Lang('Photo Gallery')}
				{assign var= photo_gallery_tour value='photo_gallery_tour'}
				{if $CHECKHELP eq 1}
				<button data-key="{$photo_gallery_tour}" data-label="{$core->get_Lang('Photo Gallery')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
				{/if}
				</h3>
				<div class="form_option_tour">
					<div class="inpt_tour">
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class="filedrop-picker">
									<div class="filedrop" onclick="file_explorer(this,event);" ondrop="file_drop(this,event)" toId="selectFile" data-options='{ldelim}"openFrom":"gallery","table_id":"{$pvalTable}","clsTableGal":"TourImage"{rdelim}' ondragover="return false">
										<h3>Kéo ảnh vào đây để tải lên</h3>
										<p>Kích thước (WxH=840x480px)<br>
										Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
										<button type="button" class="btn btn-upload">{$core->get_Lang('From computer')}</button>
									</div>
									<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"gallery","clsTableGal":"TourImage","table_id":"{$pvalTable}"{rdelim}' name="image">
									<input style="display:none" type="file" multiple name="image[]" id="ajAttachFile">
									<div class="clearfix mt-half"></div>
									<a table_id="{$pvalTable}" isoman_multiple="1" isoman_callback='isoman_gallery_callback({ldelim}"openFrom":"gallery","clsTableGal":"TourImage","table_id":"{$pvalTable}"{rdelim})' class="btn btn-upload-choice ajOpenDialog" isoman_for_id="image_val" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
								</div>
							</div>
							<div class="col-md-7 col-sm-12">
								<div id="holder_gallery" class="list-unstyled gallery"></div>
							</div>
						</div>
					</div>
					<div class="media-body mb-1 hidden">
						<p class="mb-2">
							<strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
						</p>
						<div class="progress mb-2">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
								 role="progressbar"
								 style="width: 0%"
								 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
							</div>
						</div>
					</div>
				</div>
				<div class="btn_save_titile_trip_code">
					<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="1" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">
					<p class="mb0">{$clsConfiguration->getValue($photo_gallery_tour)|html_entity_decode}</p>
				</div>
			</div>
		</div>
				
				
<script type="text/javascript">
	var table_id = '{$pvalTable}';
	var clsTableGal = 'TourImage';
	
</script>
{literal}
<script type="text/javascript">
	var options_gallery = {
		"openFrom":'gallery',
		"clsTableGal":clsTableGal,
		"table_id":table_id
	};
	$(function () {
		loadGallery(table_id, {"clsTable":clsTableGal});
	});
	function loadGallery($table_id, options){
		var $_adata = options || {};
		$_adata['tp'] = 'L';
		$_adata['table_id'] = table_id;
		$.post(path_ajax_script + '/index.php?mod=home&act=ajOpenGallery', $_adata, function(html){
			$('#holder_gallery').html(html);
			if($("#holder_gallery").find(".gallery-item").length > 0){
				$('#image-gallery').closest('li').removeAttr('class').addClass('check_success');
			}else{
				$('#image-gallery').closest('li').removeAttr('class').addClass('check_caution');
			}
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
{if 1==2}
<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<h3 class="title_box">{$core->get_Lang('Photo Gallery')}</h3>
				<div class="form_option_tour">
					<div class="inpt_tour">
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class="filedrop-picker">
									<div class="filedrop" onclick="file_explorer(this,event);" ondrop="file_drop(this,event)" toId="selectFile" data-options='{ldelim}"openFrom":"gallery","table_id":"{$pvalTable}","clsTableGal":"TourImage"{rdelim}' ondragover="return false">
										<h3>Kéo ảnh vào đây để tải lên</h3>
										<p>Kích thước (WxH=750x500)<br>
										Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
										<button type="button" class="btn btn-upload">{$core->get_Lang('From computer')}</button>
									</div>
									<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"gallery","clsTableGal":"TourImage","table_id":"{$pvalTable}"{rdelim}'>
									<div class="clearfix mt-half"></div>
									<a table_id="{$pvalTable}" isoman_multiple="1" isoman_callback='isoman_gallery_callback({ldelim}"openFrom":"gallery","clsTableGal":"TourImage","table_id":"{$pvalTable}"{rdelim})' class="btn btn-upload-choice ajOpenDialog" isoman_for_id="image_val" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
								</div>
							</div>
							<div class="col-md-7 col-sm-12">
								<div id="holder_gallery" class="list-unstyled gallery"></div>
							</div>
						</div>
					</div>
					<div class="media-body mb-1 hidden">
						<p class="mb-2">
							<strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
						</p>
						<div class="progress mb-2">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
								 role="progressbar"
								 style="width: 0%"
								 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
							</div>
						</div>
					</div>
				</div>
				<div class="btn_save_titile_trip_code">
					<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if $child_cat_menu[j.index_prev] eq ''}{if $list_menu_tour[i.index_prev].cat_menu eq ''}{$child_cat_menu[j]}{/if}{if $list_menu_tour[i.index_prev].cat_menu ne ''}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu[j.index_prev]}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
					<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="skip" present_step="{$child_cat_menu[j]}" next_step="{if $child_cat_menu[j.index_next] eq ''}{if $list_menu_tour[i.index_next].cat_menu eq ''}SaveAll{/if}{if $list_menu_tour[i.index_next].cat_menu ne ''}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu[j.index_next]}{/if}"  class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">
					<p class="mb0">{$core->get_Lang('Photo Gallery')}: {$core->get_Lang('instructionphotogallery')}</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var clsTable = 'Tour';
	var table_id = '{$pvalTable}';
	var clsTableGallery = 'TourImage';
    var count = 1;
    var count_run = 1;
    var rate_progress = 0;
</script>
{literal}
<script type="text/javascript">
	$(function () {
		loadTourGallery($tour_id, {});
	});
	function loadTourGallery($tour_id, options){
		var $_adata = options || {};
		$_adata['tp'] = 'L';
		$_adata['tour_id'] = $tour_id;
		$.post(path_ajax_script + '/index.php?mod=' + mod + '&act=ajOpenTourGalleryTourNew', $_adata, function(html){
			$('#holder_gallery').html(html);
		});
	}
	function isoman_gallery_callback(options){
		var $_adata = options || {},
			$list_images = isoman_selected_files();
		$_adata['tp'] = '_insert';
		$_adata['list_images'] = $list_images;
		$.post(path_ajax_script+'/?mod=cropper&act=upload_gallery', $_adata, function(res){
			loadTourGallery(options.table_id, {});
		});
	}
	function delete_gallery(_this){
		var table_id = $(_this).attr('table_id'),
			image_id = $(_this).attr('tour_image_id');
		$Core.alert.confirm(__['Confirm'], __['Are you sure you want to delete this?'], function(){
			var $_adata = {'table_id':table_id,'clsTable':'TourImage','image_id':image_id};
			$Core.util.toggleIndicatior(1);
			$.post(path_ajax_script+'/index.php?mod=cropper&act=ajDeleteGalImg',$_adata, function(respJson){
				$Core.util.toggleIndicatior(0);
				if(respJson.result.indexOf('success') >= 0){
					loadTourGallery($tour_id, {});
				}
			}, 'json');
		});
	}
</script>
{/literal}
{/if}