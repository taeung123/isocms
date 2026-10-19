<div class="sticky_fix">
	<div class="sidebar">
		{$core->getBlock('l_rightblog_search')}
		{if $show ne 'Region' && $clsISO->getCheckActiveModulePackage($package_id,'blog','category','default') &&
		$lstCategory}
		<div class="linkDestination" style="display: none;">
			<h3 class="title_box"><span>{$core->get_Lang('Categories')}</span></h3>
			<ul>
				{section name=i loop=$lstCategory}
				{assign var = title value = $lstCategory[i].title}
				<li class="category-link {if $cat_id eq $lstCategory[i].blogcat_id}active{/if}"><a
						data-abc="{$country_id},{$city_id},{$lstCategory[i].blogcat_id}"
						href="{$clsBlogCategory->getLink($lstCategory[i].blogcat_id,$lstCategory[i])}"
						title="{$title}">{$title}</a></li>
				{/section}
			</ul>
		</div>
		<div class="mb30"></div>
		{/if}
		{if $lstTourExtension &&
		$clsISO->getCheckActiveModulePackage($package_id,'blog','blog_tour_related','customize')}
		<div class="tour_extension_box">
			<h3 class="title_box"><span>{$core->get_Lang('Tour Related')}</span></h3>
			{section name=i loop=$lstTourExtension max=3}
			{assign var=tour_id value=$lstTourExtension[i].tour_id}
			{assign var=oneTour value=$clsTour->getOne($tour_id,'slug,title,image')}
			{$clsISO->getBlock('box_item_tour_mobile',["oneTour"=>$oneTour,"tour_id"=>$tour_id])}
			{/section}
		</div>
		<div class="clearfix mb30"></div>
		{/if}


		{if $lstCruiseExtension &&
		$clsISO->getCheckActiveModulePackage($package_id,'blog','blog_cruise_related','customize')}
			<div class="cruise_extension_box">
				<h3 class="title_box"><span>{$core->get_Lang('Cruise Related')}</span></h3>
				{section name=i loop=$lstCruiseExtension max=3}
					{assign var=cruise_item_id value=$lstCruiseExtension[i].cruise_id}
					{assign var=oneCruise value=$clsCruise->getOne($cruise_item_id,'slug,title,image')}
					{$clsISO->getBlock('box_item_cruise_list',["oneCruise"=>$oneCruise,"cruise_item_id"=>$cruise_item_id])}
				{/section}
			</div>
			<div class="clearfix mb30"></div>
		{/if}


		{if $lstHotelExtension &&
		$clsISO->getCheckActiveModulePackage($package_id,'blog','blog_hotel_related','customize')}
		<div class="hotel_extension_box">
			<h3 class="title_box"><span>{$core->get_Lang('Hotel Related')}</span></h3>
			{section name=i loop=$lstHotelExtension max=5}
			{assign var=hotel_id value=$lstHotelExtension[i].hotel_id}
			{assign var=itemHotel value=$clsHotel->getOne($hotel_id,'title,slug,star_id,image,price_avg')}
			{assign var=title value=$itemHotel.title}
			{assign var=link value=$clsHotel->getLink($lstHotelExtension[i].hotel_id,$itemHotel)}
			{assign var = getImageStar value = $clsHotel->getHotelStar($lstHotelExtension[i].hotel_id,$itemHotel)}
			<div class="item itemHotel2 cruise-relate" {if $smarty.section.i.iteration gt 3} style="display:none" {/if}>
				<div class="photo">
					<a href="{$link}" data-data="{$hotel_id}" class="cl-img clickviewedHotel">
						<img class="img-responsive img100" src="{$clsHotel->getImage($hotel_id,263,175,$itemHotel)}"
							alt="{$title}" />
					</a>
				</div>
				<div class="body">
					<h3 class="title"><a href="{$link}" title="{$title}">{$title}</a> <img class="star" height="13"
							src="{$getImageStar}" alt="star" /></h3>
					<div class="price text-right">
						{$clsHotel->getPrice($hotel_id,'',false,$itemHotel)}
					</div>
				</div>
			</div>
			{/section}
			{if $smarty.section.i.total gt 3 && $smarty.section.i.last}
			<a href="javascript:void(0)" class="view-more-tour-relate">
				{$core->get_Lang('View more')} <i class="fa fa-angle-double-down" aria-hidden="true"></i>
			</a>
			{/if}
		</div>
		<div class="mb30"></div>
		{/if}
		{if $lstPopularBlog}
		<div class="blogPopular">
			<h3 class="title_box"><span>{$core->get_Lang('Popular Blogs')}</span></h3>
			<ul class="listBlog">
				{section name=i loop=$lstPopularBlog}
				{assign var=titleBlog value=$clsBlog->getTitle($lstPopularBlog[i].blog_id,$lstPopularBlog[i])}
				<li><a href="{$clsBlog->getLink($lstPopularBlog[i].blog_id,$lstPopularBlog[i])}"
						title="{$titleBlog}">{$titleBlog}</a></li>
				{/section}
			</ul>
		</div>
		<div class="mb30"></div>
		{/if}
		{if $mod eq 'blog' and $act eq 'detail' and
		$clsISO->getCheckActiveModulePackage($package_id,'blog','tag','customize')}
		{assign var=listTagBlog value=$clsBlog->getListTag($blog_id,$blogItem)}
		{if $listTagBlog ne ''}
		<div class="blogTag mb20">
			<h3 class="title_box"><span>{$core->get_Lang('Tags')}</span></h3>
			<ul class="d2-blog-tags">
				{$listTagBlog}
			</ul>
		</div>
		<div class="mb30"></div>
		{/if}
		{/if}
		{if $show ne 'Default'}
		{if $mod eq 'blog' and $act eq 'default'}
		{if $listGuideCat or $listHotelPlace}
		{if $show eq 'Country'}
		{assign var=title value=$clsCountryEx->getTitle($country_id,$oneItemCountry)}
		{assign var=linkHotel value=$clsCountryEx->getLink($country_id,'Hotel',$oneItemCountry)}
		{assign var=linkDestination value=$clsCountryEx->getLink($country_id,'',$oneItemCountry)}
		{elseif $show eq 'City'}
		{assign var=title value=$clsCity->getTitle($city_id,$oneItemCity)}
		{assign var=linkHotel value=$clsCity->getLink($city_id,'Hotel',false,$oneItemCity)}
		{assign var=linkDestination value=$clsCity->getLink($city_id,'',false,$oneItemCity)}
		{else}
		{assign var=title value=$clsRegion->getTitle($region_id,$oneItemRegion)}
		{assign var=linkHotel value=$clsRegion->getLink($country_id,$region_id,'Hotel',false,$oneItemRegion)}
		{assign var=linkDestination value=$clsRegion->getLink($country_id,$region_id,false,$oneItemRegion)}
		{/if}
		<div class="blogLink">
			<h3 class="title_box"><span>{$title}</span></h3>
			<ul class="view-content">
				{if $listHotelPlace && $clsISO->getCheckActiveModulePackage($package_id,'hotel','default','default')}
				<li><a class="{if $mod eq 'hotel' && $act eq 'place'}active{/if}" href="{$linkHotel}"
						title="{$core->get_Lang('Hotels')}">{$core->get_Lang('Hotels')}</a></li>
				{/if}
				<li>
					<a class="{if $mod eq 'destination' && $act eq 'place'}active{/if}" href="{$linkDestination}"
						title="{$title} {$core->get_Lang('Destinations')}">{$title}
						{$core->get_Lang('Destinations')}</a>
				</li>

				{if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
				{if $show eq 'Region'}
				{section name=i loop=$listGuideCat}
				{if $clsGuide->countGuideByRegion($country_id, $region_id, $listGuideCat[i].guidecat_id) gt 0}
				<li {if $guidecat_id eq $listGuideCat[i].guidecat_id}class="active" {/if}><a
						href="{$clsGuideCat->getLinkRegion($country_id,$region_id,$listGuideCat[i].guidecat_id)}"
						title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}</a>
				</li>
				{/if}
				{/section}
				{else}
				{section name=i loop=$listGuideCat}
				{if $clsGuide->countGuideGlobal($country_id, $city_id, $listGuideCat[i].guidecat_id) gt 0}
				<li class="views-row views-row-1 views-row-odd views-row-first mb08">
					<a href="{$clsGuideCat->getLink($country_id,$city_id,$listGuideCat[i].guidecat_id,$listGuideCat[i])}"
						title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id,$listGuideCat[i])}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id,$listGuideCat[i])}</a>
				</li>
				{/if}
				{/section}
				{/if}
				{/if}
			</ul>
			<div class="mb30"></div>
		</div>
		{/if}
		{/if}
		{/if}

		<div class="blogPopular" style="display:none">
			<h3 class="title_box"><span>{$core->get_Lang('Popular Blogs')}</span></h3>
			<ul class="listBlog">
				{section name=i loop=$lstPopularBlog}
				{assign var=titlePopularBlog value=$clsBlog->getTitle($lstPopularBlog[i].blog_id,$lstPopularBlog[i])}
				<li><a href="{$clsBlog->getLink($lstPopularBlog[i].blog_id,$lstPopularBlog[i])}"
						title="{$titlePopularBlog}">{$titlePopularBlog}</a></li>
				{/section}
			</ul>
		</div>
	</div>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function () {
			$(document).on("click", ".view-more-tour-relate", function () {
				$(".box_blog_tour_relate:hidden").show();
				$(this).hide();
			});
			$(document).on("click", ".view-more-cruise-relate", function () {
				$(".cruise-relate:hidden").show();
				$(this).hide();
			});
		});
	})	
</script>
{/literal}