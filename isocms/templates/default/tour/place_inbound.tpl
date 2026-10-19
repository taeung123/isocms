{assign var=title value=$itemCity.title}
<section class="page_container">
   <div class="bg_banner">
	{if $deviceType eq 'phone'}
	<img class="img100" src="{$clsCity->getBanner($city_id,480,320,$itemCity)}" alt="{$title}">
	{else}
	<img class="img100" src="{$clsCity->getBanner($city_id,1920,400,$itemCity)}" alt="{$title}">
	{/if}
   </div>
   <nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
      <div class="container">
         <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="{$PCMS_URL}">
               <span itemprop="name" class="reb">{$core->get_Lang('Trang chủ')}</span></a>
               <meta itemprop="position" content="1" />
            </li>
             <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="{$curl}">
               <span itemprop="name" class="reb">{$core->get_Lang('Domestic tours')}</span></a>
               <meta itemprop="position" content="2" />
            </li>
			 <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				 <a itemprop="item" href="{$curl}">
					 <span itemprop="name" class="reb">{$title}</span></a>
				 <meta itemprop="position" content="3" />
			 </li>
         </ol>
      </div>
   </nav>
   <main class="maincontent pd50_0">
      <section class="introPage">
         <div class="container">
            <div class="introbox mb30">
               <h1 class="title h2 text_center text_normal upcase">{$title}</h1>
                {if $clsCity->getIntro($city_id,'',false,$itemCity)}
               <div class="intro text_center">
				   {$clsCity->getIntro($city_id,'',false,$itemCity)}
				   <div class="content">{$clsCity->getContent($city_id,$itemCity)}</div>
				</div>
              
               <a class="seemore seeclick text_center" href="javascript:void(0);" title="{$core->get_Lang('Tìm hiểu thêm')}" style="display: none">{$core->get_Lang('Tìm hiểu thêm')}</a>
               <a class="seeless seeclick text_center" href="javascript:void(0);" title="{$core->get_Lang('Thu gọn')}" style="display: none">{$core->get_Lang('Thu gọn')}</a>
               {/if}
               {literal}
               <script>
				document.addEventListener("DOMContentLoaded", function () {
					$('.introbox .intro').each(function(){
						var $_this = $(this);
						if($_this.height()>69){
							$_this.css("height","69px");
							$_this.closest(".introbox").find(".seemore").show();
						}else{
							$_this.closest(".introbox").find(".seeless").hide();
						}
					});
				})
               </script>
               {/literal}
            </div>
         </div>
      </section>
      {if $lstGuide && $clsISO->getCheckActiveModulePackage($package_id,'guide','default','default')}
	  <section class="postTravelonPage">
		  <div class="container">
			  <h2 class="titlebox h2 bold upcase">{$core->get_Lang("Những điều thú vị tại")} {$title}</h2>
			  <div class="owl-carousel slide">
				  {section name=i loop=$lstGuideCat}
					  {assign var=titleCat value=$clsGuideCat->getTitle($lstGuideCat[i].guidecat_id,$lstGuideCat[i])}
					  {assign var=guidecat__id value=$lstGuideCat[i].guidecat_id}
					  {if $clsGuideCat->countNumberGuide2($guidecat__id,$country_id,$city_id) gt '0'}
						  <div class="Item" guidecat_id="{$lstGuideCat[i].guidecat_id}"
							   style="background-image: url('{$clsGuideCat->getImage($lstGuideCat[i].guidecat_id,625,320,$lstGuideCat[i])}')">
							  <div class="body">
								  <h3><a href="{$clsGuideCat->getLink($country_id,$city_id,$guidecat__id)}"
										 title="{$titleCat}">{$titleCat}</a></h3>
								  <div class="intro">{$clsGuideCat->getIntro($lstGuideCat[i].guidecat_id,'',false,$lstGuideCat[i])}</div>
							  </div>
							  <div class="box-shadow"></div>
							  {if $lstGuide}
								  <div class="tringle"></div>
							  {/if}
						  </div>
					  {/if}
				  {/section}
			  </div>
			  {if $lstGuide}
				  <div class="ListGuide">
					  <div class="row">
						  {section name=i loop=$lstGuide}
							  {assign var=linkGuide value=$clsGuide->getLink($lstGuide[i].guide_id,$lstGuide[i])}
							  {assign var=titleGuide value=$clsGuide->getTitle($lstGuide[i].guide_id,$lstGuide[i])}
							  <div class="col-md-3 col-sm-6">
								  <div class="ItemGuide">
									  <a class="photo" href="{$linkGuide}" title="{$titleGuide}">
										  <img class="img100"
											   src="{$clsGuide->getImage($lstGuide[i].guide_id,298,182)}"
											   alt="{$titleGuide}">
									  </a>
									  <div class="body">
										  <h3 class="title limit_2line">
											  <a href="{$linkGuide}"
												 title="{$titleGuide}">{$titleGuide}</a>
										  </h3>
										  <span class="regdate">{$clsGuide->getPublishDate($lstGuide[i].guide_id,$lstGuide[i])}</span>
										  {*<div class="intro">{$clsGuide->getIntro($lstGuide[i].guide_id)|strip_tags|truncate:200}</div>*}
									  </div>
								  </div>
							  </div>
						  {/section}
					  </div>
					  {if $totalguide gt '4'}
						  <a class="seemore seeclick text_center ViewmoreGuide btn_main" href="javascript:void(0);"
							 title="{$core->get_Lang('Xem thêm')}">{$core->get_Lang('Xem thêm')}</a>
						  <a class="seeless seeclick text_center ViewmoreGuide btn_main" href="javascript:void(0);"
							 title="{$core->get_Lang('Ẩn bớt')}"
							 style="display: none">{$core->get_Lang('Ẩn bớt')}</a>
					  {/if}
				  </div>
			  {/if}
		  </div>
	  </section>
      {/if}
	   {if ($lstTour && $action=='')  || $action=='search' }
       <section class="tourTravelonPage">
           <div class="container">
               <h2 class="titlebox h2 bold upcase">{$core->get_Lang("tour du lịch")} {$title}</h2>
               <div class="contentListTravel">
                   <div class="row">
                       <div class="col-lg-3">
							<div class="block991" style="display:none">
								<div class="tag-search">
									<div class="btn_open_modal btn_quick_search bg_main" data-bs-toggle="modal" data-bs-target="#filter_search" >
										<span>{$core->get_Lang('Filter Trip')}</span> <i class="fa fa-sliders" aria-hidden="true"></i>
									</div>
								</div>
							</div> 
							<div class="modal fade" id="filter_search" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="filter_left">
											<div class="modal-header">
												<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">X</span><span class="sr-only">{$core->get_Lang('Close')}</span></button> {$core->get_Lang('Search')}
											</div>
											<div class="modal-body">
												<div class="totalTour mb20">
												   <h2 class="totalTourpage bg_main h3">{$core->get_Lang('Find')} {$totalTour} {if $totalTour gt 1}{$core->get_Lang('Tours')}{else}{$core->get_Lang('Tour')}{/if}</h2>
												</div>
												{$core->getBlock('filter_left_trip')}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                       <div class="col-lg-9">
                           <div class="listTourItem">
                               <div class="row">
                                   {section name=i loop=$lstTour}
                                       <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                           {assign var=tour_id value=$lstTour[i].tour_id}
                                           {assign var=oneTour value=$lstTour[i]}
                                           {$clsISO->getBlock('box_item_tour_mobile',["tour_id"=>$tour_id,"oneTour"=>$oneTour])}
                                       </div>
                                   {/section}
                               </div>
                           </div>
                           {if $totalPage gt '1'}
                               <div class="clearfix"></div>
                               <div class="pagination pager">
                                   {$page_view}
                               </div>
                           {/if}
                       </div>
                   </div>
               </div>
           </div>
       </section>
	   {/if}
       <section class="regionTravelonPage">
           <div class="container">
               <h3 class=" h3 bold upcase text_center">{$core->get_Lang("a-z tourism destinations in")} {$clsCountry->getTitle($country_id)}</h3>
               <div class="destinationAZ">
                   {section name=i loop=$lstRegion}
                       {assign var =lstCityRegion value =$clsCity->getListCityByRegion($lstRegion[i].region_id,$city_id)}
                       <h4 class="titleRegion  bg_main">
                           {$clsRegion->getTitle($lstRegion[i].region_id)}
                       </h4>
                       <div class="listCity">
                           <div class="row">
                               {section name=j loop=$lstCityRegion}
							   {assign var=totalTourCity value= $clsTour->countTourByCity($country_id,$lstCityRegion[j].city_id)}
							   <div class="col-md-2 col-sm-4 col-xs-6">
								   <h5 class="title">
									   <a  {$lstCityRegion[j].city_id} {if $country_id ne '4'} href="{$clsCity->getLinkOutbound($lstCityRegion[j].city_id)}" {else}href="{$clsCity->getLink($lstCityRegion[j].city_id,'',false,$lstCityRegion[j])} {/if}" title="{$clsCity->getTitle($lstCityRegion[j].city_id,$lstCityRegion[j])}">
										   {$clsCity->getTitle($lstCityRegion[j].city_id,$lstCityRegion[j])} {if $totalTourCity}<span>({$totalTourCity})</span> {/if}
									   </a>
								   </h5>
							   </div>
                               {/section}
                           </div>
                       </div>
                   {/section}
               </div>
           </div>
       </section>
   </main>
