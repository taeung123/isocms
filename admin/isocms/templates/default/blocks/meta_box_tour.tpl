<div class="meta_box">
    <div class="row-field">
        <div class="row-heading">{$core->get_Lang('Meta Title')}*:</div>
        <div class="coltrols">
			<div class="mb10">{$core->get_Lang('The meta title of your page has a length of')} <strong id="charTitleNum">{$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta titles to 70 characters')}.</div>
            <input class="text full required" name="config_value_title"  onkeyup="countCharTitle(this)" value="{$clsMeta->getMetaTitle($meta_id)}" maxlength="255" type="text">
            <div class="clearfix mt5"></div>
        </div>
    </div>
    <div class="row-field">
        <div class="row-heading">{$core->get_Lang('Meta Description')}*:</div>
        <div class="coltrols">
			<div class="mb10">{$core->get_Lang('The meta description of your page has a length of')} <strong id="charDesNum">{$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta descriptions to 160 characters')}.</div>
            <textarea name="config_value_intro" class="text full required"  onkeyup="countCharDes(this)" style="height:60px">{$clsMeta->getMetaDescription($meta_id)}</textarea>
        </div>
    </div>
	<div class="row-field">
		<div class="row-heading">{$core->get_Lang('Image Share Social')}* (Width X Height: 500x261)</div>
		<div class="coltrols">
			<div class="photobox photobox_share image" style="width:200px; height:200px; ">
				{if $_isoman_use eq '1'}
				<img src="{$clsMeta->getOneField('image',$meta_id)}" alt="{$core->get_Lang('images')}" id="isoman_show_image_seo" />
				<input type="hidden" id="isoman_hidden_image_seo" name="isoman_url_image_seo" value="{$clsMeta->getOneField('image',$meta_id)}" />
				<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_seo" isoman_val="{$clsMeta->getOneField('image',$meta_id)}" isoman_name="image_seo"><i class="iso-edit"></i></a>
				{if $clsMeta->getOneField('image',$meta_id)}
				<a pvalTable="{$pvalTable}" clsTable="Meta" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
				{/if}
				{else}
				<img src="{$clsMeta->getOneField('image',$meta_id)}" alt="{$core->get_Lang('noimages')}" id="imgTour_image_seo" />
				<input type="hidden" name="image_seo_src" value="{$clsMeta->getOneField('image',$meta_id)}" class="hidden_src" id="imgTour_hidden" />
				<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
					<i class="iso-edit"></i>
				</a> 
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