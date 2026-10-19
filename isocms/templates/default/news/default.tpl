{assign var=title_new_cat value=$clsNewsCategory->getTitle($newscat_id,$arrayCat)}

<div class="page_container news_page_container">
    <div class="banner">
        {assign var="w" value=($deviceType=="computer")?1920:480}
        {assign var="h" value=($deviceType=="computer")?400:320}
        <img class="img100" src="{$clsConfiguration->getImage(site_news_banner,$w,$h)}" alt="{if $show eq 'Default'}{$core->get_Lang('Our Blog')}{else}{$core->get_Lang('Blog in')}{$TD|default:''}{/if}"/>
    </div>
    <div class="news_box_breadcrumb">
        <nav class="breadcrumb-main">
            <div class="container">
                <ol class="breadcrumb hidden-xs mt0" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
                            <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                        <meta itemprop="position" content="1"/>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$clsISO->getLink('news')}" title="{$core->get_Lang('News')}">
                            <span itemprop="name" class="reb">{$core->get_Lang('News')}</span></a>
                        <meta itemprop="position" content="2"/>
                    </li>
                    {if $newscat_id gt '0'}
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{$clsNewsCategory->getLink($newscat_id,$arrayCat)}"
                               title="{$title_new_cat}">
                                <span itemprop="name" class="reb">{$title_new_cat}</span></a>
                            <meta itemprop="position" content="3"/>
                        </li>
                    {/if}
                </ol>
            </div>
        </nav>
    </div>

    <div id="contentPage" class="newsPage pageNewsDefault bg_fff">
        <div class="container">
            <section class="box_news_list">
                <div class="row">
                    <div class="col-lg-9 leftNews">
                        <h1 class="Title_news">{$core->get_Lang('Latest news')}</h1>
                        <div class="boxListItem mts">
                            <div class="row">
                                {section name=i loop=$lstNews}
                                {assign var=title_news value=$clsNews->getTitle($lstNews[i].news_id,$lstNews[i])}
                                {assign var=link_news value=$clsNews->getLink($lstNews[i].news_id,$lstNews[i])}
                                <article class="news_Items col-12 col-sm-6 col-lg-4">
                                    <div class="content" href="{$link_news}" title="{$title_news}">
                                        <a class="photo" href="{$link_news}" title="{$title_news}">
                                            <img class="img-responsive img_scale img100 lazy" src="{$clsNews->getImage($lstNews[i].news_id,298,248,$lstNews[i])}" alt="{$title_news}" title="{$title_news}" loading="lazy">
                                        </a>
                                        <div class="info_news">
                                            <span class="author_news">{$clsNewsCategory->getTitle($lstNews[i].newscat_id)}</span>
                                            <h3 class="title24 color_333 mb10">
                                                <a class="fontSize24 color_333" href="{$link_news}"
                                                   title="{$title_news}">{$title_news}
                                                </a>
                                            </h3>
                                            <span class="news_date">
                                                {if $lstNews[i].publish_date}
                                                    {$clsISO->converTimeToText($lstNews[i].publish_date)}
                                                {else}
                                                    {$clsISO->converTimeToText($lstNews[i].reg_date)}
                                                {/if}
                                            </span>
                                        </div>
                                    </div>
                                </article>
                                {/section}
                            </div>

                        </div>
                        {if $totalPage gt '1'}
                            <div class="clearfix"></div>
                            <div class="pagination pager">
                                {$page_view}
                            </div>
                        {/if}
                    </div>
                    <div class="col-lg-3 rightNews">
                        <div class="sticky_fix">
                            {$core->getBlock('l_boxcolNews')}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

