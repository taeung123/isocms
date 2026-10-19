<section class="tourTravelonPage PageSearch">
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
                           {section name=i loop=$lstTourResult}
                           {assign var=linkItem value=$clsTour->getLink($lstTourResult[i].tour_id)}
                           {assign var=titleItem value=$clsTour->getTitle($lstTourResult[i].tour_id)}
                           <div class="col-md-4">
                              <div class="Item">
                                 <div class="Image">
                                    <a class="photo" href="{$linkItem}" title="{$titleItem}">
                                    <img class="img100" src="{$clsTour->getImage($lstTourResult[i].tour_id,295,195)}" alt="">
                                    <span class="numbertripDuration">{$clsTour->getSelectTripDuration($lstTourResult[i].tour_id)}</span>
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
                                       {$clsReview->getStarNew($lstTourResult[i].tour_id,tour)}
                                       </label>
                                        <span class="review_text">{$clsReviews->getRateAvg($lstTourResult[i].tour_id,tour)}/5.0 | </span>
                                       <span class="review_text">{$clsReviews->getToTalReview($lstTourResult[i].tour_id,tour)} {$core->get_Lang('đánh giá')}</span>
										</div>
										{if $clsCity->getTitle($lstTourResult[i].departure_point_id)}
										<div class="departurePoint">{$core->get_Lang("Điểm khởi hành:")}{$clsCity->getTitle($lstTourResult[i].departure_point_id)} </div>
										{/if}
                                    </div>
                                    
                                    {if $clsTour->getTripPriceNewPro($lstTourResult[i].tour_id,$now_day,$is_agent,'value') gt 0}
                                    <div class="price">{$clsTour->getTripPriceNewPro($lstTourResult[i].tour_id,$now_day,$is_agent,'value')}</div>
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