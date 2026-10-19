<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('partner')}">{$core->get_Lang('partner')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$mod}">{$core->get_Lang('partnercategory')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
{if $msg eq 'DeleteFailed'}
<div style="padding:15px; padding-top:0;">
	<div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
		<strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('identicalposts')}
	</div>
</div>
<div class="clearfix"></div>
{/if}
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Partnercategory')} <a class="btn btn-success btnCreateCategoryPartner" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('systemmanagementPartnercategory')}</p>
    </div>
    <div class="clearfix"></div>
    <form id="forums" method="post" class="filterForm" action="">
        <div class="ui-action">
            <div class="wrap">
                <div class="fiterbox" style="width:100%;">
                    <div class="wrap">
                        <div class="searchbox" style="float:left !important;">
                            <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
                            <a class="btn btn-success" href="javascript:void();" id="searchbtn" style=" padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                            <a href="{$PCMS_URL}/index.php?mod=partner" class="btn btn-warning">
                                <i class="icon-list icon-white"></i> <span>{$core->get_Lang('list partner')}</span>
                            </a>
                        </div>
                        <div class="fr group_buttons">
                            <a href="{$PCMS_URL}/?mod={$mod}&act={$act}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                            <a href="{$PCMS_URL}/?mod={$mod}&act={$act}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="PartnerCategory" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <div class="wrap">
        <div class="hastable">
            <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
                <tr>
                    <td class="gridheader"><input id="check_all" type="checkbox" /></td>
                    <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('List partner')}</strong></td>
                    <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('update')}</strong></td>
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('status')}</strong></td>
                    <!--<td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>-->
                    <td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
                </tr>
                {if $allItem[0].partnercat_id ne ''}
				<tbody id="SortAble">
					{section name=i loop=$allItem}
					<tr style="cursor:move" id="order_{$allItem[i].partnercat_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
						<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].partnercat_id}" /></td>
						<td class="index"> {$smarty.section.i.index+1}</td>
						<td>
							<a style="text-decoration:none" title="{$clsClassTable->getTitle($allItem[i].partnercat_id)}"><strong style="font-size:14px;">{$clsClassTable->getTitle($allItem[i].partnercat_id)}</strong></a>
							{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
						</td>
						<td><a href="{$PCMS_URL}/?mod=partner&partnercat_id={$allItem[i].partnercat_id}">
								<i class="fa fa-folder-open"></i> {$core->get_Lang('listofarticles')} <strong style="color:#c00000;">({$clsClassTable->countItemInCat($allItem[i].partnercat_id)})</strong></a>
						</td>
						<td style="text-align:right">{$clsClassTable->getOneField('upd_date',$allItem[i].partnercat_id)|date_format:"%m-%d-%Y %H:%M"}</td>
						<td style="text-align:center">
							<a href="javascript:void(0);" class="SiteClickPublic" clsTable="PartnerCategory" pkey="partnercat_id" sourse_id="{$allItem[i].partnercat_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].partnercat_id)}" title="{$core->get_Lang('Click to change status')}">
								{if $clsClassTable->getOneField('is_online',$allItem[i].partnercat_id) eq '1'}
								<i class="fa-solid fa-circle-check green"></i>
								{else}
								<i class="fa-solid fa-circle-minus red"></i>
								{/if}
							</a>
						</td>
						<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									{if $allItem[i].is_trash eq '0'}
									<li>
										<a href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].partnercat_id)}" target="_blank" class="dropdown-item" title="{$core->get_Lang('view')}">
											<i class="icon-eye-open"></i> <span>{$core->get_Lang('view')}</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0);" class="dropdown-item btnEditPartnerCat" data="{$allItem[i].partnercat_id}" title="{$core->get_Lang('edit')}">
											<i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span>
										</a>
									</li>
									<li>
										<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Trash&partnercat_id={$core->encryptID($allItem[i].partnercat_id)}" class="dropdown-item" title="{$core->get_Lang('trash')}">
											<i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span>
										</a>
									</li>
									{else}
									<li>
										<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Restore&partnercat_id={$core->encryptID($allItem[i].partnercat_id)}" class="dropdown-item" title="{$core->get_Lang('restore')}">
											<i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span>
										</a>
									</li>
									<li>
										<a href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&partnercat_id={$core->encryptID($allItem[i].partnercat_id)}" class="dropdown-item confirm_delete" title="{$core->get_Lang('delete')}">
											<i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span>
										</a>
									</li>
									{/if}
								</ul>
							</div>
						</td>
					</tr>
					{/section}
                </tbody>
				{/if}
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
<script type="text/javascript">
var $SiteHasCat_Partner = "{$clsConfiguration->getValue('SiteHasCat_Partner')}";
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
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajUpdPosSortListPartnerCat", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/partner/jquery.partner.js?v={$upd_version}"></script>