</section>
<script >
   var country_id ='{$country_id}';
   var city_id ='{$city_id}'
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		var owl = $('.owl-carousel').owlCarousel({
			nav:true,
			dots:false,
			loop:false, 
			margin:5,
			responsiveClass:true,
			responsive: {
				0: {
					items: 1,
					nav:false,
				},
				768: {
					items: 1
				},
				1000: {
					items: 3,
				}
			}
		});
		owl.on('change.owl.carousel', function(el){
			console.log(el);
			var number = el.item.index;
			setTimeout(function(){
				$('.owl-item').removeClass('firstActiveItem');
				$('.owl-item').eq(number+1).addClass('firstActiveItem');
				
				}, 1000
			); var guidecat_id= $(".owl-item.firstActiveItem .Item").attr('guidecat_id');
				loadlistGuideByCat(guidecat_id);
		});
			
			var total = $('.owl-carousel .owl-stage .owl-item.active').length;
			$('.owl-carousel .owl-stage .owl-item.active').each(function(index){ // nested class from activator class
				if (index === 0) {
					// this is the first one
					$(this).addClass('firstActiveItem'); // add class in first item

				}
			});
			
			// Hover Item //
			$(".owl-item").mouseenter(function(el){
				var id= $(this).attr('data-index');
				$(".owl-item").removeClass('firstActiveItem');
				$(this).addClass('firstActiveItem');
				var guidecat_id= $(".owl-item.firstActiveItem .Item").attr('guidecat_id');
				loadlistGuideByCat(guidecat_id);
			}); 
		function loadlistGuideByCat(guidecat_id){
			$.ajax({  
				type:'POST',
				url:path_ajax_script+'/index.php?mod=tour&act=listGuide&lang='+LANG_ID, 
				data:{
					"cat_id":guidecat_id,
					"country_id":country_id,
					"city_id":city_id,
				},
				dataType:'html',
				success:function(html){
					$('.ListGuide').html( html );
				}
			});
		}
		$('.seemore').on('click',function () {
		var $this= $(this);
			$this.closest('.introbox').find('.intro').css('height','100%');
			$this.closest('.introbox').find('.seeless').show();
			$this.closest('.ListGuide').find('.row').css('height','100%');
			$this.closest('.ListGuide').find('.seeless').show();
			$this.hide();
		});
		$('.seeless').on('click',function () {
			var $this= $(this);
			$this.closest('.introbox').find('.intro').css('height','69px');
			$this.closest('.introbox').find('.seemore').show();
			$this.closest('.ListGuide').find('.row').removeAttr('style');
			$this.closest('.ListGuide').find('.seemore').show();
			$this.hide();
		});
	})
</script>
{/literal}