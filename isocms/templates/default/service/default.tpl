{assign var=title_service_cat value=$clsServiceCategory->getTitle($servicecat_id)}
<div class="page_container">
	<nav class="breadcrumb-main breadcrumb-default bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a  itemprop="item" href="{$clsISO->getLink('service')}" title="{$core->get_Lang('Travel services')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Travel services')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
				{if $show eq 'cat'}
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$title_service_cat}">
						<span itemprop="name" class="reb">{$title_service_cat}</span></a>
					<meta itemprop="position" content="3" />
				</li>
				{/if}
            </ol>
        </div>
    </nav>
    <div class="servicePage pageServiceDefault bg_f1f1f1">
		<div class="container">
			<article>
			{if $show eq 'cat'}
			{assign var=intro_service_cat value=$clsServiceCategory->getIntro($servicecat_id)}
			<h1 class="title32 color_333 mb20">{$title_service_cat}</h1>
			{if $intro_service_cat}
			<div class="intro mb40">{$intro_service_cat|html_entity_decode}</div>
			{else}
			<div class="clearfix mb20"></div>
			{/if}
			{else}
			{assign var=intro_mod_service value=$clsISO->getModIntro('service')}
			<h1 class="title32 color_333 mb20">{$core->get_Lang('Travel services')}</h1>
			{if $intro_mod_service}
			<div class="intro mb40">{$intro_mod_service}</div>
			{else}
			<div class="clearfix mb20"></div>
			{/if}
			{/if}
			</article>
			<div class="row">
				<div class="col-lg-9 serviceLeft">
					{section name=i loop=$listService}
					{assign var= _title value = $listService[i].title}
					{assign var= _link value = $clsService->getLink($listService[i].service_id)}
					{assign var= _service_id value = $listService[i].service_id}
					<article class="serviceItem">
						<div class="service__box">
							<div class="service__img">
								<div class="service__container">
									<a href="{$_link}" title="{$_title}">
										<img class="width100 heightAuto img-responsive" alt="{$_title}" src="{$clsService->getImage($_service_id,280,255)}"/>
									</a>
								</div>
							</div>
							<div class="service__body">
								<h3><a href="{$_link}" title="{$_title}">{$_title}</a></h3>
								<p class="time hidden"><i class="fa fa-clock-o" aria-hidden="true"></i> {$clsISO->converTimeToText($listService[i].reg_date)}</p>
								<p class="intro">{$clsService->getIntro($_service_id)|html_entity_decode|strip_tags|truncate:250}</p>
								<p class="text-right">
									<a class="sevicer__readmore btn_main" href="{$_link}" title="{$_title}">{$core->get_Lang('Read more')}</a>
								</p>
							</div>
						</div>
					</article>
					{/section}
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
                    <div class="sticky_fix">
					{$core->getBlock('l_boxcolService')}
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
