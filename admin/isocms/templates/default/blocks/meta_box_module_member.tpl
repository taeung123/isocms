<div class="box_title_trip_code" meta_id="{$meta_id}">
	<div class="row d-flex full-height">
		<div class="col-md-12">
			<div class="fill_data_box">
				<h3 class="title_box">{$core->get_Lang('seosdvanced')}</h3>
				<div class="form_option_tour">
					<div class="form-group">
						<label class="col-form-label" for="config_value_title">{$core->get_Lang('Meta Title')} <span class="required_red">*</span></label>
						<input class="form-control required" name="config_value_title" id="config_value_title" onkeyup="countCharTitle(this)" value="{$clsMeta->getMetaTitle($meta_id)}" maxlength="255" type="text">
						<span class="help-block">{$core->get_Lang('The meta title of your page has a length of')} <strong id="charTitleNum">{$clsISO->getCountMetaWord($clsMeta->getMetaTitle($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta titles to 70 characters')}.</span>
					</div>
					<div class="form-group">
						<label class="col-form-label" for="config_value_intro">{$core->get_Lang('Meta Description')} <span class="required_red">*</span></label>
						<textarea name="config_value_intro" id="config_value_intro" class="form-control required" onkeyup="countCharDes(this)">{$clsMeta->getMetaDescription($meta_id)}</textarea>
						<span class="help-block">{$core->get_Lang('The meta description of your page has a length of')} <strong id="charDesNum">{$clsISO->getCountMetaWord($clsMeta->getMetaDescription($meta_id))}</strong> {$core->get_Lang('characters')}. {$core->get_Lang('Most search engines will truncate meta descriptions to 160 characters')}.</span>
					</div>
					<div class="form-group">
						<label class="col-form-label" for="config_value_intro">{$core->get_Lang('Meta Index')} <span class="required_red">*</span></label>
						<table>
							<tr>
								<td>{$core->get_Lang('Meta Robots Index')}: </td>
								<td>
									<select name="meta_index">
										<option value="0">{$core->get_Lang('Index')}</option>
										<option value="1" {if $oneMeta.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
									</select>
								</td>
								<td>{$core->get_Lang('Meta Robots Follow')}: </td>
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