<div class="page_container">
    <div class="page-title d-flex">
        <div class="title">
            <h2>{$core->get_Lang("Administrator Role")}</h2>
            <p>{$core->get_Lang("The administrator roles allow you to fine tune exactly what each of your admin users can do within the ISOCMS admin area.")}</p>
        </div>
        <div class="button_right">
            <button class="btn add_new_usergroup btn_newgroup"
                    title="{$core->get_Lang('Add New')}">{$core->get_Lang("Add New")}</button>
        </div>
    </div>
    <div class="container-fluid table_administ">
        <table cellspacing="0" cellpadding="0" width="100%" class="tbl-grid table-striped table_responsive">
            <thead>
            <tr>
                <th class="gridheader hiden767"><strong>{$core->get_Lang('#')}</strong></th>
                <th class="gridheader name_responsive full-w767" style="text-align:left">
                    <strong>{$core->get_Lang("Group Name")}</strong></th>
                <th class="gridheader hiden767" style="text-align:left">
                    <strong>{$core->get_Lang("Assigned Admin Users")}</strong></th>
            </tr>
            </thead>
            {section name=i loop=$allItem}
                <tr class="{cycle values="row1,row2"}">
                    <td class="index hiden767">
                        {$smarty.section.i.index+1}
                    </td>
                    <td class="name_service title_td1"><strong><a
                                    href="{$PCMS_URL}/usergroup/edit/{$allItem[i].user_group_id}"
                                    title="Sửa {$allItem[i].name}"> {$allItem[i].name}</a></strong>
                        <button type="button" class="toggle-row inline_block767" style="display:none"><i
                                    class="fa fa-caret fa-caret-down"></i></button>
                    </td>
                    <td class="block_responsive" data-title="{$core->get_Lang('Assigned Admin Users')}">
                        {assign var="emails" value="{$clsISO->getAssignedAdminUsers($allItem[i].user_group_id)}"}
                        {assign var="emailList" value=","|explode:$emails}

                        {assign var="filteredEmailList" value=[]}
                        {foreach from=$emailList item=email}
                            {if $email|trim != ''}
                                {append var="filteredEmailList" value=$email}
                            {/if}
                        {/foreach}

                        {if $filteredEmailList|@count > 1}
                            <div class="email-container">
                                <span>{$filteredEmailList[0]},</span>
                                <span class="email-others" onclick="toggleEmailList(this)">+{$filteredEmailList|@count - 1} {$core->get_Lang('others')}</span>
                                <div class="email-popup">
                                    {foreach from=$filteredEmailList item=email name=emailLoop}
                                        {if $smarty.foreach.emailLoop.index > 0}
                                            <!-- Hiển thị từ email thứ 2 trở đi -->
                                            <div>{$email|escape}</div>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        {else}
                            <span>{$filteredEmailList[0]}</span>
                        {/if}






                        <div class="btn-group">
                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" style="right:0px !important">
                                <li><a title="{$core->get_Lang('edit')}"
                                       href="{$PCMS_URL}/usergroup/edit/{$allItem[i].user_group_id}"><i
                                                class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
                                {if $allItem[i].user_group_id ne 1}
                                    <li><a title="{$core->get_Lang('delete')}" class="confirm_delete"
                                           href="{$PCMS_URL}/?admin&mod=usergroup&act=delete&user_group_id={$core->encryptID($allItem[i].user_group_id)}"><i
                                                    class="icon-remove"></i>
                                            <span>{$core->get_Lang('delete')}</span></a></li>
                                {/if}
                            </ul>
                        </div>
                    </td>

                </tr>
            {/section}
        </table>
        <div class="clearfix" style="height:5px"></div>
        <div class="pagination_box">
            <div class="wrap holderEvent_tbl" id="dataTable_paginate">
                <!-- Ajax Loading pagination -->
            </div>
        </div>
    </div>
</div>
{*<script type="text/javascript" src="{$URL_THEMES}/usergroup/jquery.usergroup.js?v={$upd_version}"></script>*}

{literal}
    <style>
        .page_container .page-title {
            padding: 0;
        }

        .page_container .container-fluid {
            padding: 33px 0;
        }

        .tbl-grid {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #DADFE6;
        }

        .tbl-grid th,
        .tbl-grid td {
            border-bottom: 1px solid #DADFE6;
            border-right: 1px solid #DADFE6;
            padding: 8px;
            text-align: left;
        }

        .tbl-grid th {
            background-color: #f9f9f9;
            font-weight: bold;
            border-bottom: 2px solid #DADFE6;
        }

        .tbl-grid tr:last-child td {
            border-bottom: none;
        }

        .tbl-grid tr td:last-child {
            border-right: none;
        }

        .tbl-grid thead tr th, .tbl-grid tr td, .tbl-grid tbody tr th {
            border-right: 1px solid #DADFE6;
        }

        .tbl-grid thead tr th {
            padding: 15px !important;
        }

        .btn_newgroup {
            display: inline-flex;
            padding: 12px 24px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
            color: #FFF;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 150%; /* 24px */
        }

        .btn_newgroup:hover {
            background: var(--secondary-177-fa-4, #177FA4);
            color: #FFF;
        }

        .page-title.d-flex h2 {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 28px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
        }

        .page-title.d-flex p {
            color: var(--chroma-717171, #717171);
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%; /* 21px */
        }

        .tbl-grid thead tr th {
            color: #8591AA;
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 150%; /* 21px */
            text-transform: uppercase;
            border-radius: 4px 4px 0px 0px;
            background: #F4F7F9;
        }

        .block_responsive {
            position: relative; /* Đặt relative để làm gốc tham chiếu */
        }

        .btn-group {
            position: absolute; /* Cố định */
            right: 0; /* Đưa về phía phải */
        }

        .btn_dropdown {
            display: flex; /* Đảm bảo nút dropdown hiển thị đúng */
            justify-content: center;
            align-items: center;
        }

        .email-container {
            position: relative;
            display: inline-block;
        }

        .email-popup {
            display: none;
            position: absolute;
            bottom: 100%; /* Hiển thị bên trên */
            left: 0;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 10px;
            z-index: 100;
            white-space: nowrap;
        }

        .email-popup div {
            padding: 5px 10px;
            font-size: 14px;
        }

        .email-popup div:hover {
            background: #f0f0f0;
            cursor: pointer;
        }

        .row1 td.index, .name_service a, .email-container {
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
        }
        .row1 td.index, .name_service a {
            color: var(--primary-1-d-2-d-53, #1D2D53);
        }
        .email-others {
            color: var(--primary-18-babd, #18BABD);
        }
        .email-others:hover {
            text-decoration: underline;
            cursor: pointer;
        }

    </style>
    <script>
        $(document).on('click', '.add_new_usergroup', function (ev) {
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=usergroup&act=ajActionNewUserGroup',
                data: {
                    'tp': 'S'
                },
                dataType: "json",
                success: function (json) {
                    if (json.result == 'success') {
                        window.location.href = path_ajax_script + '/' + json.link;
                    }
                }
            });
        });

        function toggleEmailList(element) {
            var $popup = $(element).siblings('.email-popup');

            // Đóng tất cả các popup khác
            $('.email-popup').not($popup).hide();

            // Hiển thị hoặc ẩn popup hiện tại
            $popup.toggle();
        }

        // Đóng popup khi click ngoài
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.email-container').length) {
                $('.email-popup').hide();
            }
        });

    </script>
{/literal}