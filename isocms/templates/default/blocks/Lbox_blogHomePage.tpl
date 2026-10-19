{if $lstTopBlog}
	<section class="travel__inspiration bg_fff">
		<div class="travel__inspiration--header header__content">
			{assign var = TitleTravelInspiration value = TitleTravelInspiration_|cat:$_LANG_ID}
			{assign var = IntroTravelInspiration value = IntroTravelInspiration_|cat:$_LANG_ID}
			<div class="container">
				<h2 class="section_box-title">{$clsConfiguration->getValue($TitleTravelInspiration)}</h2>
				<div class="section_box-intro">
					{$clsConfiguration->getValue($IntroTravelInspiration)|html_entity_decode}
				</div>
			</div>
		</div>
		<div class="travel__inspiration--content">
			<div class="container">
				<div class="row box_col" id="list__blog">
					{section name=i loop=$lstTopBlog}
					{assign var=getTitle_Blog value=$clsBlog->getTitle($lstTopBlog[i].blog_id,$lstTopBlog[i])}
					{assign var=getLink_Blog value=$clsBlog->getLink($lstTopBlog[i].blog_id,$lstTopBlog[i])}
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="box">
							<a href="{$getLink_Blog}" title="{$getTitle_Blog}" class="item">
								<div class="box_img">
									<img class="lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',296,184)}" data-src="{$clsBlog->getImage($lstTopBlog[i].blog_id,296,184,$lstTopBlog[i])}" width="296" height="184" alt="{$getTitle_Blog}"/>
								</div>
								<div class="blog_body">
									<h3 class="limit_2line size18 color_1c1c1c">{$getTitle_Blog}</h3>
									<time class="time">{$clsISO->converTimeToText4($lstTopBlog[i].publish_date)}</time>
									<div class="intro color_333 limit_3line">
										{$clsBlog->getIntro($lstTopBlog[i].blog_id,$lstTopBlog[i])|strip_tags}
									</div>
								</div>
							</a>
						</div>
					</div>
					{/section}
				</div>
				<div class="view_more mt30">
					<a href="{$clsISO->getLink('blog')}" page="1" rel="nofollow" class="show-loader btn_view_more btn_main" id="__show-more-blog" title="{$core->get_Lang('View more')}">{$core->get_Lang('View more')}</a>
				</div>
			</div>
		</div>
	</section>
{/if}