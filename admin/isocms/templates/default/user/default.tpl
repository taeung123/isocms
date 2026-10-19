<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Administrators')}">{$core->get_Lang('Administrators')}</a>
    <a href="javascript:history.back();" class="back fr" style="width:50px;">{$core->get_Lang('Back')}</a>
</div>
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
			<a class="btn btn-main btn-addnew add_new_user" title="{$core->get_Lang('Add New Administrator')}" data-user_group_id="{$user_group_id}">{$core->get_Lang("Add New Administrator")}</a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="hastable">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="email" value="{$email|default:''}" placeholder="{$core->get_Lang('Email')}" />
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
				</form>	
			</div>
			<table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive">
				<thead>
					<tr>
						<th class="gridheader hiden767"><strong>{$core->get_Lang('index')}</strong></th>
						<th class="gridheader name_responsive full-w767" style="text-align:left;"><strong>{$core->get_Lang('Email')}</strong></th>
						<th class="gridheader hiden767" style="text-align:left;"><strong>{$core->get_Lang('First Name')}</strong></th>
						<th class="gridheader hiden767" style="text-align:left;"><strong>{$core->get_Lang('Last Name')}</strong></th>
						<th class="gridheader hiden767" style="text-align:left;"><strong>{$core->get_Lang('Administrator Role')}</strong></th>
						<th class="gridheader hiden767"><strong>{$core->get_Lang('Status')}</strong></th>
						<th class="gridheader hiden767"><strong>Action</strong></th>
					</tr>
				</thead>
				<tbody>
					{section name=i loop=$allItem}
					<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
						<td class="index hiden767">{$smarty.section.i.iteration}</td>
						<td class="name_service title_td1"><a title="Edit" href="{$PCMS_URL}/user/insert/{$allItem[i].user_id}/overview" class="row-title"><strong>{$allItem[i].user_name}</strong></a><button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button></td>
						<td class="posts column-posts num block_responsive" data-title="{$core->get_Lang('First Name')}">{$allItem[i].first_name}</td>
						<td class="posts column-posts num block_responsive" data-title="{$core->get_Lang('Last Name')}">{$allItem[i].last_name}</td>
						<td class="slug column-slug block_responsive" data-title="{$core->get_Lang('Administrator Role')}">{$clsUserGroup->getName($allItem[i].user_group_id)}</td>
						<td class="block_responsive" data-title="{$core->get_Lang('Status')}" style="text-align:center">
							<a href="javascript:void(0);" class="SiteClickPublic" clsTable="User" pkey="{$pkeyTable}" toField="is_active" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_active',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
								{if $clsClassTable->getOneField('is_active',$allItem[i].$pkeyTable) eq '1'}
								<i class="fa-solid fa-circle-check green"></i>
								{else}
								<i class="fa-solid fa-circle-minus red"></i>
								{/if}
							</a>
						</td>
						<td class="block_responsive" data-title="{$core->get_Lang('Action')}" style="vertical-align: top; width: 30px; text-align: right; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li>
										<a href="{$PCMS_URL}/user/insert/{$allItem[i].user_id}/overview" class="dropdown-item" title="{$core->get_Lang('edit')}">
											<i class="icon-edit"></i> {$core->get_Lang('edit')}
										</a>
									</li>
									<li>
										<a href="{$PCMS_URL}/?admin&mod={$mod}&act=delete&user_id={$core->encryptID($allItem[i].user_id)}" class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}">
											<i class="icon-remove"></i> {$core->get_Lang('delete')}
										</a>
									</li>
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