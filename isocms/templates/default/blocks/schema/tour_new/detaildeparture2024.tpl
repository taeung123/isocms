{$clsISO->getTemplate("blocks/schema/component/tour_new")}
{if $clsReviews->getToTalReview($tour_id,$mod) gt 0}
    {literal}
        <script type="application/ld+json">
            {
                "@context": "http://schema.org/",
                "@type": "Product",
                "name": "{/literal}{$title_tour_detail}{literal}",
                "url": "{/literal}{$DOMAIN_NAME}{$clsTour->getLink($tour_id)}{literal}",
                "description": "{/literal}{$clsTour->getTripOverview($tour_id)|strip_tags}{literal}",
                "image": "{/literal}{$DOMAIN_NAME}{$clsTour->getImage($tour_id,300,200)}{literal}",
                "brand": {
                    "@type": "Thing",
                    "name": "Tour"
                },
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "{/literal}{$clsReviews->getRateAvg($tour_id,$mod)}{literal}",
                    "bestRating": "{/literal}{$clsReviews->getBestRate($tour_id,$mod)}{literal}",
                    "ratingCount": "{/literal}{$clsReviews->getToTalReview($tour_id,$mod)}{literal}"
                }
            }
        </script>
    {/literal}
{/if}

{literal}
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Trip",
            "name": "{/literal}{$title_tour}{literal}",
            "description": "{/literal}{$clsTour->getTripOverview($tour_id,$oneItem)|html_entity_decode|replace:'"':'\"'|strip_tags:true}{literal}",
            "itinerary": [
            {/literal}
            {if $lstItineraryTour}
                {section name=i loop=$lstItineraryTour}
                    {assign var=tourItinerary_id value=$lstItineraryTour[i].tour_itinerary_id}
                    {assign var=title_itinerary value=$clsTourItinerary->getTitleItineraryNew($tourItinerary_id,$lstItineraryTour[i])}
                    {assign var=content value=$lstItineraryTour[i].content|html_entity_decode|replace:'"':'\"'|strip_tags}
                    {literal}
                        {
                            "@type": "City",
                            "name": "{/literal}{$title_itinerary}{literal}",
                            "description": "{/literal}{$content}{literal}",
                            "url": ""
                        }{/literal}
                        {if !$smarty.section.i.last}{/if}
                    {/section}
                {/if}
                {literal}
                ]
            }
    </script>

{/literal}