{assign var=title_new_cat value=$clsNewsCategory->getTitle($newscat_id)}
{assign var=title_news_top value=$clsNews->getTitle($lstNews[0].news_id)}
{assign var=link_news_top value=$clsNews->getLink($lstNews[0].news_id)}
<div class="page_container">
	<div class="breadcrumb-main bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$clsISO->getLink('news')}" title="{$core->get_Lang('Travel news')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Travel news')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
				{if $newscat_id gt '0'}
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"> 
					<a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$clsNewsCategory->getLink($newscat_id)}" title="{$title_new_cat}">
						<span itemprop="name" class="reb">{$title_new_cat}</span></a>
					<meta itemprop="position" content="3" />
				</li> 
				{/if}
            </ol>
        </div>
	</div>	
	<div class="newsPage pageNewsDefault bg_fff">
		<div class="container">
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-8 leftNews mb992_30">
					{if $show eq 'cat'}
				<h1 class="Title_news">{$title_new_cat}</h1>
			{else}
				<h1 class="Title_news">{$core->get_Lang('Travel news')}</h1>
			{/if}
					<div class="post_top">
						<a class="photo" href="{$link_news_top}" title="{$title_news_top}"><img class="full-width img100 lazy" src="{$URL_IMAGES}/pixel.png" data-src="{$clsNews->getImage($lstNews[0].news_id,747,500)}" alt="{$title_news_top}" title="{$title_news_top}"></a>
						<div class="content_item">
							<h3><a href="{$link_news_top}" title="{$title_news_top}">{$title_news_top}</a></h3>
							<p class="date_public">{$clsISO->converTimeToText($lstNews[0].reg_date)}</p>
							<div>
							{$clsNews->getIntro($lstNews[0].news_id)|strip_tags|truncate:250}<a class="clickviewtopBlog linkNews" data-news_id="{$lstNews[0].news_id}" href="{$link_news_top}" rel="tag" title="{$title_news_top}">  {$core->get_Lang('View more')}</a></div>
						 </div>
					</div>
					<div class="row">
					<div class="boxListItem mts">
					{section name=i loop=$lstNews start=1}
						{assign var=title_news value=$clsNews->getTitle($lstNews[i].news_id)}
						{assign var=link_news value=$clsNews->getLink($lstNews[i].news_id)}
						<div class="col-md-6 col-sm-6 Item">
							<div class="itemNews">
								<a class="photo" href="{$link_news}" title="{$title_news}">
									<img class="img-responsive full-width img100 lazy" src="{$URL_IMAGES}/pixel.png" data-src="{$clsNews->getImage($lstNews[i].news_id,543,362)}" alt="{$title_news}" />
								</a>
								<div class="body">
									<h3 class="title mb10"><a class=" fontSize18" href="{$link_news}" title="{$title_news}">{$title_news}</a></h3>
									<p class="date_public">{$clsISO->converTimeToText($lstNews[i].reg_date)}</p>
									<div class="intro">{$clsNews->getIntro($lstNews[i].news_id)|strip_tags|truncate:220}<a class="clickviewtopBlog linkNews" data-news_id="{$lstNews[i].news_id}" href="{$link_news}" rel="tag" title="{$core->get_Lang('View more')}"> {$core->get_Lang('View more')}</a>
									</div>
								</div>
							</div>
						</div>
					{/section}
					</div>
					</div>
					{if $totalPage gt '1'}
					<div class="clearfix"></div>
					<div class="pagination pager">
						{$page_view}
					</div>
					{/if}	
				</div>
				<div class="col-md-4 rightNews">
					{$core->getBlock('l_boxcolNews')}
				</div>
			</div>
		</div>
	</div>
</div>