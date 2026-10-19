<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('vouchercategory')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('vouchercategory')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('systemmanagementvouchercategory')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew btnCreateCategoryVoucher" title="{$core->get_Lang('Add')} {$core->get_Lang('vouchercategory')}">{$core->get_Lang('Add')} {$core->get_Lang('vouchercategory')}</a>
		</div>
    </div>
	<div class="container-fluid">
    <div class="wrap">
		<div class="filter_box">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="form-group form-keyword">
					<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}" />
				</div>
				<div class="form-group form-button">
					<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang('Search')}</button>
					<input type="hidden" name="filter" value="filter" />
				</div>
				<div class="form-group form-button">
					<a class="btn btn-delete-all" id="btn_delete" clsTable="VoucherCat" style="display:none">
						{$core->get_Lang('Delete')}
					</a>
				</div>
				<div class="fr group_buttons">
					<a href="{$PCMS_URL}/?mod={$mod}&act={$act}" class="btn btn-warning btnNew" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
					<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&type_list=Trash" class="btn btn-danger btnNew" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
				</div>  
			</form>
		</div>
		<div class="clearfix"></div>
		<input id="list_selected_chkitem" style="display:none" value="0" />
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;</td>
					<td width="50%" align="right">
						{$core->get_Lang('Record/page')}:
						{$clsISO->getRecordPerPage($recordPerPage|default:0,$totalRecord|default:0,$mod)}
					</td>
				</tr>
			</table>
		</div>
	</div>
    <div class="tabbox">
        <div class="hastable">
			<table id="list_voucher_cat" class="tbl-grid table-striped table_responsive" width="100%">
				<thead><tr>
					<th class="gridheader" style="width:40px"><input class="el-checkbox" id="check_all" type="checkbox" /></th>
					<th class="gridheader hiden767" style="width:60px">{$core->get_Lang('ID')}</th>
					<th class="gridheader name_responsive" style="text-align:left">{$core->get_Lang('Title')}</th>
					<th class="gridheader hiden_responsive" style="text-align:left; width:200px">{$core->get_Lang('List Voucher')}</th>
					<th class="gridheader hiden_responsive" style="width:140px" align="right">{$core->get_Lang('update')}</th>
					<th class="gridheader hiden_responsive" style="width:116px" align="right">{$core->get_Lang('Status')}</th>
					<th class="gridheader hiden_responsive" style="width:70px"></th>
				</tr></thead>
                {if $allItem[0].voucher_cat_id ne ''}
				<tbody id="SortAble">
			   {section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].voucher_cat_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$allItem[i].voucher_cat_id}" /></td></td>
					<td class="index hiden767"> {$allItem[i].voucher_cat_id}</td>
					<td class="text-left name_service">
						<span class="title" title="{if $clsClassTable->getOneField('is_online',$allItem[i].voucher_cat_id) eq 0}{$core->get_Lang('List Voucher PRIVATE')}{/if}">{$clsClassTable->getTitle($allItem[i].voucher_cat_id)}</span>
						{if $allItem[i].is_online eq 0}
						<span class="color_r" title="{$core->get_Lang('List Voucher PRIVATE')}">[P]</span>{/if}
						{if $allItem[i].is_trash eq '1'}
						<span class="pull-right text-muted">{$core->get_Lang('intrash')}</span>
						{/if}
						<button type="button" class="toggle-row inline_block767" style="display:none">
							<i class="fa fa-caret fa-caret-down"></i>
						</button>
					</td>
                    <td class="block_responsive border_top_responsive" data-title="{$core->get_Lang('List Voucher')}">
						<a href="{$PCMS_URL}/?mod=voucher&voucher_cat_id={$allItem[i].voucher_cat_id}"><i class="fa fa-folder-open"></i> {$core->get_Lang('listofarticles')} <strong style="color:#c00000;">({$clsClassTable->countItemInCat($allItem[i].voucher_cat_id)})</strong></a>
					</td>
					<td class="block_responsive" style="text-align:right" data-title="{$core->get_Lang('update')}">{$clsClassTable->getOneField('upd_date',$allItem[i].voucher_cat_id)|date_format:"%m-%d-%Y %H:%M"}</td>
					<td class="block_responsive" style="text-align:center" data-title="{$core->get_Lang('status')}">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="VoucherCat" pkey="voucher_cat_id" sourse_id="{$allItem[i].voucher_cat_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].voucher_cat_id)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_online',$allItem[i].voucher_cat_id) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td class="block_responsive text-center" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;" data-title="{$core->get_Lang('func')}">
                        <div class="btn-group">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>
							<ul class="dropdown-menu" style="right:0px !important">
								{if $allItem[i].is_trash eq '0'}
									<li>
										<a class="btnEditVoucherCat" title="{$core->get_Lang('edit')}" data="{$allItem[i].voucher_cat_id}">
											<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
										</a>
									</li>
									<li>
										<a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&voucher_cat_id={$core->encryptID($allItem[i].voucher_cat_id)}">
											<i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span>
										</a>
									</li>
								{else}
									<li>
										<a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&voucher_cat_id={$core->encryptID($allItem[i].voucher_cat_id)}">
											<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
										</a>
									</li>
									<li>
										<a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&voucher_cat_id={$core->encryptID($allItem[i].voucher_cat_id)}">
											<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
										</a>
									</li>
								{/if}
							</ul>
						</div>
                    </td>
				</tr>
                {/section}
                {/if}
            </table>  
			
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
var $SiteHasCat_Voucher = "{$clsConfiguration->getValue('SiteHasCat_Voucher')}";
</script>
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
			$.post(path_ajax_script+"/index.php?mod=voucher&act=ajUpdPosSortVoucherCategory", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = `${path_ajax_script}/index.php?mod=${mod}&act=${act}`;
			});
		}
	});
</script>
{/literal}
{*<script type="text/javascript" src="{$URL_THEMES}/voucher/js/jquery.voucher.js?v={$upd_version}"></script>*}