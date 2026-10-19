<div class="page_container">
	<nav class="breadcrumb-main breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Our Team')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Our Team')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
 	<section id="contentPage" class="aboutPage whyPage pd50_0">
		<div class="container ">
			<div class="row">
				<section class="col-md-9 mb992_30">
					<div class="Aboutcontent bg_fff">
						<h1 class="title">{$core->get_Lang('Our Team')}</h1>
						<ul	class="list_Team mb0">
							{section name = i loop = $listTeam}
							<li class="text-center itemTeam mb20 bg_f7f7f7">
								<article>
								<img class="photo" src="{$clsTeam->getImage($listTeam[i].team_id,120,120)}" alt="{$clsTeam->getName($listTeam[i].team_id)}" width="100%" height="auto"/>
								<div class="bodyTeam text-left">
									<span class="block name_people size14 text_bold mb05">{$clsTeam->getName($listTeam[i].team_id)}</span>
									<span class="block size12">{$clsTeam->getAbout($listTeam[i].team_id)|html_entity_decode|strip_tags}</span>
								</div>
								</article>
							</li>
							{/section}
						</ul>
					</div>
				</section>
				<aside class="col-md-3">
					{$core->getBlock('aboutRight')}
					{$core->getBlock('company')}
				</aside>
			</div>
		</div>
	</section>
</div>