<div class="page_container">
	<nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Why travel with us')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Why travel with us')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<div id="contentPage" class="aboutPage whyPage pd50_0">
		<div class="container">
			<div class="row">
				<div class="col-md-9 mb992_30">
					<article class="Aboutcontent bg_fff">
						<h1 class="title">{$core->get_Lang('Why travel with us')}?</h1>
						<dl class="list-group-FAQs">
							{section name=k loop=$lstWhy}
							<dt class="clickFAQ {if $smarty.section.k.first}current{/if}"> <a href="javascript:void(0);">{$clsWhy->getTitle($lstWhy[k].why_id)}</a> <i class="fa {if $smarty.section.k.first}fa-minus-circle{else}fa-plus-circle{/if} pull-right"></i> </dt>
							{assign var=Intro_Why value=$clsWhy->getIntro($lstWhy[k].why_id)}
							{if $Intro_Why}
							<dd id="FAQ-{$lstWhy[k].why_id}" {if !$smarty.section.k.first}style="display:none"{/if}>
								<div class="formatTextStandard"> {$Intro_Why} </div>
							</dd>
							{/if}
							{/section}
						</dl>
					</article>
				</div>
				<aside class="col-md-3 AboutRight">
					{$core->getBlock('aboutRight')}											
					{$core->getBlock('company')}
				</aside>
			</div>
		</div>
	</div>
</div>