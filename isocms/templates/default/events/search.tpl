<div class="page_container ListEvents EventsDefault">
    <div class="banner">
        <img class="full-width height-auto" src="{$SiteBannerEvent}" alt="{$core->get_Lang('Events search')}">
        <div class="titlePage">
            <h1 class="TitlePage">{$core->get_Lang('Events search')}</h1>
            <div class="intro">{$SiteIntroEvent|html_entity_decode}</div>
        </div>
        {$core->getBlock('box_search_events')}
    </div>
    <div class="eventsPage">
        <div class="list_events_box">
            {if $listEvent}
                <div id="list_events" class="list_events">
                    {section name=i loop=$listEvent}
                        <div class="item_event">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="time color_main text_bold">
                                            <span class="day">{$listEvent[i].start_date|date_format:"%d"}</span>
                                            <span class="month text-uppercase {if $_LANG_ID eq 'vn'}vn{/if}">
										{if $_LANG_ID eq 'vn'}
                                            {$core->get_Lang('Month')}
                                            {$listEvent[i].start_date|date_format:"%m"}
                                        {else}
                                            {$listEvent[i].start_date|date_format:"%b"}
                                        {/if}

									</span>
                                            <span class="year">{$listEvent[i].start_date|date_format:"%Y"}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="photo" href="{$clsISO->getLinkEvent($listEvent[i].slug,$listEvent[i].event_id)}" title="{$title}">
                                            <img src="{$listEvent[i].image}" class="img100" alt="{$listEvent[i].title}">
                                        </a>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="body">
                                            <h3 class="title limit_2line">
                                                <a class="color_1c1c1c" href="{$clsISO->getLinkEvent($listEvent[i].slug,$listEvent[i].event_id)}" title="{$listEvent[i].title}">{$listEvent[i].title}</a>
                                            </h3>
                                            <div class="header_article mb10">
                                                <a class="title_cat size14" title="{$listEvent[i].title_cat}" href="{$clsISO->getLink('events')}/{$listEvent[i].slug_cat}">{$listEvent[i].title_cat}</a>
                                            </div>
                                            <p class="location text_bold d-flex">
                                                <i class="fa fa-map-marker w_25px mt5" aria-hidden="true"></i>
                                                <span class="w__25">{$listEvent[i].address}</span>
                                            </p>
                                            <p class="date text_bold text-uppercase mb0 d-flex">
                                                <i class="fa fa-calendar-o w_25px mt5" aria-hidden="true"></i>
                                                <span class="w__25">{if $listEvent[i].start_date|date_format:"%d" eq $listEvent[i].due_date|date_format:"%d"}{$listEvent[i].start_date|date_format:"%d/%m/%Y"}{else}{$listEvent[i].start_date|date_format:"%d/%m/%Y"} - {$listEvent[i].due_date|date_format:"%d/%m/%Y"}{/if}</span>
                                            </p>
                                            <div class="intro limit_3line">{$listEvent[i].intro|html_entity_decode|strip_tags}</div>
                                            <a class="more_news" href="{$clsISO->getLinkEvent($listEvent[i].slug,$listEvent[i].event_id)}" title="{$core->get_Lang('Read more')}">{$core->get_Lang('Read more')} <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/section}
                </div>
                <div class="pagination_event">
                    {if $totalPage gt '1'}
                        <div class="list_pagination text-center">
                            <div class="pagination pager">
                                {$page_view}
                            </div>
                        </div>
                    {/if}
                </div>
                {else}
                <div id="list_events" class="list_events">
                    <div class="container">
                        <h3 style="margin: 150px 0">{$core->get_Lang('Events are being updated. Please come back later')}...</h3>
                    </div>
                </div>
            {/if}

            <div class="Subcribemail">
                <div class="container">
                    {$core->getBlock('Subcribemail')}
                </div>
            </div>
        </div>
    </div>
</div>