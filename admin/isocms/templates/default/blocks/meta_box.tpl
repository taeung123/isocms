{if $pvalTable}
<div class="meta_box">
    <div class="row-field">
        <div class="row-heading">{$core->get_Lang('Meta Title')}*:</div>
        <div class="coltrols">
			<div class="mb10">{$core->get_Lang('The meta title of your page has a length of')} <strong id="charTitleNum">{$clsISO->getCountMetaWord($clsISO->getPageTitle($pvalTable,$clsClassTable))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta titles to 70 characters')}.</div>
            <input class="text full" name="config_value_title"  onkeyup="countCharTitle(this)" value="{$clsISO->getPageTitle($pvalTable,$clsClassTable)}" maxlength="255" type="text">
            <div class="clearfix mt5"></div>
        </div>
    </div>
    <div class="row-field">
        <div class="row-heading">{$core->get_Lang('Meta Description')}*:</div>
        <div class="coltrols">
			<div class="mb10">{$core->get_Lang('The meta description of your page has a length of')} <strong id="charDesNum">{$clsISO->getCountMetaWord($clsISO->getPageDescription($pvalTable,$clsClassTable))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta descriptions to 160 characters')}.</div>
            <textarea name="config_value_intro" class="text full"  onkeyup="countCharDes(this)" style="height:60px">{$clsISO->getPageDescription($pvalTable,$clsClassTable)}</textarea>
            <div class="clearfix mt5"></div>
			<br style="clear:both" />
			<br style="clear:both" />
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
    {*<div class="row-field">
        <div class="row-heading">{$core->get_Lang('Meta Keyword')}:</div>
        <div class="coltrols">
            <textarea name="config_value_keyword" class="text full required" style="height:60px">{$clsMeta->getMetaKeyword($meta_id)}</textarea>
            <div class="clearfix mt5"></div>
           <i>{$core->get_Lang('notekeywordmeta')}</i>
        </div>
    </div>*}
	<div class="google_search_view">
		<div class="title_box">Google Search Demo</div>
		{if $meta_id gt 0}
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
		{else}
		<div class="g">
			<div class="rc" data-hveid="CAMQAA" data-ved="2ahUKEwimtvGyhrfoAhUUVN4KHUjdAt8QFSgAMAJ6BAgDEAA">
				<div class="r">
					<a href="{$clsClassTable->getLink($pvalTable)}" onMouseDown="return rwt(this,'','','','3','AOvVaw2TCr7DGKKcv5xJhzEckMqH','','2ahUKEwimtvGyhrfoAhUUVN4KHUjdAt8QFjACegQIAxAB','','',event)">
						<br>
						<h3 class="LC20lb DKV0Md">{$clsISO->getPageTitle($pvalTable,$clsClassTable)}</h3>
						<div class="TbwUpd NJjxre"><cite class="iUh30 bc tjvcx">{$host} {$clsISO->getConfigLinkViewGoogleSearch($pvalTable,$clsClassTable)}</cite></div>
					</a>
					<div class="B6fmyf">
						<div class="TbwUpd"><cite class="iUh30 bc tjvcx">{$host} {$clsISO->getConfigLinkViewGoogleSearch($pvalTable,$clsClassTable)}</cite></div>
					</div>
				</div>
				<div class="s">
					<div>{$clsISO->getPageDescription($pvalTable,$clsClassTable)}</div>
				</div>
			</div>
		</div>
		{/if}
	</div>
</div>
{else}
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
{*
<div class="row-field">
	<div class="row-heading">{$core->get_Lang('Meta Keyword')}*</div>
	<div class="coltrols">
		<div class="mb10">{$core->get_Lang('notekeywordmeta')}</div>
		<textarea name="iso-config_value_keyword" class="text full required" style="height:70px">{$clsMeta->getOneField('config_value_keyword',$meta_id)}</textarea>
	</div>
</div>*}
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
{/if}
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