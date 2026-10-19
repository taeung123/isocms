<link rel="stylesheet" href="{$URL_CSS}/chosen.css" type="text/css" media="all">
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript">
	var hotel_review_id = '{$pvalTable}';
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
						<input class="text full" id="title" name="iso-name" value="{$oneItem.name}" maxlength="255" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Day Stay')}* </strong></div>
					<div class="fieldarea">
						<input class="text full" id="title" name="iso-date_stay" value="{$oneItem.date_stay}" maxlength="255" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Title')}* </strong></div>
					<div class="fieldarea">
						<input class="text full" id="title" name="iso-title" value="{$oneItem.title}" maxlength="255" type="text" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('point review')}*</strong></div>
					<div class="fieldarea">
					{*<label class="radio inline"><input type="radio" name="point" {if $oneItem.point eq '0' or $pvalTable eq '0'}checked="checked"{/if} value="0"> {$core->get_Lang('Un Point')}</label>*} 
					{section name=point start=1 loop=11 step=1}
					<label class="radio inline"><input type="radio" name="point" {if $oneItem.point eq $smarty.section.point.index}checked="checked"{/if} value="{$smarty.section.point.index}">{$smarty.section.point.index} {$core->get_Lang('point')}</label>
					{/section}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Description')}* </strong></div>
					<div class="fieldarea">
						<textarea id="textarea_content_editor{$now}" rows="2" class="textarea_content_editor" name="iso-intro" style="width:99%">{$clsClassTable->getIntro($pvalTable)}</textarea>
					</div>
				</div>
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
<script type="text/javascript" src="{$URL_THEMES}/hotelpro/jquery.hotelpro.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>
