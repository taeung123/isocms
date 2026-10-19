<div class="sliderWrapper block1140" style="display:none">
     {if $lstImage ne ''}
    <div id="sliderTourDetail" class="owl-carousel">
    	<div class="sliderItem">
			<img src="{$clsTour->getImage($tour_id,944,629)}" width="100%" alt="" />
        </div>
    	{section name=i loop=$lstImage} 
        <div class="sliderItem" style="cursor:pointer">
			<img src="{$clsTourImage->getImage($lstImage[i].tour_image_id,944,629)}" width="100%" alt="" />
        </div>
        {/section}     
    </div>
    {else}
    <div id="imageTourDetail">
    	<div class="sliderItem">
			<img src="{$clsTour->getImage($tour_id,944,629)}" width="100%" alt="" />
        </div>
    </div>
    {/if}
    {if $clsTour->getTripPrice($tour_id,$now_day) gt '0'}
     <div class="leadin visible-sm visible-xs">
        <span>From</span>
        <span class="field-trip-price">{$clsISO->getRate()} {$clsTour->getTripPrice($tour_id,$now_day)}</span>
    </div>
    {elseif $clsTour->getTripPrice($tour_id,$now_day) eq '0' and $clsTour->getLTripPriceOld($tour_id) gt '0'}
    <div class="leadin visible-sm visible-xs">
        <span>From</span>
        <span class="field-trip-price">{$clsISO->getRate()} {$clsTour->getLTripPriceOld($tour_id)}</span>
    </div>
    {elseif $clsTour->getTripPrice($tour_id,$now_day) gt '0' and $clsTour->getLTripPriceOld($tour_id) eq '0'}
    <div class="leadin visible-sm visible-xs">
        <span>From</span>
        <span class="field-trip-price">{$clsISO->getRate()} {$clsTour->getTripPrice($tour_id,$now_day)}</span>
    </div>
    {else}
    
    {/if}
</div>
{literal}
<script type="text/javascript">
 $(function(){
	if($('#sliderTourDetail').length > 0){
		var $owl = $('#sliderTourDetail');
		$owl.owlCarousel({
			loop:true,
			margin:0,
			responsiveClass:true,
			autoplay:true,
			responsive:{
				0:{
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
			$('#sliderTourDetail .owl-next').trigger('click');
		});
		$('#prev_1').click(function(){
			$('#sliderTourDetail .owl-prev').trigger('click');
		});
	}
});
</script>
<style type="text/css">
.sliderWrapper{position:relative}
.sliderWrapper .container_wrapper {
    position: absolute;
    top: 30%;
    z-index: 99;
    width: 65%;
    left: 0;
    right: 0;
    margin: 0 auto;
}
.sliderWrapper .owl-dots{display:none !important}
.sliderWrapper #sliderHomePage{height:100%; overflow:hidden}
#sliderHomePage .container{position:relative}
.sliderWrapper h1.banner_sub_heading {
    text-transform: none;
    font-size: 28px;
    color: #fff;
    font-weight: 400;
    margin-top: 20px;
}
.sliderWrapper p.banner_main_heading{
    text-transform: uppercase;
    font-size: 42px;
    color: #fff;
    font-weight: 700;
    margin-top: 6px;
    text-shadow: 1px 1px 1px #515151;
    margin-bottom: 60px;
}
.sliderItem{position:relative}
.sliderItem .titleSlide{position:absolute; width:auto; height:36px; line-height:36px; background:rgba(0,0,0,0.6); bottom:15px; right:15px; color:#fff; padding:0 10px}
.search_page {
    background: #fff;
	height:46px; 
	overflow:hidden;
}
.main form.form-inline {
	width:100%;
    max-width: 100%;
    margin: auto;
    padding-top: 0px;
    margin-bottom: 0px;
}
.search_page .form-inline.search_bar {
    height: 46px;
}
.search_page .form-inline .form-group{
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
}
.w30 {
    width: 30%!important;
}
.search_page .btn_search{border-radius:0}
.search_page .btn_search i{
    color:#fff;
}
.search_page .btn_search span{
    color:#fff;
}
.sliderWrapper .leadin {
	bottom: -47px;
    padding-top: 0px;
    border-radius: 50%;
    width: 95px;
    height: 95px;
    border: 2px solid #fff;
    text-align: center;
    display: flex !important;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    background: #F60;
    position: absolute;
    left: 10%;
    right: 10%;
    z-index: 9;
    margin: 0 auto;
}
.sliderWrapper .leadin span {
    font-size: 10px;
    text-transform: uppercase;
    display: block;
    font-weight: 500;
    line-height: 14px;
	color:#fff;
}
.sliderWrapper .leadin span.field-trip-price {
    font-size: 16px;
    display: inline;
    line-height: 26px;
    padding-top: 0;
	color:#fff; 
	font-weight:bold;
	
}
@media only screen and (min-width: 1200px) {
	.sliderWrapper{}
}
@media only screen and (max-width: 1024px) {

.sliderWrapper .container_wrapper {
	 top: 15%;
	width: 80%;
}
}
@media only screen and (max-width: 992px) {
	.sliderWrapper{}


	.sliderWrapper #sliderHomePage img{height:400px}
	.sliderWrapper h1.banner_sub_heading {
		text-transform: none;
		font-size: 18px;
		color: #fff;
		font-weight: 400;
		margin: 0px;
	}
	.sliderWrapper p.banner_main_heading {
		text-transform: uppercase;
		font-size: 40px;
		color: #fff;
		font-weight: 700;
		margin-top: 6px;
		text-shadow: 1px 1px 1px #515151;
		margin-bottom: 30px;
	}

}
@media only screen and (max-width: 768px) {
	.sliderWrapper{}
	.sliderWrapper .container_wrapper {
		width: 90%;
	}
}
@media only screen and (max-width: 600px) {
	.sliderWrapper{}
	.sliderWrapper p.banner_main_heading {
		text-transform: uppercase;
		font-size: 32px;
		line-height:36px;
		color: #fff;
		font-weight: 700;
		margin-top: 6px;
		text-shadow: 1px 1px 1px #515151;
		margin-bottom: 20px;
	}
}
@media only screen and (max-width: 450px) {
	.sliderWrapper .container_wrapper {
		 top: 22%;
		width: 95%;
	}
}
@media only screen and (max-width: 350px) {
	.sliderWrapper .container_wrapper {
		 top: 18%;
		width: 95%;
	}
}


</style>
{/literal}
