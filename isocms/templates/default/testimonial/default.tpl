<div class="page_container">
	<nav class="breadcrumb-main bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Testimonials')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Testimonials')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
            </ol>
        </div>
	</nav>
	<div class="testimonialPage">
		<div class="container">
			<div class="row">
				<section class="col-lg-8 mb991_30">
					<h1 class="title32 color_333 mb20">{$core->get_Lang('Testimonials')}</h1>
					{if $clsISO->getModIntro('testimonial')}
					<div class="intro">{$clsISO->getModIntro('testimonial')}</div>
					{/if} 
					<div class="listTestimonial">
						{section name=i loop=$listItem}
						{assign var=title value=$clsTestimonial->getTitle($listItem[i].testimonial_id,$listItem[i])}
						{assign var=link value=$clsTestimonial->getLink($listItem[i].testimonial_id,$listItem[i])}
						<div class="item bg_fff">
							<a href="{$link}" title="{$title}"> 
								<div class="photo">
									<img class="img-responsive img100 lazy" src="{$clsTestimonial->getImage($listItem[i].testimonial_id,260,200,$listItem[i])}" alt="{$title}" loading="lazy" /> 
								</div>
								<div class="body title">
									<h3 class="testimonials-title"> {$title}</h3>
									<div class="introCrx"> {$clsTestimonial->getIntro($listItem[i].testimonial_id,$listItem[i])|strip_tags|truncate:235} </div>
									<div class="wrap profilet"> <strong>{$clsTestimonial->getName($listItem[i].testimonial_id,$listItem[i])}, {$clsTestimonial->getCountry($listItem[i].testimonial_id,$listItem[i])}</strong> </div>
									<div class="star mt10">
									<label class="rate-2019 block">{$clsTestimonial->getRatesStar($listItem[i].testimonial_id,$listItem[i])}</label>
									</div>
								</div>
							</a>
						</div>
						{/section}
					</div>
					{if $totalPage gt '1'}
					<div class="clearfix"></div>
					<div class="pagination pager">
						{$page_view}
					</div>
					{/if}	
				</section>
				<aside class="col-lg-4 testimonialsRight" >
					<div class="sticky_fix">
						{$core->getBlock('aboutRight')}
						{$core->getBlock('company')}
						{$core->getBlock('Lwhybox')}
					</div>
				</aside>
			</div>
		</div>
	</div>
</div>