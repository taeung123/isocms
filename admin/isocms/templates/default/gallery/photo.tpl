<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('gallery')}</a>
	<a>&raquo;</a>
    <a>{$clsClassTable->getTitle($pvalTable)}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
	<div class="page-title">
		<h2>{$core->get_Lang('gallery')} &raquo; {$clsClassTable->getTitle($pvalTable)}</h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
	</div>
	<div class="infobox">
		<b>Hướng dẫn</b><br />
		Mỗi thư mục ảnh sẽ có nhiều ảnh. Để đảm bảo hệ thống chạy tốt nên upload các hỉnh ảnh có kích thước vừa phải<br /><br />
		1) Click vào tải thêm ảnh<br />
		2) Chọn ảnh cần uploads<br />
		3) Click đồng bộ hóa để reset lại như vị trí ban đầu
	</div>
	<div id="galleryHolder">
	</div>
</div>
<script type="text/javascript">
	var $table_id = '{$pvalTable}';
	var $type = 'Gallery';
</script>
{literal}
<script type="text/javascript">
	$(function(){
		initGalleryModPage($table_id, $type, 'galleryHolder');
	});
	function initGalleryModPage($table_id, $type, $container){
		var adata = {'table_id'	: $table_id,'type'	: $type};
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod=gallery&act=ajaxInitPhotosGallery",
			data: adata,
			dataType: "html",
			cache: true,
			success: function(html){
				$('#'+$container).html(html);
				loadGalleryModPage($table_id,$type,'',1);
			}
		});
	}
	function loadGalleryModPage($table_id, $type, $keyword, $page){
		var adata = {
			'table_id'	: $table_id,
			'keyword'	: $keyword,
			'type'	: $type,
			'page'	: $page,
		};
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod=gallery&act=ajLoadPhotosGallery&lang="+LANG,
			data: adata,
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				var $htm = html.split('$$$');
				$('#preview').html($htm[0]);
				if($.trim($htm[1]) != ''){
					$('#gallery_paginate').height(24).html($htm[1]);
				}
			}
		});
	}
</script>
{/literal}