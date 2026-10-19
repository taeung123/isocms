{assign var=_link value = $clsCruise->getLink2($cruise_item_id,'',$arrCruise)}
{assign var=_title value = $clsCruise->getTitle($cruise_item_id,$arrCruise)}
{assign var=start_from value = $clsCruise->getStartCityAround($cruise_item_id,0,0)}
{assign var=destination value = $clsCruise->getLCityAround2($cruise_item_id,0,0)}
{assign var=lstUtilities value=$clsCruise->lstUtilities($cruise_item_id)}
{assign var=cabins value=$clsCruise->getTotalCabin($cruise_item_id)}
{assign var=getBuild value=$clsCruise->getBuild($cruise_item_id)}
{assign var=highlight value=$clsCruise->getHighlight($cruise_item_id)}
<div class="item_cruise mb-4">
    <div class="row">
        <div class="col-12 {if $act ne 'detail'}col-lg-6{/if}">
            <a class="photo" href="{$_link}" title="{$_title}">
                <img class="img100 {if $act eq 'cat' || $act eq 'default'}lazy{else}owl-lazy{/if}" alt="{$_title}"
                     src="{$clsConfiguration->getImage('default_image_pixel',3,2)}"
                     data-src="{$clsCruise->getImage($cruise_item_id,704,368,$arrCruise)}" width="406" height="269"/>
            </a>
        </div>
		
        <div class="col-12 {if $act ne 'detail'}col-lg-6{/if}">
            <div class="cruise_body">
                <div class="box_info_top">
                    <h3 class="title_item_cruise d-flex"><a href="{$_link}" title="{$_title}">{$_title}</a>
                        <p class="cruise_star">{$clsCruise->getStarNew($cruise_item_id,$arrCruise)}</p>
                    </h3>

                    {if $arrCruise.departure_port}
                        <div class="box_item_info">
                            <div class="box_img_item">
                                <img src="{ftp_abs_path_image}/icon/address.svg" alt="Icon">
                            </div>
                            <p class="item_info item_info_start">
                                <label for="" class="lbl_item_info">{$core->get_Lang('Departure Port')}:</label>
                                {$arrCruise.departure_port}
                            </p>
                        </div>
                    {/if}
                    {if $getBuild}
                        <div class="box_item_info">
                            <div class="box_img_item">
                                <img src="{ftp_abs_path_image}/icon/cabin.svg" alt="Icon">
                            </div>
                            <p class="item_info item_info_start">
                                <label for="" class="lbl_item_info">{$core->get_Lang('Launched in')}:</label>
                                {$getBuild}
                            </p>
                        </div>
                    {/if}
                    {if $cabins}
                        <div class="box_item_info">
                            <div class="box_img_item">
                                <img src="{ftp_abs_path_image}/icon/launched.svg" alt="Icon">
                            </div>
                            <p class="item_info item_info_start">
                                <label for="" class="lbl_item_info">{$core->get_Lang('Cabins')}:</label>
                                {$cabins}
                            </p>
                        </div>
                    {/if}
                    {*{if $destination}
                    <p class="item_info item_info_start">
                        <label for="" class="lbl_item_info">{$core->get_Lang('Destinations')}:</label>
                        {$destination}
                    </p>
                    {/if}*}
                    <div class="box_utilities">
                        {if $deviceType ne "phone"}
                            {assign var=key_utilities value=10}
                        {else}
                            {assign var=key_utilities value=5}
                        {/if}
                        {if $lstUtilities.list }
                            {foreach from=$lstUtilities.list key=key item=item}
                                {if $key lt $key_utilities}
                                    <div class="box_utilities_item">
                                        <div class="box_utilities_img">
                                            <img src="{$item.image}" alt="{$item.title}">
                                        </div>
                                        <div class="box_utilities_txt">
                                            {$item.title}
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        {/if}
                        {if $lstUtilities.count gt $key_utilities}
                            {assign var=effect value=$lstUtilities.count - $key_utilities}
                            <div class="box_utilities_more">
                                <div class="box_utilities_more_txt">
                                    {$effect} +
                                </div>
                                <div class="box_utilities_more_list">
                                    {assign var=key_utilities_new value=$key_utilities - 1}
                                    {foreach from=$lstUtilities.list key=key item=item}
                                        {if $key gt $key_utilities_new}
                                            <div class="box_utilities_item">
                                                <div class="box_utilities_img">
                                                    <img src="{$item.image}" alt="{$item.title}">
                                                </div>
                                                <div class="box_utilities_txt">
                                                    {$item.title}
                                                </div>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>

                {if $highlight}
                    <div class="btn_high_light mb-2">
                        {$core->get_Lang('Highlight')}
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </div>
                {/if}

                <div class="box_highlight_content">
                    {$highlight|html_entity_decode}
                </div>

                <div class="box_info_bottom">
                    <div class="cruise_price_box">
                        {$clsCruise->getLTripPrice1($cruise_item_id,$now_month,'list')}
                    </div>
                    <div class="btn_booknow">
                        <a href="{$_link}" title="{$core->get_Lang('Detail')}">{$core->get_Lang('Detail')}<i
                                    class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{literal}
    <style>
        .item_cruise .title_item_cruise {
            gap: 11px;
        }
    </style>
{/literal}