{if $listTourDeparture}
<div class="iso_home_departure_schedule">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-5">
                <div id="calendar"></div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="iso_box_departure_schedule">
                    <div class="iso_departure_title">
                        {$core->get_Lang('Departure schedule')}
                    </div>
                    <div class="iso_departure_body">
                        {foreach from=$listTourDeparture key=key item=item}
                        {if $clsTour->checkIsPackage($item.tour_id)}
                            {assign var=parent_id value=$clsTour->getParentId($item.tour_id)}
                            {assign var=tour_link value=$clsTour->getLink($parent_id)}
                        {else}
                            {assign var=tour_link value=$clsTour->getLink($item.tour_id)}
                        {/if}
                        {assign var=tour_title value=$clsTour->getTitle($item.tour_id)}
                        {assign var=dayDeparture value=$clsTourStartDate->getDateDeparture($item.end_date)}
                        {assign var=monthDeparture value=$clsTourStartDate->getMonthDeparture($item.end_date)}
                        {if !$item.allotment} 
                        {assign var=txt_allotment value=$core->get_Lang('Unlimited space')}
                        {else} 
                        {assign var=txt_allotment value=$item.allotment|cat:$core->get_Lang('remaining')}
                        {/if}
                        <a href="{$tour_link}" class="iso_departure_item">
                            <div class="box_left d-flex flex-column align-items-center justify-content-center">
                                <span class="box_left-day">{$dayDeparture}</span>
                                <span class="box_left-month">{$monthDeparture}</span>
                            </div>
                            <div class="box_right iso_departure_body_right">
                                <div  class="d-flex flex-column">
                                    <div class="box_right_title">
                                        {$tour_title}
                                    </div>
                                    <div class="box_right_body d-flex">
                                        <div class="box_right_body_item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                                <path d="M8.40032 15.1723L8.16751 14.7299L8.40032 15.1723ZM7.5996 15.1723L7.83241 14.7299L7.83241 14.7299L7.5996 15.1723ZM13.4999 7.65706C13.4999 9.59625 12.5267 11.18 11.3459 12.3887C10.1651 13.5973 8.81597 14.3887 8.16751 14.7299L8.63313 15.6148C9.32701 15.2498 10.7777 14.4012 12.0611 13.0875C13.3445 11.774 14.4999 9.95317 14.4999 7.65706H13.4999ZM7.99996 2.1571C11.0375 2.1571 13.4999 4.61952 13.4999 7.65706H14.4999C14.4999 4.06724 11.5898 1.1571 7.99996 1.1571V2.1571ZM2.5 7.65706C2.5 4.61952 4.96242 2.1571 7.99996 2.1571V1.1571C4.41013 1.1571 1.5 4.06724 1.5 7.65706H2.5ZM7.83241 14.7299C7.18395 14.3887 5.83486 13.5973 4.65407 12.3887C3.47317 11.18 2.5 9.59625 2.5 7.65706H1.5C1.5 9.95317 2.65546 11.774 3.93878 13.0875C5.22219 14.4012 6.67291 15.2498 7.36679 15.6148L7.83241 14.7299ZM8.16751 14.7299C8.06115 14.7858 7.93876 14.7858 7.83241 14.7299L7.36679 15.6148C7.76462 15.8242 8.2353 15.8242 8.63313 15.6148L8.16751 14.7299ZM10.0713 7.65701C10.0713 8.80102 9.14392 9.72842 7.99991 9.72842V10.7284C9.6962 10.7284 11.0713 9.35331 11.0713 7.65701H10.0713ZM7.99991 5.5856C9.14392 5.5856 10.0713 6.513 10.0713 7.65701H11.0713C11.0713 5.96072 9.6962 4.5856 7.99991 4.5856V5.5856ZM5.9285 7.65701C5.9285 6.513 6.8559 5.5856 7.99991 5.5856V4.5856C6.30361 4.5856 4.9285 5.96072 4.9285 7.65701H5.9285ZM7.99991 9.72842C6.8559 9.72842 5.9285 8.80102 5.9285 7.65701H4.9285C4.9285 9.35331 6.30361 10.7284 7.99991 10.7284V9.72842Z" fill="#717171"/>
                                            </svg>
                                            <span>{$clsTour->getListDeparturePoint($item.tour_id)}</span>
                                        </div>
                                        <div class="box_right_body_item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                                <rect x="1.33325" y="2.5" width="13.3333" height="6" rx="2" stroke="#717171"/>
                                                <path d="M10.6666 12.5V12.5C10.6666 13.2364 10.0696 13.8334 9.33325 13.8334H6.66659C5.93021 13.8334 5.33325 13.2364 5.33325 12.5V12.5" stroke="#717171"/>
                                                <path d="M12.6666 9.83329V9.83329C12.6666 10.5697 12.0696 11.1666 11.3333 11.1666H4.66659C3.93021 11.1666 3.33325 10.5697 3.33325 9.83329V9.83329" stroke="#717171"/>
                                            </svg>
                                            <span>{$txt_allotment}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        {/foreach}
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let allowedDates = `{$lstDateDeparture}`;
</script>
{/if}