{assign var=tourItinerary_id value=$item.tour_itinerary_id}
{assign var=_lstItineraryTransport value=$item.lstItineraryTransport}
{assign var=lst_transport_id value=$item.transport}
{assign var=lstItineraryTransport value=$clsTransport->getAll("is_trash=0 and is_online=1 and transport_id in ($lst_transport_id) order by order_no ASC",'transport_id,image,title')}
{assign var=_ItineraryContent value=$item.content}
{assign var=_ItineraryImage value = $item.image}
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed "
                type="button" data-bs-toggle="collapse"
                data-bs-target="#panelsStayOpen-collapse{$key}"
                aria-expanded="true"
                aria-controls="panelsStayOpen-collapse{$key}">
            {$clsTourItinerary->getTitleItineraryNew($tourItinerary_id,$item)}
        </button>
    </h2>
    <div id="panelsStayOpen-collapse{$key}"
         class="accordion-collapse collapse">
        <div class="accordion-body">
            {*{if $lstItineraryTransport && $clsISO->getCheckActiveModulePackage($package_id,'property','transport','default')}
                <div class="mb10">
                    <div class="icon-transport-tour">
                        {section name=k loop=$lstItineraryTransport|@count}
                            <div class="iso_transport_tour"
                                 title="{$clsTransport->getTitle($lstItineraryTransport[k].transport_id,$lstItineraryTransport[k])}">
                                <img src="{$clsTransport->getImageUrl($lstItineraryTransport[k].transport_id,$lstItineraryTransport[k])}"
                                     width="30" height="30"
                                     alt="{$clsTransport->getTitle($lstItineraryTransport[k].transport_id,$lstItineraryTransport[k])}"/>
                            </div>
                        {/section}
                    </div>
                </div>
            {/if}*}
            {if $item.is_show_image eq '1' and $_ItineraryImage ne ''}
                <div class="box_content_item d-flex flex-wrap">
                    <div class="photo_itinerary">
                        <img class="photo275 image img100" width="263"
                             height="153" src="{$_ItineraryImage}"
                             onerror="this.style.display='none';"/>
                    </div>
                    <div class="intro_itinerary">
                        {$_ItineraryContent|html_entity_decode}
                    </div>
                </div>
            {else}
                {$_ItineraryContent|html_entity_decode}
            {/if}
        </div>
    </div>
</div>