<div class="page_container">
	<nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs bg_fff mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Sitemap')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Sitemap')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<section id="contentPage" class="aboutPage SitemapPage pd50_0">
		<div class="container">
			<div class="row">
				<section class="col-md-9 mb992_30">
					<div class="Aboutcontent bg_fff">
						<h1 class="title">{$core->get_Lang('Sitemap')}</h1>
						<div id="sitemap" class="mb40" style="position:relative">
							<dl class="dllv1">
								<dt><a href="{$PCMS_URL}{$extLang}">{$PAGE_NAME}</a></dt>
								<span class="expanded rowClick"></span>
								<dd class="ddlv1">
									<dl class="dllv2">
										<dd class="ddlv2"> <a class="root-lv2" href="javascript:void(0);" rel="nofollow">{$core->get_Lang('Destinations')}</a> <span class="expanded rowClick"></span>
											<dl class="dllv3">
												{section name=i loop=$lstCountry}
												<dd class="ddlv3" style="position:relative;"> <a class="root-lv3" title="{$clsCountry->getTitle($lstCountry[i].country_id)}" href="{$clsCountry->getLink($lstCountry[i].country_id)}">{$clsCountry->getTitle($lstCountry[i].country_id)}</a> </dd>
												{/section}
											</dl>
										</dd>
									</dl>
									<dl class="dllv2">
										<dd class="ddlv2"> <a class="root-lv2" title="{$core->get_Lang('Travel Styles')}">{$core->get_Lang('Travel Styles')}</a> <span class="expanded rowClick"></span>
											<dl class="dllv3">
												{section name=i loop=$listCatTours}
												<dt><a title="{$clsTourCategory->getTitle($listCatTours[i].tourcat_id)}" href="{$clsTourCategory->getLink($listCatTours[i].tourcat_id)}">{$clsTourCategory->getTitle($listCatTours[i].tourcat_id)}</a></dt>
												{/section}
											</dl>
										</dd>
									</dl>
									<dl class="dllv2">
										<dd class="ddlv2"> <a class="root-lv2" title="{$core->get_Lang('Hotels')}">{$core->get_Lang('Hotels')}</a> <span class="expanded rowClick"></span>
											<dl class="dllv3">
												{section name=i loop=$lstCountry}
												<dt><a title="{$clsCountryEx->getTitle($lstCountry[i].country_id)}" href="{$clsCountryEx->getLink($lstCountry[i].country_id,'Hotel')}">{$clsCountryEx->getTitle($lstCountry[i].country_id)} {$core->get_Lang('hotels')}</a></dt>
												{/section}
											</dl>
										</dd>
									</dl>
									<dl class="dllv2">
										<dd class="ddlv2"> <a class="root-lv2" title="{$core->get_Lang('About us')}" href="{$extLang}/about-us.html">{$core->get_Lang('About Us')}</a> <span class="expanded rowClick"></span>
											<dl class="dllv3" style="position:relative;">
												{section name=i loop=$lstPage}
												<dt><a href="{$clsPage->getLink($lstPage[i].page_id)}" title="{$clsPage->getTitle($lstPage[i].page_id)}">{$clsPage->getTitle($lstPage[i].page_id)}</a></dt>
												{/section}
											</dl>
										</dd>
									</dl>
									<dl class="dllv2">
										<dd class="ddlv2"> <a class="root-lv2" title="{$core->get_Lang('Other')}" rel="nofollow">{$core->get_Lang('Other')}</a> <span class="expanded rowClick"></span>
											<dl class="dllv3" style="position:relative;">
												<dt><a class="root-other" title="{$core->get_Lang('Contact us')}" href="{$extLang}/contact-us.html">{$core->get_Lang('Contact us')}</a></dt>
												<dt><a class="root-other" title="{$core->get_Lang('Faqs')}" href="{$extLang}/faqs.html">{$core->get_Lang('Faqs')}</a></dt>
												<dt><a class="root-other" title="{$core->get_Lang('Travel Services')}" href="{$clsISO->getLink('service')}">{$core->get_Lang('Travel Services')}</a></dt>
												<dt><a class="root-other" title="{$core->get_Lang('Testimonials')}" href="{$clsISO->getLink('testimonial')}">{$core->get_Lang('Testimonials')}</a></dt>
												<dt><a class="root-other" title="{$PAGE_NAME} {$core->get_Lang('Blog')}" href="{$clsISO->getLink('blog')}">{$PAGE_NAME} {$core->get_Lang('Blogs')}</a></dt>
												<dt><a class="root-other" title="{$core->get_Lang('Tailor Made Tour')}" href="{$extLang}/customize-tour.html">{$core->get_Lang('Tailor Made Tour')}</a></dt>
											</dl>
										</dd>
									</dl>
								</dd>
							</dl>
						</div>
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
{literal}
<script type="text/javascript">
$().ready(function () {
	$('span.rowClick').click(function () {
		if ($(this).hasClass('expanded')) {
			$(this).removeClass('expanded').addClass('collapsed');
		} else {
			$(this).removeClass('collapsed').addClass('expanded');
		}
		var el = $(this).parent().find('dl');
		if (el.is(':visible')) {
			el.hide();
		} else {
			el.show();
		}
	});
});
</script> 
{/literal}