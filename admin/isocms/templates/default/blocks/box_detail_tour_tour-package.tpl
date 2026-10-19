<div class="box_package_tour box_main_step_content">
    <div class="row d-flex full-height">
        <div class="col-md-9 ajContent">
            <div class="fill_data_box">
                <h3 class="title_box mb10">{$core->get_Lang('Tour Package')}</h3>
                <p class="intro_box">{$core->get_Lang("This function is intended to manage tour package in isoCMS system")}</p>
                <div class="button_right">
                    <a href="#" tour_id="{$tour_id}" target="_blank" class="btn ajAddTourPackage btn-green mb10" style="float:right">
                        <span>Add Packages</span>
                    </a>
                </div>
                <div class="form_option_tour">
                    <div class="inpt_tour">
                        <div class="hastable">
                            {if $listTourpackage}
                                <table class="tbl-grid table-striped table_responsive" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="gridheader name_responsive name_responsive1" style="text-align:left">
                                            <strong>{$core->get_Lang('Tour package')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:center; width:100px">
                                            <strong>{$core->get_Lang('status')}</strong></th>
                                        <th class="gridheader hiden_responsive"
                                            style="text-align:center; width:70px">{$core->get_Lang("Function")}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="SortAble">
                                    {foreach from=$listTourpackage item=item}
                                        {assign var="tour_package_id" value=$item.tour_id}
                                        {assign var="is_package_online" value=$item.is_package_online}
                                        {assign var="link_edit_package" value="$PCMS_URL/tour/edit/$tour_package_id/basic/title-tripcode"}
                                        <tr style="cursor: move" id="order_{$tour_package_id}" class="{cycle values="row1,row2"}">
                                            <td class="text-left name_service">
                                                <div class="d-flex align-items-center" style="gap: 10px">
                                                    <a style="color: inherit" href="{$link_edit_package}">{$item.title}</a>
{*                                                    {if $clsISO->checkConnTMS() && (!empty($item.yield_id) || !empty($item.tms_code))}<span class="btn_connect is_connect_tms">{$core->get_Lang('TravelMaster')}</span>{/if}*}
                                                </div>
                                            </td>
                                            <td class="block_responsive" data-title="{$core->get_Lang('status')}"
                                                style="text-align:center">
                                                <a href="javascript:void(0);" class="SiteClickPublic" clsTable="Tour"
                                                   pkey="tour_id" sourse_id="{$tour_package_id}" rel="{$is_package_online}" toField="is_package_online"
                                                   title="{$core->get_Lang('Click to change status')}">
                                                    {if $is_package_online eq '1'}
                                                        <i class="fa fa-check-circle green"></i>
                                                    {else}
                                                        <i class="fa fa-minus-circle red"></i>
                                                    {/if}
                                                </a>
                                            </td>
                                            {*<td class="block_responsive" align="center" data-title="{$core->get_Lang('func')}"
                                                style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                                <div class="btn-group-ico">
                                                    <a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/tour/edit/{$tour_package_id}/basic/title-tripcode"
                                                       class="edit_tour_package" data-tour_package_id="{$tour_package_id}"
                                                       data-func="edit"><i class="ico ico-edit"></i></a>
                                                    <a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&tour_id={$core->encryptID($tour_package_id)}"
                                                       class="confirm_delete delete_tour_package"
                                                       data-tour_package_id="{$tour_package_id}" data-func="Del"><i
                                                                class="ico ico-remove"></i></a>
                                                </div>
                                            </td>*}
                                            <td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">
                                                <div class="d-flex align-items-center justify-content-center" style="gap:5px">
                                                    <div class="btn-group">
                                                        <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" title="{$core->get_Lang('edit')}" href="{$link_edit_package}">
                                                                    <i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&tour_id={$core->encryptID($tour_package_id)}">
                                                                    <i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
                                                                </a>
                                                            </li>
                                                            {* Nếu muốn thêm phần syncTMS thì tương tự:
                                                            <li>
                                                                <a class="dropdown-item" id="syncTourApitoTMS" title="{$core->get_Lang('syncTourAPItoTMS')}" data-tour_package="{$tour_package_id}" href="javascript:void(0);">
                                                                    <i class="icon-share"></i> <span>{$core->get_Lang('syncTourAPItoTMS')}</span>
                                                                </a>
                                                            </li>
                                                            *}
                                                        </ul>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                            {else}
                                <div class="mb30">{$core->get_Lang("No data")}</div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="instruction_fill_data_box">
                <p class="title_box"><i class="fa fa-question-circle text-red "
                                        aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
                <div class="content_box">
                    <p class="mb0">{$core->get_Lang("Thông tin về các gói tour")}</p>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <style>
        .edit_tour_package {
            font-weight: normal;
        }
    </style>
    <script type="text/javascript">
        $(document).on('click', '#syncTourApifromTMS', function(e) {
            e.preventDefault();
            let tour_package = $(this).data("tour_package");
            let yield_id = $(this).data("yield_id");
            let data = {
                "tour_id": tour_package,
                "yield_id": yield_id
            }
            $.post(path_ajax_script+'/index.php?mod='+mod+'&act=syncOneTourPackageAPI', data, function(res){
                $Core.util.toggleIndicatior(0);
                if ($Core.util.isEmpty(res.result)){
                    $.alert({
                        title: 'Thất bại',
                        content: 'Vui lòng kiểm tra thông tin kết nối TMS tại: Cài đặt > Hồ sơ Công ty',
                    });
                }else{
                    if (res.result == 'error') {
                        $.alert({
                            title: 'Thất bại',
                            content: res.msg,
                            onClose: function () {
                                location.href = REQUEST_URI;
                            }
                        });
                    } else {
                        $.alert({
                            title: 'Thành công',
                            content: res.msg,
                            onClose: function () {
                                location.href = REQUEST_URI;
                            }
                        });
                    }
                }
            },'json');
            return false;
        });
        $(document).on('click', '#syncTourApitoTMS', function(e) {
            e.preventDefault();
            let tour_package = $(this).data("tour_package");
            let lst_tour_id = [tour_package]
            $.post(path_ajax_script+'/index.php?mod='+mod+'&act=syncTourToTMS', {lst_tour_id:lst_tour_id}, function(res){
                $Core.util.toggleIndicatior(0);
                if ($Core.util.isEmpty(res.result)){
                    $.alert({
                        title: 'Thất bại',
                        content: 'Vui lòng kiểm tra thông tin kết nối TMS tại: Cài đặt > Hồ sơ Công ty',
                    });
                }else{
                    if (res.result == 'error') {
                        $.alert({
                            title: 'Thất bại',
                            content: res.msg,
                            onClose: function () {
                                location.href = REQUEST_URI;
                            }
                        });
                    } else {
                        $.alert({
                            title: 'Thành công',
                            content: res.msg,
                            onClose: function () {
                                location.href = REQUEST_URI;
                            }
                        });
                    }
                }
            },'json');
            return false;
        });
        $("#SortAble").sortable({
            opacity: 0.8,
            cursor: 'move',
            start: function(){
                vietiso_loading(1);
            },
            stop: function(){
                vietiso_loading(0);
            },
            update: function(){
                let order = $(this).sortable("serialize")+`&tour_id=${tour_id}`;
                $.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdSortTourPackage", order,

                function(){
                    vietiso_loading(0);
                });
            }
        });
    </script>
{/literal}
