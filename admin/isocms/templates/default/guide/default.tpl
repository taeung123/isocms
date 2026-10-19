<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Travel Guide')}: {$core->get_Lang('Content list')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('Travel Guide')}: {$core->get_Lang('Content list')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$number_all|default:0} {$core->get_Lang('Content list')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_guide" title="{$core->get_Lang('Add guide')}">{$core->get_Lang('Add guide')}</a>
			<div class="btn btn-setting"><a href="{$PCMS_URL}/?mod={$mod}&act=setting" title="{$core->get_Lang('Setting')}"><i class="fa fa-cog" aria-hidden="true"></i></a></div>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
                    <div class="form_search_box mb30">
                        <div class="form-group form-keyword">
                            <input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
                        </div>
                        {if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
                        <div class="form-group form-country">
                            <select onchange="_reload2();" name="country_id" class="form-control" data-width="100%" id="slb_country">
                                {$clsCountry->makeSelectboxOption($country_id)}
                            </select>
                        </div>
                        {/if}
                        {*{if $clsRegion->makeSelectboxOption($country_id,$region_id) && $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
                        <div class="form-group form-country">
                            <select onchange="_reload2();" name="region_id" class="form-control" data-width="100%" id="slb_country">
                                {$clsRegion->makeSelectboxOption($country_id,$region_id)}
                            </select>
                        </div>
                        {/if}
                        <div class="form-group form-country">
                            <select onchange="_reload2();" name="city_id" class="form-control" data-width="100%" id="slb_country">
                                {$clsCity->makeSelectboxOptionnew($city_id,$country_id,$region_id,$city_id)}
                            </select>
                        </div>*}
                        {if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
                        <div class="form-group form-country">
                            <select onchange="_reload2();" name="cat_id" class="form-control" data-width="100%" id="slb_country">
                                {$clsGuideCat->makeSelectboxOptionNew(0,$cat_id,$country_id,$city_id)}
                            </select>
                        </div>
                        {/if}
                        <div class="form-group form-button">
                            <button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
                            <input type="hidden" name="filter" value="filter" />
                        </div>
                    </div>
					<div class="statistical mb5">
                        <table width="100%" border="0" cellpadding="3" cellspacing="0">
                            <tr>
                                <td width="50%" align="left">
                                    {if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
                                    <div class="group_buttons mt10_767">
                                         <a href="{$PCMS_URL}/?mod={$mod}&act=cat" class="btn btn-success btnNew" title="{$core->get_Lang('Guide Category')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('Guide Category')}</span> </a>
                                    </div>
                                    {/if}
                                    <div class="form-group form-button">
                                        <a class="btn btn-delete-all" id="btn_delete" clsTable="Guide" style="display:none">
                                            {$core->get_Lang('Delete')}
                                        </a>
                                    </div>
                                </td>
                                <td width="50%" align="right">
                                    {$core->get_Lang('Record/page')}:
                                    {$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod,'','')}
                                </td>
                            </tr>
                        </table>
                    </div>
				</form>	
			</div>			
			
			<div class="clearfix"></div>
			<div class="tabbox">
				<div class="hastable">
					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
						<thead>
							<tr>
								<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox"  class="el-checkbox" /></th>
								<th class="gridheader hiden767" style="width:60px">{$core->get_Lang('ID')}</th>
								<th class="gridheader name_responsive" style="text-align:left">{$core->get_Lang('Name')}</th>
								{if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
								<th class="gridheader hiden_responsive" style="text-align:left; width:200px">{$core->get_Lang('categories')}</th>
								{/if}
								{*{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
								<th class="gridheader hiden_responsive" style="text-align:left; width:120px">{$core->get_Lang('City')}</th>
								{/if}*}
								{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
								<th class="gridheader hiden_responsive" style="text-align:left; width:120px">{$core->get_Lang('Country')}</th>
								{/if}
								<th class="gridheader hiden_responsive" style="width:70px">{$core->get_Lang('status')}</th>
								<th class="gridheader hiden_responsive" style="width:74px">{$core->get_Lang('func')}</th>
							</tr>
						</thead>
						{if $allItem[0].guide_id ne ''}
						<tbody id="SortAble">
							{section name=i loop=$allItem}
							{assign var = guide_id value = $allItem[i].guide_id}
							<tr style="cursor:move" id="order_{$guide_id}" class="{cycle values="row1,row2"}" >
								<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$guide_id}" /></td>
								<td class="index hiden767">{$allItem[i].guide_id}</td>
								<td class="name_service">
								<span class="title" title="{if $clsClassTable->getOneField('is_online',$allItem[i].guide_id) eq 0}{$core->get_Lang('Guide PRIVATE')}{/if}">{$clsClassTable->getTitle($allItem[i].guide_id)}</span>
								{if $clsClassTable->getOneField('is_online',$allItem[i].guide_id) eq 0}<span style="color:red;" title="{$core->get_Lang('Guide PRIVATE')}">[P]</span>{/if}
								{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
								<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
								</td>
							   {if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
								<td data-title="{$core->get_Lang('categories')}" class="block_responsive">
								<i class="fa fa-folder-open"></i>  <a href="{$PCMS_URL}/?mod={$mod}&cat_id={$allItem[i].cat_id}" title="{$clsGuideCat->getTitle($allItem[i].cat_id)}">{$clsGuideCat->getTitle($allItem[i].cat_id)}</a>
								</td>
								{/if}
								{*{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
								<td data-title="{$core->get_Lang('City')}" class="block_responsive">
								{$clsCity->getTitle($allItem[i].city_id)}
								</td>
								{/if}*}
								{if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
								<td data-title="{$core->get_Lang('Country')}" class="block_responsive">
								{$clsCountry->getTitle($allItem[i].country_id)}
								</td>
								{/if}
								<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Guide" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
										{if $clsClassTable->getOneField('is_online',$allItem[i].$pkeyTable) eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											{if $allItem[i].is_trash eq '0'}
												<li>
													<a href="{$DOMAIN_NAME}{$clsClassTable->getLink($allItem[i].guide_id)}" target="_blank" title="{$core->get_Lang('view')}" class="dropdown-item">
														<i class="icon-eye-open"></i> {$core->get_Lang('view')}
													</a>
												</li>
												<li>
													<a href="{$PCMS_URL}/guide/insert/{$allItem[i].guide_id}/overview" title="{$core->get_Lang('edit')}" class="dropdown-item">
														<i class="icon-edit"></i> {$core->get_Lang('edit')}
													</a>
												</li>
												<li>
													<a href="{$PCMS_URL}/?mod={$mod}&act=trash&guide_id={$core->encryptID($allItem[i].guide_id)}{$pUrl|default:''}&page={$currentPage}" title="{$core->get_Lang('trash')}" class="dropdown-item">
														<i class="icon-trash"></i> {$core->get_Lang('trash')}
													</a>
												</li>
											{else}
												<li>
													<a href="{$PCMS_URL}/?mod={$mod}&act=restore&guide_id={$core->encryptID($allItem[i].guide_id)}{$pUrl|default:''}&page={$currentPage}" title="{$core->get_Lang('restore')}" class="dropdown-item">
														<i class="icon-refresh"></i> {$core->get_Lang('restore')}
													</a>
												</li>
												<li>
													<a href="{$PCMS_URL}/?mod={$mod}&act=delete&guide_id={$core->encryptID($allItem[i].guide_id)}{$pUrl|default:''}&page={$currentPage}" title="{$core->get_Lang('delete')}" class="confirm_delete dropdown-item">
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
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
		</div>
	</div>
</div>
<script type="text/javascript">
	var $boxID = "";
	var $cat_id = `{$cat_id|default:0}`;
	var $guide_id= `{$guide_id|default:0}`;
	var $departure_point_id= `{$departure_point_id|default:''}`;
	var $is_set= `{$is_set|default:0}`;
	var $recordPerPage = `{$recordPerPage|default:0}`;
	var $currentPage = `{$currentPage|default:0}`;
</script>
<script type="text/javascript" src="{$URL_THEMES}/guide/jquery.guide.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		opaguide: 0.8,
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
			$.post(path_ajax_script+"/index.php?mod=guide&act=ajUpdPosSortGuide", order,

			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}