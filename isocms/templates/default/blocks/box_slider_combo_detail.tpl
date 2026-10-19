<div class="box__images relative">
    <div class="owl_full_width owl-carousel">
        {section name=i loop=$lstImage}
            <div class="tour_image_item">
				{if $deviceType eq 'phone'}
				<img class="img100"  src="{$clsComboImage->getImage($lstImage[i].combo_image_id,480,320)}" alt="{$clsComboImage->getTitle($lstImage[i].combo_image_id)}"/>
				{else}
                <img class="img100"  src="{$clsComboImage->getImage($lstImage[i].combo_image_id,950,498)}" alt="{$clsComboImage->getTitle($lstImage[i].combo_image_id)}"/>
				{/if}
            </div>
        {/section}
    </div>
</div>
{literal}
<script>
var full_width_window = $(window).width();
var stagePadding=(full_width_window-950)/2;
var stagePadding1=(full_width_window-750)/2;
var stagePadding2=(full_width_window-640)/2;
var stagePadding3=(full_width_window-480)/2;
if($('.owl_full_width').length > 0){
	var $owl = $('.owl_full_width');
	$owl.owlCarousel({
		center: true,
		loop:true,
		nav: true,
		navText:'',
		dots:false,
		margin:10,
		lazyLoad:true,
		autoplay:false,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
				margin:5,
				stagePadding:0,
			},
			480:{
				items:1,
				stagePadding: stagePadding3,
			},
			991:{
				items:1,
				stagePadding: stagePadding2,
			},
			1200:{
				items:1,
				stagePadding: stagePadding1,
			},
			1600:{
				items:1,
				stagePadding: stagePadding,
			}
		}
	});
}
</script>
{/literal}
