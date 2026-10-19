{if $lstTopBlog}
	<section class="travel__inspiration bg_fff">
		<div class="container">
			<div class="travel__inspiration--header header__content">
				{assign var = TitleTravelInspiration value = TitleTravelInspiration_|cat:$_LANG_ID}
				{assign var = IntroTravelInspiration value = IntroTravelInspiration_|cat:$_LANG_ID}
				<div class="container plr_mb-20">
					<h2 class="section_box-title">{$clsConfiguration->getValue($TitleTravelInspiration)}</h2>
					<div class="section_box-intro">
						{$clsConfiguration->getValue($IntroTravelInspiration)|html_entity_decode}
					</div>
				</div>
			</div>
			<div class="travel__inspiration--content">
				<div class="container plr_mb-20">
					<div class="row box_col  owl-carousel" id="list__blog">
						{section name=i loop=$lstTopBlog}
						{assign var=getTitle_Blog value=$lstTopBlog[i].title}
						{assign var=getLink_Blog value=$clsBlog->getLink($lstTopBlog[i].blog_id,$lstTopBlog[i])}
							<div class="box mb20">
								<a href="{$getLink_Blog}" title="{$getTitle_Blog}" class="item">
									<img class="lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',3,2)}" data-src="{$clsBlog->getImage($lstTopBlog[i].blog_id,295,185,$lstTopBlog[i])}" width="295" height="185" alt="{$getTitle_Blog}"/>
									<div class="blog_body">
										<h3 class="limit_2line">{$getTitle_Blog}</h3>
										<time class="time">{$clsISO->converTimeToText4($lstTopBlog[i].publish_date)}</time>
										<div class="intro limit_3line">
											{$lstTopBlog[i].intro|html_entity_decode|strip_tags}
										</div>
									</div>
								</a>
							</div>
						{/section}
					</div>
				</div>
			</div>
		</div>
	</section>
	
	{literal}
	<script>
		$(function(){
			$('#list__blog').owlCarousel({
				loop:true,
				responsiveClass:true,
				dots:false,
				responsive:{
					0:{
						items:2,
						nav:true,
						center: true,
						margin:14,
					},
					600:{
						items:2,
						nav:false,
						center: true,
						margin:20,
					},
					1000:{
						items:4,
						nav:true,
						loop:false,
						margin:30,
					}
				}
			})
		});
	</script>
	{/literal}
{/if}