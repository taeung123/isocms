<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Countries List')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Countries List')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$number_all} {$core->get_Lang('Countries List')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_country" title="{$core->get_Lang('Add country')}">{$core->get_Lang('Add country')}</a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="Country" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
					<div class="fr group_buttons full_width_767 text_right mt10_767">
						<a href="{$PCMS_URL}/?mod={$mod}&act=multi_country" class="btn btn-warning btnNew"> 
							<i class="fa fa-cog" aria-hidden="true"></i> <span>Multi-country setting</span> 
						</a>
                        <a href="{$PCMS_URL}/?mod={$mod}{{$pUrl|default:''}}" class="btn btn-warning btnNew"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                        <a href="{$PCMS_URL}/?mod={$mod}{{$pUrl|default:''}}&type_list=Trash" class="btn btn-danger btnNew"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                    </div>
				</form>	
			</div>			
			<div class="statistical mb5">
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="50%" align="left">&nbsp;</td>
						<td width="50%" align="right">
							{$core->get_Lang('Record/page')}:
							{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod,'','')}
						</td>
					</tr>
				</table>
			</div>
			<div class="clearfix"></div>
			<div class="tabbox">
				<div class="hastable">
					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
						<thead>
							<tr>
								<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" class="el-checkbox" /></th>
								<th class="gridheader hiden767" style="text-align:center">{$core->get_Lang('ID')}</th>
								<th class="gridheader name_responsive" style="text-align:left">{$core->get_Lang('Countries name')}</th>
								{if $core->checkAccess('region') && $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
								<th class="gridheader text-center hiden_responsive" width="120px">{$core->get_Lang('Region')}</th>
								{/if}
								{if $core->checkAccess('city') && $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
								<th class="gridheader text-center hiden_responsive" width="120px">{$core->get_Lang('Cities')}</th>
								{/if}
								<th class="gridheader hiden_responsive" style="width:80px">{$core->get_Lang('status')}</th>
								<th class="gridheader hiden_responsive" style="width:70px">{$core->get_Lang('func')}</th>
							</tr>
						</thead>
						{if $allItem[0].country_id ne ''}
						<tbody id="SortAble">
							{section name=i loop=$allItem}
							{assign var = country_id value = $allItem[i].country_id}
							<tr style="cursor:move" id="order_{$country_id}" class="{cycle values="row1,row2"}" >
								<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$country_id}" /></td></td>
								<td class="index hiden767" data-title="ID"><span>{$country_id}</span></td>
								<td class="text-left name_service">
									<span class="title" title="{if $clsClassTable->getOneField('is_online',$country_id) eq 0}{$core->get_Lang('Country PRIVATE')}{/if}">{$clsClassTable->getTitle($country_id)}</span>
									{if $allItem[i].is_online eq 0}
									<span class="color_r" title="{$core->get_Lang('Country PRIVATE')}">[P]</span>{/if}
									{if $allItem[i].is_trash eq '1'}
									<span class="pull-right text-muted">{$core->get_Lang('intrash')}</span>
									{/if}
									<button type="button" class="toggle-row inline_block767" style="display:none">
										<i class="fa fa-caret fa-caret-down"></i>
									</button>
								</td>
								{if $core->checkAccess('region') && $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
								<td data-title="{$core->get_Lang('region')}" class="text-center block_responsive border_top_responsive">
									<a href="{$PCMS_URL}/index.php?mod=region&country_id={$country_id}{{$pUrl|default:''}}">
										{$clsClassTable->countNumberRegion($country_id)}
									</a>
								</td>
								{/if}
								{if $core->checkAccess('city') && $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
								<td data-title="{$core->get_Lang('Cities')}" class="text-center block_responsive border_top_responsive">
									<a href="{$PCMS_URL}/index.php?mod=city&country_id={$country_id}{{$pUrl|default:''}}">
										{$clsClassTable->countNumberCity($country_id)}
									</a>
								</td>
								{/if}
								<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Country" pkey="country_id" sourse_id="{$country_id}" rel="{$clsClassTable->getOneField('is_online',$country_id)}" title="{$core->get_Lang('Click to change status')}">
										{if $clsClassTable->getOneField('is_online',$country_id) eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								<td data-title="{$core->get_Lang('func')}" class="block_responsive text-center" style="vertical-align: middle; width: 10px; text-align:left; white-space: nowrap;">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											{if $allItem[i].is_trash eq '0'}
												<li>
													<a title="{$core->get_Lang('view')}" target="_blank" href="{$DOMAIN_NAME}{$clsClassTable->getLink($country_id)}" class="dropdown-item">
														<i class="icon-eye-open"></i> {$core->get_Lang('view')}
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/country/insert/{$country_id}/overview" class="dropdown-item">
														<i class="icon-edit"></i> {$core->get_Lang('edit')}
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&country_id={$core->encryptID($country_id)}{$pUrl|default:''}" class="dropdown-item">
														<i class="icon-trash"></i> {$core->get_Lang('trash')}
													</a>
												</li>
											{else}
												<li>
													<a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&country_id={$core->encryptID($country_id)}{$pUrl|default:''}" class="dropdown-item">
														<i class="icon-refresh"></i> {$core->get_Lang('restore')}
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act=delete&country_id={$core->encryptID($country_id)}{$pUrl|default:''}" class="dropdown-item">
														<i class="icon-remove"></i> {$core->get_Lang('delete')}
													</a>
												</li>
											{/if}
										</ul>
									</div>
								</td>
							</tr>
							{/section}
						</tbody>
						{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
		</div>
	</div>
</div>
<script type="text/javascript">
	var $boxID = "";
	var $cat_id = `{$cat_id|default:0}`;
	var $city_id= `{$city_id|default:0}`;
	var $departure_point_id= `{$departure_point_id|default:0}`;
	var $is_set= `{$is_set|default:0}`;
	var $recordPerPage = `{$recordPerPage|default:0}`;
	var $currentPage = `{$currentPage|default:0}`;
</script>
<script type="text/javascript" src="{$URL_THEMES}/country/jquery.country.js?v={$upd_version}"></script>
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
			$.post(path_ajax_script+"/index.php?mod=country&act=ajUpdPosSortCountry", order,

			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}