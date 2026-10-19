{assign var=_link value = $clsCruise->getLink($_cruise_id)}
{assign var=_title value = $clsCruise->getTitle($_cruise_id)}

{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
{assign var=getToTalReview value=$clsReviews->getToTalReview($_cruise_id,'cruise')}
{assign var=getRateAvg value=$clsReviews->getRateAvg($_cruise_id,'cruise')}
{assign var=getStarNew value=$clsReviews->getStarNew($_cruise_id,'cruise')}
{else}
{assign var=getToTalReview value=$clsReviews->getToTalReviewNoLogin($_cruise_id,'cruise')}
{assign var=getRateAvg value=$clsReviews->getRateAvgNoLogin($_cruise_id,'cruise')}
{assign var=getStarNew value=$clsReviews->getStarNewNoLogin($_cruise_id,'cruise')}
{/if}
<div class="it__entry_thumb">
   <a href="{$_link}" title="{$_title}">
   <img class="img-responsive img100" alt="{$_title}" src="{$clsCruise->getImage($_cruise_id,380,250)}"/>	
   </a>
</div>
<div class="it__entry_body">
   <h3 class="title"><a href="{$_link}" title="{$_title}">{$_title}</a></h3>
   <div class="price__box">
      {assign var=promotion_id value =$clsCruise->getMinStartDatePromotionProID($_cruise_id)}
      {assign var=check_mem value =$clsCruise->getCheckMemSet($_cruise_id)}
      {if $check_mem eq 1}
      {if $profile_id eq ''}
      {$clsCruise->getLTripPrice($_cruise_id,$now_month,'Valuelist')}
      {else}
      {$clsCruise->getLTripPrice($_cruise_id,$now_month,'list')}
      {/if}
      {else}
      {$clsCruise->getLTripPrice($_cruise_id,$now_month,'list')}
      {/if}
   </div>
   <div class="it_entry_meta mt10">
      <label class="rate-1">
      {$getStarNew} 
      </label>
      <span class="rate_avg">
      {$getRateAvg}	
      </span>
      <span class="text_review text_bold">
      {$clsReviews->getTextRateAVG($_cruise_id,'cruise')} 
      </span>
      {if $getToTalReview gt 0}
      {$getToTalReview} {$core->get_Lang('reviews')}
      {/if}
   </div>
   {if $clsCruise->getDeparturePort($_cruise_id) ne ''}
   <div class="city_des">
      <i class="fa fa-map-marker color_main size24" aria-hidden="true"></i>
      <span class="color_666"><strong class="color_333">{$core->get_Lang('Departure Port')}:</strong> {$clsCruise->getDeparturePort($_cruise_id)}</span>	
   </div>
   {/if}
</div>