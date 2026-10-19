<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Meta Tags')}">{$core->get_Lang('Meta Tags')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable eq 0}{$core->get_Lang('Add New Meta Tags')}{else}{$core->get_Lang('Edit Meta Tags')}{/if}</h2>
		<p>{$core->get_Lang('Tool management & custom meta your system')}.</p>
    </div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<div class="row-field">
        	<div class="row-heading">{$core->get_Lang('Link')}*</div>
			<div class="coltrols">
			{$DOMAIN_NAME}<input class="text required full_width_767" name="config_link" value="{$clsClassTable->getOneField('config_link',$pvalTable)}" maxlength="255" type="text" style="width:calc(100% - 250px);">
			</div>
		</div>
		<div class="row-field">
        	<div class="row-heading">{$core->get_Lang('Meta Title')}*</div>
			<div class="coltrols">
				<div class="mb10">{$core->get_Lang('The meta title of your page has a length of')} <strong id="charTitleNum">{$number_word_title}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta titles to 70 characters')}.</div>
				<input class="text full fontLarge required" name="config_value_title" value="{$clsClassTable->getOneField('config_value_title',$pvalTable)}"  onkeyup="countCharTitle(this)" maxlength="255" type="text">
			</div>
		</div>
		<div class="row-field">
        	<div class="row-heading">{$core->get_Lang('Meta Description')}*</div>
			<div class="coltrols">
				<div class="mb10">{$core->get_Lang('The meta description of your page has a length of')} <strong id="charDesNum">{$number_word_description}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta descriptions to 160 characters')}.</div>
				<textarea name="iso-config_value_intro" class="text full required"  onkeyup="countCharDes(this)" style="height:70px">{$clsClassTable->getOneField('config_value_intro',$pvalTable)}</textarea>
			</div>
		</div>
		<div class="row-field">
        	<div class="row-heading">{$core->get_Lang('Image Share Social')}* (Width X Height: 500x261)</div>
			<div class="coltrols">
				<div class="photobox photobox_share image" style="width:300px; height:160px; ">
					{if $_isoman_use eq '1'}
					<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
					<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
					<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
					{if $oneItem.image}
					<a pvalTable="{$pvalTable}" clsTable="Meta" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
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
		</div>
		<div class="row-field">
        	<div class="row-heading">{$core->get_Lang('Meta Index')}*</div>
			<div class="coltrols">
				<table>
					<tr>
						<td style="background:#CCC">{$core->get_Lang('Meta Robots Index')}</td>
						<td>
							<select name="iso-meta_index">
								<option value="0">{$core->get_Lang('Index')}</option>
								<option value="1" {if $oneItem.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
							</select>
						</td>
						<td style="background:#CCC">{$core->get_Lang('Meta Robots Follow')}</td>
						<td>
							<select name="iso-meta_follow">
								<option value="0">{$core->get_Lang('Follow')}</option>
								<option value="1" {if $oneItem.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
							</select>
						</td>
					</tr>
				</table>
			</div>
		</div>

		{$core->getBlock('meta_schema')}
		
		<div class="google_search_view">
			<div class="title_box">Google Search Demo</div>
			<div class="g">
				<div class="rc" data-hveid="CAMQAA" data-ved="2ahUKEwimtvGyhrfoAhUUVN4KHUjdAt8QFSgAMAJ6BAgDEAA">
					<div class="r">
						<a href="{$clsClassTable->getConfigLink($pvalTable)}" onMouseDown="return rwt(this,'','','','3','AOvVaw2TCr7DGKKcv5xJhzEckMqH','','2ahUKEwimtvGyhrfoAhUUVN4KHUjdAt8QFjACegQIAxAB','','',event)">
							<br>
							<h3 class="LC20lb DKV0Md">{$clsClassTable->getMetaTitle($pvalTable)}</h3>
							<div class="TbwUpd NJjxre"><cite class="iUh30 bc tjvcx">{$host} {$clsClassTable->getConfigLinkViewGoogleSearch($pvalTable)}</cite></div>
						</a>
						<div class="B6fmyf">
							<div class="TbwUpd"><cite class="iUh30 bc tjvcx">{$host} {$clsClassTable->getConfigLinkViewGoogleSearch($pvalTable)}</cite></div>
						</div>
					</div>
					<div class="s">
						<div>{$clsClassTable->getMetaDescription($pvalTable)}</div>
					</div>
				</div>
			</div>
		</div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}{$resetBtn}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script>
	var domain_name="{$DOMAIN_NAME}";
</script>
{literal}

<style type="text/css">
.google_search_view {display:inline-block; width:100%; margin-top:30px;}
.google_search_view .title_box{color:#333; font-size:21px; margin-bottom:15px;}
.google_search_view .g {
    margin-top: 0;
    margin-bottom: 27px;
	font-size: 14px;
	line-height: 1.2;
    text-align: left;
    width: 600px;
}
.google_search_view .rc {
    position: relative;
	line-height: 1.58;
	font-size: small;
	font-weight: normal;
    margin: 0;
}
.google_search_view a{
    text-decoration: none;
}
.google_search_view a:hover{text-decoration:underline}
a:link, .q:active, .q:visited {
    cursor: pointer;
}
.google_search_view h3{
    font-size: 20px;
    line-height: 1.3;
	color:#1a0dab;
	font-weight:normal;
}
.google_search_view h3:hover{text-decoration:underline}
.google_search_view .DKV0Md {
    padding-top: 4px;
}
.google_search_view .LC20lb {
    display: inline-block;
    line-height: 1.3;
    margin-bottom: 3px;
}
.google_search_view .NJjxre {
    position: absolute;
    left: 0;
    top: 0;
}
.google_search_view .TbwUpd {
    padding-bottom: 1px;
    padding-top: 1px;
    -webkit-text-size-adjust: none;
}
.google_search_view .TbwUpd {
    line-height: 1.58;
	display: inline-block;
}

.google_search_view .iUh30 {
    font-size: 14px;
    padding-top: 1px;
    line-height: 1.3;
}
.google_search_view cite{
    color: #3C4043;
    font-style: normal;
}
.google_search_view .B6fmyf {
    position: absolute;
    top: 0;
    height: 0;
    visibility: hidden;
    white-space: nowrap;
}
.google_search_view .rc .s {
	color: #3C4043;
	font-size:14px;
    line-height: 1.58;
}
</style>
<script>
function countCharTitle(val) {
	var len = val.value.length;
	$('#charTitleNum').text(len);
};
function countCharDes(val) {
	var len = val.value.length;
	$('#charDesNum').text(len);
};
$('input[name=config_link]').bind('blur change click',function(){
	var config_link=$(this).val();
	var regex=domain_name;
	if(config_link.match(regex)){
		var link_config=config_link.replace(regex,'');
		$(this).val(link_config);
	}
});
</script>
{/literal}