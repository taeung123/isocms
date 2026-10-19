{assign var=TD value=$clsRegion->getTitle($region_id,$oneItemRegion)}

<link rel="stylesheet" href="{$URL_CSS}/travelguide.css?v={$upd_version}"/>
<div class="page_container blog_page_container">
    <div class="banner">
        {assign var="w" value=($deviceType=="computer")?1920:480}
        {assign var="h" value=($deviceType=="computer")?400:320}
        <img class="img100" src="{$clsConfiguration->getImage(site_guide_banner,$w,$h)}"
             alt="{if $show ne 'default'}{$core->get_Lang('Travel Guide')}{else}{$core->get_Lang('Travel Guide in')}{$TD}{/if}"/>
    </div>
    <div class="blog_box_breadcrumb">
        <nav class="breadcrumb-main">
            <div class="container">
                <ol class="breadcrumb hidden-xs mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    {if LANG_ID}
                    {/if}
                        <a itemprop="item" href="{$homeUrl}" title="{$core->get_Lang('Home')}">
                            <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                        <meta itemprop="position" content="1"/>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
           
                        <span itemprop="name" class="reb">{$core->get_Lang('Travel Guide')}</span>
                        <meta itemprop="position" content="2"/>
                    </li>
                </ol>
            </div>
        </nav>
    </div>
    <div id="contentPage" class="pageBlogDefault bg_f1f1f1 pdt50">
        <article class="container">
            <div class="row">
                <div class="col-lg-9 blogLeft mb991_30">
                    <h1 class="title32 color_333 mb20">
                        {if $show ne 'default'}{$core->get_Lang('Travel Guide')}{else}{$core->get_Lang('Travel Style in')} {$TD}{/if}
                    </h1>
                    <div class="row">
                        {if $listGuide}
                            {foreach from=$listGuide key=key item=item}
                                {assign var=title_guide value=$clsGuide->getTitle($item.guide_id, $item)}
                                {assign var=link_guide value=$clsGuide->getLink($item.guide_id, $item)}
                                <article class="blogItem col-12 col-sm-6 col-lg-4"
                                         data-country="{$item.country_id}">
                                    <div class="content" href="{$link_guide}" title="{$title_guide}">
                                        <a class="photo" href="{$link_guide}" title="{$title_guide}">
                                            <img
                                                class="trek-blog-gallery img100"
                                                src="{$clsGuide->getImage($item.guide_id,298,248,$item)}"
                                                alt="{$title_guide}"
                                                title="{$title_guide}">
                                        </a>
                                    </div>
                                    <div class="info_blog">
                                        <h3 class="title24 color_333 mb10">
                                            <a class="fontSize24 color_333" href="{$link_guide}"
                                               title="{$title_guide}">{$title_guide}
                                            </a>
                                        </h3>
                                        <span class="blog_date">{$clsGuide->getPublishDate($item.guide_id)}</span>
                                    </div>
                                </article>
                            {/foreach}
                        {/if}
                    </div>
                
                    {if $totalRecord gt 1}
                        <div class="text-center">
                            <div class="item-list">
                                <div class="pagination pager">
                                    {$page_view}
                                </div>
                            </div>
                        </div>
                    {/if}
                </div>
                <aside class="col-lg-3 rightBlog">
                    <div class="sticky_fix">
                        <div class="sidebar">
                            {$core->getBlock('l_rightguide_search')}
                        </div>
                    </div>
                </aside>
            </div>
        </article>
    </div>
</div>
{literal}
    <script>
        $("#box_inforblog").owlCarousel({
            loop: true,
            dots: false,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 30,
                },
                600: {
                    items: 2,
                    margin: 30,
                },
                1000: {
                    items: 4,
                    margin: 30,
                },
            },
        });
        $(function () {
            $(document).on("click", ".view-more-tour-relate", function () {
                $(".box_blog_tour_relate:hidden").show();
                $(this).hide();
            });
            $(document).on("click", ".view-more-cruise-relate", function () {
                $(".cruise-relate:hidden").show();
                $(this).hide();
            });
        });
    </script>
{/literal}