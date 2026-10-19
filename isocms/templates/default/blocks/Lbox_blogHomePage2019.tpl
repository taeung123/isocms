{if $lstTopBlog}
<section class="box_home_2019 boxBlogHomePage bg_fff">
	<div class="container">
		<div class="title text_center mb30">
			<p class="color_main_2019 text_upper mb15">{$core->get_Lang('Live now, not later')}!</p>
			<h2 class="h2_title mb10">{$core->get_Lang('title_what_new')}</h2>
			{assign var = SiteBlockTravel_News value = SiteBlockTravel_News_|cat:$_LANG_ID}
			<div class="color_666">{$clsConfiguration->getValue($SiteBlockTravel_News)|html_entity_decode}</div>
		</div>
		<div class="slide_list_blog_home">
			<div class="jcarousel-box owl-carousel" id="TopBlogHome">
				{section name=i loop=$lstTopBlog max=8}
					{assign var=getTitle_Blog value=$clsBlog->getTitle($lstTopBlog[i].blog_id)}
					{assign var=getLink_Blog value=$clsBlog->getLink($lstTopBlog[i].blog_id)}
					{assign var=getImageBlog value=$clsBlog->getImage($lstTopBlog[i].blog_id,265,178)}
					<div class="blogItem">
						<a href="{$getLink_Blog}" tabindex="{$smarty.section.i.index}">
							<img class="owl-lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',263,175)}" data-src="{$clsBlog->getImage($lstTopBlog[i].blog_id,263,175)}" alt="{$getTitle_Blog}"/>
						</a>
						<div class="blog_body">
							<h3><a href="{$getLink_Blog}" title="{$getTitle_Blog}">{$getTitle_Blog}</a></h3>
							<div class="intro">
							{$clsBlog->getIntro($lstTopBlog[i].blog_id)|strip_tags|truncate:65}
							</div>
							<p class="mb0 time_post">{$clsISO->converTimeToText4($clsBlog->getOneField('publish_date',$lstTopBlog[i].blog_id))}</p>
						</div>
					</div>
				{/section}
			</div>
		</div>
	</div>
</section>
{/if}