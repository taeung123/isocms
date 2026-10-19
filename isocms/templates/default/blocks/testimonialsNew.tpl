{if $lstTestimonial}
{assign var = TitleSiteTestimonial value = TitleTestimonialsHome_|cat:$_LANG_ID}
{assign var = IntroSiteTestimonial value = IntroTestimonialsHome_|cat:$_LANG_ID}
<section class="section_box testimonials__box">
	<div class="container">
		<div class="box_testimonial">
			<h2 class="title_testimonials">{$core->get_Lang('What do customers say about us?')}</h2>
			<div class="list_testimonial">
				<div class="jcarousel-box owl_slide_testimonial_cruise owl-carousel">
					{section name=i loop=$lstTestimonial}
					{assign var = title_testimonial value = $lstTestimonial[i].title}
					{assign var = link_testimonial value = $clsTestimonial->getLink($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}
					{assign var=image_default value=$URL_IMAGES|cat:"/noimage.png"}
					<div class="tes_item" data-dot="<button>{$smarty.section.i.index}</button>">
						<a class="" href="{$link_testimonial}" title="{$title_testimonial}">
							<h3 class="title_test limit_1line">{$title_testimonial}</h3>
							<div class="item__intro limit_3line">{$lstTestimonial[i].intro|html_entity_decode|strip_tags} </div>
							<div class="box_customer">
								<div class="box_avt">
									<img width="45" height="45" src="{$clsISO->tripslashImage($image_default,45,45)}" data-src="{$clsTestimonial->getImage($lstTestimonial[i].testimonial_id,45,45,$lstTestimonial[i])}" alt="{$getTitle}" class="img_customer owl-lazy img100">
								</div>
								<div class="box_left_customer">
									<p class="item_name text1line">{$lstTestimonial[i].name}</p>
									<span class="country_user text_normal">{$clsTestimonial->getCountry($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}</span>
									<label class="rate-2019 block">{$clsTestimonial->getRatesStar($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}</label>
								</div>
							</div>
						</a>
					</div>
					{/section}
				</div>
			</div>
		</div>
	</div>
</section>
{/if} 