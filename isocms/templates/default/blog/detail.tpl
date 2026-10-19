<link rel="preload" href="{$URL_CSS}/blog2.css?v={$upd_version}">
<link rel="stylesheet" href="{$URL_CSS}/blog2.css?v={$upd_version}"/>
{assign var=title_blog value=$clsBlog->getTitle($blog_id,$blogItem)}
{assign var=publish_date value=$blogItem.publish_date|date_format:"%Y-%m-%d"}
{assign var=upd_date value=$blogItem.upd_date|date_format:"%Y-%m-%d"}
{assign var=author value=$blogItem.author}
{assign var=imgBlog value=$clsBlog->getImage($blog_id,800,535,$blogItem)}
{assign var=listTag value=$clsBlog->getArrayTag($blog_id,$blogItem)}
{assign var=title_country value=$clsCountryEx->getTitle($country_id)}
{assign var=title_cat value=$clsBlogCategory->getTitle($cat_id)}

<div class="page_container">
    <div class="detail_top_box">
        <div class="d-flex">
            <div class="col-photo">
                <img src="{$clsBlog->getImage($blog_id,1920,800)}" width="1920" height="800" alt="{$title_blog}"/>
            </div>
            <div class="col-text">
                <div class="blog_info">
                    <p class="country_cat">
                        {if $title_country}
                            <a href="{$clsCountryEx->getLink($country_id,'Blog')}" title="{$title_country}">
                                {$title_country} |
                            </a>
                        {/if}
                        {if $title_cat}
                            <a href="{$clsBlogCategory->getLink($cat_id)}" title="{$title_cat}">
                                {$title_cat}
                            </a>
                        {/if}
                    </p>
                    <h1 class="title text3line">{$title_blog}</h1>
                    <div class="intro text5line">
                        {$clsBlog->getIntro($blog_id,$blogItem)|strip_tags}
                    </div>
                    <div lang="publish_author submitted">
                        <span class="publish_date mgr10">
                            <i class="fa-regular fa-clock"></i>
                            {$clsISO->converTimeToText($blogItem.publish_date)}
                        </span>
                        {if $author}
                            <span class="author">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            {$author}
                        </span>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="breadcrumb-main breadcrumb-{$mod} ">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 " itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$clsISO->getLink('blog')}" title="{$core->get_Lang('Blog')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Blog')}</span>
                    </a>
                    <meta itemprop="position" content="2"/>
                </li>
                {if $cat_id gt 0 && $clsISO->getCheckActiveModulePackage($package_id,'blog','category','default')}
                    {assign var=itemCat value=$clsBlogCategory->getOne($cat_id,'title,slug')}
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$clsBlogCategory->getLink($cat_id,$itemCat)}"
                           title="{$itemCat.title}">
                            <span itemprop="name" class="reb">{$itemCat.title}</span></a>
                        <meta itemprop="position" content="3"/>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$curl}" title="{$title_blog}">
                            <span itemprop="name" class="reb">{$title_blog}</span></a>
                        <meta itemprop="position" content="4"/>
                    </li>
                {else}
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{$curl}" title="{$title_blog}">
                            <span itemprop="name" class="reb">{$title_blog}</span></a>
                        <meta itemprop="position" content="3"/>
                    </li>
                {/if}
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="blogPage pageBlogDefault ">
        {*<div class="share_detail_box sticky_fix">
            <div class="col-share">
                <script type="text/javascript" src="{$URL_JS}/jquery.sharer.js"></script>
                {assign var=link_share value=$curl}
                {assign var=title_share value=$title_blog}
                <span>{$core->get_Lang('Share')}</span>
                {$clsISO->getBlock('box_share',["link_share"=>$link_share,"title_share"=>$title_share])}
            </div>
        </div>*}
        <div class="container">
            <div class="row">
                <div class="col-lg-3" id="iso_box_index">
                    <div class="icon_box_index">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                    <div id="iso_index" class="tinymce_Content">
                        <p class="text_head">{$core->get_Lang('Content')} [<button id="hide_menu" class="iso_hide_menu">{$core->get_Lang('hide')}</button>]</p>
                    </div>
                </div>
                <div class="col-lg-9 blogLeft mb768_30">
                    <div class="blogContent">
                        <div class="tinymce_Content">
                            {$clsBlog->getContent($blog_id,$blogItem)}
                        </div>
                        <div class="clearfix"></div>
                        {assign var=listTagBlog value=$clsBlog->getListTag($blog_id,$blogItem)}
                        <div class="tag_voted">
                            {if $listTagBlog ne ''}
                                <div class="tag_blog">
                                    <p class="title_box">{$core->get_Lang('Tags')}:</p>
                                    <ul class="listtag">{$listTagBlog}</ul>
                                </div>
                            {/if}
                            <div class="voted">
                                {assign var=table_id value=$blog_id}
                                {if $percentRateAVG}
                                    {assign var=percentAVG value=$percentRateAVG}
                                {else}
                                    {assign var=percentAVG value='0'}
                                {/if}
                                {$core->getBlock('rate_star')}
                            </div>
                        </div>
                        <div class="comment_box mtm mt30 w-100">
                            <div class="fb-comments" data-href="{$PCMS_URL}{$clsBlog->getLink($blog_id,$blogItem)}"
                                 data-width="100%" data-numposts="5" data-colorscheme="light"></div>
                        </div>
                    </div>
                </div>
                <aside class="col-lg-3 sidebar rightBlog">
                    {$core->getBlock('l_rightblog')}
                </aside>
            </div>
            {if $lstRelated}
                <div class="cleafix"></div>
                <div class="read_this_next mt80 mb70">
                    <h2 class="title24 mb20">
                        {$core->get_Lang('Read this next')}
                    </h2>
                    <div class="related_list">
                        <div class="row">
                            {* ===== Item đầu tiên (layout lớn) ===== *}
                            {assign var=first value=$lstRelated[0]}
                            {assign var=title value=$clsBlog->getTitle($first.blog_id,$first)}
                            {assign var=link value=$clsBlog->getLink($first.blog_id,$first)}
                            {assign var=country value=$clsCountryEx->getTitle($first.country_id)}
                            {assign var=cat value=$clsBlogCategory->getTitle($first.cat_id)}
                            <div class="col-xl-12 col-lg-6">
                                <div class="related_top">
                                    <div class="blog_related_item">
                                        <a class="photo"
                                        href="{$link}"
                                        title="{$title}">
                                            <img class="d-xl-block d-none"
                                                src="{$clsBlog->getImage($first.blog_id,752,504,$first)}"
                                                width="752"
                                                height="504"
                                                alt="{$title}"/>
                                            <img class="d-xl-none"
                                                src="{$clsBlog->getImage($first.blog_id,145,145,$first)}"
                                                width="145"
                                                height="145"
                                                alt="{$title}"/>
                                        </a>
                                        <div class="body">
                                            <p class="country_cat">
                                                {if $country}
                                                <a href="{$clsCountryEx->getLink($first.country_id,'Blog')}"
                                                title="{$country}">
                                                    {$country} |
                                                </a>
                                                {/if}
                                                <a href="{$clsBlogCategory->getLink($first.cat_id)}"
                                                title="{$cat}">
                                                    {$cat}
                                                </a>
                                            </p>
                                            <h3 class="title">
                                                <a class="text2line"
                                                href="{$link}"
                                                title="{$title}">
                                                {$title}
                                                </a>
                                            </h3>
                                            <div class="intro text3line">
                                                {$clsBlog->getIntro($first.blog_id,$first)|strip_tags}
                                            </div>
                                            {$clsBlog->getStarRating($first.blog_id,$first)}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {* ===== Các item còn lại ===== *}
                            {foreach from=$lstRelated item=item key=k}
                            {if $k > 0}
                                {assign var=title value=$clsBlog->getTitle($item.blog_id,$item)}
                                {assign var=link value=$clsBlog->getLink($item.blog_id,$item)}
                                {assign var=country value=$clsCountryEx->getTitle($item.country_id)}
                                {assign var=cat value=$clsBlogCategory->getTitle($item.cat_id)}
                                <div class="col-xl-4 col-lg-6">
                                    <div class="blog_related_item">
                                        <a class="photo"
                                        href="{$link}"
                                        title="{$title}">
                                            <img src="{$clsBlog->getImage($item.blog_id,145,145,$item)}"
                                                alt="{$title}"/>
                                        </a>
                                        <div class="body">
                                            <p class="country_cat">
                                                {if $country}
                                                <a href="{$clsCountryEx->getLink($item.country_id,'Blog')}"
                                                title="{$country}">
                                                {$country} |
                                                </a>
                                                {/if}
                                                <a href="{$clsBlogCategory->getLink($item.cat_id)}"
                                                title="{$cat}">
                                                {$cat}
                                                </a>
                                            </p>
                                            <h3 class="title">
                                                <a class="text2line"
                                                href="{$link}"
                                                title="{$title}">
                                                {$title}
                                                </a>
                                            </h3>
                                            {$clsBlog->getStarRating($item.blog_id,$item)}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {/foreach}
                        </div>
                    </div>
                </div>
                {/if}
        </div>
        {*{$core->getBlock('quick_contact')}*}
    </div>
    {*{$core->getBlock('testimonialsHomepro')}*}
