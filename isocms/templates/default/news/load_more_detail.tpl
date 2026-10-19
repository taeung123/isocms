<section data-hash="{$clsNews->getLink($news_id)}" class="section" order_no="{$clsNews->getOneField('order_no',$news_id)}">
	<div class="container">
		{assign var=title_news value=$clsNews->getTitle($news_id)}
		<h1 class="title32 color_333 mb20"><a class="anchor color_333" href="{$clsNews->getLink($news_id)}" title="{$title_news}" url="{$clsNews->getLink($news_id)}">{$title_news}</a></h1>
		<div class="row">
			<div class="col-md-9 col-sm-8 newsLeft mb768_30">
				<article class="NewsContent">
					<div class="submitted"> 
						<i class="fa fa-clock-o" aria-hidden="true"></i> {$clsISO->converTimeToText($clsNews->getOneField('reg_date',$news_id))} 
						<div class="sharethis-buttons mt0">
							<div class="sharethis-wrapper">
								<div class="addthis_toolbox addthis_default_style" addthis:media="{$DOMAIN_NAME}{$clsNews->getImage($news_id,400,300)}"  addthis:url="{$DOMAIN_NAME}{$clsNews->getLink($news_id)}" addthis:title="{$title_news}">
									<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
									<a class="addthis_button_tweet"></a>
									<a class="addthis_button_pinterest_pinit"></a>
									<a class="addthis_counter addthis_pill_style"></a>
								</div>
								<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=thiembv"></script>
							</div>
						</div>
					</div>
					<div class="content">
						<div class="field-items maxWidthImage tinymce_Content">
							{$clsNews->getIntro($news_id)}
							<div class="clearfix"></div>
							{$clsNews->getContent($news_id)}
						</div>
					</div>
					<div class="cleafix"></div>
					<div class="sharethis-bottom"  style="display:none !important">
						<div class="sharethis-buttons">
							<div class="sharethis-wrapper">
								<div class="addthis_toolbox addthis_default_style" addthis:url="{$DOMAIN_NAME}{$clsNews->getLink($news_id)}" addthis:title="{$title_news}">
								<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
								<a class="addthis_button_tweet"></a>
								<a class="addthis_button_pinterest_pinit"></a>
								<a class="addthis_counter addthis_pill_style"></a>
							</div>
							<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=thiembv"></script>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>
 {literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ajaxComplete(function () {
			try {
				FB.XFBML.parse();
			} catch (ex) { }
		});
	})
</script>
{/literal}