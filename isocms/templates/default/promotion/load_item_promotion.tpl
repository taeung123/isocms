{if $clsTable eq 'tour'}
    {if $listArr}
        <div class="row" id="home-masonry-container">
            {section name=i loop=$listArr}
                {assign var=title_item value =$clsTour->getTitle($listArr[i].tour_id)}
                {assign var=link_item value =$clsTour->getLinkLoad($listArr[i].tour_id)}
                {assign var=image_item value =$clsTour->getImage($listArr[i].tour_id,300,200)}
                {assign var=wishlist_num value=$clsTour->getOneField('wishlist_num',$listArr[i].tour_id)}
                {assign var=promotion_id value=$clsTour->getMinStartDatePromotionProID($listArr[i].tour_id)}
                {assign var=checkmem value=$clsTour->getCheckMemSet($listArr[i].tour_id)}
                {assign var=getFlagText value=$clsPromotion->getFlagText($promotion_id)}
                {assign var=getLTripDuration value=$clsTour->getTripDuration2019($listArr[i].tour_id)}
                {assign var=getStarNew value=$clsReviews->getStarNew($listArr[i].tour_id,tour)}
                {assign var=getToTalReview value=$clsReviews->getToTalReview($listArr[i].tour_id,tour)}
                {assign var=getPriceTourPromotion value=$clsTour->getTripPriceNewPro2019($listArr[i].tour_id,$now_day,$is_agent)}
                {assign var=getPriceTourPromotionnomem value=$clsTour->getTripPriceNewPro2019($listArr[i].tour_id,$now_day,$is_agent,'nomem')}
                <div class="col-sm-4 box">
                    <div class="item_image_pro">
                        <span style="cursor:pointer;right: 25px;" class="{if $profile_id eq ''}exitLoginHome{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" clsTable="Tour" data="{$listArr[i].tour_id}" id="addwishlistTour{$listArr[i].tour_id}">{$wishlist_num}</span>
                        <a href="{$link_item}" title="{$title_item}">
                            <img src="{$image_item}" alt="{$title_item}" width="100%" height="auto">
                        </a>
                    </div>
                   
                    <div class="content_item_pro">
                        <div class="body_item_top">
                            <h3 class="title_item_pro"><a href="{$link_item}" title="{$title_item}">{$title_item}</a></h3>
                            {if $checkmem eq 1}
                                {if $profile_id ne ''}
                                    {if $getFlagText ne ''}
                                        <p class="discount_text_item_pro">{$getFlagText}</p>
                                    {/if}
                                {/if}
                            {else}
                                {if $getFlagText ne ''}
                                    <p class="discount_text_item_pro">{$getFlagText}</p>
                                {/if}
                            {/if}
                        </div>
                        <p class="duration" style="height: 21px"> {$getLTripDuration}</p>
                        <div class="body_item_bottom">
                            <div class="tour_rate">
                                <label class="rate-2019 block mb05">{$getStarNew}</label>
                                <span class="review_text color_666">{$clsReviews->getRateAVG($listArr[i].tour_id,'tour')}/5 - <span class="text_bold color_333">{$getToTalReview} {$core->get_Lang('reviews')}</span></span>
                            </div>
                            <div class="tour_price">

                                {if $checkmem eq 1}
                                    {if $profile_id eq ''}{$getPriceTourPromotionnomem}{else}{$getPriceTourPromotion}{/if}
                                {else}
                                    {$getPriceTourPromotion}
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            {/section}

        </div>
        {if $totalPage gt 1}
            <div class="cleafix"></div>
            <div id="exploreWorldLoadMore">
                <div id="load_more_collections">
                    <div class="loader"></div>
                    <a href="javascript:void(0);" rel="nofollow" page="1" class="btn_orance_border show-loader" id="show-more">{$core->get_Lang('LOAD MORE COLLECTIONS')}</a>
                </div>
            </div>
        {/if}
    {/if}
    <script type="text/javascript">
        var totalRecord='{$totalRecord}';
        var clsTable='{$clsTable}';
        var $pageLastest = 1;
        var country_check='{$country_id}';
        var city_id='{$city_id}';
        var sort='{$sort}';
        var travel_style_check='{$cat_ID}';
        var min_duration='{$min_duration}';
        var max_duration='{$max_duration}';
        var travel_acti_check='{$activities_id}';
        var $_LANG_ID = '{$_LANG_ID}';
    </script>

    {literal}
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $("#show-more").on('click',function () {
                    var $_this = $(this);
                    $_this.find('.ajax-loader').show();
                    $pageLastest++;
                    $.ajax({
                        type:'POST',
                        url:path_ajax_script+'/index.php?mod=promotion&act=ajLoadMorePromotion',
                        data:{
                            "clsTable":clsTable,
                            "page":$pageLastest,
                            "sort":sort,
                            "country_check":country_check,
                            "travel_style_check":travel_style_check,
                            "min_duration":min_duration,
                            "max_duration":max_duration,
                            "travel_acti_check":travel_acti_check,
                            "_LANG_ID":$_LANG_ID,
                        },
                        dataType:'html',
                        success:function(html){
                            $_this.find('.ajax-loader').hide();
                            $('#home-masonry-container').append(html);
                            setwidthLeft();
                        }
                    });
                    setInterval(function(){
                        loadPagepro();
                    },100);
                });
                function loadPagepro($number_per_page){
                    var $number_show = $('#home-masonry-container .box:visible').size();
                    if($number_show >= totalRecord){
                        $('#exploreWorldLoadMore').remove();
                    }
                }
            })
        </script>
    {/literal}
{elseif $clsTable eq 'cruise'}
    {if $listArr}
        <div class="row" id="home-masonry-container">
            {foreach from=$listArr key=k item=v}
                {assign var=title_item value =$clsCruise->getTitle($v.cruise_id)}
                {assign var=link_item value =$clsCruise->getLink($v.cruise_id)}
                {assign var=promotion_id value =$clsCruise->getMinStartDatePromotionProID($v.cruise_id)}
                {assign var=check_mem value =$clsCruise->getCheckMemSet($v.cruise_id)}
                {assign var=image_item value =$clsCruise->getImage($v.cruise_id,380,250)}
                {assign var=getStarNew value =$clsReviews->getStarNew($v.cruise_id,'cruise')}
                {assign var=getToTalReview value=$clsReviews->getToTalReview($v.cruise_id,'cruise')}
                <div class="col-sm-4 box">
                    <div class="item_image_pro">
                        {*<span style="cursor:pointer;right: 25px;" class="{if $profile_id eq ''}exitLoginHome{else}addWishlist{/if} heart-o inline-block text-center btnwl" title="{$core->get_Lang('Saved to wishlist')}" clsTable="Tour" data="{$listArr[i].tour_id}" id="addwishlistTour{$listArr[i].tour_id}">{$wishlist_num}</span>*}
                        <a href="{$link_item}" title="{$title_item}">
                            <img src="{$image_item}" alt="{$title_item}" width="100%" height="auto">
                        </a>
                    </div>

                    <div class="content_item_pro">
                        <div class="body_item_top">
                            <h3 class="title_item_pro"><a href="{$link_item}" title="{$title_item}">{$title_item}</a></h3>
                            {*{if $checkmem eq 1}
                                {if $profile_id ne ''}
                                    {if $getFlagText ne ''}
                                        <p class="discount_text_item_pro">{$getFlagText}</p>
                                    {/if}
                                {/if}
                            {else}
                                {if $getFlagText ne ''}
                                    <p class="discount_text_item_pro">{$getFlagText}</p>
                                {/if}
                            {/if}*}
                        </div>
                        {*<p class="duration">{$getLTripDuration}</p>*}
                        <div class="body_item_bottom">
                            <div class="tour_rate">
                                <label class="rate-2019 block mb05">{$getStarNew}</label>
                                <span class="review_text color_666">{$clsReviews->getRateAVG($v.cruise_id,'tour')}/5 - <span class="text_bold color_333">{$getToTalReview} {$core->get_Lang('reviews')}</span></span>
                            </div>
                            <div class="tour_price">
                                {if $check_mem eq 1}
                                    {if $profile_id eq ''}
                                        {$clsCruise->getLTripPrice1($v.cruise_id,$now_month,'Valuelist')}
                                    {else}
                                        {$clsCruise->getLTripPrice1($v.cruise_id,$now_month,'list')}
                                    {/if}
                                {else}
                                    {$clsCruise->getLTripPrice1($v.cruise_id,$now_month,'list')}
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
            {section name=i loop=$listArr}

            {/section}

        </div>
        {if $totalPage gt 1}
            <div class="cleafix"></div>
            <div id="exploreWorldLoadMore">
                <div id="load_more_collections">
                    <div class="loader"></div>
                    <a href="javascript:void(0);" rel="nofollow" page="1" class="btn_orance_border show-loader" id="show-more">{$core->get_Lang('LOAD MORE COLLECTIONS')}</a>
                </div>
            </div>
        {/if}
    {/if}
    <script type="text/javascript">
        var totalRecord='{$totalRecord}';
        var clsTable='{$clsTable}';
        var $pageLastest = 1;
        var country_check='{$country_id}';
        var city_id='{$city_id}';
        var sort='{$sort}';
        var travel_style_check='{$cat_ID}';
        var min_duration='{$min_duration}';
        var max_duration='{$max_duration}';
        var travel_acti_check='{$activities_id}';
        var cruise_cat_check='{$cruise_cat_id}';
        var $_LANG_ID = '{$_LANG_ID}';
    </script>

