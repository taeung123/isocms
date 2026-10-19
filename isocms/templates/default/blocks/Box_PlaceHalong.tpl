<link rel="stylesheet" type="text/css" href="{$URL_CSS}/html5lightbox/box-video.css?v={$upd_version}"/>
<div class="container" style="text-align:center;">
	<h2>{$core->get_lang('Places to go Halong Bay')}</h2>
    {assign var=site_blog_intro_home value=site_blog_intro_home_|cat:$_LANG_ID}
    <p class="mb30">{$clsConfiguration->getValue($site_blog_intro_home)|html_entity_decode|strip_tags}</p>
    </div>
	<section id="VideoBlogHomePage" class="c_Video_home" style="height:488px">
    	<div class="slideMain">
            <ul class="slide1">
                <li>
                    <div class="row">
                    {section name=i loop=$listPlace}
                    {assign var=image value=$clsPlace->getImage($listPlace[i].place_id,369,237)}
                    {assign var=title value=$clsPlace->getTitle($listPlace[i].place_id)}
                    {assign var=link value=$clsPlace->getLink($listPlace[i].place_id)}
					<article class="col-xs-3">
						<div class="video-item" style="margin-bottom:12px;">
                            <a href="{$link}" title="{$title}">  
                                <div class="title_intro">
                                    <div class="side"><img  class="img-responsive image_video" src="{$image}"></div>
                                    <div class="side back">
                                        <div style="padding:20px">
                                            <h3 class="title">{$title}</h3>
                                            <p class="text">{$clsPlace->getIntro($listPlace[i].place_id)|strip_tags|truncate:200}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="text-video" style="display:none !important">
                                <h2 class="title"> <a href="{$link}" title="{$title}">{$title}</a></h2>
                            </div>
						</div>
					 </article>
				 	{/section}	   
              	 </div>
			 </li>
		 </ul>
	 </div>
</section>
<script src="{$URL_JS}/jquery.rotate.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
	$(function(){
		var $ww = $(window).width();
		$('#VideoBlogHomePage .slide1').width(1903);
		$('#VideoBlogHomePage .slide2').width(1903);
		$("#VideoBlogHomePage").rotate({
			speed : 50
		});
	});
  </script>
 {/literal}


