<div class="recommended_box">
	<div class="hd">
		<h3 class="fl SegoeUILight">{$core->get_Lang('Trips recommended to you')}</h3>
		<div class="control_js fr">
			<a href="javascript:void();" class="prev" id="prev"></a>
			<a href="javascript:void();" class="next" id="next"></a>
		</div>
	</div>
	<div class="jcarousel-box owl-carousel listTour" id="jcarousel-slides">
		{section name=i loop=$listTour}
		{assign var=titleVn value=$clsTour->getTitle($listTour[i].tour_id)}
		{assign var=linkVn value=$clsTour->getLink($listTour[i].tour_id)}
        <div class="box">
            <div class="TourItem">
                <div class="photo250">
                    <a class="photo" href="{$linkVn}" title="{$titleVn}">
						<img class="img-responsive" src="{$clsTour->getImage($listTour[i].tour_id,600,400)}" alt="{$titleVn}" width="100%" /></a>
                 <div class="price">From <strong>{$clsTour->getTripPrice($listTour[i].tour_id)}</strong></div>
                 <div class="duration">{$clsTour->getTripDuration($listTour[i].tour_id)}</div>
                </div>
                <div class="body">
                    <h3><a href="{$link}" title="{$title}">{$clsTour->getTitle($listTour[i].tour_id)}</a></h3>
                    <div class="address"><i class="icon_add"></i>
                        {$clsTour->getCityAround($listTour[i].tour_id)}
                    </div>
                    <div class="intro14_3">
                        {$clsTour->getStripIntro($listTour[i].tour_id)|truncate:80}
                    </div>
                </div>
                <a class="linkBook" href="{$clsTour->getLinkBook($tour_id)}" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
            </div>
        </div>		
		{/section}
	</div>
</div>
{literal}
<script type="application/javascript">
	if($('#jcarousel-slides').length > 0){
		var $owl = $('#jcarousel-slides');
		$owl.owlCarousel({
			loop:true,
			margin:30,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:false
				},
				600:{
					items:2,
					nav:false
				},
				1200:{
					items:4,
					nav:false
				}
			}
		});
		$('.control_js #next').click(function(){
			$('.owl-next').trigger('click');
			checkTourItem();
		});
		$('.control_js #prev').click(function(){
			$('.owl-prev').trigger('click');
			checkTourItem();
		});
	}
</script>
{/literal}