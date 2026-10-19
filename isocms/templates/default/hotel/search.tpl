<div class="page_container">
    <div class="banner">
    	<img class="full-width height-auto" src="{$clsConfiguration->getImage(site_hotel_banner,1920,500)}" alt="{$core->get_Lang('Result Search')}"/>
        {$core->getBlock('find_hotel')}
    </div>   
	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
			   <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				   <a  itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Result Search')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Result Search')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
 	<div id="contentPage" class="pageHotelSearch rowbox primary pd50_0">
    	<div class="container">
			<h1 class="size30 pane-title text-left mt0 mb30">{$core->get_Lang('Result Search')} <span class="totalSearch">({$totalRecord} {$core->get_Lang('results')})</span></h1>
			{if $listHotel}
			<div class="boxHotels row" id="listHolderView">
			{assign var=totalHotels value=$listHotel|@count}
			{section name=i loop=$listHotel}
			{assign var = hotel_id value = $listHotel[i].hotel_id}
			<div class="box col-sm-6 col-md-4 col-lg-3">
				{$clsISO->getBlock('hotelbox',["hotel_id"=>$hotel_id])}
			</div>
			{/section}
			</div>
			{else}
			<div class="med" style="font-size:18px">  
				<p style="padding-top:.33em"> 
					{$core->get_Lang('Your search')} - <em>{$keyword}</em> - {$core->get_Lang('did not match any hotels')}.  
				</p> 
				<p style="margin:1em 0">{$core->get_Lang('Suggestions')}:</p> 
				<ul style="margin-left:1.3em;margin-bottom:2em; list-style:disc">
					<li>{$core->get_Lang('Make sure that all words are spelled correctly')}.</li>
					<li>{$core->get_Lang('Try different keywords')}.</li>
					<li>{$core->get_Lang('Try more general keywords')}.</li>
				</ul> 
			</div>
			{/if}
			{if $totalPage gt '1'} 
			<div id="exploreWorldLoadMore">
				<div id="load_more_collections">
					<div class="loader"></div>
					<a href="javascript:void(0);" rel="nofollow" page="1" class="btn_orance_border show-loader" id="show-more">{$core->get_Lang('LOAD MORE COLLECTIONS')}</a>
				</div>
			</div>                                                  
			{/if}
    	</div>
	</div>
</div>
<script >
	var totalRecord='{$totalRecord}';
	var $pageLastest = 1;
	var country_id='{$country_id}';
	var city_id='{$city_id}';
	var star_id='{$star_id}';
	var price_range='{$price_range}';
	var show='Search';
</script>
{literal}
<script >
	document.addEventListener("DOMContentLoaded", function () {
		$(function(){
			$(document).on('click', "#show-more", function(ev) {
				var $_this = $(this);
				$_this.find('.ajax-loader').show();
				$pageLastest++;
				$.ajax({  
					type:'POST',
					url:path_ajax_script+'/index.php?mod=hotel&act=ajLoadMoreHotelSearch&lang='+LANG_ID, 
					data:{
						"page":$pageLastest,
						"country_id":country_id,
						"city_id":city_id,
						"star_id":star_id,
						"price_range":price_range,
						"show":show,
					},
					dataType:'html',
					success:function(html){
						$_this.find('.ajax-loader').hide();
						$('#listHolderView').append( html );
						setwidthLeft();
					}
				});
				setInterval(function(){	
					loadPageFixHotel();	
				},100);	
			});
		});
		function loadPageFixHotel($number_per_page){
			var $number_show = $('#listHolderView .box:visible').size();
			if($number_show >= totalRecord){
				$('#exploreWorldLoadMore').remove();
			}
		}
	})
</script>
{/literal}
