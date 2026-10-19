{if $lstCatTour}
<section class="home_box box_travel_style">
	{assign var = TitleCatTour value = TitleCatTour_|cat:$_LANG_ID}
	{assign var = IntroCatTour value = IntroCatTour_|cat:$_LANG_ID}
	<div class="container">
		<div class="title text_center mb30">
			<h2 class="section_box-title">{$clsConfiguration->getValue($TitleCatTour)}</h2>
			<div class="intro_box">{$clsConfiguration->getValue($IntroCatTour)|html_entity_decode}</div>
		</div>
	</div>
	<div class="transitions-enabled" id="listTravelStyle" style="position: relative">
		<div class="row">
			{section name=i loop=$lstCatTour max=3}
			{assign var=getTitle value=$lstCatTour[i].title}
			{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[i].tourcat_id,$lstCatTour[i])}
			<div class="col-md-4 col-sm-4 box">
				<div class="catItem">
					<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',501,277)}" data-src="{$clsTourCategory->getImage($lstCatTour[i].tourcat_id,501,277,$lstCatTour[i])}"/></a>
					<div class="spotlight">
					<h3><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
					{assign var=number_tour_by_cat value=$clsTourCategory->countItemInCat($lstCatTour[i].tourcat_id)}
					{if $number_tour_by_cat}
					<p class="mb0">{$number_tour_by_cat} {$core->get_Lang('tours found')}</p>
					{/if}
					</div>
				</div>
			</div>
			{/section}
		</div>
		<div class="row">
			{section name=i loop=$lstCatTour start=3 max=2}
			{assign var=getTitle value=$lstCatTour[i].title}
			{assign var=getLink value=$clsTourCategory->getLink($lstCatTour[i].tourcat_id,$lstCatTour[i])}
			<div class="col-md-6 col-sm-6 box">
				<div class="catItem">
					<a href="{$getLink}" title="{$getTitle}"><img alt="{$getTitle}" class="lazy img100" src="{$clsConfiguration->getImage('default_image_pixel',767,425)}" data-src="{$clsTourCategory->getImage($lstCatTour[i].tourcat_id,767,425,$lstCatTour[i])}"/></a>
					<div class="spotlight">
					<h3 class=" mb10"><a href="{$getLink}" title="{$getTitle}">{$getTitle}</a></h3>
					{assign var=number_tour_by_cat value=$clsTourCategory->countItemInCat($lstCatTour[i].tourcat_id)}
					{if $number_tour_by_cat}
					<p class="mb05">{$number_tour_by_cat} {$core->get_Lang('tours found')}</p>
					{/if}
					</div>
				</div>
			</div>
			{/section}
		</div>
	</div>
	{if $lstCatTour|@count gt 5}
	<div class="view_more">
		<a href="javascript:void(0);" page="1" rel="nofollow" role="link" class="show-loader btn_view_more btn_main" id="show-more-cat" title="{$core->get_Lang('View more')}">{$core->get_Lang('View more')}</a>
	</div>
	<script>
	var totalCatTour='{$lstCatTour|@count}';
	var $pageLastestcat =1;
	</script>
	{literal}
	<script>
	
	$(document).on('click', ".box_travel_style #show-more-cat", function(ev) {
		var $_this = $(this);
		_Action = 'ajLoadMoreTourCategory';
		$_this.find('.ajax-loader').show();
		$pageLastestcat++;
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod=home&act='+_Action+'&lang='+LANG_ID,
			data:{
				"page":$pageLastestcat,
			},
			dataType:'html',
			success:function(html){
				$_this.find('.ajax-loader').hide();
				$('#listTravelStyle').append( html );
				$('.lazy').lazy({
					effect: "fadeIn",
					effectTime: 20,
					threshold: 0
				});
			}
		});
		setInterval(function(){
			loadPageShowMoreCat();
		},100);
	});
	function loadPageShowMoreCat(){
		var $number_show_cat = $('#listTravelStyle .box:visible').size();
		if($number_show_cat >= totalCatTour){
			$('.box_travel_style .view_more').remove();
		}
	}
	</script>
	{/literal}
	{/if}
</section>

{/if}