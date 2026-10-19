<main id="main" class="page_container">
    {$core->getBlock('slider_homepro')}
	
    {if $listWhyHome}
    <section class="section_box why">
        <div class="container">
			{if $deviceType eq 'computer'}
			   <div class="owl-carousel slideWhy" id="whyWithUs">
					{section name=i loop=$listWhyHome}
					{assign var=title value=$clsWhy->getTitle($listWhyHome[i].why_id)}
					<div class=" item__why box_col"> 
						<div class="item__why--icon">
							<img src="{$URL_IMAGES}/pixel.png" data-src="{$clsWhy->getIcon($listWhyHome[i].why_id)}" alt="{$title}" class="lazy img100">
						</div>
						<div class="item__why--artice">
							<p class="title size20 mb10">{$title}</p>
							<div class="intro limit_2line">
								{$clsWhy->getIntro($listWhyHome[i].why_id)}
							</div>
						</div>
					</div>
					{/section}
				</div>
		   {else}
				<div class="row slideWhy">
					{section name=i loop=$listWhyHome}
					{assign var=title value=$clsWhy->getTitle($listWhyHome[i].why_id)}
					<div class="col-lg-4 col-md-12 item__why box_col"> 
						<div class="item__why--icon">
							<img src="{$URL_IMAGES}/pixel.png" data-src="{$clsWhy->getIcon($listWhyHome[i].why_id)}" alt="{$title}" class="lazy img100">
						</div>
						<div class="item__why--artice">
							<p class="title">{$title}</p>
							<div class="intro limit_2line">
								{$clsWhy->getIntro($listWhyHome[i].why_id)}
							</div>
						</div>
					</div>
					{/section}
				</div>
		   {/if}
        </div>
    </section>
    {/if}
 	{$core->getBlock('Lbox_topTourpro')}
    {$core->getBlock('testimonialsHomepro')}
   
    {$core->getBlock('Lbox_blogHomePagepro')}
    
    <section class="section_box tour_for_ask">
        <div class="container-fuild bgc-F5F5F5">
		   <div class="container">
				<div class="row">
				<div class="col-xl-12">
					<div class="box_tour">
						<div class="box-left">
							<h3 class="title_tour_for_ask">{$core->get_Lang('Self-sufficient travel')}, {$core->get_Lang(' Book isoCMS')}</h3>
							<p class="text_tour_for_ask">{$core->get_Lang('Millions of people have chosen isoCMS to travel in their own way. How about you')}?</p>
							<a href="" title="{$core->get_Lang('Tailor made tour')}" class="link_tour_for_ask">{$core->get_Lang('Tailor made tour')}</a>
						</div>
						<div class="box-right">
							<img src="{$URL_IMAGES}/img_isocms/banner_tour_for_ask.png" alt="{$core->get_Lang('Self-sufficient travel')}, {$core->get_Lang(' Book isoCMS')}" class="img_banner_tour">
						</div>
					</div>
				</div>
			   </div>
		   </div>
        </div>
    </section>
    

    {$core->getBlock('partnerpro')}
    {$core->getBlock('Press_news')}
     {$core->getBlock('subscribeHomepro')}
</main>