{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $("#show-more").on('click',function () {
                var $_this = $(this);
                $_this.find('.ajax-loader').show();
                $pageLastest++;
                $.ajax({
                    type:'POST',
                    url:path_ajax_script+'/index.php?mod=promotion&act=ajLoadMorePromotion',
                    data:{
                        "clsTable":clsTable,
                        "page":$pageLastest,
                        "sort":sort,
                        "country_check":country_check,
                        "travel_style_check":travel_style_check,
                        "min_duration":min_duration,
                        "max_duration":max_duration,
                        "travel_acti_check":travel_acti_check,
                        "cruise_cat_check":cruise_cat_check,
                        "_LANG_ID":$_LANG_ID,
                    },
                    dataType:'html',
                    success:function(html){
                        $_this.find('.ajax-loader').hide();
                        $('#home-masonry-container').append(html);
                        setwidthLeft();
                    }
                });
                setInterval(function(){
                    loadPagepro();
                },100);
            });
            function loadPagepro($number_per_page){
                var $number_show = $('#home-masonry-container .box:visible').size();
                if($number_show >= totalRecord){
                    $('#exploreWorldLoadMore').remove();
                }
            }
        })
    </script>
{/literal}
{elseif $clsTable eq 'hotel'}
    <h2>ok {$clsTable}</h2>
{/if}
