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
                            {assign var="tour_package_id" value=$item.tour_package_id}
                            {assign var="is_online" value=$item.is_online}
                            <tr class="{cycle values="row1,row2"}">
                                <td class="text-left name_service">
                                    <div class="box_name_services">
                                        <p class="txt_name_services">
                                            <a title="{$core->get_Lang('edit')}" href="javascript:void(0)"
                                               class="edit_tour_package" data-tour_package_id="{$tour_package_id}"
                                               data-tour_id="{$tour_id}">{$item.title}</a></p>
                                    </div>
                                    <button type="button" class="toggle-row inline_block767 top12" style="display:none">
                                        <i class="fa fa-caret fa-caret-down"></i></button>
                                </td>
                                <td class="block_responsive" data-title="{$core->get_Lang('status')}"
                                    style="text-align:center">
                                    <a href="javascript:void(0);" class="SiteClickPublic" clsTable="TourPackage"
                                       pkey="tour_package_id" sourse_id="{$tour_package_id}" rel="{$is_online}"
                                       title="{$core->get_Lang('Click to change status')}">
                                        {if $is_online eq '1'}
                                            <i class="fa-solid fa-circle-check green"></i>
                                        {else}
                                            <i class="fa-solid fa-circle-minus red"></i>
                                        {/if}
                                    </a>
                                </td>
                                <td class="block_responsive" align="center" data-title="{$core->get_Lang('func')}"
                                    style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                    <div class="btn-group-ico">
                                        <a title="{$core->get_Lang('edit')}" href="javascript:void(0)"
                                           class="edit_tour_package" data-tour_package_id="{$tour_package_id}"
                                           data-func="edit"><i class="ico ico-edit"></i></a>
                                        <a title="{$core->get_Lang('delete')}" href="javascript:void(0)"
                                           class="confirm_delete delete_tour_package"
                                           data-tour_package_id="{$tour_package_id}" data-func="Del"><i
                                                    class="ico ico-remove"></i></a>
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
            {*<a class="btn_additinerary add_tour_package"
               title="{$core->get_Lang('add new')}">+ {$core->get_Lang('add new')}</a>*}
        </div>
    </div>
</div>