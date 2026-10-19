{assign var=TD value=''}

{if $show eq 'Country' && $country_id|default:0 gt 0}
    {assign var=TD value=$clsCountryEx->getTitle($country_id,$oneItemCountry|default:array())}

{elseif $show eq 'City' && $city_id|default:0 gt 0}
    {assign var=TD value=$clsCity->getTitle($city_id,$oneItemCity|default:array())}

{elseif $show eq 'Region' && $region_id|default:0 gt 0}
    {assign var=TD value=$clsRegion->getTitle($region_id,$oneItemRegion|default:array())}

{else}
    {assign var=TD value=''}
{/if}


<div class="page_container blog_page_container">
	<div class="banner">
		{assign var="w" value=($deviceType=="computer")?1920:480}
		{assign var="h" value=($deviceType=="computer")?400:320}
		<img class="img100" src="{$clsConfiguration->getImage(site_blog_banner,$w,$h)}"
			alt="{if $show eq 'Default'}{$core->get_Lang('Our Blog')}{else}{$core->get_Lang('Blog in')}{$TD}{/if}" />
	</div>
	<div class="blog_box_breadcrumb">
		<nav class="breadcrumb-main">
			<div class="container">
				<ol class="breadcrumb hidden-xs mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
					<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
							<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
						<meta itemprop="position" content="1" />
					</li>
					<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Blogs')}">
							<span itemprop="name" class="reb">{$core->get_Lang('Blogs')}</span></a>
						<meta itemprop="position" content="2" />
					</li>
					{if $show eq 'City'}
					<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="{$clsCity->getLink($city_id,'Blog',false,$oneItemCity)}" title="{$TD}">
							<span itemprop="name" class="reb">{$TD}</span></a>
						<meta itemprop="position" content="3" />
					</li>
					{elseif $show eq 'Country'}
					<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<a itemprop="item" href="{$curl}" title="{$TD}">
							<span itemprop="name" class="reb">{$TD}</span></a>
						<meta itemprop="position" content="3" />
					</li>
					{else}
					{/if}
				</ol>
			</div>
		</nav>
	</div>

	{*
	<div class="box_category">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="col-10">
					{assign var="count_listBlogCat" value=(count($lstBlogCategory)>6)?true:false}
					<div class="row {if $count_listBlogCat}owl-carousel{/if}" id="{if $count_listBlogCat}box_inforblog{/if}">
						{foreach from=$lstBlogCategory key=key item=item}
						<a class="col box_icon_child" href="{$clsBlogCategory->getLink($item.blogcat_id,$item)}">
							<div class="box_blog_img">
								<img src="{$clsISO->tripslashImage($item.icon, 26, 26)}" alt="{$item.title}" />
							</div>
							<p class="txt_box_blog">{$item.title}</p>
						</a>
						{/foreach}
					</div>
				</div>
			</div>
		</div>
	</div>
	*}

	{literal} 
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			$("#box_inforblog").owlCarousel({
				loop: true,
				dots: false,
				nav: false,
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
						margin: 30,
					},
					600: {
						items: 2,
						margin: 30,
					},
					1000: {
						items: 4,
						margin: 30,
					},
				},
			});
		});
	</script>
	{/literal}

	<div id="contentPage" class="pageBlogDefault bg_f1f1f1 pdt50">
		<article class="container">
			<div class="row">
				<div class="col-lg-9 blogLeft mb991_30">
					<h1 class="title32 mb20">
						{if $show eq 'Default'}{$core->get_Lang('Our Blog')}{else}{$core->get_Lang('Blog listing by destinations')} {$TD}{/if}
					</h1>
					<div class="row">
						{if $lstBlogs}
						{foreach from=$lstBlogs key=key item=item}
						{assign var=title_blog value=$clsBlog->getTitle($item.blog_id,$item)}
						{assign var=link_blog value=$clsBlog->getLink($item.blog_id,$item)}
						{assign var=author value=$clsBlog->getAuthor($item.blog_id,$item)}
						<article class="blogItem col-12 col-sm-6 col-lg-4">
							{*<div class="submitted">
								<i class="fa fa-clock-o" aria-hidden="true"></i>
								{$clsISO->converTimeToText($item.publish_date)} {if $author ne ''}<i class="fa fa-user"
									aria-hidden="true"></i> {$author} {/if}
								{assign var=link_share value=$link_blog}
								{assign var=title_share value=$title_blog}
								{$core->getBlock('box_share')}
							</div>*}
							<div class="content" href="{$link_blog}" title="{$title_blog}">
								<a class="photo" href="{$link_blog}" title="{$title_blog}">
									<img class="trek-blog-gallery img_scale lazy img100" src="{$clsBlog->getImage($item.blog_id,298,248,$item)}" alt="{$title_blog}"
										title="{$title_blog}" draggable="false">
								</a>
								<div class="info_blog">
									<span class="author_blog">{$author}</span>
									<h3 class="title24 mb10"><a class="fontSize24"
											href="{$link_blog}" title="{$title_blog}">{$title_blog}</a></h3>
									<span class="blog_date">{$clsISO->converTimeToText($item.publish_date)}</span>
									{*<div class="bodyBlog textjustify992">
										{$clsBlog->getIntro($item.blog_id,$item)|strip_tags|truncate:250}
										<a class="linkBlog" href="{$link_blog}"
											title="{$title_blog}">{$core->get_Lang('Read more')}</a>
									</div>*}
								</div>
							</div>
						</article>
						{/foreach}
						{/if}
					</div>
					{if $totalPage gt '1'}
					<div class="text-center">
						<div class="item-list">
							<div class="pagination pager">
								{$page_view}
							</div>
						</div>
					</div>
					{/if}
				</div>
				<aside class="col-lg-3 rightBlog">
					{$core->getBlock('l_rightblog')}
				</aside>
			</div>
		</article>
		{if $show ne 'Default'}
		<!-- <div class="pd50_0 bg_fff">
			<div class="container">
				<div class="destinationAZ">
					{if $show eq 'City'}
					<h2 class="pane-title mt0 mb30">{$core->get_Lang('A-Z Blogs of Other Destinations')}</h2>
					{else}
					<h2 class="pane-title mt0 mb30">{$core->get_Lang('A-Z Blogs of Destinations')} {$TD}</h2>
					{/if}
					<div class="listDestination d-flex flex-wrap">
						{section name=i loop=$letter}
						{assign var = lstCityAZ value =
						$clsISO->getItemByAlphabetCityBlog($country_id,$city_id,$letter[i])}
						{if $lstCityAZ}
						<ul class="masonry grid-of-blog">
							<h3 class="title"><span>{$letter[i]}</span></h3>
							{section name=j loop=$lstCityAZ}
							{if $clsBlog->countBlogGolobal($country_id,$lstCityAZ[j].city_id) gt 0}
							{assign var=itemCity value=$clsCity->getOne($lstCityAZ[j].city_id,'title,slug')}
							<li><a
									href="{$clsCity->getLink($lstCityAZ[j].city_id,'Blog',false,$itemCity)}">{$clsCity->getTitle($lstCityAZ[j].city_id,$itemCity)}</a>
							</li>
							{/if}
							{/section}
						</ul>
						{/if}
						{/section}
					</div>
				</div>
			</div>
		</div> -->
		{/if}
	</div>
</div>