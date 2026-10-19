{if $lstTestimonial[0].testimonial_id ne ''}
<div class="TestimonialColBox pd1510 bg_fff">
	<h3 class="text_center size21" style="font-size: 24px !important;"><a class="color_333" title="{$core->get_Lang('What Our Guests Say')}" href="{$clsISO->getLink('testimonial')}" target="_blank">{$core->get_Lang('What Our Guests Say')}</a></h3>
	<div class="widget contentTes">
		<div class="jcarousel-box jcarousel-testimonial-slides owl-carousel">
			{section name=i loop=$lstTestimonial}
			{assign var = title value = $clsTestimonial->getTitle($lstTestimonial[i].testimonial_id)}
			{assign var = link value = $clsTestimonial->getLink($lstTestimonial[i].testimonial_id)}
			<div class=" discover_Items">
				<a class="photo"><img src="{$clsTestimonial->getImage($lstTestimonial[i].testimonial_id,106,106)}" alt="{$title}" class="img-circle"></a>
				<div class="intro"> {$clsTestimonial->getIntro($lstTestimonial[i].testimonial_id)|strip_tags|truncate:150} </div>
				<strong class="cus-cm z_14 inline-block">{$clsTestimonial->getName($lstTestimonial[i].testimonial_id)}, {$clsTestimonial->getCountry($lstTestimonial[i].testimonial_id)}</strong> </div>
			{/section}
		</div>
	</div>
</div>
{literal} 
<script>
$(function(){
	if($('.jcarousel-testimonial-slides').length > 0){
	var $owl = $('.jcarousel-testimonial-slides');
	$owl.owlCarousel({
		loop:true,
		responsiveClass:true,
		autoplay:true,
		responsive:{
			0:{
					items:1,
					nav:false
			},
			600:{
					items:1,
					nav:false
			},
			1200:{
					items:1,
					nav:false
			}
		}
	});
	$('#next_1').click(function(){
			$('.jcarousel-testimonial-slides .owl-next').trigger('click');
	});
	$('#prev_1').click(function(){
			$('.jcarousel-testimonial-slides .owl-prev').trigger('click');
	});
	}
});
</script>
<style>
	.discover_Items{text-align:center}
	.discover_Items .photo{display:block; width:106px; height:106px; border-radius:100%; margin:15px auto}
	.discover_Items .photo img{margin:0; border-radius:100%}
	.discover_Items .intro{text-align:center !important; margin-bottom:12px;}
	.discover_Items .intro p{text-align:center !important}
	.discover_Items .cus-cm {
		color: #999;
		margin-top: 5px;
	}
	.widget .owl-controls{margin:0 0 15px !important}
	.widget .owl-theme .owl-dots .owl-dot.active span, .widget .owl-theme .owl-dots .owl-dot:hover span {
		background: #144aa8 !important;
	}
</style>
{/literal}
{/if} 