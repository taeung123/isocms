<div class="page_container wapper_content page_cruise_cat">
    <div class="cruise-banner">
        {if $deviceType eq 'computer'}
            <img class="img100" src="{$clsConfiguration->getImage('site_cruise_banner',1920,400)}" width="1920" height="400" alt="{$core->get_Lang('Cruise')}" />
        {else}
            <img class="img100" src="{$clsConfiguration->getImage('site_cruise_banner',480,320)}" width="480" height="320" alt="{$core->get_Lang('Cruise')}" />
        {/if}
    </div>
    <nav class="breadcrumb-main cruise hidden-xs">
        <div class="container">
            <ol class="breadcrumb mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('Home')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                    <a itemprop="item" href="{$curl}" title="{$core->get_Lang('Cruise')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Cruise')}</span>
                    </a>
                    <meta itemprop="position" content="2"/>
                </li>
            </ol>
        </div>
    </nav><!--end breadcrumb-main -->
    <div class="box_cruise_header_page">
        <div class="container">
            <div class="box_top_cruise_cat text-center">
                <h1 class="title_page_cruise">{$core->get_Lang('Cruise')}</h1>
                {assign var=site_cruise_intro value=site_cruise_intro_|cat:$_LANG_ID}
                {assign var=intro_page value=$clsConfiguration->getValue($site_cruise_intro)|html_entity_decode}
                {if $intro_page}
                    <div class="intro_cruise_short">
                        {$intro_page}
                    </div>
                {/if}
            </div>
        </div>
    </div>
    {if $listCruise}
    <section class="section_list_cruise">
        <div class="container">
            <div class="list_cruise">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        {if $checkFilter}
                            {$core->getBlock('box_find_cruise')}
                        {/if}
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div class="list_cruise_2">
                            {section name=i loop=$listCruise}
                                {assign var=cruise_item_id value = $listCruise[i].cruise_id}
                                {assign var=arrCruise value = $listCruise[i]}

                                {$clsISO->getBlock('box_item_cruise',["cruise_item_id"=>$cruise_item_id,"arrCruise"=>$arrCruise])}

                            {/section}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    {/if}

        <section class="box_recommend_cruises">
            <div class="container">
                <div class="clearfix"></div>
                {if $TotalPageCruisePromotion gt $currentPagePromo}
                    <div class="text-center box_btn_click_more mt30">
                        <a href="javascript:void(0);" data-page="{$currentPagePromo+1}" data-cruise_store="RECOMMED" data-cruise_cat_id="{$cat_id}" data-totalpage="{$TotalPageCruisePromotion}" class="load_more_cruise_promo">
                            {$core->get_Lang('Load More')}
                        </a>
                    </div>
                    <div class="text-center pre_loader">
                        <div class="preloader-item">
                            <div class="preloader">
                                <div class="preloader__line_5"></div>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>
        </section><!--end box_recommend_cruises-->

    {$core->getBlock('testimonialsNew')}
</div>
{literal}
<script type="application/ld+json">
    {
      "@context": "http://schema.org/",
      "@type": "Product",
      "name": "{/literal}{$title_cat}{literal}",
  "url": "{/literal}{$link_cat}{literal}",
  "description": "{/literal}{$global_description_page|strip_tags}{literal}",
 "image": "{/literal}{$DOMAIN_NAME}{$clsCruiseCat->getImage($cat_id,225,150,$oneCat)}{literal}",
  "aggregateRating": {
    "@type": "AggregateRating",
	"ratingValue": "{/literal}{if $clsReviews->getRateAvg($cat_id,$mod) gt 0}{$clsReviews->getRateAvg($cat_id,$mod)}{else}5{/if}{literal}",
    "bestRating": "{/literal}{if $clsReviews->getBestRate($cat_id,$mod) gt 0}{$clsReviews->getBestRate($cat_id,$mod)}{else}5{/if}{literal}",
    "ratingCount": "{/literal}{if $clsReviews->getToTalReview($cat_id,$mod) gt 0}{$clsReviews->getToTalReview($cat_id,$mod)}{else}1{/if}{literal}"
  }
}
</script>
{/literal}
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(document).on('click', '.more_intro_c,.less_intro_c',function(ev){
                $_this = $(this);
                $_parent = $_this.closest('.home_header');
                $_type = 'more';
                if($_this.hasClass('less_intro_c')){
                    $_type = 'less';
                }
                if($_type == 'more'){
                    $_parent.find('.intro_cruise_short').hide();
                    $_parent.find('.intro_cruise_full').show();
                }else{
                    $_parent.find('.intro_cruise_full').hide();
                    $_parent.find('.intro_cruise_short').show();
                }
                ev.stopImmediatePropagation();
                return false;
            });
        })
    </script>
{/literal}
<script defer src="{$URL_JS}/jquerycruise.js?v={$upd_version}"></script>