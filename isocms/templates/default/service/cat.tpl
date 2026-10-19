<div class="page_container">
	<div class="breadcrumb-main">
        <div class="container">
            <ol class="breadcrumb hidden-xs" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLink('service')}" title="{$core->get_Lang('Travel services')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Travel services')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$clsServiceCategory->getTitle($servicecat_id)}">
						<span itemprop="name" class="reb">{$clsServiceCategory->getTitle($servicecat_id)}</span></a>
					<meta itemprop="position" content="3" />
				</li>
            </ol>
        </div>
    </div>
    <div class="servicePage pageServiceDefault bg_f1f1f1">
		<div class="container">
			<h1 class="title32 color_333 mb20">{$clsServiceCategory->getTitle($servicecat_id)}</h1>
			{if $clsServiceCategory->getIntro($servicecat_id)}
			<div class="intro mb30">{$clsServiceCategory->getIntro($servicecat_id)|html_entity_decode}</div>  
			{/if}
			<div class="row">
				<div class="col-lg-9 serviceLeft">
					{section name=i loop=$listService}
						<article class="serviceItem">
							<h3 class="title24 color_333 mb10"><a class="fontSize24 color_333" href="{$clsService->getLink($listService[i].service_id)}" title="{$clsService->getTitle($listService[i].service_id)}">{$clsService->getTitle($listService[i].service_id)}</a></h3>
							<div class="submitted">
								<i class="fa fa-clock-o" aria-hidden="true"></i> {$clsISO->converTimeToText($listService[i].reg_date)}
								<div class="sharethis-buttons mt0">
									<div class="sharethis-wrapper">
										<div class="addthis_toolbox addthis_default_style" addthis:media="{$DOMAIN_NAME}{$clsService->getImage($listService[i].service_id,400,300)}" addthis:url="{$DOMAIN_NAME}{$clsService->getLink($listService[i].service_id)}" addthis:title="{$clsService->getTitle($listService[i].service_id)}">
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
								<div class="photo">
									<img class="trek-blog-gallery lazy" src="{$clsService->getImage($listService[i].service_id,828,552)}" alt="{$clsService->getTitle($listService[i].service_id)}" title="{$clsService->getTitle($listService[i].service_id)}" width="100%" height="auto" draggable="false">
								</div>
								<div class="bodyService textjustify992">
									{$clsService->getIntro($listService[i].service_id)|html_entity_decode|strip_tags|truncate:250}
									<a class="linkBlog" href="{$clsService->getLink($listService[i].service_id)}" rel="tag" title="{$clsService->getTitle($listService[i].service_id)}">{$core->get_Lang('Read more')}</a>
								</div>
								
							</div>
					</article>
				{/section}
				 <div class="clearfix"></div>
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
				<div class="col-lg-3 rightService">
					{$core->getBlock('l_boxcolService')}
				</div>  
			</div>
		</div>
	</div>
</div>