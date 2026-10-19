<h3 class="title_box">{$core->get_Lang('Photo Gallery')}
{assign var= photo_gallery_voucher value='photo_gallery_voucher'}
{assign var= help_first value=$photo_gallery_voucher}
{if $CHECKHELP eq 1}
<button data-key="{$photo_gallery_voucher}" data-label="{$core->get_Lang('Photo Gallery')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
{/if}
</h3>
<div class="form_option_tour">
	<div class="inpt_tour">
		<div class="row">
			<div class="col-md-5 col-sm-12">
				<div class="filedrop-picker">
					<div class="filedrop" onclick="file_explorer(this,event);" ondrop="file_drop(this,event)" toId="selectFile" data-options='{ldelim}"openFrom":"gallery","table_id":"{$pvalTable}","clsTableGal":"Voucher"{rdelim}' ondragover="return false">
						<h3>Kéo ảnh vào đây để tải lên</h3>
						<p>Kích thước (WxH=714x467)<br>
						Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
						<button type="button" class="btn btn-upload">{$core->get_Lang('From computer')}</button>
					</div>
					<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"openFrom":"gallery","clsTableGal":"Voucher","table_id":"{$pvalTable}"{rdelim}' name="image">
					<input style="display:none" type="file" multiple name="image[]" id="ajAttachFile">
					<div class="clearfix mt-half"></div>
					<a table_id="{$pvalTable}" isoman_multiple="1" isoman_callback='isoman_gallery_callback({ldelim}"openFrom":"gallery","clsTableGal":"Voucher","table_id":"{$pvalTable}"{rdelim})' class="btn btn-upload-choice ajOpenDialog" isoman_for_id="image_val" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
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
				
				
<script type="text/javascript">
	var table_id = '{$pvalTable}';
	var clsTableGal = 'Voucher';
	
</script>
{literal}
<style>
	.gallery {grid-template-columns: repeat(3, 1fr) !important}
	.fill_data_box input {width: 100%;margin-top: 3px}
</style>
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
		$.post(path_ajax_script + '/index.php?mod=voucher&act=ajOpenGallery', $_adata, function(html){
			$('#holder_gallery').html(html);
		});
	}
	function isoman_gallery_callback(options){
		var $_adata = options || {},
			$list_images = isoman_selected_files();
		$_adata['tp'] = '_insert';
		$_adata['list_images'] = $list_images;
		$.post(path_ajax_script+'/?mod=voucher&act=upload_gallery', $_adata, function(res){
			loadGallery(options.table_id, {"clsTable":clsTableGal});
		});
	}
	function delete_gallery(_this){
		var table_id = $(_this).attr('table_id'),
			table_image_id = $(_this).attr('table_image_id');
		$Core.alert.confirm(__['Confirm'], __['Are you sure you want to delete this?'], function(){
			var $_adata = {'table_id':table_id,'clsTable':clsTableGal,'image_id':table_image_id};
			$Core.util.toggleIndicatior(1);
			$.post(path_ajax_script+'/index.php?mod=voucher&act=ajDeleteGallery',$_adata, function(respJson){
				$Core.util.toggleIndicatior(0);
				if(respJson.result.indexOf('success') >= 0){
					loadGallery(table_id, {"clsTable":clsTableGal});
				}
			}, 'json');
		});
	}
	
	function changeTitleGallery(e){
		var value = $(e).attr('value');
		var data = $(e).attr('data');
		var table_id = $(e).attr('table_id');
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod='+mod+'&act=ajaxChangeTitleGallery',
			data:{value : value,data:data,table_id:table_id,clsTable:clsTableGal},
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				loadGallery(table_id, {"clsTable":clsTableGal});
			}
		});
		return false;
	}
</script>
{/literal}