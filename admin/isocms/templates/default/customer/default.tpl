<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')}:</strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Customer')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Customer')} 
			<a href="{$PCMS_URL}/?mod={$mod}&act=edit" class="btn btn-success fileinput-button">
				<i class="icon-plus icon-white"></i> <span></span> 
			</a>
		</h2>

		<p>{$core->get_Lang('This function is intended to manage Customer in isoCMS system')}</p>
    </div>
	<div class="clearfix"></div>
    <div id="clienttabs">
        <ul>
            <li class="tabchild"><a href="#">{$core->get_Lang('List Customer')}</a></li>
        </ul>
    </div>
    <div id="tab_content">
        <div class="tabbox" style="display:block">
            <form id="forums" method="post" action="" class="filterForm">
                 <div class="ui-action">
                    <div class="wrap">
                        <div class="span100 fiterbox">
                            <div class="wrap">
                                <div class="searchbox" style="float:left !important;">
                                    <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('Search')}..." />
                                    <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                                        <i class="icon-search icon-white"></i>
                                    </a>
                                </div>
								<div style="float:right;">
									<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span> </a>
									<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
									<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Customer" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="filter" value="filter" />
            </form>
            <div class="clearfix"><br /></div>
            {if $allItem[0].customer_id eq ''}
            No data
            {else}
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;</td>
					<td width="50%" align="right">
						{$core->get_Lang('Record/page')}:
						{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
					</td>
				</tr>
			</table>
            <table cellspacing="0" class="table tbl-grid table-striped table_responsive" width="100%">
				<thead>
					<tr>
						<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
						<th class="gridheader hiden767" style="width:60px">{$core->get_Lang('ID')}</th>
						<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Full Name')}</strong></th>
						<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('Email')}</strong></th>
						<th class="gridheader hiden_responsive" style="width:60px"><strong>{$core->get_Lang('status')}</strong></th>
						<th class="gridheader text-center hiden_responsive" style="width:40px"></th>
					</tr>
				</thead>
                <tbody id="SortAble" class="sortByTd">
					{section name=i loop=$allItem}
					<tr style="cursor:move" id="order_{$allItem[i].customer_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
						<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].customer_id}" /></th>
						<th class="index hiden767" style="width: 5%; text-align: center;">{$allItem[i].customer_id}</th>
						<td class="name_service">							
							<a title="Edit" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&customer_id={$allItem[i].customer_id}">
							   <strong>{$clsClassTable->getTitle($allItem[i].customer_id)}</strong>
							</a>
							{if $allItem[i].is_trash eq '1'}
							<span style="color:#ccc;">[In Trash]</span>
							{/if}
							<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
						</td>
						<td data-title="{$core->get_Lang('Email')}" class="block_responsive border_top_responsive">{$clsClassTable->getEmail($allItem[i].customer_id)}
						</td>
						<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
							<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Customer" pkey="customer_id" sourse_id="{$allItem[i].customer_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].customer_id)}" title="{$core->get_Lang('Click to change status')}">
								{if $clsClassTable->getOneField('is_online',$allItem[i].customer_id) eq '1'}
								<i class="fa-solid fa-circle-check green"></i>
								{else}
								<i class="fa-solid fa-circle-minus red"></i>
								{/if}
							</a>
						</td>
						<td data-title="{$core->get_Lang('func')}" class="block_responsive" style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;"> 
							<div class="dropdown">
								<button class="btn btn_dropdown dropdown-toggle"
										type="button"
										data-bs-toggle="dropdown"
										aria-expanded="false">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>

								<ul class="dropdown-menu dropdown-menu-end">
									{if $allItem[i].is_trash eq '0'}

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('edit')}"
										href="{$PCMS_URL}/?mod={$mod}&act=edit&customer_id={$allItem[i].customer_id}">
											<i class="icon-edit"></i> {$core->get_Lang('edit')}
										</a>
									</li>

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('trash')}"
										href="{$PCMS_URL}/?mod={$mod}&act=trash&customer_id={$allItem[i].customer_id}">
											<i class="icon-trash"></i> {$core->get_Lang('trash')}
										</a>
									</li>

									{else}

									<li>
										<a class="dropdown-item"
										title="{$core->get_Lang('restore')}"
										href="{$PCMS_URL}/?mod={$mod}&act=restore&customer_id={$allItem[i].customer_id}">
											<i class="icon-refresh"></i> {$core->get_Lang('restore')}
										</a>
									</li>

									<li>
										<a class="dropdown-item confirm_delete"
										title="{$core->get_Lang('delete')}"
										href="{$PCMS_URL}/?mod={$mod}&act=delete&customer_id={$allItem[i].customer_id}">
											<i class="icon-remove"></i> {$core->get_Lang('Delete')}
										</a>
									</li>

									{/if}
								</ul>
							</div>
						</td>
					</tr>	
					{/section}
            	</tbody>
			</table>
            {/if}
            {$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
		</div>
	</div>
</div>

<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
{literal}
<script type="text/javascript">
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
			var recordPerPage = $recordPerPage;
			var currentPage = $currentPage;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListCustomer", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}