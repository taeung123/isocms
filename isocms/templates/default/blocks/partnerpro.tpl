{if $lstPartner}
<section class="section_box partner__box bg_fff">
    <div class="partner__box--header header__content">
        {assign var = TitlePartner value = TitlePartner_|cat:$_LANG_ID}
        {assign var = IntroPartner value = IntroPartner_|cat:$_LANG_ID}
        <h2 class="section_box-title">{$clsConfiguration->getValue($TitlePartner)}</h2>
        <div class="section_box-intro">
            {$clsConfiguration->getValue($IntroPartner)|html_entity_decode}
        </div>
    </div>
    <div class="container">
    <div class="partner_logo_box owl-carousel">
    	{section name=i loop=$lstPartner}
        <div class="partner_icon_scale">
            <a href="{$lstPartner[i].url}" title="{$lstPartner[i].title}" target="_blank">
                <img title="{$lstPartner[i].title}" src="{$clsPartner->getUrlImage($lstPartner[i].partner_id,$lstPartner[i])}" height="auto" width="auto"/>
            </a>
        </div>
        {/section}
    </div>
 	</div>
</section>
{if $deviceType eq 'phone'}
{literal}
<script>
    if($('.partner_logo_box').length > 0){
		var $owl = $('.partner_logo_box');
		$owl.owlCarousel({
			loop:false,
			nav: false,
			dots:false,
			margin:10,
			autoplay:true,
            autoplayTimeout:3000,	
			responsiveClass:true,
			responsive:{
				0:{
					items:2,
                    margin:20,
                    nav: false,
				},
				320:{
					items:2.3,
					margin:20,
				},
				360:{
					items:2.5,
					margin:20,
				},
				420:{
					items:3,
					margin:20,
				}
			}
		});
	}
</script>
{/literal}
{/if}
{/if}