{if $lstPartner}
<link rel="preload" href="{$URL_JS}/jquery.partner.js?v={$upd_version}" as="script">
<section class="section_box partner__box press__news bg_fff">
	<div class="box_Partner">
        <div class="partner__box--header header__content">
            {assign var = TitlePressNews value = TitlePressNews_|cat:$_LANG_ID}
            {assign var = IntroPressNews value = IntroPressNews_|cat:$_LANG_ID}
            <h2 class="section_box-title">{$clsConfiguration->getValue($TitlePressNews)}</h2>
            {if $IntroPressNews}
            <div class="section_box-intro">
                {$clsConfiguration->getValue($IntroPressNews)|html_entity_decode}
            </div>
            {/if}
        </div>
        <div class="container">
			<div id="boxPress" class="boxPress">
				<div class="slideMain" style="height:85px">
					<ul class="slide1" style="height:85px;padding:0">
						<li>
							{section name=i loop=$lstPartner}
							{assign var=title value=$lstPartner[i].title}
							<div class="item">
								<a href="{$lstPartner[i].url}" title="{$lstPartner[i].url}" target="_blank">
									<img title="{$title}" src="{$clsPartner->getUrlImage($lstPartner[i].partner_id,$lstPartner[i])}" height="auto" width="auto"/>
								</a>
							</div>
							{/section}
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script src="{$URL_JS}/jquery.partner.js?v={$upd_version}"></script>
	<script type="text/javascript">
		var $width_slide_panner = '{$width_slide_panner}';
	</script>
    {literal}
	<style type="text/css">
		.box_Partner{background:#fff;width: 100%; overflow: hidden}
		.box_Partner h3{font-size:27px;border-top:1px solid #ccc; width:100%;max-width:1060px;margin: 0 auto;padding-top:30px}
		.boxPress{width:100%; max-width:950px;overflow:hidden;position:relative;margin:0 auto;height:85px;overflow:hidden;display:block}
		.boxPress li{list-style:none;height:85px}
		.boxPress ul{margin:0}
		.boxPress li .item{width:131px;height:85px;display:inline-block;text-align:center;padding:10px;margin-right:10px;vertical-align:top;float:left;position:relative}
		.boxPress li .item img{display:inline-block;max-width:100%;margin:auto;position:absolute;z-index:1;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-khtml-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);-o-transform:translate(-50%,-50%);transform:translate(-50%,-50%);max-height:100%}
		.boxPress .mainPartner{width:100%;height:130px;overflow:hidden;border:0}
		.boxPress .mainPartner li{height:128px;display:inline-block;float:left}
		@media screen and (max-width: 600px) {
			.box_Partner h3 {font-size: 21px;}
		}
	</style>
	<script type="text/javascript">
		$(function(){
			var $ww = $(window).width();
			$('#boxPress .slide1').width($width_slide_panner);
			$('#boxPress .slide2').width($width_slide_panner);
			$("#boxPress").rotate({
				speed : 20
			});
		});
	</script>
    {/literal}
</section>
{/if}