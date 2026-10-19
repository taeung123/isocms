<script defer type="text/javascript" src="{$URL_JS}/jquery.sharer.js?v={$up_version}"></script>
<div class="page_container">
    <nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="{$clsISO->getLink('blog')}" title="{$core->get_Lang('Blogs')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Blogs')}</span></a>
                    <meta itemprop="position" content="2" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="{$curl}" title="{$title_blog_cat}">
                        <span itemprop="name" class="reb">{$title_blog_cat}</span></a>
                    <meta itemprop="position" content="3" />
                </li>
            </ol>
        </div>
    </nav>
    <section id="contentPage" class="blogPage pageBlogCat bg_f1f1f1">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 blogLeft mb991_30">
                    <h1 class="title32 color_333 mb20">{$core->get_Lang('Blog listing by')} {if $show eq 'Cat'}
                        {$core->get_Lang('category')} {$title_blog_cat}{else} {$title_blog_cat} of {if $show eq
                        'Country'}
                        {$title_country_blog} {else}{$title_city_blog}{/if} {/if}</h1>
                    <div class="row">
                        {foreach from=$lstBlogs key=key item=item}
                        {assign var=title_blog value=$clsBlog->getTitle($item.blog_id,$item)}
                        {assign var=link_blog value=$clsBlog->getLink($item.blog_id,$item)}
                        {assign var=author value=$clsBlog->getAuthor($item.blog_id,$item)}
                        <article class="blogItem col-12 col-sm-6 col-lg-4">
                            {*<div class="submitted">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                {$clsISO->converTimeToText($item.publish_date)} {if $author ne ''}<i class="fa fa-user"
                                    aria-hidden="true"></i> {$author} {/if}
                                {assign var=link_share value=$link_blog}
                                {assign var=title_share value=$title_blog}
                                {$core->getBlock('box_share')}
                            </div>*}
                            <div class="content" href="{$link_blog}" title="{$title_blog}">
                                <a class="photo" href="{$link_blog}" title="{$title_blog}">
                                    <img class="trek-blog-gallery lazy img100" src="{$clsBlog->getImage($item.blog_id,298,248,$item)}"
                                        data-src="{$clsBlog->getImage($item.blog_id,298,248,$item)}" alt="{$title_blog}"
                                        title="{$title_blog}" draggable="false">
                                </a>
                                <div class="info_blog">
                                    <span class="author_blog">{$author}</span>
                                    <h3 class="title24 color_333 mb10"><a class="fontSize24 color_333"
                                            href="{$link_blog}" title="{$title_blog}">{$title_blog}</a></h3>
                                    <span class="blog_date">{$clsISO->converTimeToText($item.publish_date)}</span>
                                    {*<div class="bodyBlog textjustify992">
                                        {$clsBlog->getIntro($item.blog_id,$item)|strip_tags|truncate:250}
                                        <a class="linkBlog" href="{$link_blog}"
                                            title="{$title_blog}">{$core->get_Lang('Read
                                            more')}</a>
                                    </div>*}
                                </div>
                            </div>
                        </article>
                        {/foreach}
                    </div>
                    {*{section name=i loop=$lstBlogs}
                    {assign var=title_blog value=$clsBlog->getTitle($lstBlogs[i].blog_id,$lstBlogs[i])}
                    {assign var=link_blog value=$clsBlog->getLink($lstBlogs[i].blog_id,$lstBlogs[i])}
                    <article class="blogItem">
                        <h3 class="title24 color_333 mb10"><a class="fontSize24 color_333" href="{$link_blog}"
                                title="{$title_blog}">{$title_blog}</a></h3>
                        <div class="submitted">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            {$clsISO->converTimeToText($lstBlogs[i].publish_date)} {if $lstBlogs[i].author ne
                            ''}&nbsp;<i class="fa fa-user" aria-hidden="true"></i> {$lstBlogs[i].author} {/if}
                            {assign var=link_share value=$link_blog}
                            {assign var=title_share value=$title_blog}
                            {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
                        </div>
                        <div class="content">
                            <a class="photo" href="{$link_blog}" rel="tag" title="{$title_blog}">
                                <img class="trek-blog-gallery lazy img100" src="{$URL_IMAGES}/pixel.png"
                                    data-src="{$clsBlog->getImage($lstBlogs[i].blog_id,730,487,$lstBlogs[i])}"
                                    alt="{$title_blog}" title="{$title_blog}" draggable="false">
                            </a>
                            <div class="bodyBlog textjustify992">
                                {$clsBlog->getIntro($lstBlogs[i].blog_id,$lstBlogs[i])|strip_tags|truncate:250}
                                <a class="linkBlog" href="{$link_blog}" rel="tag"
                                    title="{$title_blog}">{$core->get_Lang('Read more')}</a>
                            </div>
                        </div>
                    </article>
                    {/section}*}
                    <div class="clearfix"></div>
                    {if $totalPage gt '1'}
                    <div class="text-center">
                        <div class="item-list">
                            <div class="pagination pager">
                                {$page_view}
                            </div>
                        </div>
                    </div>
                    {/if}
                </div>
                <aside class="col-lg-3 sidebar rightBlog">
                    {$core->getBlock('l_rightblog')}
                </aside>
            </div>
        </div>
    </section>
</div>