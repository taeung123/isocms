<div class="page_container">
    <div class="banner">
        {if $show eq 'City'}
            <img src="{$clsCity->getImageBannerHotel($city_id,1600,500,$oneItem)}" class="img100"
                 alt="{$core->get_Lang('Hotels in')} {$TD}"/>
        {else}
            <img src="{$clsCountryEx->getImageBannerHotel($country_id,1600,500,$oneItem)}" class="img100"
                 alt="{$core->get_Lang('Hotels in')} {$TD}"/>
        {/if}
        {$core->getBlock('box_form_search_hotel')}
    </div>
    <nav class="breadcrumb-main breadcrumb-cruise bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Hotels')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Hotels')}</span></a>
                    <meta itemprop="position" content="2"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
                    <a itemprop="item" href="{$curl}" title="{$TD}">
                        <span itemprop="name" class="reb">{$TD}</span></a>
                    <meta itemprop="position" content="3"/>
                </li>
            </ol>
        </div>
    </nav>
    <div id="contentPage" class="hotelPlacePage pdt40">
        <div class="container">
            <h1>{$core->get_Lang('Hotels in')} {$TD}</h1>
            <div class="intro_top short_content" data-height="150">
                {$HOTEL_INTRO}
            </div>
            <div class="row">
                <h2 class="result_search">{$core->get_Lang('Find')} {$totalRecord} {$core->get_Lang('accommodations')}</h2>
                <div class="col-lg-3">
                    <div class="block991" style="display:none">
                        <div class="tag-search">
                            <div class="btn_open_modal btn_quick_search bg_main" data-bs-toggle="modal"
                                 data-bs-target="#filter_search">
                                <span>{$core->get_Lang('Filter Trip')}</span> <i class="fa fa-sliders"
                                                                                 aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="filter_search" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="filter_left">
                                    <div class="modal-header">
                                        <h2>
                                            <button type="button" class="close" data-bs-dismiss="modal">
                                                <span aria-hidden="true">X</span>
                                                <span class="sr-only">{$core->get_Lang('Close')}</span>
                                            </button> {$core->get_Lang('Search')}
                                        </h2>
                                    </div>
                                    <div class="modal-body">
                                        {$core->getBlock('filter_left_search_hotel')}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    {assign var=totalHotel value=$listHotelPlace|@count}
                    {section name=i loop=$listHotelPlace}
                        {assign var = hotel_id value = $listHotelPlace[i].hotel_id}
                        {assign var = arrHotel value = $listHotelPlace[i]}
                        {$clsISO->getBlock('box_hotel_item',["hotel_id"=>$hotel_id,"arrHotel"=>$arrHotel])}
                    {/section}
                    {if $totalPage gt '1'}
                        <div class="pagination pager">
                            {$page_view}
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var $_View_more = '{$core->get_Lang("View more")}';
    var $_Less_more = '{$core->get_Lang("Less more")}';
    var $Loading = '{$core->get_Lang("Loading")}';
    var selectmonth = '{$core->get_Lang("select month")}';
    var $_Expand_all = '{$core->get_Lang("Expand all")}';
    var $_Collapse_all = '{$core->get_Lang("Collapse all")}';
    var $_LANG_ID = '{$_LANG_ID}';
</script>

{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function toggleShorted(_this, e) {
                e.preventDefault();
                if (!$(_this).hasClass('clicked')) {
                    $(_this).parent('.short_content')
                        .css('height', 'auto')
                        .removeClass('shorted')
                        .addClass('lessmore');
                    $(_this).addClass('clicked').text($_Less_more);
                } else {
                    var max_height = $(_this).attr('max_height');
                    $(_this).parent('.short_content')
                        .css('height', max_height)
                        .addClass('shorted')
                        .removeClass('lessmore');
                    $(_this).removeClass('clicked').text($_View_more);
                }
                return false;
            }

            $(function () {
                if ($('.short_content').length) {
                    $('.short_content').each((_i, _elem) => {
                        var _max_height = $(_elem).data('height'),
                            _origin_height = $(_elem).outerHeight(false);
                        if (parseInt(_max_height) < _origin_height) {
                            $(_elem)
                                .height(_max_height)
                                .addClass('shorted')
                                .append('<a class="more" max_height="' + _max_height + '" onClick="toggleShorted(this,event)">' + $_View_more + '</a>');
                        }
                    });
                }
            });
        })
    </script>
{/literal}
<script defer src="{$URL_JS}/jquery.countdown.min.js?v={$upd_version}"></script>
<script defer src="{$URL_JS}/jquery-confirm.min.js?v={$upd_version}"></script>
