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
    <div class="partner_logo_box">
    	{section name=i loop=$lstPartner}
    		<div class="partner_icon_scale">
    			<a href="{$clsPartner->getLink($lstPartner[i].partner_id)}" target="_blank">
    				<i data-image="i_shangrila_en" class="i_shangrila_en" style="background-image: url({$clsPartner->getUrlImage($lstPartner[i].partner_id)})"></i>
    			</a>
    		</div>
    	{/section}
    </div>
 	</div>
</section>
{/if}