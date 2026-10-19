{assign var=title_science value=$clsScience->getTitle($science_id)}
<div class="page_container">
	<div class="breadcrumb-main bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLink('science')}" title="{$core->get_Lang('Science')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Science')}</span></a>
					<meta itemprop="position" content="2" />
				</li> 
                {if $sciencecat_id gt '0' && $clsConfiguration->getValue('SiteHasCat_Science')}
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$clsScienceCategory->getLink($sciencecat_id)}" title="{$clsScienceCategory->getTitle($sciencecat_id)}">
						<span itemprop="name" class="reb">{$clsScienceCategory->getTitle($sciencecat_id)}</span></a>
					<meta itemprop="position" content="3" />
				</li> 
                {/if}
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$title_science}">
						<span itemprop="name" class="reb">{$title_science}</span></a>
					<meta itemprop="position" content="4" />
				</li>
            </ol>
        </div>
    </div>
    <div class="sciencePage pageScienceDefault bg_f1f1f1">
		<div class="container">
			<h1 class="title mb20">{$title_science}</h1>
			<div class="row">
				<div class="col-md-8 col-sm-8 scienceLeft mb768_30">
					<div class="ScienceContent">
						<div class="submitted"> 
							<i class="fa fa-clock-o" aria-hidden="true"></i> {$clsISO->converTimeToText($clsScience->getOneField('reg_date',$science_id))} 
						</div>
						<div class="content">
							<div class="field-items maxWidthImage tinymce_Content">
								{$clsScience->getIntro($science_id)}
								<div class="clearfix"></div>
								{$clsScience->getContent($science_id)}
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="col-left">
						{if $lstRelated}
						<div class="relateNews mb30">
							<h2 class="title24 mb20 titleRelated">{$core->get_Lang('Related News')}</h2>
							<div class="list_post">
							{section name=i loop=$lstRelated}
							{assign var=title_news_relate value=$clsScience->getTitle($lstRelated[i].science_id)}
							<div class="post_item">
								<h3>
								<a class="clickviewtopnews" data-item="{$lstRelated[i].science_id}" href="{$clsScience->getLink($lstRelated[i].science_id)}" title="{$title_news_relate}">{$title_news_relate}</a>
								</h3>
							</div>
							{/section}
							</div>
						</div>
						{/if}
					</div>
				</div>
			</div>
        </div>
    </div>
</div>