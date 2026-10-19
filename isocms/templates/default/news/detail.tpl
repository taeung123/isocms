{assign var=title_news value=$clsNews->getTitle($news_id,$newsItem)}
{assign var=reg_date value=$newsItem.reg_date|date_format:"%Y-%m-%d"}
{assign var=last_update value=$newsItem.last_update|date_format:"%Y-%m-%d"}
{assign var=author value=$newsItem.author}
{literal}	
	<script type="application/ld+json">
	{
		"@graph": [{
			"@context": "http://schema.org",
			"@type": "NewsArticle",
			"mainEntityOfPage": {
				"@type": "WebPage",
				"@id": "{/literal}{$DOMAIN_NAME}{$curl}{literal}"
			},
			"image": {
			"@type": "ImageObject",
			"url": "{/literal}{$DOMAIN_NAME}{$global_image_seo_page}{literal}",
			"height": 850,
			"width": 480
			},
			"datePublished": "{/literal}{$reg_date}{literal}",
			"dateModified": "{/literal}{$last_update}{literal}",
			"publisher": {
			"@type": "Organization",
			"name": "{/literal}{$PAGE_NAME}{literal}",
			"logo": "{/literal}{$DOMAIN_NAME}{$clsConfiguration->getImageValue('HeaderLogo')}{literal}"},
			"description": "{/literal}{$PAGE_NAME}{literal}"
			}
		]
	}
	</script>
{/literal}
<div class="page_container">
	<div class="breadcrumb-main bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="{$clsISO->getLink('news')}" title="{$core->get_Lang('Experience')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Experience')}</span></a>
					<meta itemprop="position" content="2" />
				</li> 
                {if $newscat_id gt 0 && $clsISO->getCheckActiveModulePackage($package_id,'news','category','default')}
                {assign var=itemCat value=$clsNewsCategory->getOne($newscat_id,'title,slug')}
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="{$clsNewsCategory->getLink($newscat_id,$itemCat)}" title="{$clsNewsCategory->getTitle($newscat_id,$itemCat)}">
						<span itemprop="name" class="reb">{$clsNewsCategory->getTitle($newscat_id,$itemCat)}</span></a>
					<meta itemprop="position" content="3" />
				</li> 
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$title_news}">
						<span itemprop="name" class="reb">{$title_news}</span></a>
					<meta itemprop="position" content="4" />
				</li>
				{else}
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$title_news}">
						<span itemprop="name" class="reb">{$title_news}</span></a>
					<meta itemprop="position" content="3" />
				</li>
                {/if}
                
            </ol>
        </div>
    </div>
    <div class="newsPage pageNewsDefault bg_f1f1f1">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 newsLeft mb991_30">
					<div class="box_title_top">
						<h1 class="title mb20">
							{$title_news}
						</h1>
                        {if $deviceType eq 'computer'}
                        <div class="share_box">
						<div class="icon_share">
							<i class="ic ic_share"></i>
						</div>
							<script defer type="text/javascript" src="{$URL_JS}/jquery.sharer.js?v={$upd_version}"></script>
							{assign var=link_share value=$curl}
							{assign var=title_share value=$title_news}
							{$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
						</div>
                        {/if}
					</div>
					<div class="NewsContent">
						<div class="submitted">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
								 fill="none">
								<g clip-path="url(#clip0_2953_5834)">
									<path d="M10 1C5.03125 1 1 5.03125 1 10C1 14.9688 5.03125 19 10 19C14.9688 19 19 14.9688 19 10C19 5.03125 14.9688 1 10 1Z"
										  stroke="#0077CC" stroke-miterlimit="10"/>
									<path d="M10 4V11H15" stroke="#0077CC" stroke-linecap="round"
										  stroke-linejoin="round"/>
								</g>
								<defs>
									<clipPath id="clip0_2953_5834">
										<rect width="20" height="20" fill="white"/>
									</clipPath>
								</defs>
							</svg>
							{if $newsItem.publish_date} 
								{$clsISO->converTimeToText($newsItem.publish_date)}
							{else} 
								{$clsISO->converTimeToText($newsItem.reg_date)}
							{/if}
							
							{if $author}
								<span>
								<i class="fa fa-user-o" aria-hidden="true"></i>
								{$author}
								</span>
							{/if}
                            
                             {if $deviceType ne 'computer'}
                            <div class="share_box">
                                <div class="icon_share">
                                    <i class="ic ic_share"></i>
                                </div>
                            
                                <script type="text/javascript" src="{$URL_JS}/jquery.sharer.js?v={$up_version}"></script>
                                {assign var=link_share value=$curl}
                                {assign var=title_share value=$title_news}
                                {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
                            </div>
                            {/if}
						</div>
						<div class="content">
							<div class="field-items maxWidthImage tinymce_Content">
								{$clsNews->getIntro($news_id,$newsItem)}
								<div class="clearfix"></div>
								{$clsNews->getContent($news_id,$newsItem)}
							</div>
						</div>
						<div class="cleafix"></div>
						<div class="comment_box mtm mt30">
                                <div class="fb-comments" data-href="{$PCMS_URL}{$clsNews->getLink($news_id,$newsItem)}" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
                        </div>
					</div>

				</div>
				<div class="col-lg-3 sidebar rightNews">
					{$core->getBlock('l_boxcolNews')}
				</div>
			</div>
        </div>
    </div>
</div>