{if $lstTestimonial}
{assign var = TitleSiteTestimonial value = TitleTestimonialsHome_|cat:$_LANG_ID}
{assign var = IntroSiteTestimonial value = IntroTestimonialsHome_|cat:$_LANG_ID}
<section class="section_box testimonials__box">
    <div class="container">
		<div class="title text_center mb0">
			<h2 class="section_box-title">{$clsConfiguration->getValue($TitleSiteTestimonial)}</h2>
			<div class="intro_box">{$clsConfiguration->getValue($IntroSiteTestimonial)|html_entity_decode}</div>
		</div>
	</div>
	<div class="container">
		<div class="list_testimonial">
			<div class="jcarousel-box owl_slide_testimonial owl-carousel">
				{section name=i loop=$lstTestimonial}
				{assign var = title_testimonial value = $lstTestimonial[i].title}
				{assign var = link_testimonial value = $clsTestimonial->getLink($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}
				<div class="tes_item">
					<a class="color_1c1c1c" href="{$link_testimonial}" title="{$title_testimonial}">
						<h3 class="title size20 text_bold color_1c1c1c mb10 limit_1line">{$title_testimonial}</h3>
						<div class="item__intro limit_3line mb10">{$clsTestimonial->getIntro($lstTestimonial[i].testimonial_id,$lstTestimonial[i])|strip_tags} </div>
                        
                        <div class="user d-flex">
                            <div class="avatar">
                                <img class="img100" alt="{$clsTestimonial->getName($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}" src="{$clsTestimonial->getImage($lstTestimonial[i].testimonial_id,45,45,$lstTestimonial[i])}" width="45" height="45" />
                            </div>
                            <div class="user_name">
                                <p class="name">{$clsTestimonial->getName($lstTestimonial[i].testimonial_id,$lstTestimonial[i])} <span class="country_user text_normal">{$clsTestimonial->getCountry($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}</span></p>
                                <p class="rate">
                                <label class="rate-2019 block">{$clsTestimonial->getRatesStar($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}</label>
                                </p>
                            </div>
                        </div>
					</a>
				</div>
				{/section}
			</div>
		</div>
	</div>
    <div class="tour_for_ask">
       <div class="container">
            <div class="box_tour">
                <div class="box-left">
                   	{assign var = TitleSufficient value = TitleSufficient_|cat:$_LANG_ID}
                   	{assign var = IntroSufficient value = IntroSufficient_|cat:$_LANG_ID}
                    <h3 class="title_tour_for_ask">{$clsConfiguration->getValue($TitleSufficient)|html_entity_decode}</h3>
                    <p class="text_tour_for_ask">{$clsConfiguration->getValue($IntroSufficient)|html_entity_decode}</p>
                    <a href="{$clsISO->getLink('tailor')}" title="{$core->get_Lang('Tailor made tour')}" class="link_tour_for_ask btn_main">{$core->get_Lang('Tailor made tour')}</a>
                </div>
                <div class="box-right">
                    <img width="625" height="401" src="{$clsConfiguration->getImage('default_image_pixel',3,2)}" data-src="{$URL_IMAGES}/img_isocms/banner_tour_for_ask.png" alt="{$core->get_Lang('Tailor made tour')}" class="lazy img_banner_tour img100" loading="lazy">
                </div>
            </div>
		</div>
    </div>
</section>
{/if} 