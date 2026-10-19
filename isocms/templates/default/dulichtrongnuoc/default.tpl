{assign var=title value=$clsCity->getTitle($city_id)}
<section class="pagetravel_container">
   <section class="banner">
      <img src="{$clsCity->getBanner($city_id,1900,340)}">
   </section>
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
               <span itemprop="name" class="reb">{$core->get_Lang('Việt Nam')}</span></a>
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
   <main class="maincontent">
      <section class="introPage">
         <div class="container">
            <div class="introbox">
               <p class="title h2 text_center bold upcase">{$title}</p>
               <div class="intro text_center">{$clsCity->getIntro($city_id)}</div>
               {if $clsCity->getIntro($city_id)}
               <a class="seemore seeclick text_center " href="javascript:void(0);" title="{$core->get_Lang('Tìm hiểu thêm')}">{$core->get_Lang('Tìm hiểu thêm')}</a>
               <a class="seeless seeclick text_center" href="javascript:void(0);" title="{$core->get_Lang('Thu gọn')}" style="display: none">{$core->get_Lang('Thu gọn')}</a>
               {/if}
               {literal}
               <script>
                  var height = $('.introbox .intro').height();
                  if(height < 69){
                  	$('.seemore').hide();
                  }
               </script>
               {/literal}
            </div>
         </div>
      </section>
      <section class="postTravelonPage">
         <div class="container">
            <p class="titlebox h3 bold upcase">{$core->get_Lang("Những điều thú vị tại")} {$title}</p>
            <div class="owl-carousel slide">
               {section name=i loop=$lstGuideCat}
               {assign var=titleCat value=$clsGuideCat->getTitle($lstGuideCat[i].guidecat_id)}
               {assign var=guidecat__id value=$lstGuideCat[i].guidecat_id}
               <div class="Item" guidecat_id="{$lstGuideCat[i].guidecat_id}">
                  <img class="img100" src="{$clsGuideCat->getImage($lstGuideCat[i].guidecat_id,315,320)}" alt="">
                  <div class="body">
                     <h3>{$titleCat}</h3>
                     <div class="intro">{$clsGuideCat->getIntro($lstGuideCat[i].guidecat_id)}</div>
                  </div>
                  <div class="box-shadow"></div>
                   
               </div>
              
               {/section}
            </div>
            <div class="ListGuide">
               {if $lstGuide}
               <div class="row">
                  {section name=i loop=$lstGuide}
                  {assign var=linkGuide value=$clsGuide->getLink($lstGuide[i].guide_id)}
                  {assign var=titleGuide value=$clsGuide->getTitle($lstGuide[i].guide_id)}
                  <div class="col-md-3 col-sm-6">
                     <div class="ItemGuide">
                        <a class="photo" href="{$linkGuide}" title="{$titleGuide}">
                        <img class="img100" src="{$clsGuide->getImage($lstGuide[i].guide_id,295,180)}" alt="{$titleGuide}">
                        </a>
                        <div class="body">
                           <h3 class="title">
                              <a href="{$linkGuide}" title="{$titleGuide}">{$clsGuide->getTitle($lstGuide[i].guide_id)}</a>
                           </h3>
                           <span class="regdate">{$clsGuide->getRegDate($lstGuide[i].guide_id)}</span>
                           <div class="intro">{$clsGuide->getIntro($lstGuide[i].guide_id)|strip_tags}</div>
                        </div>
                     </div>
                  </div>
                  {/section}
               </div>
               <!--						<a class="ViewmoreGuide" href="/" title="{$core->get_Lang("Xem thêm")}">{$core->get_Lang("Xem thêm")}</a>-->
               <a class="seemore seeclick text_center ViewmoreGuide" href="javascript:void(0);" title="{$core->get_Lang('Xem thêm')}">{$core->get_Lang('Xem thêm')}</a>
               <a class="seeless seeclick text_center ViewmoreGuide" href="javascript:void(0);" title="{$core->get_Lang('Ẩn bớt')}" style="display: none">{$core->get_Lang('Ẩn bớt')}</a>
               {/if}
            </div>
         </div>
      </section>
      <section class="tourTravelonPage">
         <div class="container">
            <p class="titlebox h3 bold upcase">{$core->get_Lang("tour du lịch")} {$title}</p>
            <div class="contentListTravel">
               <div class="row">
                  <div class="col-md-3">
                     <div class="filter_left">
                        <div class="totalTour">
                           <p class="totalTourpage h3">{$core->get_Lang('Tìm thấy')} {$totalTour} {$core->get_lang('tour')}</p>
                        </div>
                        {$core->getBlock('Lfilter_trongnuoc')}
                     </div>
                  </div>
                  <div class="col-md-9">
                     <div class="listTourItem">
                        <div class="row">
                           {section name=i loop=$lstTour}
                           {assign var=linkItem value=$clsTour->getLink($lstTour[i].tour_id)}
                           {assign var=titleItem value=$clsTour->getTitle($lstTour[i].tour_id)}
                           <div class="col-md-4 col-sm-6">
                              <div class="Item">
                                 <div class="Image">
                                    <a class="photo" href="{$linkItem}" title="{$titleItem}">
                                    <img class="img100" src="{$clsTour->getImage($lstTour[i].tour_id,295,195)}" alt="">
                                    <span class="numbertripDuration">{$clsTour->getSelectTripDuration($lstTour[i].tour_id)}</span>
                                    </a>
                                    <div class="box-shadow"></div>
                                 </div>
                                 <div class="body">
                                    <div class="show_item">
                                    <h3 class="title">
                                       <a href="{$linkItem}" title="{$titleItem}">{$titleItem}</a>
                                    </h3>
                                    	<div class="review">
                                       <label class="rate-1">
                                       {$clsReview->getStarNew($lstTour[i].tour_id,tour)}
                                       </label>
                                        <span class="review_text">{$clsReviews->getRateAvg($lstTour[i].tour_id,tour)}/5.0 | </span>
                                       <span class="review_text">{$clsReviews->getToTalReview($lstTour[i].tour_id,tour)} {$core->get_Lang('đánh giá')}</span>
										</div>
										{if $clsCity->getTitle($lstTour[i].departure_point_id)}
										<div class="departurePoint">{$core->get_Lang("Điểm khởi hành:")}{$clsCity->getTitle($lstTour[i].departure_point_id)} </div>
										{/if}
                                    </div>
                                    
                                    {if $clsTour->getTripPriceNewPro($lstTour[i].tour_id,$now_day,$is_agent,'value') gt 0}
                                    <div class="price">{$clsTour->getTripPriceNewPro($lstTour[i].tour_id,$now_day,$is_agent,'value')}</div>
                                    {/if}
                                 </div>
                              </div>
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
      <section class="regionTravelonPage">
         <div class="container">
            <p class=" h3 bold upcase text_center">{$core->get_Lang("a-z các điểm du lịch tại")} {$clsCountry->getTitle($country_id)}</p>
            <div class="destinationAZ">
               {section name=i loop=$lstRegion}
               {assign var =lstCityRegion value =$clsCity->getListCityByRegion($lstRegion[i].region_id,$city_id)}
               <h3 class="title">
                  {$clsRegion->getTitle($lstRegion[i].region_id)}
               </h3>
               <div class="listCity">
                  <div class="row">
                     {section name=j loop=$lstCityRegion}
                     <div class="col-md-2">
                        {$clsCity->getTitle($lstCityRegion[j].city_id)}
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
   var min_duration_value = '{$min_duration}';
   var max_duration_value = '{$max_duration}';
   var country_id ='{$country_id}';
   var city_id ='{$city_id}'
