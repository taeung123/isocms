<link rel="stylesheet" href="{$URL_CSS}/salekits.css?v={$upd_version}"/>
<div class="page_container page_sale_kits">
    <div class="bg_banner">
        <img class="full-width height-auto" src="/uploads/Banner/banner_VIAC.jpg" alt="Resources">
        {$core->getBlock('2024_breadcrumb')}
    </div>
    <div class="boxEventMaterial">
        <div class="container">
            <div class="EventMaterial_caption">
                <h1 class="h1_caption">Publications</h1>
            </div>
            <div class="listDownload_event">
                <div class="find-a-trip">
                    <form class="form_search_book" method="post" action="">
                        <input type="text" name="keyword" class="form-control" value="{$keyword}" placeholder="{$core->get_Lang("Search")}...">
                        <input type="hidden" value="searchBook" name="hid">
                        <button class="btn_submit_form" type="submit"><i class="fa-regular fa-magnifying-glass"></i></button>
                    </form>
                </div>
                {if !empty($listSaleKit)}
                    {foreach from=$listSaleKit item=item}
                        <div class="item_download_event">
                            <a class="photo" target="_blank" href="{$item.attachment_file}" title="{$item.title}">
                                <img class="full-width height-auto" src="{$clsISO->tripslashImage($item.image, 220, 298)}" alt="{$item.title}">
                            </a>
                            <div class="body">
                                <h2 class="title"><a class="text-dark" target="_blank" href="{$item.attachment_file}" title="{$item.title}">{$item.title}</a></h2>
                                <div class="intro">{$item.intro|html_entity_decode}</div>
                                <div class="date">
                                    {$clsISO->formatDateMText($item.upd_date)}
                                </div>
                                <div class="venue">
                                </div>
                                <a target="_blank" href="{$item.attachment_file}" download title="{$core->get_Lang('Download')}" class="down_load">
                                    <i class="fa-regular fa-download"></i> {$core->get_Lang('Download')}
                                </a>
                            </div>
                        </div>
                    {/foreach}
                {/if}
            </div>
            {if $page_view}
                <div class="hnv_trvs_main_tour_paginate">
                    <div class="pagination pager">
                        {$page_view}
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>