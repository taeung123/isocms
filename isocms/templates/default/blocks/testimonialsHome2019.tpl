{if $lstTestimonial}
<section class="box_home_2019 testimonialsHome">
	<div class="container">
		<div class="jcarousel-box owl_slide_testimonial owl-carousel"> 
			{section name=i loop=$lstTestimonial}
			{assign var = title_testimonial value = $lstTestimonial[i].title}
			{assign var = link_testimonial value = $clsTestimonial->getLink($lstTestimonial[i].testimonial_id)}
			<div class="tes_item"> 
				<a class="photo" href="{$link_testimonial}" title="{$title_testimonial}">
					<img src="{$URL_IMAGES}/pixel.png" data-src="{$clsTestimonial->getImage($lstTestimonial[i].testimonial_id,180,180)}" alt="{$title_testimonial}" class="img-circle owl-lazy img100"/>
				</a>
				<div class="tes_body">
					<h3 class="mb10"><a href="{$link_testimonial}" title="{$title_testimonial}">{$title_testimonial}</a></h3>				
					<div class="intro"> {$clsTestimonial->getIntro($lstTestimonial[i].testimonial_id)|strip_tags|truncate:250} </div>
					<div class="country_name">{$clsTestimonial->getName($lstTestimonial[i].testimonial_id)} - {$clsTestimonial->getCountry($lstTestimonial[i].testimonial_id)}</div>
				</div>
			</div>
			{/section} 
		</div>
		<div class="view_all"><a href="{$clsISO->getLink('testimonial')}" title="{$core->get_Lang('VIEW ALL TESTIMONIALS')}">{$core->get_Lang('VIEW ALL TESTIMONIALS')}</a></div>
	</div>
</section>
{/if} 