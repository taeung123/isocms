{if $mod eq 'tour'}
    {assign var="title" value=$core->get_Lang("Travel Styles")}
    {if $act === "place_inbound2024"}
        {assign var="title" value=$clsCountry->getTitle($country_id)}
    {elseif $act === "searchtour2024"}
        {assign var="title" value=$core->get_Lang("Tours")}
        {assign var="title_active" value=$core->get_Lang("Search results")}
    {/if}

    <section class="hnv_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{$DOMAIN_NAME}{$extLang}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
                    </li>
                    {if $act == "place_inbound2024" || $act == "travel_style_by_country"}
                        <li class="breadcrumb-item">
                            <a href="#" title="{$core->get_Lang($title)}">{$core->get_Lang("Destination")}</a>
                        </li>
                    {/if}
                    {if $show == "CatCountry"}
                        <li class="breadcrumb-item">
                            <a href="#">{$clsCountry->getTitle($country_id)}</a>
                        </li>
                    {/if}
                    <li class="breadcrumb-item">
                        <a href="#" title="{$core->get_Lang($title)}">{$core->get_Lang($title)}</a>
                    </li>
                    {if isset($oneItem) && !empty($oneItem.title)}
                    <li class="breadcrumb-item active" aria-current="page">
                        {$oneItem.title} {if $act === "place_inbound2024" || $act === "place_outbound2024"}{$core->get_Lang("tours")}{/if}
                        {$title_active|default:''}
                    </li>
                    {/if}
                </ol>
            </nav>
        </div>
    </section>
{elseif $mod eq 'tour_new'}
    <section class="hnv_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{$DOMAIN_NAME}{$extLang}"
                           title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{$clsISO->getLink('search_tour')}" title="{$core->get_Lang('Tours')}">
                            {$core->get_Lang('Tours')}
                        </a>
                    </li>
                    {if isset($oneItem) && !empty($oneItem.title)}
                        <li class="breadcrumb-item active" aria-current="page">
                            {$oneItem.title}
                        </li>
                    {/if}
                </ol>
            </nav>
        </div>
    </section>
{elseif $mod eq 'hotel'}
    <section class="hnv_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{$DOMAIN_NAME}{$extLang}"
                           title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
                    </li>
                    {if $act == 'place2024'}    <!-- 2024 breadcrumb hotel list -->
                        {if $show == 'Country'}
                            <li class="breadcrumb-item">
                                <a href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Hotels')}">
                                    {$core->get_Lang('Hotels')}
                                </a>
                            </li>
                            {if isset($oneItem) && !empty($oneItem.country_id)}
                            <li class="breadcrumb-item active" aria-current="page">
                                {$clsCountryEx->getTitle($oneItem['country_id'])}
                            </li>
                            {/if}
                        {else}
                            <li class="breadcrumb-item active" aria-current="page">
                                {$core->get_Lang('Hotels')}
                            </li>
                        {/if}
                    {elseif $act == 'detail2024'}   <!-- 2024 breadcrumb hotel detail -->
                        <li class="breadcrumb-item">
                            <a href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Hotels')}">
                                {$core->get_Lang('Hotels')}
                            </a>
                        </li>
                        {if isset($oneItem) && !empty($oneItem.country_id)}
                            <li class="breadcrumb-item">
                                <a href="{$clsCountryEx->getLink($oneItem['country_id'],'Hotel')}"
                                   title="{$clsCountryEx->getTitle($oneItem['country_id'])}">
                                    {$clsCountryEx->getTitle($oneItem['country_id'])}
                                </a>
                            </li>
                        {/if}
                       {if isset($oneItem) && !empty($oneItem.title)}
                        <li class="breadcrumb-item active" aria-current="page">
                            {$oneItem.title}
                        </li>
                        {/if}
                    {/if}
                </ol>
            </nav>
        </div>
    </section>
{elseif $mod eq 'cruise'}
    <section class="hnv_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{$DOMAIN_NAME}{$extLang}"
                           title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{$link_cat}" title="{$title_cat}">
                            {$title_cat}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {$clsCruise->getTitle($cruise_id)}
                    </li>
                </ol>
            </nav>
        </div>
    </section>
{elseif $mod eq 'agent' && $act eq 'sale_kits'}
    <section class="hnv_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{$DOMAIN_NAME}{$extLang}"
                           title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{$clsISO->getLink("sale_kits")}" title="{$title_cat}">
                            {$core->get_Lang("Sale Kits")}
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
{/if}

{literal}
    <style>
        .hnv_breadcrumb {
            margin-top: 10px;
            margin-bottom: 32px;
            color: var(--chroma-717171, #717171);
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 21px; /* 150% */
        }

        .hnv_breadcrumb .breadcrumb {
            margin: unset;
            padding: unset;
        }

        @media (max-width: 992px) {
            .hnv_breadcrumb {
                display: none;
            }
            .hnv_tour_detail_intro {
                margin-top: 72px;
            }
        }
        @media (max-width: 768px) {
            .hnv_tour_detail_main_meeting_pickup_content .col-12.col-md-6:first-child {
                border-bottom: 1px solid #DADFE6;
                padding-bottom: 15px;
                margin-bottom: 15px;
            }
            .hnv_tour_detail_main_review_content_filter_left {
                margin-bottom: 30px;
            }
        }
    </style>
{/literal}

