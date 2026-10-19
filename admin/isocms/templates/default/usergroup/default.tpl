<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Administrators Role')}">{$core->get_Lang('Administrators Role')}</a>
	<!-- Back -->
    <a href="javascript:history.back();" class="back fr" style="width:50px;">{$core->get_Lang('Back')}</a>
</div>
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang("Administrator Role")}</h2>
			<p>{$core->get_Lang("The administrator roles allow you to fine tune exactly what each of your admin users can do within the ISOCMS admin area.")}</p>
		</div>
		<div class="button_right">
			<a  class="btn btn-main btn-addnew add_new_usergroup" title="{$core->get_Lang('Add New Administrator Role')}">{$core->get_Lang("Add New Administrator Role")}</a>
		</div>
    </div>
	<div class="container-fluid">
		<table cellspacing="0" cellpadding="0" width="100%" class="tbl-grid table-striped table_responsive">
			<thead>
				<tr>
					<th class="gridheader hiden767"><strong>{$core->get_Lang('No.')}</strong></th>
					<th class="gridheader name_responsive full-w767" style="text-align:left"><strong>{$core->get_Lang("Group Name")}</strong></th>
					<th class="gridheader hiden767" style="text-align:left"><strong>{$core->get_Lang("Assigned Admin Users")}</strong></th>
					<th class="gridheader hiden767" style="width:6%">{$core->get_Lang("action")}</th>
				</tr>
			</thead> 
			{section name=i loop=$allItem}
			<tr class="{cycle values="row1,row2"}">
				<td class="index hiden767">
					{$smarty.section.i.index+1}
				</td>
				<td class="name_service title_td1"><strong><a href="{$PCMS_URL}/usergroup/edit/{$allItem[i].user_group_id}" title="Sửa {$allItem[i].name}"> {$allItem[i].name}</a></strong><button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button></td>
				<td class="block_responsive" data-title="{$core->get_Lang('Assigned Admin Users')}">{$clsISO->getAssignedAdminUsers($allItem[i].user_group_id)}</td>
				<td class="block_responsive" data-title="{$core->get_Lang('action')}" style="vertical-align:top; text-align:right; white-space: nowrap;"> 
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							<li>
								<a href="{$PCMS_URL}/usergroup/edit/{$allItem[i].user_group_id}" class="dropdown-item" title="{$core->get_Lang('edit')}">
									<i class="icon-edit"></i> {$core->get_Lang('edit')}
								</a>
							</li>
							{if $allItem[i].user_group_id ne 1}
							<li>
								<a href="{$PCMS_URL}/?admin&mod={$mod}&act=delete&user_group_id={$core->encryptID($allItem[i].user_group_id)}" class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}">
									<i class="icon-remove"></i> {$core->get_Lang('delete')}
								</a>
							</li>
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
<script type="text/javascript" src="{$URL_THEMES}/usergroup/jquery.usergroup.js?v={$upd_version}"></script>