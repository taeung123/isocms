<form id="forums" method="post" action="">
	<div class="wrap">
		<div class="fl col_Left">
			<div class="row-field">
				<div class="row-heading">{$core->get_Lang('Meta Image')}* <span class="size12">(W X H: 500x261)</span></div>
				<div class="coltrols">
					<div class="photobox photobox_share image" style="width:200px; height:200px; ">
						{if $_isoman_use eq '1'}
						<img src="{$oneMeta.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image_seo" />
						<input type="hidden" id="isoman_hidden_image_seo" name="isoman_url_image_seo" value="{$oneMeta.image}" />
						<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_seo" isoman_val="{$oneMeta.image}" isoman_name="image_seo"><i class="iso-edit"></i></a>
						{if $oneMeta.image}
						<a pvalTable="{$pvalTable}" clsTable="Meta" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImageHtml" data-name_input="isoman_url_image_seo" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
						{/if}
						{else}
						<img src="{$oneMeta.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
						<input type="hidden" name="image_src" value="{$oneMeta.image}" class="hidden_src" id="imgTour_hidden" />
						<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
							<i class="iso-edit"></i>
						</a> 
						<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
						{/if}
					</div>
				</div>
			</div>
		</div>
		<div class="fr col_Right">
			<div class="row-field">
				<div class="row-heading">{$core->get_Lang('Meta Title')}*</div>
				<div class="coltrols">
					<div class="mb10">{$core->get_Lang('The meta title of your page has a length of')} <strong id="charTitleNum">{$number_word_title}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta titles to 70 characters')}.</div>
					<input class="text full fontLarge required" name="config_value_title"  onkeyup="countCharTitle(this)" value="{$clsMeta->getOneField('config_value_title',$meta_id)}" maxlength="255" type="text">
				</div>
			</div>
			<div class="row-field">
				<div class="row-heading">{$core->get_Lang('Meta Description')}*</div>
				<div class="coltrols">
					<div class="mb10">{$core->get_Lang('The meta description of your page has a length of')} <strong id="charDesNum">{$number_word_description}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta descriptions to 160 characters')}.</div>
					<textarea name="config_value_intro" class="text full required"  onkeyup="countCharDes(this)" style="height:70px">{$clsMeta->getOneField('config_value_intro',$meta_id)}</textarea>
				</div>
			</div>
			<div class="row-field">
				<div class="row-heading">{$core->get_Lang('Meta Index')}*</div>
				<div class="coltrols">
					<table>
						<tr>
							<td style="background:#CCC">{$core->get_Lang('Meta Robots Index')}</td>
							<td>
								<select name="meta_index">
									<option value="0">{$core->get_Lang('Index')}</option>
									<option value="1" {if $oneMeta.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
								</select>
							</td>
							<td style="background:#CCC">{$core->get_Lang('Meta Robots Follow')}</td>
							<td>
								<select name="meta_follow">
									<option value="0">{$core->get_Lang('Follow')}</option>
									<option value="1" {if $oneMeta.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="google_search_view">
		<div class="title_box">Google Search Demo</div>
		<div class="g">
			<div class="rc" data-hveid="CAMQAA" data-ved="2ahUKEwimtvGyhrfoAhUUVN4KHUjdAt8QFSgAMAJ6BAgDEAA">
				<div class="r">
					<a href="{$clsMeta->getConfigLink($meta_id)}" onMouseDown="return rwt(this,'','','','3','AOvVaw2TCr7DGKKcv5xJhzEckMqH','','2ahUKEwimtvGyhrfoAhUUVN4KHUjdAt8QFjACegQIAxAB','','',event)">
						<br>
						<h3 class="LC20lb DKV0Md">{$clsMeta->getMetaTitle($meta_id)}</h3>
						<div class="TbwUpd NJjxre"><cite class="iUh30 bc tjvcx">{$host} {$clsMeta->getConfigLinkViewGoogleSearch($meta_id)}</cite></div>
					</a>
					<div class="B6fmyf">
						<div class="TbwUpd"><cite class="iUh30 bc tjvcx">{$host} {$clsMeta->getConfigLinkViewGoogleSearch($meta_id)}</cite></div>
					</div>
				</div>
				<div class="s">
					<div>{$clsMeta->getMetaDescription($meta_id)}</div>
				</div>
			</div>
		</div>
	</div>
	<fieldset class="submit-buttons">
        {$saveBtn}
        <input value="UpdateMeta" name="submitMeta" type="hidden">
    </fieldset>
</form>
{literal}
<script type="text/javascript">
function countCharTitle(val) {
	var len = val.value.length;
	$('#charTitleNum').text(len);
};
function countCharDes(val) {
	var len = val.value.length;
	$('#charDesNum').text(len);
};
</script>
{/literal}