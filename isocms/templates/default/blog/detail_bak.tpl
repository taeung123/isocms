{assign var=title_blog value=$clsBlog->getTitle($blog_id,$blogItem)}
{assign var=publish_date value=$blogItem.publish_date|date_format:"%Y-%m-%d"}
{assign var=upd_date value=$blogItem.upd_date|date_format:"%Y-%m-%d"}
{assign var=author value=$blogItem.author}
{assign var=imgBlog value=$clsBlog->getImage($blog_id,800,535,$blogItem)}
{assign var=listTag value=$clsBlog->getArrayTag($blog_id,$blogItem)}
{literal}
<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "BlogPosting",
        "@id": "{/literal}{$DOMAIN_NAME}{$curl}{literal}#BlogPosting",
    "mainEntityOfPage": "{/literal}{$DOMAIN_NAME}{$curl}{literal}",
    "headline": "{/literal}{$title_blog}{literal}",
    "name": "{/literal}{$title_blog}{literal}",
    "description": "{/literal}{$description_page}{literal}",
    "datePublished": "{/literal}{$publish_date}{literal}",
    "dateModified": "{/literal}{$upd_date}{literal}",
    "author": {
		"@type": "Person",
		"name": "{/literal}{$author}{literal}"
	},
    "publisher": {
		"@type": "Organization",
		"@id": "{/literal}{$DOMAIN_NAME}{literal}",
		"name": "VietISO Company",
		"logo": {
			"@type": "ImageObject",
			"@id": "{/literal}{$DOMAIN_NAME}/uploads/logo/logo_footer_new.png{literal}",
			"url": "{/literal}{$DOMAIN_NAME}/uploads/logo/logo_footer_new.png{literal}",
			"width": "98",
			"height": "47"
		}
	},
    "image": {
        "@type": "ImageObject",
        "@id": "{/literal}{$DOMAIN_NAME}{$imgBlog}{literal}",
		"url": "{/literal}{$DOMAIN_NAME}{$imgBlog}{literal}",
        "height": "535",
        "width": "800"
    },
    "url": "{/literal}{$DOMAIN_NAME}{$curl}{literal}",
    "isPartOf": {
        "@type" : "Blog",
         "@id": "{/literal}{$DOMAIN_NAME}{$clsISO->getLink('blog')}{literal}",
         "name": "{/literal}{$core->get_Lang('Blog')}{literal}",
         "publisher": {
             "@type": "Organization",
             "@id": "{/literal}{$DOMAIN_NAME}{literal}",
             "name": "VietISO Company"
         }
     }
    {/literal}{if $listTag}{literal},"keywords": {/literal}{$listTag|@json_encode}{literal}{/literal}{/if}{literal}
    }
</script>
{/literal}
<div class="page_container">
    <nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span>
                    </a>
                    <meta itemprop="position" content="1" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$clsISO->getLink('blog')}" title="{$core->get_Lang('Blog')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Blog')}</span>
                    </a>
                    <meta itemprop="position" content="2" />
                </li>
                {if $cat_id gt 0 && $clsISO->getCheckActiveModulePackage($package_id,'blog','category','default')}
                    {assign var=itemCat value=$clsBlogCategory->getOne($cat_id,'title,slug')}
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$clsBlogCategory->getLink($cat_id,$itemCat)}" title="{$itemCat.title}">
                            <span itemprop="name" class="reb">{$itemCat.title}</span></a>
                        <meta itemprop="position" content="3" />
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$curl}" title="{$title_blog}">
                            <span itemprop="name" class="reb">{$title_blog}</span></a>
                        <meta itemprop="position" content="4" />
                    </li>
                {else}
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$curl}" title="{$title_blog}">
                            <span itemprop="name" class="reb">{$title_blog}</span></a>
                        <meta itemprop="position" content="3" />
                    </li>
                {/if}
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="blogPage pageBlogDefault bg_f1f1f1">
        <div class="container">
            <h1 class="title32 color_333 mb50">{$title_blog}</h1>
            <div class="row">
                <div class="col-lg-9 blogLeft mb768_30">
                    <div class="blogContent">
                        <div class="tinymce_Content">
                            <div class="submitted">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                {$clsISO->converTimeToText($blogItem.publish_date)}
                                {assign var=getAuthor value=$blogItem.author}
                                {if $getAuthor ne ''}
                                    &nbsp;<i class="fa fa-user" aria-hidden="true"></i>&nbsp; {$getAuthor}
                                {/if}
                                <!--<div class="sharethis-inline-share-buttons" data-image="{$DOMAIN_NAME}{$clsISO->getPageImageShare($blog_id,'Blog',$blogItem)}" data-url="{$DOMAIN_NAME}{$curl}" data-title="{$title_blog}"></div>-->
                                <script type="text/javascript"
                                        src="{$URL_JS}/jquery.sharer.js?v={$up_version}"></script>
                                {assign var=link_share value=$curl}
                                {assign var=title_share value=$title_blog}
                                {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
                            </div>
                            <div class="content">
                                <div class="field-items maxWidthImage">
                                    {$clsBlog->getIntro($blog_id,$blogItem)}
                                    <div class="clearfix mb40"></div>
                                    {$clsBlog->getContent($blog_id,$blogItem)}
                                </div>
                            </div>
                        </div>

                        <div class="comment_box mtm mt30 w-100">
                            <div class="fb-comments" data-href="{$PCMS_URL}{$clsBlog->getLink($blog_id,$blogItem)}"
                                 data-width="100%" data-numposts="5" data-colorscheme="light"></div>
                        </div>
                    </div>
                    {if $lstRelated}
                        <div class="cleafix mb30"></div>
                        <div class="relateBlog mb30">
                            <h2 class="title24 mb20">{$core->get_Lang('Related Blogs')}</h2>
                            <ul class="listBlog">
                                {section name=i loop=$lstRelated}
                                    {assign var=title_blog_relate
                                    value=$clsBlog->getTitle($lstRelated[i].blog_id,$lstRelated[i])}
                                    <li><a class="clickviewtopnews" data-data="{$lstRelated[i].blog_id}"
                                           href="{$clsBlog->getLink($lstRelated[i].blog_id,$lstRelated[i])}"
                                           title="{$title_blog_relate}">{$title_blog_relate}</a></li>
                                {/section}
                            </ul>
                        </div>
                    {/if}
                </div>
                <aside class="col-lg-3 sidebar rightBlog">
                    {$core->getBlock('l_rightblog')}
                </aside>
            </div>
        </div>
    </div>
</div>
{literal}
    <script>
        $('.tinymce_Content img').each(function (i) {
            var self = $(this);
            self.attr('data-action', 'zoom');
        });
    </script>
{/literal}
<link rel="stylesheet" href="{$URL_JS}/zoom/zoom.css?v={$upd_version}" />
<script src="{$URL_JS}/zoom/zoom.js?v={$upd_version}"></script>