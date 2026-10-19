{assign var=title_news value=$clsNews->getTitle($news_id)}
{$title_news|var_dump}
<div class="page_container">
	<div class="breadcrumb-main bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="name"><a itemprop="url" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
				<li itemprop="name"><a href="{$clsISO->getLink('news')}" title="{$core->get_Lang('Travel news')}">{$core->get_Lang('Travel news')}</a></li> 
                {if $newscat_id gt '0'}
                <li itemprop="name"><a href="{$clsNewsCategory->getLink($newscat_id)}" title="{$clsNewsCategory->getTitle($newscat_id)}">{$clsNewsCategory->getTitle($newscat_id)}</a></li> 
                {/if}
                <li itemprop="name"><a href="{$curl}" title="{$title_news}">{$title_news}</a> </li>
            </ol>
        </div>
    </div>
    <div class="newsPage pageNewsDefault bg_f1f1f1">
		<div class="infinite-scroll">
    	<section data-hash="{$clsNews->getLink($news_id)}" class="section" order_no="{$clsNews->getOneField('order_no',$news_id)}">
			<div class="container">
				<h1 class="title32 color_333 mb20"><a href="{$clsNews->getLink($news_id)}" class="anchor color_333" url="{$clsNews->getLink($news_id)}">{$title_news}</a></h1>
				<div class="row">
					<div class="col-md-9 col-sm-8 newsLeft mb768_30">
						<article class="NewsContent">
							<div class="submitted"> 
								<i class="fa fa-clock-o" aria-hidden="true"></i> {$clsISO->converTimeToText($clsNews->getOneField('reg_date',$news_id))} 
								<div class="sharethis-buttons mt0">
									<div class="sharethis-wrapper">
										<div class="addthis_toolbox addthis_default_style" addthis:media="{$DOMAIN_NAME}{$clsNews->getImage($news_id,400,300)}"  addthis:url="{$DOMAIN_NAME}{$clsNews->getLink($news_id)}" addthis:title="{$title_news}">
											<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
											<a class="addthis_button_tweet"></a>
											<a class="addthis_button_pinterest_pinit"></a>
											<a class="addthis_counter addthis_pill_style"></a>
										</div>
										<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=thiembv"></script>
									</div>
								</div>
							</div>
							<div class="content">
								<div class="field-items maxWidthImage tinymce_Content">
									{$clsNews->getIntro($news_id)}
									<div class="clearfix"></div>
									{$clsNews->getContent($news_id)}
								</div>
							</div>
							<div class="cleafix"></div>
							<div class="sharethis-bottom"  style="display:none !important">
								<div class="sharethis-buttons">
									<div class="sharethis-wrapper">
										<div class="addthis_toolbox addthis_default_style" addthis:url="{$DOMAIN_NAME}{$clsNews->getLink($news_id)}" addthis:title="{$title_news}">
										<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
										<a class="addthis_button_tweet"></a>
										<a class="addthis_button_pinterest_pinit"></a>
										<a class="addthis_counter addthis_pill_style"></a>
									</div>
									<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=thiembv"></script>
									</div>
								</div>
							</div>
						</article>
						{if $lstRelated}
						<div class="cleafix mb30"></div>
						<div class="relateNews mb30">
							<h2 class="title24 mb20">{$core->get_Lang('Related News')}</h2>
							<ul class="listNews">
								{section name=i loop=$lstRelated}
									{assign var=title_news_relate value=$clsNews->getTitle($lstRelated[i].news_id)}
									<li><a class="clickviewtopnews" data="{$lstRelated[i].news_id}" href="{$clsNews->getLink($lstRelated[i].news_id)}" title="{$title_news_relate}">{$title_news_relate}</a></li>
								{/section}
							</ul>
						</div>
						{/if}
					</div>
					<div class="col-md-3 col-sm-4 sidebar rightNews">
						{$core->getBlock('l_boxcolNews')}
					</div>
				</div>
			</div>
			</section>
		</div>
		<div class="pagemore">
			<div class="pagemore">
				<div class="showmorethisresult" id="showmorethisdetail" cat_id="{$newscat_id}">
					<span>Đang tải thêm dữ liệu <img src="{$URL_IMAGES}/loading_dots.gif" alt="loading" /></span>
				</div>
			</div>
		</div>
    </div>
</div>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			var alreadyScroll = 0;
			var $pageLastest = 2;
			$(window).scroll(function(){
				if(isScrolledIntoView('#showmorethisdetail') && alreadyScroll == 0){
					alreadyScroll = 1;
					var $button = $('div[id=showmorethisdetail]');
					var $post__item = $('.section:last');
					var $newscat_id = $button.attr('cat_id');
					var $order_no = $post__item.attr('order_no');
					var $url = $post__item.data('hash');
					var $_adata = {
						newscat_id: $newscat_id,
						order_no: $order_no,
					}
					$.ajax({
						type: "POST",
						cache: true,
						url: path_ajax_script+"/index.php?mod=news&act=load_more_detail&lang="+LANG_ID,
						data: $_adata,
						dataType: "html",
						success: function(html){
							if(html.indexOf('_empty') >= 0){
								alreadyScroll = 1;
								$button.fadeOut();
							}else{
								alreadyScroll = 0;
								var htm = html.split('$$$');
								//window.history.replaceState('string', '',htm[1]);
								
								window.history.pushState('string', '', htm[1]);
								
								$('.infinite-scroll > .section:last').after(htm[0]);
								
							}
						}
					});
				}
			});
			/*$(document).on("scroll", function() {
			$(".anchor").each(function (idx, el) {
				if ( isElementInViewport(el) ) {
				// update the URL hash
				if (window.history.pushState) {
					var urlHash = $(el).attr("url");
					window.history.pushState(null, null, urlHash);
				}
				}
			});
			});*/
		});
		$(document).ready(function(){
		var sections = {};
		
		$(".section").each(function(){
			var hash = $(this).attr("hash"),
					topOffset = $(this).offset().top;
				sections[topOffset] = hash;
		});
		
		$(window).scroll(function(e){
			var scrollTop = $(window).scrollTop();
				setHash(scrollTop);
		});
		
		function setHash(st){
			var hash = "";
			for(section in sections){
				if (section < st + ($(window).height()/2)) {
					hash = sections[section];
				}
			}
			console.log(hash);
			window.history.pushState('string', '',hash);
			//window.location.hash = hash;
		}
		});
		function isElementInViewport (el) {
		//special bonus for those using jQuery
		if (typeof jQuery === "function" && el instanceof jQuery) {
			el = el[0];
		}
		var rect = el.getBoundingClientRect();
		return (
			rect.top >= 0 &&
			rect.left >= 0 &&
			rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
			rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
		);
		}
		function isScrolledIntoView(elem){
			if($(elem).length){
			var docViewTop = $(window).scrollTop();
			var docViewBottom = docViewTop + $(window).height();
			var elemTop = $(elem).offset().top;
			var elemBottom = elemTop + $(elem).height();
			return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom)
			&& (elemBottom <= docViewBottom) &&  (elemTop >= docViewTop) );
			}
			else return false;
		}
	})
</script>
{/literal}