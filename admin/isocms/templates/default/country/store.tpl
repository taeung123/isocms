<div class="page_container">
    <div class="breadcrumb">
        <strong>{$core->get_Lang('youarehere')} : </strong>
        <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
        <a>&raquo;</a>
        <a href="{$curl}" title="{$mod}">{$clsCityStore->getTitle($type)}</a>
        <!-- // -->
        <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
    </div>
    <div class="container-fluid">
        <div class="page-title">
            <h2>{$clsCityStore->getTitle($type)}</h2>
            <p>{$core->get_Lang('Top Management departures list system')}</p>
        </div>
        <div class="wrap">
            <div class="row">
                <div class="clearfix" style="height:10px"></div>
                <div class="col-xs-12 filter_box">
                    <form id="forums" method="post" class="filterForm" action="">
                        <div class="form-group form-keyword">
                            <input type="text" class="form-control m-wrap short" name="keyword" value="{$keyword}"
                                   placeholder="{$core->get_Lang('search')}..."/>
                        </div>
                        <div class="form-group form-country">
                            <select name="country_id" onchange="document.getElementById('forums').submit();"
                                    class="form-control select"
                                    style="font-size:14px;">{$clsCountry->makeSelectboxOption($country_id)}</select>
                        </div>
                        <div class="form-group form-button">
                            <button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
                            <input type="hidden" name="filter" value="filter"/>
                        </div>
                    </form>
                </div>
                <div class="hastable col-md-6">
                    <table cellspacing="0" class="tbl-grid full-width" width="100%">
                        <tr>
                            <th class="gridheader"></th>
                            <th class="gridheader hidden1023"><strong>{$core->get_Lang('index')}</strong></th>
                            <th class="gridheader" style="text-align:left">
                                <strong>{$core->get_Lang('nameofcity')}</strong></th>
                            <th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('func')}</strong>
                            </th>
                        </tr>
                        {if !empty($listItem) && $listItem[0].city_id ne ''}
                            {foreach from=$listItem item=item name=cityLoop}
                                <tr class="{cycle values="row1,row2"}">
                                    <td class="check_40 text_center">
                                        <input class="chkitem iso_checkbox_item" value="{$item.city_id}" data-country_id="{$item.country_id}" type="checkbox">
                                    </td>
                                    <td class="index hidden1023">{$smarty.foreach.cityLoop.iteration}</td>
                                    <td>
                                        <strong style="font-size:18px">{$clsClassTable->getTitle($item.city_id)}</strong>
                                    </td>
                                    <td style="vertical-align:middle; width:65px; text-align:right; white-space:nowrap;">
                                        <a class="iso-button-action"
                                        href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Add&type={$core->encryptID($type)}&city_id={$item.city_id}&country_id={$item.country_id}"
                                        title="Thêm địa điểm này"><i class="icon-plus-sign icon-white"></i> {$core->get_Lang('Add')}</a>
                                    </td>
                                </tr>
                            {/foreach}
                        {else}
                            <tr>
                                <td colspan="6" style="text-align:center">{$core->get_Lang('No Data')}!</td>
                            </tr>
                        {/if}

                    </table>
                    <input type="hidden" id="list_selected_chkitem"/>
                    <div class="clearfix" style="height:10px"></div>
                    <div style="width:96%; padding:2%; background: #fff;border:1px solid #ccc">
                        <label><input type="checkbox" id="check_all"/> {$core->get_Lang('selectall')}</label>
                        <a _type="{$type}" class="btn btn-success fileinput-button clickToSaveCityStore">
                            <i class="icon-plus icon-white"></i>
                            <span>{$core->get_Lang('Save')}</span>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="adminPaging">
                        <ul class="lstAdminPaging">
                            {section name=i loop=$listPageNumber}
                                <li>
                                    <a href="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}"
                                       {if $listPageNumber[i] eq $currentPage}class="active"{/if}>{$listPageNumber[i]}</a>
                                </li>
                            {/section}
                        </ul>
                        <div class="report">
                            <strong>{$core->get_Lang('statistical')}</strong>:
                            <strong>{$totalRecord}</strong> {$core->get_Lang('records')}
                            /<strong>{$totalPage}</strong> {$core->get_Lang('page')}
                            . {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong>.
                        </div>
                    </div>
                </div>
                <div class="hastable col-md-6">
                    <div class="fiterbox">
                        <div class="wrap">
                            <div class="searchbox" style="float:left !important; width:100%">
                                <h1 style="font-family:Cambria; font-weight:bold; font-style:italic;">{$clsCityStore->getTitle($type)} {$core->get_Lang('selected')}</h1>
                            </div>
                        </div>
                    </div>
                    <table cellspacing="0" class="tbl-grid full-width">
                        <thead>
                        <tr>
                            <th class="gridheader"><strong>{$core->get_Lang('index')}</strong></th>
                            <th class="gridheader" style="text-align:left">
                                <strong>{$core->get_Lang('nameofcity')}</strong></th>
                            <th class="gridheader" style="text-align:center"><strong>{$core->get_Lang('func')}</strong>
                            </th>
                        </tr>
                        </thead>
                        {if $listSelected[0].city_id ne ''}
                            <tbody id="SortAble">
                            {section name=i loop=$listSelected}
                                <tr style="cursor:move" id="order_{$listSelected[i].city_id}"
                                    class="{cycle values="row1,row2"}">
                                    <td class="index">{$smarty.section.i.index+1}</td>
                                    <td>
                                        <strong style="font-size:18px">{$clsClassTable->getTitle($listSelected[i].city_id)}</strong>
                                    </td>
                                    </td>
                                    <td style="vertical-align: middle; width: 90px; text-align: right; white-space: nowrap;">
                                        <a class="iso-cancel-action clkDeleteCityStore"
                                           _citystore_id="{$listSelected[i].citystore_id}"
                                           title="{$core->get_Lang('Cancel')}" href="javascript:void();"><i
                                                    class="icon-upload icon-white"></i> {$core->get_Lang('Cancel')}</a>
                                    </td>
                                </tr>
                            {/section}
                            </tbody>
                        {else}
                            <tbody>
                            <tr>
                                <td colspan="7" style="text-align:center">{$core->get_Lang('No Data')}!</td>
                            </tr>
                            </tbody>
                        {/if}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <style>.disabled {
            -moz-opacity: .8;
            -webkit-opacity: .8;
            -o-opacity: .8;
            opacity: .8;
            filter: anpha(opacity=80)
        }</style>
{/literal}
<script type="text/javascript">
    var required_country = "{$core->get_Lang('You not selected country')}";
    var required_city = "{$core->get_Lang('You not selected city')}";
</script>
{literal}
    <script type="text/javascript">
        $().ready(function () {
            $(document).on('click', '.clkDeleteCityStore', function (ev) {
                if (confirm(confirm_delete)) {
                    var $_this = $(this);
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajDeleteCityStore',
                        data: {'citystore_id': $_this.attr('_citystore_id')},
                        dataType: "html",
                        success: function (html) {
                            window.location.reload(true);
                        }
                    });
                }
            });
            $(document).on('click', '.ajMoveCityStore', function (ev) {
                var $_this = $(this);
                var adata = {
                    'citystore_id': $_this.attr('_citystore_id'),
                    'city_id': $_this.attr('_city_id'),
                    'country_id': $_this.attr('_country_id'),
                    'direct': $_this.attr('direct')
                };
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=" + mod + "&act=ajMoveCityStore",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        window.location.reload(true);
                    }
                });
                return false;
            });

            $(document).on('click', '.clickToSaveCityStore', function (ev) {
                var _this = $(this);
                // if ($('select[name=country_id]').val() == '') {
                //     alertify.error(required_country);
                //     $('select[name=country_id]').focus();
                //     return false;
                // }
                // if ($('#list_selected_chkitem').val() == '') {
                //     alertify.error(required_city);
                //     return false;
                // }
                let lstCheckbox = [];
                $('.iso_checkbox_item').each(function(){
                    if($(this).prop('checked')){
                        let city_id = $(this).val();
                        let country_id = $(this).data('country_id');
                        lstCheckbox.push({country_id: country_id, city_id: city_id})
                    }
                })
                var adata = {
                    lstCheckbox: lstCheckbox,
                    'type': _this.attr('_type')
                };
                _this.find('span').text(loading);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/index.php?mod=" + mod + "&act=ajSaveStoreForCity",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        _this.find('span').text(save);
                        $('#check_all').removeAttr('checked');
                        window.location.reload(true);
                    }
                });
            });
        });
    </script>
{/literal}
<script type="text/javascript">
    var $type = '{$type}';
    var $recordPerPage = '{$recordPerPage}';
    var $currentPage = '{$currentPage}';
</script>
{literal}
    <script type="text/javascript">
        $("#SortAble").sortable({
            opacity: 0.8,
            cursor: 'move',
            start: function () {
                vietiso_loading(1);
            },
            stop: function () {
                vietiso_loading(0);
            },
            update: function () {
                var type = $type;
                var recordPerPage = $recordPerPage;
                var currentPage = $currentPage;
                var order = $(this).sortable("serialize") + '&update=update' + '&recordPerPage=' + recordPerPage + '&currentPage=' + currentPage + '&type=' + type;
                $.post(path_ajax_script + "/index.php?mod=country&act=ajUpdPosSortCityStore", order,

                    function (html) {
                        vietiso_loading(0);
                    });
            }
        });
    </script>
{/literal}