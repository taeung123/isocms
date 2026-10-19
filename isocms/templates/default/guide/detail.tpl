{assign var=title_guide value=$clsGuideCat->getTitle($guidecat_id)}
{assign var = link_guidecat value = $clsGuideCat->getLinkGuideCountry($guidecat_id, "cat", $country_id)}

<div class="page_container">

    <div class="detail_top_box">
        <div class="d-flex">
            <div class="col-photo">
                <img src="{$clsGuide->getImage($guide_id,1034,861)}" width="1034" height="861" alt="{$clsGuide->getTitle($guide_id)}"/>
            </div>
            <div class="col-text">
                <div class="blog_info">
                    <p class="country_cat">
                        {if $title_guide}
                            <a href="{$link_guidecat}" title="{$title_guide}">
                                {$title_guide}
                            </a>
                        {/if}
                    </p>
                    <h1 class="title text3line">{$clsGuide->getTitle($guide_id)}</h1>
                    <div class="intro text5line">
                        {$clsGuide->getIntro($guide_id)}
                    </div>
                    {if $clsGuide->getPublishDate($guide_id)}
                    <div lang="publish_author submitted">
                        <span class="publish_date mgr10">
                            <i class="fa-regular fa-clock"></i>
                          {$clsISO->converTimeToText($clsGuide->getOneField('publish_date',$guide_id))}
                        </span>
                    </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>

    <nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$curl}" title="{$core->get_Lang('Destinations')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Destinations')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a itemprop="item" href="{$link_guidecat}" title="{$title_guide}">
					   <span itemprop="name" class="reb">{$title_guide}</span></a>
					<meta itemprop="position" content="3" />
				</li>
{*                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">*}
{*                    <a itemprop="item" href="{$clsGuideCat->getLink($country_id,$city_id,$guidecat_id)}" title="{$title_guide}">*}
{*                        <span itemprop="name" class="reb">{$title_guide}</span></a>*}
{*                    <meta itemprop="position" content="3" />*}
{*                </li>*}
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                  <a itemprop="item" title="{$title_guide}">
                    <span itemprop="name" class="reb">{$clsGuide->getTitle($guide_id)}</span>
                  </a>
				   <meta itemprop="position" content="4" />
               </li>
            </ol>
        </div>
    </nav>
    <div class="container pdt40">
        <div class="row">
            <div class="col-lg-9 blogLeft mb991_30">
                <article class="guideDetail bg_fff">
					<div class="intro14_2 mb50">
							<div class="intro15_2 mb10">{$clsGuide->getIntro($guide_id)}</div>
                        <div class="tinymce_Content">
							{$clsGuide->getContent($guide_id)}
                        </div>
					</div>
					<div class="comment_box mtm">
							<div class="fb-comments" data-href="{$PCMS_URL}{$clsGuide->getLink($guide_id)}" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
					</div>
                </article>			
            </div>
            <aside class="col-lg-3">
                {$core->getBlock('right_guide')}
            </aside>
        </div>
        <section class="Relateds-guide mt30 mb30">
            {if $lstRelated[0].guide_id}
            <h2 class="pane-title text-left mb10">{$core->get_Lang('See more')}</h2>                 
            <div class="jcarousel-box owl-carousel" id="jcarousel-guide-Relateds"> 
                    {section name=i loop=$lstRelated}
                    {assign var=link value=$clsGuide->getLink($lstRelated[i].guide_id)} 
                    {assign var=title value=$clsGuide->getTitle($lstRelated[i].guide_id)}
                    <div class="h_traveltip_item_fisrt">
                        <a class="h_image" href="{$link}" title="{$title}">
                            <img class="full-width height-auto" src="{$clsGuide->getImage($lstRelated[i].guide_id,462,308)}" alt="{$title}" />
                        </a>
                        <div class="desc pd10">
                          <div class="name"><a href="{$link}" target="_blank">{$title}</a></div>
                        </div>
                    </div>
                 {/section}   
            </div>                
            {/if}
		</section>
    </div>
</div>

<script>
    var txt_hide = "{$core->get_Lang('hide')}";
    var txt_show = "{$core->get_Lang('show')}";
    var txt_less_slidebar = "{$core->get_Lang('switch to sidebar')}";
</script>

{literal}
    <script>
        $(function(){
            let screenWidth = $(window).width();
            $(".guideDetail .mce-toc").clone().appendTo("#iso_index.tinymce_Content");
            $("#iso_index.tinymce_Content .mce-toc").prepend(`
            <div class="iso_index_close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
        `);
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
    </script>
{/literal}

{literal}
<script>
$(function(){
    if($('#jcarousel-guide-Relateds').length > 0){
        var $owl = $('#jcarousel-guide-Relateds');
        $owl.owlCarousel({
            loop:false,
            margin:25,
            responsiveClass:true,
            autoplay:true,
            responsive:{
                0:{
                items:1,
                nav:false
                },
                500:{
                items:2,
                nav:false
                },
                900:{
                items:3,
                nav:false
                },
                1200:{
                items:4,
                nav:false
                }
            }
            });
            $('#next_1').click(function(){
            $('#jcarousel-tours-slides .owl-next').trigger('click');
            });
            $('#prev_1').click(function(){
            $('#jcarousel-tours-slides .owl-prev').trigger('click');
        });
    }
});
</script>

    <style>
        .intro14_2 img {
            width: 100%;
        }
    </style>
{/literal}