</script>
{literal}
<script>
   var owl = $('.owl-carousel');
   owl.owlCarousel({
   nav:true,
   dots:false,
   loop:true,
   animateOut: 'slideOutDown',
   animateIn: 'flipInX',
     	smartSpeed:450,
   margin:10,
   responsiveClass:true,
   responsive: {
   	0: {
   		items: 1,
   		nav:false,
   	},
   	600: {
   		items: 1
   	},
   	1000: {
   		items: 3,
   	}
   }
   }).on('changed.owl.carousel', function(el){
   var number = el.item.index,
   	guidecat_id = $('.owl-item').eq(number).find('.Item').attr('guidecat_id');
   	$('.owl-item.ActiveContent').removeClass('ActiveContent');
   	$('.owl-item').eq(number).addClass('ActiveContent');
   	loadlistGuideByCat(guidecat_id);
   });
   function loadlistGuideByCat(guidecat_id){
   $('.ListGuide').html('');
   $.ajax({  
   	type:'POST',
   	url:path_ajax_script+'/index.php?mod=dulichtrongnuoc&act=listGuide&lang='+LANG_ID, 
   	data:{
   		"cat_id":guidecat_id,
   		"country_id":country_id,
   		"city_id":city_id,
   	},
   	dataType:'html',
   	success:function(html){
   		$('.ListGuide').append( html );
   	}
   	
   });
   }
   $('.play').on('click',function(){
   owl.trigger('play.owl.autoplay',[2000])
   })
   $('.stop').on('click',function(){
   owl.trigger('stop.owl.autoplay')
   })
</script>
{/literal}
{literal}
<script>
   $('.seemore').on('click',function () {
   	$(this).closest('.introbox').find('.intro').css('height','100%');
   	$(this).closest('.introbox').find('.seeless').show();
   	$(this).hide();
   });
   $('.seeless').on('click',function () {
   	$(this).closest('.introbox').find('.intro').removeAttr('style');
   	$(this).closest('.introbox').find('.seemore').show();
   	$(this).hide();
   });
</script>
{/literal}
{literal}
<script>
   $('.seemore').on('click',function () {
   	$(this).closest('.ListGuide').find('.row').css('height','100%');
   	$(this).closest('.ListGuide').find('.seeless').show();
   	$(this).hide();
   });
   $('.seeless').on('click',function () {
   	$(this).closest('.ListGuide').find('.row').removeAttr('style');
   	$(this).closest('.ListGuide').find('.seemore').show();
   	$(this).hide();
   });
</script>
{/literal}