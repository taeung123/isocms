{assign var=title_country value=$clsCountryEx->getTitle($country_id)}
<div class="page_container">
    <div class="breadcrumb-main breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Hotels')}" itemprop="url">
					   <span itemprop="name" class="reb">{$core->get_Lang('Videos')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active" >
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$title_country} {$core->get_Lang('Videos')}" itemprop="url">
						<span itemprop="name" class="reb">{$title_country} {$core->get_Lang('Videos')}</span></a>
					<meta itemprop="position" content="3" />
				</li>
            </ol>
        </div>
    </div>
    <div id="contentPage" class="hotelPlacePage pd40_0">
        <div class="container">
        	<h1 class="size32 mt0 mb20">{$core->get_Lang('Videos in')} {$title_country}</h1>
			<div class="box_list_video">
				<div class="row" id="apend_html"> 
					{section name=i loop=$lstVideoClip}
					<div class="col-md-4 col-sm-6 col-xs-6 full_width_600 mb20 box_append">
						<div class="VideoItem">
							<a class="venobox_video relative" data-gall="gall-video" data-autoplay="false" data-vbtype="video" href="{$clsVideo->getLinkVideo($lstVideoClip[i].video_id)}">
							<img src="{$clsVideo->getImage($lstVideoClip[i].video_id,360,240)}" width="100%" height="auto" />
							<i class="icon icon_play_video"></i>
							</a>
							<h3 class="title_video"><a class="venobox_video" data-gall="gall-video" data-autoplay="false" data-vbtype="video" href="{$clsVideo->getLinkVideo($lstVideoClip[i].video_id)}">{$clsVideo->getTitle($lstVideoClip[i].video_id)}</a></h3>
						</div>
					</div>
					{/section}
				</div>
				{if $totalVideo gt 6}
				<div class="cleafix"></div>
				<div id="load_more_collections" class="text_center mb40">
				<div class="loader"></div>
				<a href="javascript:void(0);" rel="nofollow" page="1" class="btn_orance_border show-loader" id="show-more-video">{$core->get_Lang('LOAD MORE COLLECTIONS')}</a>
				</div> 
				{/if}   
			</div>
        </div>
    </div>
</div>

<script type="text/javascript">
	var totalRecord='{$totalVideo}';
	var country_id='{$country_id}';
	var $pageLastest = 1;
</script>
{literal}
<script type="text/javascript">

$(function(){
	$('.venobox').venobox({
		framewidth:750,
		numeratio: true
	});
	$('.venobox_video').venobox({
		framewidth:950,
		border: '5px',
		bgcolor: '#fff',
		numeratio: true,
		infinigall: true
	});
});
$(function(){
	$(document).on('click', "#show-more-video", function(ev) {
		var $_this = $(this);
		$_this.find('.ajax-loader').show();
		$pageLastest++;
		$.ajax({  
			type:'POST',
			url:path_ajax_script+'/index.php?mod=video&act=ajLoadMoreVideo&lang='+LANG_ID, 
			data:{
				"page":$pageLastest,
				"country_id":country_id,
			},
			dataType:'html',
			success:function(html){
				$_this.find('.ajax-loader').hide();
				$('#apend_html').append( html );
				setwidthLeft();
			}
		});
		setInterval(function(){	
            loadPageGallery();	
        },100);	
	});
});
function loadPageGallery($number_per_page){
	var $number_show = $('#apend_html .box_append:visible').size();
	if($number_show >= totalRecord){
		$('#load_more_collections').remove();
	}
}
</script>
{/literal}