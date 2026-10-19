{if $lstCruiseViewed}
<div class="widget widget-viewed">
    <h4 class="widget-tit">{$core->get_Lang('My Viewed Cruises')} <i class="fa-dropdown fa fa-angle-down hidden-lg hidden-md"></i></h4>
    <div class="w-body">
    <ul>
        {section name=i loop=$lstCruiseViewed}
        <li class="media eachlicruiseviewed_69">
            <a href="{$clsCruise->getLink($lstCruiseViewed[i].cruise_id)}" data="{$lstCruiseViewed[i].cruise_id}" class="clickviewedCruise pull-left">
            <img src="{$clsCruise->getImage($lstCruiseViewed[i].cruise_id,50,50)}" alt="{$clsCruise->getTitle($lstCruiseViewed[i].cruise_id)}" width="100%"/>
            </a>
            <div class="media-body">
            <h5 class="media-heading"><a data="{$lstCruiseViewed[i].cruise_id}" class="clickviewedCruise" href="{$clsCruise->getLink($lstCruiseViewed[i].cruise_id)}">{$clsCruise->getTitle($lstCruiseViewed[i].cruise_id)}</a></h5>
            <label class="rate-1">{$clsReviews->getStarNew($lstCruiseViewed[i].cruise_id)}</label>
            </div>
        </li>
        {/section}
    </ul>
    </div>
</div>
{/if}