<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div class="page_container">
    <div class="page-title d-flex">
        <div class="title">
            {if $user_group_id eq '0'}
                <h2>{$core->get_Lang('Administrators')}</h2>
            {else}
                <h2>{$core->get_Lang('Administrators')}: {$oneUserGroup.name}</h2>
            {/if}
            <p>{$core->get_Lang("This is where you configure the users which you want to allow to access the admin area.")}</p>
        </div>
        <div class="button_right">
            <a class="btn add_new_user btn_newgroup" title="{$core->get_Lang('Add New')}" data-user_group_id="{$user_group_id}">{$core->get_Lang("Add New")}</a>
        </div>

    </div>
    <div class="container-fluid">
        <div class="hastable">
            <table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive">
                <thead>
                <tr>
                    <th class="gridheader hiden767"><strong>{$core->get_Lang('#')}</strong></th>
                    <th class="gridheader name_responsive full-w767" style="text-align:left;"><strong>{$core->get_Lang('Email')}</strong></th>
{*                    <th class="gridheader hiden767" style="text-align:left;"><strong>{$core->get_Lang('First Name')}</strong></th>*}
{*                    <th class="gridheader hiden767" style="text-align:left;"><strong>{$core->get_Lang('Last Name')}</strong></th>*}
                    <th class="gridheader hiden767" style="text-align:left;"><strong>{$core->get_Lang('Administrator Role')}</strong></th>
                    <th class="gridheader hiden767"><strong>{$core->get_Lang('Status')}</strong></th>
                </tr>
                </thead>
                <tbody>
                {section name=i loop=$allItem}
                    <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                        <td class="index hiden767">{$smarty.section.i.iteration}</td>
                        <td class="name_service title_td1"><a title="Edit" href="{$PCMS_URL}/user/insert/{$allItem[i].user_id}/overview" class="row-title"><strong>{$allItem[i].user_name}</strong></a><button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button></td>
{*                        <td class="posts column-posts num block_responsive" data-title="{$core->get_Lang('First Name')}">{$allItem[i].first_name}</td>*}
{*                        <td class="posts column-posts num block_responsive" data-title="{$core->get_Lang('Last Name')}">{$allItem[i].last_name}</td>*}
                        <td class="slug column-slug block_responsive" data-title="{$core->get_Lang('Administrator Role')}">{$clsUserGroup->getName($allItem[i].user_group_id)}</td>
                        <td class="block_responsive btntoggle_status" data-title="{$core->get_Lang('Status')}" style="text-align:center">
                            <div class="form-check form-switch align-items-center d-flex" style="gap: 9px">
                                <input class="form-check-input toggle-switch" type="checkbox"
                                       id="statusSwitch{$allItem[i].$pkeyTable}"
                                       data-rel="{$allItem[i].$pkeyTable}"
                                       data-cls-table="User"
                                       data-to-field="is_active"
                                       {if $clsClassTable->getOneField('is_active', $allItem[i].$pkeyTable) eq '1'}checked{/if}>
                                <label class="form-check-label ms-2" for="statusSwitch{$allItem[i].$pkeyTable}">
                                    {if $clsClassTable->getOneField('is_active', $allItem[i].$pkeyTable) eq '1'}{$core->get_Lang('Active')}{else}{$core->get_Lang('Deactivate')}{/if}
                                </label>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu" style="right:0px !important">
                                    <li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/user/insert/{$allItem[i].user_id}/overview"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
                                    <li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?admin&mod={$mod}&act=delete&user_id={$core->encryptID($allItem[i].user_id)}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
                                </ul>
                            </div>
                        </td>


                    </tr>
                {/section}
                </tbody>
            </table>
            <div class="clearfix" style="height:5px"></div>
            <div class="pagination_box">
                <div class="wrap holderEvent_tbl" id="dataTable_paginate">
                    <!-- Ajax Loading pagination -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{$URL_THEMES}/user/jquery.user.new.js?v={$upd_version}"></script>

<script>
    var lang = {
        error_update: "<?= $core->get_Lang('Error updating, please try again.') ?>",
        success_update: "<?= $core->get_Lang('Update successful.') ?>"
    };
</script>
{literal}
    <style>
        .page_container .page-title {
            padding: 0;
        }

        .page_container .container-fluid {
            padding: 33px 0;
        }

        .row1 td.index, .name_service a strong, .email-container, .form-check-label, .block_responsive {
            font-size: 16px !important;
            font-style: normal;
            font-weight: 400;
            line-height: 150% !important;
        }
        .row1 td.index, .name_service a, .block_responsive {
            color: var(--primary-1-d-2-d-53, #1D2D53);
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

        .tbl-grid thead tr th {
            padding: 15px !important;
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

        /* Đổi màu toggle */
        .form-check-input.toggle-switch {
            width: 40px;
            height: 21px;
            background-color: #ddd;
            border-radius: 20px;
            transition: background-color 0.3s ease-in-out;
            position: relative;
            -webkit-appearance: none;
            appearance: none;
            cursor: pointer;
            outline: none;
            border: none;
        }

        input[type=checkbox]:focus {
            outline: none;
        }

        .form-check-input.toggle-switch:checked {
            border-radius: 20px;
            background: var(--primary-18-babd, #18BABD);
            box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.10) inset;
            border: none;
        }

        .form-check-input.toggle-switch:before {
            content: '';
            width: 18px;
            height: 18px;
            background-color: #fff;
            border-radius: 50%;
            position: absolute;
            top: 1px;
            left: 1px;
            transition: left 0.3s ease-in-out;
        }

        .form-check-input.toggle-switch:checked:before {
            left: 21px; /* Vị trí nút khi bật */
        }

        /* Tùy chỉnh nhãn (Active/Disactive) */
        .form-check-label {
            color: #343a40;
            margin: 0;
        }

        .btntoggle_status {
            display: flex;
            justify-content: space-between;
        }

    </style>

    <script>
        $(document).on('click', '.add_new_user', function (ev) {
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=user&act=ajActionNewUser',
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

        $(document).ready(function () {
            $('.toggle-switch').on('change', function () {
                let isActive = $(this).is(':checked') ? 1 : 0; // Trạng thái mới (1: Bật, 0: Tắt)
                let rel = $(this).data('rel');                // Giá trị khóa chính của đối tượng (pvalTable)
                let clsTable = $(this).data('cls-table');     // Tên bảng (clsTable)
                let toField = $(this).data('to-field');       // Trường cần cập nhật (toField)
                let pkey = $(this).data('pkey');              // Tên khóa chính (pkey)

                // Gửi AJAX
                $.ajax({
                    url: 'https://isocms.com/admin/index.php?mod=home&act=saveField',
                    method: 'POST',
                    data: {
                        clsTable: clsTable,     // Tên bảng
                        pkey: pkey,             // Khóa chính của bảng
                        pvalTable: rel,         // Giá trị khóa chính (ID)
                        toField: toField,       // Trường cần cập nhật
                        val: isActive,          // Giá trị mới
                        allowDuplicate: 0       // Không cho phép trùng lặp
                    },
                    success: function (response) {
                        if (response !== 'IsDuplicated') {
                            // Tải lại trang sau khi cập nhật thành công
                            location.reload();
                        }
                    },
                    error: function () {
                        alert(lang.error_update);
                    }
                });
            });
        });



    </script>
    {/literal}