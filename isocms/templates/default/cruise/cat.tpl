<div class="page_container wapper_content page_cruise_cat">
    <div class="cruise-banner">
        {if $deviceType == 'computer'}
            <img class="img100" src="{$clsCruiseCat->getImageBanner($cat_id,1920,400,$oneCat)}" width="1920"
                 height="400" alt="{$title_cat}"/>
        {else}
            <img class="img100" src="{$clsCruiseCat->getImageBanner($cat_id,480,320,$oneCat)}" width="480" height="320"
                 alt="{$title_cat}"/>
        {/if}
    </div>
    <nav class="breadcrumb-main cruise hidden-xs">
        <div class="container">
            <ol class="breadcrumb mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('Home')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                    <meta itemprop="position" content="1"/>
                </li>
                {assign var=position value=2}
                {assign var=arr_parent value=$clsCruiseCat->getListParentLevel($cat_id)}
                {if $arr_parent}
                    {foreach from=$arr_parent item=item}
                        {assign var=oneCatParent value=$clsCruiseCat->getOne($item,'title,slug')}
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{$clsCruiseCat->getLink($item,$oneCatParent)}"
                               title="{$oneCatParent.title}">
                                <span itemprop="name" class="reb">{$oneCatParent.title}</span></a>
                            <meta itemprop="position" content="{$position}"/>
                        </li>
                        {math equation = "x+1" x=$position assign="position"}
                    {/foreach}
                {/if}
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                    <a itemprop="item" href="{$link_cat}" title="{$title_cat}">
                        <span itemprop="name" class="reb">{$title_cat}</span>
                    </a>
                    <meta itemprop="position" content="{$position}"/>
                </li>
            </ol>
        </div>
    </nav><!--end breadcrumb-main -->
    <div class="box_cruise_header_page">
        <div class="container">
            <div class="box_top_cruise_cat text-center">
                <h1 class="title_page_cruise">{$title_cat}</h1>
                {if $intro_More}
                    <div class="intro_cruise_short">
                        {$intro_More}
                    </div>
                {/if}
            </div>
        </div>
    </div><!--end box_cruise_header_page-->
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
                    <a href="javascript:void(0);" data-page="{$currentPagePromo+1}" data-cruise_store="RECOMMED"
                       data-cruise_cat_id="{$cat_id}" data-totalpage="{$TotalPageCruisePromotion}"
                       class="load_more_cruise_promo">
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
            $(document).on('click', '.more_intro_c,.less_intro_c', function (ev) {
                $_this = $(this);
                $_parent = $_this.closest('.home_header');
                $_type = 'more';
                if ($_this.hasClass('less_intro_c')) {
                    $_type = 'less';
                }
                if ($_type == 'more') {
                    $_parent.find('.intro_cruise_short').hide();
                    $_parent.find('.intro_cruise_full').show();
                } else {
                    $_parent.find('.intro_cruise_full').hide();
                    $_parent.find('.intro_cruise_short').show();
                }
                ev.stopImmediatePropagation();
                return false;
            })
            .on('click', '.box_utilities_more', function () {
                $(this).find('.box_utilities_more_list').addClass('active');
            })
            .on('click', function (event) {
                if (!$(event.target).closest('.box_utilities_more').length) {
                    $('.box_utilities_more_list').removeClass('active');
                }
            })
        })
        
    </script>
{/literal}
<script defer src="{$URL_JS}/jquerycruise.js?v={$upd_version}"></script>