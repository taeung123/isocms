<section class="help_center">
    <div class="container">
            <div class="img_txt_helpcenter">
                <a href="{$clsISO->getLink('contact')}" title="{$core->get_Lang('Contact')}">
                <div class="border_imgservices">
                    <img src="https://i.ibb.co/4fp3dgq/img-customer-Care.png"
                         alt="Help Center Icon" class="mr-3 img100 img_helpcenter" width="88" height="88" loading="lazy">
                </div>
                <div class="info_helpcenter">
                    <h2 class="txt_h2helpcenter">{$core->get_Lang('isoCMS Help Center')}</h2>
        </a>
        <p class="txt_phelpcenter">{$core->get_Lang("Our customer service team is available 24/7 via chat, email and social.")}</p>
    </div>
</section>

{if $listTopDestination}
    <section class="top_des_tourguide">
        <div class="container">
            <div class="top_des_travelstyle">
                <div class="row topdestination">
                    <div class="col-lg-9 col-md-8 col-sm-12">
                        <div class="card_item_destop">
                            <div class="card_body_topdest">
                                <h3 class="title_topdest">{$core->get_Lang('Top Destinations')}</h3>
                                <div class="row">
                                    {section name = y loop=$listTopDestination}
                                        {assign var=is_country_online value=$clsCountryEx->getOneField('is_online',$listTopDestination[y].country_id)}
                                        {if !empty($is_country_online)}
                                        {assign var=city_top_id value=$listTopDestination[y].city_id}
                                        {assign var=getTitle_City value=$listTopDestination[y].title}
                                        {assign var=getLink_City value=$clsCity->getLink($listTopDestination[y].city_id)}
                                        <div class="col-lg-3 col-md-6 col-sm-6 col-6" style="margin-bottom: 12px">
                                            <div class="list-unstyled list_top_dest">
                                                <a href="{$getLink_City}" title="{$getTitle_City}">
                                                    {$getTitle_City}
                                                </a>
                                            </div>
                                        </div>
                                        {/if}
                                    {/section}
                                </div>
                            </div>
                        </div>
                    </div>
                    {if $lstCatTour}
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <div class="card_item_destop">
                                <div class="card_body_topdest">
                                    <h3 class="title_topdest">{$core->get_Lang('Top travel styles')}</h3>
                                    <div class="list_top_dest list_top_travelstyles">
                                        {section name = zz loop= $lstCatTour}
                                            {assign var=getTitle value=$lstCatTour[zz].title}
                                            {assign var=getLink value=$clsTourCategory->getLink($lstCatTour[zz].tourcat_id,$lstCatTour[zz])}
                                            <a href="{$getLink}" title="{$getTitle}">
                                                {$getTitle}
                                            </a>
                                        {/section}
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </section>
{/if}

{literal}
    <style>
        .help_center,
        .top_des_tourguide {
            margin-top: var(--section-space-top)
        }
        .top_des_tourguide {
            margin-bottom: var(--margin-bottom-section);
        }
        /* CSS Help Center */
        .img_txt_helpcenter {
            border-radius: var(--border-radius-card);
            background: var(--main-color);
            padding: 22px;
            display: flex;
            align-items: center;

        }

        .border_imgservices {
            max-width: 128px;
            height: 100%;
            max-height: 128px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--secondary-e-8-f-8-f-8, #E8F8F8);
        }

        .help_center .info_helpcenter {
            margin-left: 51px;
        }

        .help_center .txt_h2helpcenter, 
        .help_center .txt_phelpcenter {
            color: var(--chroma-ffffff, #FFF);
        }

        /* CSS Top Destion and Top Travel Style */

        .card_item_destop {
            border-radius: var(--border-radius-card);
            border: 1px solid var(--card-border-color);
            background: var(--chroma-ffffff, #FFF);
            padding: 24px 26px;
            height: 100%;
            box-shadow: var(--box-shadow);
        }

        .title_topdest {
            margin-bottom: 20px;
        }

        .card_body_topdest .list_top_dest {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .card_body_topdest .list_top_dest a {
            color: var(--text-color);
            font-size: var(--font-size-small);
        }

        .card_body_topdest .list_top_dest a:hover {
            color: var(--secondary-color);
        }

        /*.card_body_topdest .list_top_dest a:nth-child(n+6) {*/
        /*    display: none;*/
        /*}*/

        .card_body_topdest .btn_viewmore {
            padding: 0 10px;
            margin-top: 10px;
        }

        @media (max-width: 1199px) {
        }

        @media (max-width: 991px) {
            .help_center {
                text-align: -webkit-center;
            }
        }

        @media (max-width: 767px) {
            .img_txt_helpcenter {
                display: block;
            }

            .help_center .info_helpcenter {
                margin-left: 0;
            }

        }

        @media (max-width: 575px) {
        }
    </style>
{/literal}