</div>
<script>
    var txt_hide = "{$core->get_Lang('hide')}";
    var txt_show = "{$core->get_Lang('show')}";
    var txt_hide2 = "[{$core->get_Lang('hide')}]";
    var txt_show2 = "[{$core->get_Lang('show')}]";
    var txt_less_slidebar = "{$core->get_Lang('switch to sidebar')}";
</script>
{if $blogItem.rate}
{literal}
    <script type="application/ld+json">{
    "@context": "https://schema.org/",
    "@type": "CreativeWorkSeries",
    "name": "{/literal}{$blogItem.title|html_entity_decode}{literal}",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{/literal}{$rateavg}{literal}",
        "bestRating": "5",
        "ratingCount": "{/literal}{$blogItem.rate}{literal}"
    }
}
    </script>
{/literal}
{/if}
{literal}
    <script>
        $(document).ready(function() {
            // Khởi tạo với txt_hide
            $('.tinymce_Content .mce-toc h2').attr('data-after-text', txt_show2);
            // Toggle khi click
            $('.tinymce_Content .mce-toc h2').on('click', function() {
                var $ul = $(this).next('ul');
                var currentText = $(this).attr('data-after-text');
                if (currentText === txt_hide2) {
                    $(this).attr('data-after-text', txt_show2);
                    $ul.slideUp(); // Ẩn <ul>
                } else {
                    $(this).attr('data-after-text', txt_hide2);
                    $ul.slideDown(); // Hiện <ul>
                }
            });
        });
        $(function(){
            let screenWidth = $(window).width();

            let checkMenu = $.trim($('#iso_menu_hide').text()) == '' ? 1 : 0
            if(checkMenu == 1){
                $('#iso_box_menu').hide();
            }
            $('.icon_box_index').click(function(){
                $("#iso_index").show().addClass('absolute');
                $('.iso_index_close').show();
            })
            $(document).on('click', '.iso_hide_menu', function(){
                $("#iso_index").removeClass('absolute').hide();
                $('.icon_box_index').show();
                $('#iso_box_index').removeClass('col-lg-3');
                $('.blogLeft').removeClass('col-lg-6').addClass('col-lg-9');
                $(this).removeClass('iso_hide_menu').addClass('iso_show_menu');
                $(this).text(txt_less_slidebar);
            })
            $(document).on('click', '.iso_show_menu', function(){
                $("#iso_index").removeClass('absolute').show();
                $('.icon_box_index, .iso_index_close').hide();
                $('#iso_box_index').addClass('col-lg-3');
                $('.blogLeft').addClass('col-lg-6').removeClass('col-lg-9');
                $(this).addClass('iso_hide_menu').removeClass('iso_show_menu');
                $(this).text(txt_hide);
            })
            $('.iso_index_close').click(function(){
                $("#iso_index").removeClass('absolute').hide();
            })
            $(document).click(function(event) {
                if (!$(event.target).closest('#iso_index').length && !$(event.target).closest('.icon_box_index').length) {
                    if(screenWidth < 998){
                        $("#iso_index").hide();
                    }
                }
            });
            $('#iso_index .mce-toc a').click(function(){
                if($('#hide_menu').hasClass('iso_hide_show')){
                    $("#iso_index").removeClass('absolute').hide();
                }
            })
            $(".mce-toc h2").click(function(){
                $(this).toggleClass('hide');
                $(this).next().slideToggle();
            });
            var topMenu = $("#iso_index").find('.mce-toc'),
                topMenuHeight = topMenu.outerHeight()+15,
                menuItems = topMenu.find("a"),
                scrollItems = menuItems.map(function(){
                    var item = $($(this).attr("href"));
                    if (item.length) { return item; }
                });
            $(window).scroll(function(){
                var fromTop = $(this).scrollTop()+topMenuHeight;
                var cur = scrollItems.map(function(){
                    if ($(this).offset().top < fromTop)
                        return this;
                });
                cur = cur[cur.length-1];
                var id = cur && cur.length ? cur[0].id : "";
                menuItems
                    .parent().removeClass("active")
                    .end().filter("[href='#"+id+"']").parent().addClass("active");
                if ($(window).scrollTop() >= 30) {
                    $('.menu_blog_hide').addClass("fixed_menu_hide");
                } else {
                    $('.menu_blog_hide').removeClass("fixed_menu_hide");
                }
            });
        });

	document.addEventListener("DOMContentLoaded", function () {
		$(function () {
			$(".tinymce_Content img").each(function (i) {
				var self = $(this);
				self.attr("data-action", "zoom");
			});

			let screenWidth = $(window).width();
			$(".blogContent .mce-toc").clone().appendTo("#iso_index.tinymce_Content");
			// Kiểm tra nếu không có nội dung trong mục lục thì ẩn và thay đổi layout
			if ($("#iso_index .mce-toc").children().length === 0) {
				$("#iso_box_index").remove(); // Xóa phần mục lục
				$(".blogLeft").removeClass("col-lg-6").addClass("col-lg-9"); // Mở rộng phần nội dung
			} else {
				$("#iso_index.tinymce_Content .mce-toc").prepend(`
					<div class="iso_index_close">
						<i class="fa fa-times" aria-hidden="true"></i>
					</div>
				`);
			}
			let checkMenu = $.trim($("#iso_menu_hide").text()) == "" ? 1 : 0;
			if (checkMenu == 1) {
				$("#iso_box_menu").hide();
			}
			$(".icon_box_index").click(function () {
				$("#iso_index").show().addClass("absolute");
				$(".iso_index_close").show();
			});
			$(document).on("click", ".iso_hide_menu", function () {
				$("#iso_index").removeClass("absolute").hide();
				$(".icon_box_index").show();
				$("#iso_box_index").removeClass("col-lg-3");
				$(".blogLeft").removeClass("col-lg-6").addClass("col-lg-9");
				$(this).removeClass("iso_hide_menu").addClass("iso_show_menu");
				$(this).text(txt_less_slidebar);
			});
			$(document).on("click", ".iso_show_menu", function () {
				$("#iso_index").removeClass("absolute").show();
				$(".icon_box_index, .iso_index_close").hide();
				$("#iso_box_index").addClass("col-lg-3");
				$(".blogLeft").addClass("col-lg-6").removeClass("col-lg-9");
				$(this).addClass("iso_hide_menu").removeClass("iso_show_menu");
				$(this).text(txt_hide);
			});
			$(".iso_index_close").click(function () {
				$("#iso_index").removeClass("absolute").hide();
			});
			$(document).click(function (event) {
				if (
					!$(event.target).closest("#iso_index").length &&
					!$(event.target).closest(".icon_box_index").length
				) {
					if (screenWidth < 998) {
						$("#iso_index").hide();
					}
				}
			});
			$("#iso_index .mce-toc a").click(function () {
				if ($("#hide_menu").hasClass("iso_hide_show")) {
					$("#iso_index").removeClass("absolute").hide();
				}
			});
			$(".mce-toc h2").click(function () {
				$(this).toggleClass("hide");
				$(this).next().slideToggle();
			});
			var topMenu = $("#iso_index").find(".mce-toc"),
				topMenuHeight = topMenu.outerHeight() + 15,
				menuItems = topMenu.find("a"),
				scrollItems = menuItems.map(function () {
					var item = $($(this).attr("href"));
					if (item.length) {
						return item;
					}
				});
			$(window).scroll(function () {
				var fromTop = $(this).scrollTop() + topMenuHeight;
				var cur = scrollItems.map(function () {
					if ($(this).offset().top < fromTop) return this;
				});
				cur = cur[cur.length - 1];
				var id = cur && cur.length ? cur[0].id : "";
				menuItems
					.parent()
					.removeClass("active")
					.end()
					.filter("[href='#" + id + "']")
					.parent()
					.addClass("active");
				if ($(window).scrollTop() >= 30) {
					$(".menu_blog_hide").addClass("fixed_menu_hide");
				} else {
					$(".menu_blog_hide").removeClass("fixed_menu_hide");
				}
			});
		});
	});
</script> 
{/literal}
{literal}
    <style>
        .company_truspilot {
            margin-top: unset !important;
        }
        .blog_detail_body  .review_customer {
            padding-bottom: 40px;
        }
        .blogLeft.col-lg-9 .tinymce_Content img {
            width: 100%;
        }
        #iso_index, .tinymce_Content .mce-toc, #iso_box_index{
            display: none !important;
        }
    </style>
{/literal}
