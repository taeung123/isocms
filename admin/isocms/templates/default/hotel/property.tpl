<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/module.css?v={$upd_version}">
<div class="page-tour_setting">
    {$core->getBlock('header_title_module_setting')}
    <div class="container-fluid container-fluid-2 d-flex">
        {$core->getBlock('menu_hotel_setting')}
        <div class="content_setting_box">
            <div class="page_detail-title d-flex">
                <div class="title">
                    {assign var=title_type value= ($type == "HotelCategory") ? "Hotel Category" : $clsClassTable->getTextByType($type)}
                    <h2>{$title_type}</h2>
                    <p>{$core->get_Lang('Function to manage the list of')} {$title_type} {$core->get_Lang('in the isoCMS system')}</p>
                </div>
                <div class="button_right">
                    <a class="btn btn-main btn-addnew clickToAddProperty" href="javascript:void(0);"
                       title="{$core->get_Lang('Add new')}">{$core->get_Lang('Add new')}</a>
                </div>
            </div>

            <div class="wrap">
                <div class="statistical mb5">
                    <table width="100%" border="0" cellpadding="3" cellspacing="0">
                        <tr>
                            <td width="50%" align="left">&nbsp;</td>
                            <td width="50%" align="right">
                                {$core->get_Lang('Record/page')}:
                                {$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod,$act,$type)}
                                <a class="btn btn-danger btn-delete-all" clsTable="Property" style="display:none">
                                    <i class="icon-remove icon-white"></i>
                                    <span>{$core->get_Lang('Delete Options')}</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <table cellspacing="0" class="tbl-grid table-data full-width table-striped table_responsive">
                    <thead>
                    <tr>
                        {if $type=='HotelFacilities' || $type=='RoomFacilities'}
                            <th class="gridheader boder_top_none"
                                style="text-align:left; width: 80px;">{$core->get_Lang('Favorite')}</th>
                        {/if}
                        <th class="gridheader hiden767" style="width:60px"></th>
                        <th class="gridheader boder_top_none hiden767"
                            style="text-align:left; width: 145px;">{$core->get_Lang('ID')}</th>
                        <th class="gridheader boder_top_none name_responsive {if $type ne 'HotelFacilities' && $type ne 'RoomFacilities'}full-w767{/if}"
                            style="text-align:left;width: calc(100% - 80px)">{$core->get_Lang('Title')}</th>
                        <th class="gridheader boder_top_none hiden767"
                            style="text-align:center; width: 80px;">{$core->get_Lang('func')}</th>
                    </tr>
                    </thead>
                    {if $allItem}
                        <tbody id="SortAble">
                        {section name=i loop=$allItem}
                            <tr style="cursor:move" id="order_{$allItem[i].property_id}"
                                class="{cycle values="row1,row2"}">
                                <td class="index sortable"><i class="fa fa-arrows" aria-hidden="true"></i></td>
                                {if $type=='HotelFacilities' || $type=='RoomFacilities'}
                                    <td class="text_center has-checkbox" style="with:80px">
                                        <input class="changeFavorite" {if $allItem[i].is_favorite} checked{/if}
                                               type="checkbox" data="{$allItem[i].property_id}">
                                    </td>
                                {/if}
                                <td class="text_left hiden767">{$allItem[i].property_id}</td>
                                <td class="name_service {if $type ne 'HotelFacilities' && $type ne 'RoomFacilities'}title_td1{/if}">
                                    <span class="title">{$clsClassTable->getTitle($allItem[i].property_id)}</span>
                                    <button type="button" class="toggle-row inline_block767" style="display:none"><i
                                                class="fa fa-caret fa-caret-down"></i></button>
                                </td>
                                </td>
                                <td class="block_responsive text-center" data-title="{$core->get_Lang('func')}">
                                    <div class="btn-group">
                                        <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu" style="right:0px !important">
                                            <li>
                                                <a class="clickToEditProperty item_left" title="{$core->get_Lang('Edit')}" href="javascript:void(0);" data="{$allItem[i].property_id}">
                                                    <i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="clickToDeleteProperty item_right" title="{$core->get_Lang('Delete')}" href="javascript:void(0);" data="{$allItem[i].property_id}">
                                                    <i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        {/section}
                        </tbody>
                    {elseif $lstHotelProperty}
                        {if $type == "HotelCategory"}
                            <tbody id="SortAble">
                            {section name=i loop=$lstHotelProperty}
                                <tr style="cursor:move" id="order_{$lstHotelProperty[i].hotel_property_id}"
                                    class="{cycle values="row1,row2"}">
                                    <td class="index sortable"><i class="fa fa-arrows" aria-hidden="true"></i></td>
                                    <td class="text_left hiden767">{$lstHotelProperty[i].hotel_property_id}</td>
                                    <td class="name_service"><span
                                                class="title">{$clsHotelProperty->getTitle($lstHotelProperty[i].hotel_property_id)}</span>
                                        <button type="button" class="toggle-row inline_block767" style="display:none"><i
                                                    class="fa fa-caret fa-caret-down"></i></button>
                                    </td>
                                    </td>
                                    <td class="block_responsive text-center" data-title="{$core->get_Lang('func')}">
                                        <div class="btn-group">
                                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </button>
                                            <ul class="dropdown-menu" style="right:0px !important">
                                                <li>
                                                    <a class="clickToEditProperty item_left" title="{$core->get_Lang('Edit')}" href="javascript:void(0);" data="{$lstHotelProperty[i].hotel_property_id}">
                                                        <i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="clickToDeleteProperty item_right" title="{$core->get_Lang('Delete')}" href="javascript:void(0);" data="{$lstHotelProperty[i].hotel_property_id}">
                                                        <i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/section}
                            </tbody>
                        {/if}

                    {else}
                        <tr>
                            <td colspan="7" style="text-align:center">{$core->get_Lang('No Data')}!</td>
                        </tr>
                    {/if}
                </table>
                <div class="clearfix"></div>
                {$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var parent_id = `{$parent_id|default:''}`;
    var type = `{$type|default:''}`;
    var text_delete_type = '{$core->get_Lang("Delete")} {$clsClassTable->getTextByType($type)}';
    var content_vn_required = '{$core->get_Lang("content_vn_required")}';
    var content_en_required = '{$core->get_Lang("content_en_required")}';
    var insert_success = '{$core->get_Lang("insert_success")}';
    var update_success = '{$core->get_Lang("update_success")}';
    var confirm_delete = '{$core->get_Lang("confirm_delete")}';
</script>
{literal}
    <script type="text/javascript">
        $().ready(function () {
            $('#forums select').change(function () {
                $('#forums').submit();
            });
            $('.clickToAddProperty').click(function () {
                vietiso_loading(1);
                var adata = {
                    'parent_id': parent_id,
                    'type': type
                };
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=property&act=ajLoadFormAddProperty",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        makepopup('700px', 'auto', html, 'frmAddProperty', 'frmPop2');
                    }
                });
                return false;
            });
            $('.clickToEditProperty').live('click', function () {
                var $_this = $(this);
                var adata = {
                    'property_id': $_this.attr('data'),
                    'type': type
                };
                vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + "/?mod=property&act=ajLoadFormEditProperty",
                    data: adata,
                    dataType: "html",
                    success: function (html) {
                        vietiso_loading(0);
                        makepopup('700px', 'auto', html, 'frmEditProperty', 'frmPop2');
                    }
                });
                return false;
            });
            $('.clickToDeleteProperty').live('click', function () {
                if (confirm(text_delete_type)) {
                    var $_this = $(this);
                    var adata = {
                        'property_id': $_this.attr('data'),
                        'type': type
                    };
                    vietiso_loading(1);
                    $.ajax({
                        type: "POST",
                        url: path_ajax_script + "/?mod=property&act=ajDeleteProperty",
                        data: adata,
                        dataType: "html",
                        success: function (html) {
                            vietiso_loading(0);
                            window.location.reload();
                        }
                    });
                }
                return false;
            });
            $('.frmPop .clickToClose').live('click', function (e) {
                var idtmp = $(this).closest('.frmPop');
                $('#isoblanketpop_' + idtmp.attr('id')).remove();
                idtmp.remove();
            });
            $('.changeFavorite').live('change', function () {
                var $_this = $(this);
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=property&act=ajUpdatePropertyFavorite',
                    data: {'property_id': $_this.attr('data'), 'is_favorite': $_this.is(':checked') ? 1 : 0},
                    dataType: 'html',
                    success: function (html) {
                        alertify.success(update_success);
                    }
                });
            });
            $('#clickSubmitProperty').live('click', function (e) {
                e.preventDefault();
                var _this = $(this);
                var $image = $('#isoman_url_image');
                if ($('#title').val() == '') {
                    $('#title').addClass('errorInput').focus();
                    alertify.error(title_required);
                    return false;
                }

                var adata = {
                    'title': $('#title').val(),
                    'image': $image.val(),
                    'type': type,
                    'property_id': _this.attr('property_id'),
                    'cat_id': $('#cat_id').val(),
                    'deposit': $('#deposit').val(),
                };
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=property&act=ajSubmitProperty',
                    data: adata,
                    dataType: 'html',
                    success: function (html) {
                        window.location.reload();
                    }
                });
            });
            $('#clickSubmitHotelProperty').live('click', function (e) {
                e.preventDefault();
                var _this = $(this);
                if ($('#title').val() == '') {
                    $('#title').addClass('errorInput').focus();
                    alertify.error(title_required);
                    return false;
                }

                var adata = {
                    'title': $('#title').val(),
                    'type': type,
                    'property_id': _this.attr('property_id'),
                };
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=property&act=ajSubmitHotelProperty',
                    data: adata,
                    dataType: 'html',
                    success: function (html) {
                        window.location.reload();
                    }
                });
            });
        });
    </script>
{/literal}
<script type="text/javascript">
    var $type = `{$type|default:''}`;
    var $recordPerPage = `{$recordPerPage|default:''}`;
    var $currentPage = `{$currentPage|default:''}`;
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
                $.post(path_ajax_script + "/index.php?mod=hotel&act=ajUpdPosSortProperty", order,

                    function (html) {
                        vietiso_loading(0);
                        location.href = REQUEST_URI;
                    });
            }
        });
    </script>
{/literal}